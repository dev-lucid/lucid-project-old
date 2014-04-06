<html>
	<head>
		<link rel="Stylesheet" type="text/css" href="/templates/standard/styles.css" />
	</head>
	<body>
		<div class="headnav">
			<?=$config['headnav']?>
		</div>
		<?if(!isset($_REQUEST['mode'])){?>
		<div class="toolbar">
			<button class="edit" onclick="location.href='index.php?file=<?=$config['file']?>&mode=edit';">Edit</button>
		</div>
		<?}?>