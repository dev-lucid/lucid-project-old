<?php
global $lucid;
include(__DIR__.'/../lib/lucid-router/lib/php/lucid.php');
lucid::init();
lucid::process();
lucid::deinit();
?>