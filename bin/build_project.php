<?php

function lucid__build_project($config)
{
	$script = 'cd '.$config['choices']['path'].";\n";
	echo("Setting up secondary submodules...\n");
	
	# the url router
	$script .= 'git submodule add '.$config['repo-urls']['router-lucid']." lib/lucid-router/;\n";
	
	# the UI framework
	$config['choices']['ui'] = ($config['choices']['ui'] == 'extjs')?'none':$config['choices']['ui'];
	if($config['choices']['ui'] != 'none')
	{
		$script .= 'git submodule add '.$config['repo-urls']['ui-'.$config['choices']['ui']]." lib/".$config['choices']['ui']."/;\n";
	}
	$script .= 'git submodule add '.$config['repo-urls']['validator-lucid']." lib/lucid-validator/;\n";
	
	# the orm
	if($config['choices']['orm'] != 'none')
	{
		$script .= 'git submodule add '.$config['repo-urls']['orm-'.$config['choices']['orm']]." lib/".$config['choices']['orm']."-orm/;\n";
	}
	if($config['choices']['test'] != 'none')
	{
		$script .= 'git submodule add '.$config['repo-urls']['test-'.$config['choices']['test']]." lib/".$config['choices']['test']."-test/;\n";
	}
	
	# the next gen css compiler, depending on UI framework
	if($config['choices']['ui'] == 'bootstrap')
	{
		$script .= 'git submodule add '.$config['repo-urls']['less']." lib/less/;\n";
	}
	if($config['choices']['ui'] == 'foundation')
	{
		$script .= 'git submodule add '.$config['repo-urls']['scss']." lib/scss/;\n";
	}
	
	# misc javascript libraries
	$script .= 'git submodule add '.$config['repo-urls']['hash-change']." lib/hash-change/;\n";
	$script .= 'git submodule add '.$config['repo-urls']['jsmin']." lib/jsmin-php/;\n";
	
	if($config['choices']['use-wiki'])
	{
		$script .= 'git submodule add '.$config['repo-urls']['project-wiki']." lib/docuwiki/;\n";
	}
	
	$script .= "git submodule update --init --recursive;\n";
	shell_exec($script);
	
	echo("Assembling dev/maintenance scripts...\n");
	$script = 'cd '.$config['choices']['path'].";\n";
	$script .= 'cp lib/lucid-project/bin/deploy.php bin/;';
	$script .= 'cp lib/lucid-project/bin/patches.php bin/;';
	$script .= 'cp lib/lucid-project/bin/tests.php bin/;';

	if($config['choices']['orm'] == 'lucid')
	{
		$script .= 'cp lib/lucid-project/bin/lucid-orm-db-models.php bin/db-models.php;';
	}
	if($config['choices']['db-use-local-sqlite'] == 1)
	{
		$script .= 'cp lib/lucid-project/bin/sqlite-db-build.php bin/db-build.php;';
		$script .= 'cp lib/lucid-project/db/sqlite-build.sql db/sqlite-build.sql;';
		$script .= 'cp lib/lucid-project/etc/sqlite-db.php etc/db.php;';
	}
	
	# generate the serve scripts
	$serve1 = file_get_contents(__DIR__.'/serve.sh');
	$serve1 = str_replace('{dev-port}',$config['choices']['dev-port'],$serve1);
	if($config['choices']['use-wiki'])
	{
		$serve1 .= ' & php --server 0.0.0.0:{wiki-port} --docroot $current_dir/../lib/docuwiki/ --php-ini $current_dir/../etc/';
		$serve1 = str_replace('{wiki-port}',$config['choices']['wiki-port'],$serve1);
	}
	file_put_contents($config['choices']['path'].'/bin/serve.sh',$serve1);
	$serve2 = file_get_contents(__DIR__.'/serve.bat');
	$serve2 = str_replace('{dev-port}',$config['choices']['dev-port'],$serve2);
	if($config['choices']['use-wiki'])
	{
		$serve2 .= ' & php --server 0.0.0.0:{wiki-port} --docroot $current_dir/../lib/docuwiki/ --php-ini $current_dir/../etc/';
		$serve2 = str_replace('{wiki-port}',$config['choices']['wiki-port'],$serve2);
	}
	file_put_contents($config['choices']['path'].'/bin/serve.bat',$serve2);
	
	# move over some other basic files: 
	#	index.php  = loading skeleton,
	#	cacher.php = css/less/scss/js minifier/concatenator/compiler/cacher. 
	#   app.php    = app entry point. Handles json requests.
	$script .= 'cp lib/lucid-project/www/index.php www/;';
	$script .= 'cp lib/lucid-project/www/media/cacher.php www/media/;';
	$script .= 'cp lib/lucid-project/www/app.php www/;';
	$script .= 'cp lib/lucid-project/www/humans.txt www/;';
	$script .= 'cp lib/lucid-project/www/robots.txt www/;';
	$script .= 'cp lib/lucid-project/www/favicon.ico www/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/index.php www/controllers/static_content/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/about.php www/controllers/static_content/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/contact.php www/controllers/static_content/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/dropdown1.php www/controllers/static_content/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/dropdown2.php www/controllers/static_content/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/dropdown3.php www/controllers/static_content/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/dropdown4.php www/controllers/static_content/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/details1.php www/controllers/static_content/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/details2.php www/controllers/static_content/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/static_content/views/details3.php www/controllers/static_content/views/;';

	$script .= 'cp lib/lucid-project/www/controllers/navigation/views/left_1.php www/controllers/navigation/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/navigation/views/left_2.php www/controllers/navigation/views/;';
	$script .= 'cp lib/lucid-project/www/controllers/navigation/views/left_3.php www/controllers/navigation/views/;';

		
	file_put_contents($config['choices']['path'].'/www/media/js/jquery.js',file_get_contents('http://code.jquery.com/jquery-latest.min.js'));
	
	# make the directory for less or scss, depending on UI framework choice
	if($config['choices']['ui'] == 'bootstrap')
	{
		$script .= 'cp lib/lucid-project/www/media/less/customizations.less www/media/less;';
	}
	if($config['choices']['ui'] == 'foundation')
	{
		$script .= 'cp lib/lucid-project/www/media/scss/customizations.scss www/media/scss;';
	}
	$script .= 'cp lib/lucid-project/etc/cacher.php etc/;';
	$script .= 'cp lib/lucid-project/etc/db.php etc/;';
	

	echo("Copying over app project files...\n");
	shell_exec($script);
	
	echo("Setting up permissions...\n");
	$script = 'cd '.$config['choices']['path'].";\n";
	$script .= "chmod 777 www/media/cache;\n";
	$script .= "chmod 777 var;\n";
	$script .= "chmod 777 bin/serve*;\n";
	shell_exec($script);
	
	
	$writeable_config = $config;
	unset($writeable_config['has']);
	unset($writeable_config['repo-urls']);
	ini_write($config['choices']['path'].'/etc/build.ini',$writeable_config);
	
	# fix up the wiki a bit
	/*
	$index = file_get_contents(__DIR__.'/../../project-wiki/index.php');
	$index = str_replace('WIKI_TITLE = "New wiki"','WIKI_TITLE = "'.$config['choices']['name'].'"',$index);
	$index = str_replace('LANG = "no"','LANG = "en"',$index);
	$index = str_replace('HISTORY_COMPRESSION = "gzip"','HISTORY_COMPRESSION = "plain"',$index);
	$index = str_replace('START_PAGE = "Innhold"','START_PAGE = "Landing"',$index);
	$index = str_replace('TIME_FORMAT = "%d.%m.%Y %R";',"TIME_FORMAT = \"%d.%m.%Y %R\";\n\t\tdate_default_timezone_set('UTC');",$index);
	file_put_contents(__DIR__.'/../../project-wiki/index.php',$index);
	*/
	
	echo("To run your project, type: ".$config['choices']['path']."/bin/serve.sh\n");
}

?>