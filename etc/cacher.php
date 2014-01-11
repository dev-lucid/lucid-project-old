<?php
global $cacher_config;

$cacher_config = array(
	'less-entry-point'=>__DIR__.'/../www/media/less/customizations.less',
	'scss-entry-point'=>__DIR__.'/../www/media/scss/customizations.scss',
	'path-to-less.php'=>__DIR__.'/../lib/less/lib/',
	'path-to-scss.php'=>__DIR__.'/../lib/scss/lib/',
	'cache-directory'=>__DIR__.'/../www/media/cache/',
	'less-dirs'=>array(
		__DIR__.'/../lib/bootstrap/less/'=>'/media/',
		__DIR__.'/../www/media/less/'=>'/media/',
	),
	'scss-dirs'=>array(
	
	),
    'js-dirs'=>array(
		__DIR__.'/../lib/bootstrap/js/',
		__DIR__.'/../lib/lucid-router/lib/js/',
		__DIR__.'/../www/media/js/',
	),
);
?>