<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="media/cacher.php?type=less" />
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php#!static_content/index">Project name</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="index.php#!static_content/index">Home</a></li>
						<li><a href="#!static_content/about">About</a></li>
						<li><a href="#!static_content/contact">Contact</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#!static_content/dropdown1">Action 1</a></li>
								<li><a href="#!static_content/dropdown2">Action 2</a></li>
								<li class="divider"></li>
								<li class="dropdown-header">Nav header</li>
								<li><a href="#!static_content/dropdown3">Action 3</a></li>
								<li><a href="#!static_content/dropdown4">Action 4</a></li>
								
							</ul>
						</li>
					</ul>
					<form class="navbar-form navbar-right" style="display: none;">
						<div class="form-group">
							<input type="text" placeholder="Email" class="form-control">
						</div>
						<div class="form-group">
							<input type="password" placeholder="Password" class="form-control">
						</div>
						<button type="submit" class="btn btn-success">Sign in</button>
					</form>
				</div><!--/.navbar-collapse -->
			</div>
		</div>
		<div id="full-width" class="container">
		</div>
		<div class="row" id="split" style="display:none;">
			<div id="left" class="col-xs-12 col-sm-12 col-md4 col-lg-3 container">
			</div>
			<div id="center" class="col-xs-12 col-sm-12 col-md8 col-lg-9 container">
			</div>
		</div>
		
		<div class="container">
			<footer>
				<p>&copy; Company 2013</p>
			</footer>
		</div> <!-- /container -->
		<script src="media/cacher.php?type=js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script>
			var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
			(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
			g.src='//www.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>
