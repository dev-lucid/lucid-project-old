<?php
global $lucid;
include(__DIR__.'/../lib/lucid-router/lib/php/lucid.php');
lucid::init();
include(__DIR__.'/../etc/db.php');

$tables = $lucid->db->_schema_tables();
		
foreach($tables as $table)
{
	echo("building model for $table\n");
	list($parent_src,$child_src) = $lucid->db->_build_model(
		$table,
		$lucid->db->_schema_columns($table),
		$lucid->db->_schema_keys($table)
	);
	file_put_contents($lucid->db->model_path.'/base/'.$table.'.php',$parent_src);
	file_put_contents($lucid->db->model_path.'/'.$table.'.php',$child_src);
}

exit("model building complete!\n");
?>