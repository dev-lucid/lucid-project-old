<?php
include(__DIR__.'/../lib/lucid-orm/lib/php/lucid_orm.php');

global $lucid;
$lucid->db = lucid_orm::init(array(
	'type'=>'sqlite',
	'path'=>__DIR__.'/../db/db.sqlite',
	'model_path'=>__DIR__.'/../db/models/',
));

?>