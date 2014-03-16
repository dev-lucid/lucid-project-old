<?php
global $cacher_config;

$cacher_config = array(
	'less-entry-point'=>__DIR__.'/../www/media/less/customizations.less',
	'scss-entry-point'=>__DIR__.'/../www/media/scss/customizations.scss',
	'path-to-less.php'=>__DIR__.'/../lib/less/lib/',
	'path-to-scss.php'=>__DIR__.'/../lib/scss/lib/',
	'cache-directory'=>__DIR__.'/../www/media/cache/',
	'less-files'=>array(
		__DIR__.'/../lib/bootstrap/less/'=>'/media/',
		__DIR__.'/../www/media/less/'=>'/media/',
	),
	'scss-files'=>array(
	
	),
	'js-files'=>array(
		__DIR__.'/../www/media/js/jquery.js',
		__DIR__.'/../lib/bootstrap/js/affix.js',
		__DIR__.'/../lib/bootstrap/js/alert.js',
		__DIR__.'/../lib/bootstrap/js/carousel.js',
		__DIR__.'/../lib/bootstrap/js/collapse.js',
		__DIR__.'/../lib/bootstrap/js/dropdown.js',
		__DIR__.'/../lib/bootstrap/js/modal.js',
		__DIR__.'/../lib/bootstrap/js/tooltip.js',
		__DIR__.'/../lib/bootstrap/js/popover.js',
		__DIR__.'/../lib/bootstrap/js/scrollspy.js',
		__DIR__.'/../lib/bootstrap/js/tab.js',
		__DIR__.'/../lib/bootstrap/js/tooltip.js',
		__DIR__.'/../lib/bootstrap/js/transition.js',
		__DIR__.'/../lib/lucid-router/lib/js/lucid.js',
	),
);
?>