<?php
global $cacher_config;
include(__DIR__.'/../../etc/cacher.php');
ob_start();

if(!isset($_REQUEST['type']) || !isset($cacher_config[$_REQUEST['type'].'-dirs']))
{
    exit('/* must specific type param, either ?type=less or ?type=js */');
}

# a super-basic PSR-0 autoloader needed for less.php
function autoload($className)
{
	global $cacher_config;
    $className = ltrim($className, '\\');
    $fileName  = $cacher_config['path-to-less.php'];
    $namespace = '';
 
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
	require $fileName;
}
spl_autoload_register('autoload');

# used to build a long string of the concatenated file modification times of all possible files.
function get_mtimes($path)
{
	$to_return = '';
    if(is_dir($path))
    {
      $dir = opendir($path);
	  while (false !== ($file = readdir($dir)))
	  {
		  if(is_file($path.$file))
		  {
			  $to_return .= filemtime($path.$file);
		  }
	  }
    }
	return $to_return;
}



# build a unique signature for this version of all related files
$alltimes = '';
foreach($cacher_config[$_REQUEST['type'].'-dirs'] as $key=>$value)
{
	$alltimes .= get_mtimes((($_REQUEST['type'] == 'less')?$key:$value));
}
$digest = md5($alltimes);

# baed on the file change times, determine the final filename
$outfile = $cacher_config['cache-directory'].$digest.'.'.$_REQUEST['type'];

# only generate the file if necessary
if(!file_exists($outfile))
{
	# immediately error out if the cache directory isn't writable.
	if(!is_writable($cacher_config['cache-directory']))
	{
		error_log('Cacher: no write permission on cache directory '.$cacher_config['cache-directory']);
		exit('/* no write permission on cache directory: '.$cacher_config['cache-directory'].' */');
	}
	
	
    if($_REQUEST['type'] == 'less')
    {
        $parser = new Less_Parser(array( 'compress'=>true ));
        $parser->SetImportDirs($cacher_config['less-dirs']);
        $parser->parseFile($cacher_config['less-entry-point'], '/media/');
        $content = $parser->getCss();
    }
    else if($_REQUEST['type'] == 'js')
    {
        $final_src = '';
        foreach($cacher_config['js-dirs'] as $path)
        {
            if(is_dir($path))
            {
                $dir = opendir($path);
                while (false !== ($file = readdir($dir)))
                {
                    if(is_file($path.$file) && 'js' == pathinfo($path.$file,PATHINFO_EXTENSION))
                    {
                        $final_src .= file_get_contents($path.$file);
                    }
                }
            }
        }
        
        # got the final src, now load the minifier and write it out
        include(__DIR__.'/../../lib/jsmin-php/jsmin.php');
        $content = JSMin::minify($final_src);
        
    }
    
    # write the content to the file for serving
    file_put_contents($outfile,$content);
}

# set the content type header
switch($_REQUEST['type'])
{
    case 'less':
        header("Content-type: text/css; charset: UTF-8"); 
        break;
    case 'js':
        header("Content-type: application/javascript; charset: UTF-8"); 
        break;
}

exit(file_get_contents($outfile));
?>