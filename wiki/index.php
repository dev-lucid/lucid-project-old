<?php
global $config,$template_start,$template_end;
$config = array(
	'parsedown_path'=>'../lib/parsedown/',
	'default_page'=>'index.md',
	'template'=>'standard',
	'headnav'=>'',
	'contents'=>'',
	'footnav'=>'',
);

if(isset($_REQUEST['todo']) and $_REQUEST['todo'] == 'save')
{
	file_put_contents(__DIR__.'/'.$_REQUEST['file'],$_REQUEST['contents']);
	header('Location: index.php?file='.$_REQUEST['file']);
}

include($config['parsedown_path'].'/Parsedown.php');

function handle_content($file)
{
	if(!file_exists($file))
	{
		exit($file." does not exist.\n");
	}
	$contents = file_get_contents($file);
	$contents = str_replace("\r",'',$contents);
	$contents = preg_replace('/\((..+\.md)\)/','(index.php?file=\1)',$contents);
	$parsedown = new Parsedown();
	$contents  = $parsedown->parse($contents);
	return $contents;
}

# Determine the file to load
$config['file'] = ((isset($_REQUEST['file']))?$_REQUEST['file']:$config['default_page']);


$config['headnav'] = handle_content('headnav.md');
$config['footnav'] = handle_content('footnav.md');


# include the template start, echo the content, include template end
if(!is_dir(__DIR__.'/templates/'.$config['template']))
{
	$config['contents'] = '<div class="error"><b>Warning: </b>Template '.$config['template'].' does not exist, or is not complete. Defaulting to standard template instead.</div>'.$config['contents'];
	$config['template'] = 'standard';
}
include(__DIR__.'/templates/'.$config['template'].'/template_start.php');
if(
	(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'edit')
	or
	!file_exists(__DIR__.'/'.$config['file'])
)
{
	$config['title'] = '<h1>Editing '.$config['file'].'</h1>';
	if(file_exists(__DIR__.'/'.$config['file']))
	{
		$config['contents'] = file_get_contents(__DIR__.'/'.$config['file']);
	}
	else
	{
		$config['title'] .= '<b>Note: </b> You are editing a new file.';
	}
	include(__DIR__.'/templates/'.$config['template'].'/editor.php');
}
else
{
	$config['contents'] = handle_content(__DIR__.'/'.$config['file']);
	echo($config['contents']);
}
include(__DIR__.'/templates/'.$config['template'].'/template_end.php');
?>