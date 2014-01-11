<?php

function lucid__build_project($config)
{
	$script = 'cd '.$config['choices']['path'].";\n";
	echo("Setting up secondary submodules...\n");
	$script .= 'git submodule add '.$config['repo-urls']['router-lucid']." lib/lucid-router/;\n";
	
	$config['choices']['ui'] = ($config['choices']['ui'] == 'extjs')?'none':$config['choices']['ui'];
	if($config['choices']['ui'] != 'none')
	{
		#$script .= 'git submodule add '.$config['repo-urls']['ui-'.$config['choices']['ui']]." lib/".$config['choices']['ui']."/;\n";
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
	$script .= "git submodule update --init --recursive;\n";
	#exit($script);
	shell_exec($script);
	
	echo("Assembling dev/maintenance scripts...\n");
	$script = 'cd '.$config['choices']['path'].";\n";
	$script .= 'cp lib/lucid-project/bin/deploy.php bin/;';
	$script .= 'cp lib/lucid-project/bin/patches.php bin/;';
	$script .= 'cp lib/lucid-project/bin/test.php bin/;';
	
	$serve1 = file_get_contents('serve.sh');
	$serve1 = str_replace('{dev-port}',$config['choices']['dev-port'],$serve1);
	file_put_contents($config['choices']['path'].'/bin/',$serve1);
	$serve1 = file_get_contents('serve.bat');
	$serve1 = str_replace('{dev-port}',$config['choices']['dev-port'],$serve1);
	file_put_contents($config['choices']['path'].'/bin/',$serve1);
	
	$script .= 'cp lib/lucid-project/bin/serve.bat bin/;';
	$script .= 'cp lib/lucid-project/bin/serve.sh bin/;';
	$script .= 'cp lib/lucid-project/www/media/cacher.php www/media/;';
	
	echo("Copying over app project files...\n");
	
	
	echo("Setting up permissions...\n");
	$script = 'cd '.$config['choices']['path'].";\n";
	$script .= "chmod 777 www/media/cache;\n";
	$script .= "chmod 777 var;\n";
	
	
	echo("To run your project, type: bin/serve.sh\n");
}

?>