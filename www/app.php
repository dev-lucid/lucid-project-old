<?php
global $lucid;
include(__DIR__.'/../lib/lucid-router/lib/php/lucid.php');
lucid::init();
include(__DIR__.'/../etc/db.php');
lucid::process();
lucid::deinit();
?>