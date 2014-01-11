<?php

function lucid__build_project($config)
{
	$script = 'cd '.$config['choices']['path'].";\n";
	echo("Setting up secondary submodules...\n");
	$script .= 'git submodule add '.$config['repo-urls']['router-lucid']." lib/lucid-router/;\n";
	
	$config['choices']['ui'] = ($config['choices']['ui'] == 'extjs')?'none':$config['choices']['ui'];
	if($config['choices']['ui'] != 'none')
	{
		$script .= 'git submodule add '.$config['repo-urls']['ui-'.$config['choices']['ui']]." lib/".$config['choices']['ui']."/;\n";
	}
	$script .= 'git submodule add '.$config['repo-urls']['validator-lucid']." lib/lucid-validator/;\n";
	
	if($config['choices']['orm'] != 'none')
	{
		$script .= 'git submodule add '.$config['repo-urls']['orm-'.$config['choices']['orm']]." lib/".$config['choices']['orm']."-orm/;\n";
	}
	if($config['choices']['test'] != 'none')
	{
		$script .= 'git submodule add '.$config['repo-urls']['orm-'.$config['choices']['test']]." lib/".$config['choices']['test']."-test/;\n";
	}
	
	if($config['choices']['ui'] == 'bootstrap')
	{
		$script .= 'git submodule add '.$config['repo-urls']['less']." lib/less/;\n";
	}
	if($config['choices']['ui'] == 'foundation')
	{
		$script .= 'git submodule add '.$config['repo-urls']['scss']." lib/scss/;\n";
	}
	
	$script .= 'git submodule add '.$config['repo-urls']['hash-change']." lib/hash-change/;\n";
	$script .= 'git submodule add '.$config['repo-urls']['jsmin']." lib/jsmin-php/;\n";
	$script .= "git submodule update --init --recursive;\n";
	shell_exec($script);
	
	echo("Assembling dev/maintenance scripts...\n");
	$script = 'cd '.$config['choices']['path'].";\n";
	$script .= 'cp lib/lucid-project/bin/deploy.php bin/;';
	$script .= 'cp lib/lucid-project/bin/patches.php bin/;';
	$script .= 'cp lib/lucid-project/bin/test.php bin/;';
	
	$serve1 = file_get_contents(__DIR__.'/serve.sh');
	$serve1 = str_replace('{dev-port}',$config['choices']['dev-port'],$serve1);
	file_put_contents($config['choices']['path'].'/bin/serve.sh',$serve1);
	$serve2 = file_get_contents(__DIR__.'/serve.bat');
	$serve2 = str_replace('{dev-port}',$config['choices']['dev-port'],$serve2);
	file_put_contents($config['choices']['path'].'/bin/serve.bat',$serve2);
	
	file_put_contents($config['choices']['path'].'/www/media/js/jquery.js',file_get_contents('http://code.jquery.com/jquery-latest.min.js'));
	
	$script .= 'cp lib/lucid-project/www/index.php www/;';
	$script .= 'cp lib/lucid-project/www/app.php www/;';
	$script .= 'cp lib/lucid-project/www/media/cacher.php www/media/;';
	
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
	$script .= 'cp lib/lucid-project/etc/php.ini etc/;';

	echo("Copying over app project files...\n");
	shell_exec($script);
	
	echo("Setting up permissions...\n");
	$script = 'cd '.$config['choices']['path'].";\n";
	$script .= "chmod 777 www/media/cache;\n";
	$script .= "chmod 777 var;\n";
	$script .= "chmod 777 bin/serve*;\n";
	shell_exec($script);
	
	echo("To run your project, type: ".$config['choices']['last_folder']."/bin/serve.sh\n");
}

?>