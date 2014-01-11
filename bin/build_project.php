<?php

function lucid__build_project($config)
{
	$script = '';
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
	$script .= "git submodule update --init --recursive;\n";
	
	
	echo("Assembling dev/maintenance scripts...\n");
	
	echo("Copying over app project files...\n");
	
	
	echo("Setting up permissions...\n");
}

?>