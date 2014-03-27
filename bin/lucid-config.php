<?php
$version = explode('.',phpversion());
print_r($version);
if($version[0]<6 && $version[1] < 4)
{
	exit("You must have at least php version 5.4 to use this script :(\n");
}
global $config;
$config = array(
	'has'=>array(
		'mysql'=>false,
		'pgsql'=>false,
		'phpversion'=>false,
		'git'=>false,
		'svn'=>false,
		'ssh'=>false,
	),
	'choices'=>array(
		'name'=>null,
		'repo-url'=>null,
		'path'=>null,
		'vcs'=>null,
		'db'=>null,
		'db-use-local-sqlite'=>null,
		'db-hostname'=>null,
		'db-database'=>null,
		'db-username'=>null,
		'db-password'=>null,
		'orm'=>null,
		'ui'=>null,
		'test'=>null,
		'use-patcher'=>null,
		'use-wiki'=>null,
		'http-server'=>null,
		'org-user-db'=>null,
		'org-user-loginform'=>null,
		'repo-exists'=>null,
		'repo-checked-out'=>null,
		'setup-db-server'=>null,
		'setup-http-server'=>null,
		'build-project'=>null,
		'print-script'=>false,
		'dev-port'=>null,
		'wiki-port'=>null,
	),
	'repo-urls'=>array(
		//'project-lucid'=>'git@github.com:Dev-Lucid/lucid-project.git',
		'project-lucid'=>'file:///opt/git-clones/lucid-project/',

		//'project-wiki'=>'git@github.com:splitbrain/dokuwiki.git',
		'project-wiki'=>'file:///opt/git-clones/dokuwiki/',

		//'router-lucid'=>'git@github.com:Dev-Lucid/lucid-router.git',
		'router-lucid'=>'file:///opt/git-clones/lucid-router/',
		//'validator-lucid'=>'git@github.com:Dev-Lucid/lucid-validator.git',
		'validator-lucid'=>'file:///opt/git-clones/lucid-validator/',
		//'ui-bootstrap'=>'git@github.com:twbs/bootstrap.git',
		'ui-bootstrap'=>'file:///opt/git-clones/bootstrap/',
		'ui-foundation'=>'git@github.com:zurb/foundation.git',
		//'orm-lucid'=>'git@github.com:Dev-Lucid/lucid-orm.git',
		'orm-lucid'=>'file:///opt/git-clones/lucid-orm/',
		'orm-propel'=>'git@github.com:propelorm/Propel.git',
		'orm-doctrine'=>'git@github.com:doctrine/doctrine2.git',

		//'test-lucid'=>'git@github.com:Dev-Lucid/lucid-unittest.git',
		'test-lucid'=>'file:///opt/git-clones/lucid-unittest/',
		'test-phpunit'=>'git@github.com:sebastianbergmann/phpunit.git',

		//'less'=>'git@github.com:oyejorge/less.php.git',
		'less'=>'file:///opt/git-clones/less.php/',
		'scss'=>'git@github.com:leafo/scssphp.git',

		//'jsmin'=>'https://github.com/eriknyk/jsmin-php.git',
		'jsmin'=>'file:///opt/git-clones/jsmin-php/',

		//'hash-change'=>'git@github.com:apopelo/jquery-hashchange.git',
		'hash-change'=>'file:///opt/git-clones/jquery-hashchange',
	),
);

# load the parameters passed on the command line
for($i=1;$i<count($argv);$i++)
{
	$option = explode('=',$argv[$i]);
	if(!isset($option[1]))
		$option[1] = true;
	else if(trim($option[1]) == 'true' || trim($option[1]) == 'false')
		$option[1] = ($option[1] == 'true');
	$config['choices'][$option[0]] = $option[1];
}

print_r($argv);

if(!is_null($config['choices']['repo-url']))
{
	$config['choices']['repo-exists'] = true;
}


/* UTILITY_FUNCTIONS. For end, search for END_UTILITY_FUNCTIONS */
global $cli_handle;
$cli_handle = fopen ("php://stdin","r");


function get_yn($default=true)
{
	global $cli_handle;
	echo("[yn]> ");
	$value = strtolower(trim(fgets($cli_handle)));
	if($value == '')
	{
		return $default;
	}
	return ($value == 'y');
}

function get_string($default='')
{
	global $cli_handle;
	echo("> ");
	$value = strtolower(trim(fgets($cli_handle)));
	if($value == '')
	{
		return $default;
	}
	return $value;
}

function get_option($options,$default=null)
{
	global $cli_handle;
	
	$keys = array_keys($options);
	$vals = array_values($options);
	
	if(is_null($default))
	{
		$default = $keys[0];
	}
	
	for($i=0;$i<count($vals);$i++)
	{
		echo("[$i]: ".$vals[$i]."\n");
	}
	echo("> ");
	$value = strtolower(trim(fgets($cli_handle)));
	if($value == '')
	{
		return $default;
	}
	$value = intval($value);
	if(!is_numeric($value) || is_nan($value))
	{
		echo("Please enter a number, 0 through ".count($options).":");
		return get_option($options,$default);
	}
	return $keys[$value];
}

function separator()
{
	echo("-----------------------------------\n");
}


 /**
 * Write data to an INI file
 * 
 * The data array has to be like this:
 * 
 *  Array
 *  (
 *      [Section1] => Array
 *          (
 *              [key1] => val1
 *              [key2] => val2
 *          )
 *      [Section2] => Array
 *          (
 *              [key3] => val3
 *              [key4] => val4
 *          )    
 *  )
 *
 * @param string $filePath
 * @param array $data
 */
function ini_write($filePath, array $data)
{
    $output = '';
 
    foreach ($data as $section => $values)
    {
        //values must be an array
        if (!is_array($values)) {
            continue;
        }
 
        //add section
        $output .= "[$section]\n";
 
        //add key/value pairs
        foreach ($values as $key => $val) {
            $output .= "$key=$val\n";
        }
        $output .= "\n";
    }
 
    //write data to file
    file_put_contents($filePath, trim($output));
}

 
/**
 * Read and parse data from an INI file
 * 
 * The data is returned as follows:
 * 
 *  Array
 *  (
 *      [Section1] => Array
 *          (
 *              [key1] => val1
 *              [key2] => val2
 *          )
 *      [Section2] => Array
 *          (
 *              [key3] => val3
 *              [key4] => val4
 *          )    
 *  )
 * 
 * @param string $filePath
 * @return array|false
 */
function ini_read($filePath)
{
    if (!file_exists($filePath)) {
        return false;
    }
 
    //read INI file linewise
    $lines = array_map('trim', file($filePath));
    $data  = array();
 
    $currentSection = null;
    foreach ($lines as $line)
    {
        if (substr($line, 0, 1) == '[') {
            $currentSection = substr($line, 1, -1);
            $data[$currentSection] = array();
        }
        else
        {
            //skip line feeds in INI file
            if (empty($line)) {
                continue;
            }
 
            //if no $currentsection is still null,
            //there was missing a "[<sectionName>]"
            //before the first key/value pair
            if (null === $currentSection) {
                return false;
            }
 
            //get key and value
            list($key, $val) = explode('=', $line);
            $data[$currentSection][$key] = $val;
        }
    }
 
    return $data;
}

/* END_UTILITY_FUNCTIONS */

/* REQUIREMENTS_FUNCTIONS. For end, search for END_REQUIREMENTS_FUNCTIONS */
function check_requirements()
{
	global $config;
	echo("Checking requirements....\n");
	
	$config['has']['mysql'] = cmd_exists('mysql');
	$config['has']['pgsql'] = cmd_exists('psql');
	$config['has']['git']   = cmd_exists('git');
	$config['has']['svn']   = cmd_exists('svn');
	$config['has']['ssh']   = cmd_exists('ssh');

	echo("\tmysql: ".(($config['has']['mysql'])?'Yes':'No')."\n");
	echo("\tpgsql: ".(($config['has']['pgsql'])?'Yes':'No')."\n");
	echo("\t  git: ".(($config['has']['git'])?'Yes':'No')."\n");
	echo("\t  svn: ".(($config['has']['svn'])?'Yes':'No')."\n");
	echo("\t  ssh: ".(($config['has']['ssh'])?'Yes':'No')."\n");

	if(!$config['has']['mysql'] && !$config['has']['pgsql'])
	{
		exit("You do not meet the database requirement. You must have either postgresql or mysql installed. Please correct this and try again.\n");
	}
	if(!$config['has']['git'] && !$config['has']['svn'])
	{
		exit("You do not meet the version control requirement. You must have either git or svn installed. Please correct this and try again.\n");
	}
	if(!$config['has']['ssh'] && !$config['has']['ssh'])
	{
		exit("You do not meet the ssh requirement. You must have ssh installed to deploy. Please correct this and try again.\n");
	}
	echo("Passed!\n");
}

function cmd_exists($command)
{
    if (\strtolower(\substr(PHP_OS, 0, 3)) === 'win')
    {
        $fp = \popen("where $command", "r");
        $result = \fgets($fp, 255);
        $exists = ! \preg_match('#Could not find files#', $result);
        \pclose($fp);   
    }
    else # non-Windows
    {
        $fp = \popen("which $command", "r");
        $result = \fgets($fp, 255);
        $exists = ! empty($result);
        \pclose($fp);
    }

    return $exists;
}

/* END_REQUIREMENTS_FUNCTIONS */

check_requirements();
separator();

if(is_null($config['choices']['name']))
{
	echo("What is the name of your new project?\n");
	$config['choices']['name'] = get_string();
}

# which version control system - git, svn
if(is_null($config['choices']['vcs']))
{
	if($config['has']['svn'] && $config['has']['git'])
	{
		echo("Please choose a version control system:\n");
		$config['choices']['vcs'] = get_option(array('git'=>'git (recommended)','svn'=>'svn'));
	}
	else
	{
		$config['choices']['vcs'] = ($config['has']['git'])?'git':'svn';
		echo('Autoselected '.$config['choices']['vcs']." for version control\n");
	}
}


if(is_null($config['choices']['repo-exists']))
{
	echo("Do you have a version control repository for your project already?\n");
	$config['choices']['repo-exists'] = get_yn();
}

if($config['choices']['repo-exists'])
{
	if(is_null($config['choices']['repo-checked-out']))
	{
		echo("Have you checked out/cloned your project already?\n");
		$config['choices']['repo-checked-out'] = get_yn();
	}
	
	if($config['choices']['repo-checked-out'] && is_null($config['choices']['path']))
	{
		echo("What is the path to your checkout/clone?\n");
		$config['choices']['path'] = get_string();
	}
	else
	{
		if(is_null($config['choices']['repo-url']))
		{
			echo("What is the url to your repo?\n");
			$config['choices']['repo-url'] = get_string();
		}
		
		if(is_null($config['choices']['path']))
		{
			echo("Where would you like to checkout/clone your repo to?\n");
			$config['choices']['path'] = get_string();
		}
	}
}
else
{
	exit("Please create a repo first and then restart this process. This script can help you ".(($config['choices']['vcs']=='svn')?'checkout':'clone')." your repo once it has been created.\n");
}

if(is_null($config['choices']['db']))
{
	# which database - mysql, postgresql
	if($config['has']['mysql'] && $config['has']['pgsql'])
	{
		echo("Please choose a database:\n");
		$config['choices']['db'] = get_option(array(
			'pgsql'=>'Postgresql (recommended)',
			'mysql'=>'MySQL (or a compatible substitute like MariaDB)',
		));
	}
	else
	{
		$config['choices']['db'] = ($config['has']['mysql'])?'mysql':'pgsql';
	}
}

if(is_null($config['choices']['db-use-local-sqlite']))
{
	echo("Do you want to use a local sqlite database for development?\n");
	$config['choices']['db-use-local-sqlite'] = get_yn();
}

if(is_null($config['choices']['use-patcher']))
{
	echo("Do you want to the Lucid db patch maintenance scripts?\n");
	$config['choices']['use-patcher'] = get_yn();
}

if(is_null($config['choices']['setup-db-server']))
{
	echo("Do you want to setup your database connection information now?\n");
	$config['choices']['setup-db-server'] = get_yn();
}


if($config['choices']['setup-db-server'])
{
	echo("What is the hostname of your database? default is localhost\n");
	$config['choices']['db-hostname'] = get_string('localhost');
	echo("What is the name of your database? default is ".$config['choices']['name']."_dev\n");
	$config['choices']['db-database'] = get_string('localhost');
	echo("What username should your app use to connect to your database?\n");
	$config['choices']['db-username'] = get_string();
	echo("What password should your app use to connect to your database?\n");
	$config['choices']['db-password'] = get_string();
	
	if($config['choices']['db'] == 'mysql')
	{
		echo("To setup this database, you should run these commands as a database super user: \n");
	}
	if($config['choices']['db'] == 'pgsql')
	{
		echo("To setup this database, you should run these commands as a database super user: \n");
	}
}
else
{
	echo("You will have to setup the information yourself later in /etc/db.php\n");
}

# which ORM layer - lucid, propel
if(is_null($config['choices']['orm']))
{
	echo("Please choose a ORM layer:\n");
	$config['choices']['orm'] = get_option(array(
		'lucid'=>'Lucid ORM (recommended)',
		'propel'=>'Propel ORM',
		'doctrine'=>'Doctrine ORM',
		'none'=>'None',
	));
}

# which UI layer - bootstrap (will require less compiler, foundation (which require scss compiler), extjs, etc
if(is_null($config['choices']['ui']))
{
	echo("Please choose a UI framework:\n");
	$config['choices']['ui'] = get_option(array(
		'bootstrap'=>'Bootstrap (recommended) - advanced responsive framework',
		'foundation'=>'Foundation - a different, advanced responsive framework',
		'extjs'=>'Extjs - For applications',
		'none'=>'None',
	));
}

if(is_null($config['choices']['test']))
{
	echo("Please choose a testing framework:\n");
	$config['choices']['test'] = get_option(array(
		'lucid'=>'Lucid (recommended) - advanced responsive framework, built to integrate perfectly',
		'phpunit'=>'PHPUnit - really common, well tested',
		'none'=>'None',
	));
}

if(is_null($config['choices']['setup-http-server']))
{
	echo("Do you want to setup a webserver config now?\n");
	$config['choices']['setup-http-server'] = get_yn();
}
if($config['choices']['setup-http-server'])
{
	$config['choices']['setup-server'] = true;
	if(is_null($config['choices']['http-server']))
	{
		echo("Which HTTP server do you want to use?\n");
		$config['choices']['http-server'] = get_option(array(
			'nginx'=>'Nginx (recommended) - The new hotness',
			'apache'=>'Apache - Widely used and well supported',
			'IIS'=>'IIS - might get ugly',
		));
	}
}
else
{
	echo("To do this later, php -f bin/configure-webserver.php\n");
}


if(is_null($config['choices']['org-user-db']))
{
	echo("Do you want to include a boilerplate organization/user database table?\n");
	$config['choices']['org-user-db'] = get_yn();
}

if(is_null($config['choices']['org-user-loginform']))
{
	echo("Do you want to include a boilerplate login form?\n");
	$config['choices']['org-user-loginform'] = get_yn();
}
# other misc libraries

if(is_null($config['choices']['use-wiki']))
{
	echo("Do you want to use the inbuilt wiki for documentation (strongly recommended)?\n");
	$config['choices']['use-wiki'] = get_yn();
}
if($config['choices']['use-wiki'] && is_null($config['choices']['wiki-port']))
{
	echo("What port do you want to run your project wiki on? (defaults to 9000)\n");
	$config['choices']['wiki-port'] = get_string(9000);
}
if(is_null($config['choices']['dev-port']))
{
	echo("What port do you want to run your development area on? (defaults to 8000)\n");
	$config['choices']['dev-port'] = get_string(8000);
}

separator();
echo("Your choices: \n");
print_r($config['choices']);

if(is_null($config['choices']['build-project']))
{
	echo("Do you want to build your project with these options? (enter n to quit)\n");
	$config['choices']['build-project'] = get_yn();
}


if(!$config['choices']['build-project'])
{
	exit("Done.");
}

separator();

echo("Building basic folder structure...\n");

$path = explode('/',$config['choices']['path']);
$config['choices']['last_folder'] = array_pop($path);
$script = "cd ".$config['choices']['path']."/../;";
if($config['choices']['vcs'] == 'git')
{
	$script .= "git clone ".$config['choices']['repo-url']." ".$config['choices']['last_folder'].";\n";
}
else
{
	$script .= "svn checkout ".$config['choices']['repo-url']." ".$config['choices']['last_folder'].";\n";
}
$script .= "cd ".$config['choices']['last_folder'].";\n";
$script .= "mkdir bin;mkdir db;mkdir db/patches;mkdir db/builds;mkdir db/models;mkdir etc;mkdir lib;mkdir var;mkdir www;mkdir www/controllers;\n";

if($config['choices']['orm'] == 'lucid')
{
	$script .= 'mkdir db/models/base;';
}

$script .= "mkdir www/controllers/static_content;mkdir www/controllers/static_content/views;";
$script .= "mkdir www/controllers/navigation;mkdir www/controllers/navigation/views;";
$script .= "mkdir www/media;mkdir www/media/js;mkdir www/media/cache;";

if($config['choices']['ui'] == 'bootstrap')
{
	$script .= "mkdir www/media/less;";
}
else if($config['choices']['ui'] == 'foundation')
{
	$script .= "mkdir www/media/scss;";
}
else
{
	$script .= "mkdir www/media/less;";
}

if($config['choices']['vcs'] == 'git')
{
	$script .= 'git submodule add '.$config['repo-urls']['project-lucid']." lib/lucid-project/;\n";
	$script .= "git submodule update --init --recursive;\n";
}
else
{
}

if($config['choices']['print-script'])
{
	echo($script);
}

shell_exec($script);
include($config['choices']['path'].'/lib/lucid-project/bin/build_project.php');
echo("Using Lucid-Project code to bootstrap the build...\n");
lucid__build_project($config);

exit("Done.");

separator();
echo("You should now install the appropriate config file for your server, located in the etc/http-server folder. You will almost certaily have to restart the server after this action. Happy developing!\n");

?>