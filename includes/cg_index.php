<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CodeGen - Version<?php echo CGManager::$CG_VERSION ?></title>

<!--CSS-->

<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="assets/js/libs/jqueryFileTree/jqueryFileTree.css" type="text/css" media="screen" />
 

<!--jQuery Code-->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/mobile/1.0a4.1/jquery.mobile-1.0a4.1.min.js"></script>

<!--CodeGen JS-->
<script src="assets/js/CodeGen.js" type="text/javascript"></script>
<script src="assets/js/CodeGenUtilities.js" type="text/javascript"></script>

<!--jQuery Plugins-->
<script src="assets/js/jquery.debug.js" type="text/javascript"></script>
<script src="assets/js/jquery.json.js" type="text/javascript"></script>
<script src="assets/js/jquery.flash.js" type="text/javascript"></script>
<script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="assets/js/jquery.highlight.js" type="text/javascript"></script>
<script src="assets/js/libs/jqueryFileTree/jqueryFileTree.js" type="text/javascript"></script>





</head>
<body>
<div data-role="page">
	<div data-role="header">
		<h1>CodeGen v. <?php echo CGManager::$CG_VERSION ?></h1>
		<a href="?page=settings">Settings</a>
		<div id="cg_header_navbar" data-id="cg_header_navbar" data-role="navbar">
			<ul>
				<li><a href="index.php">Dashboard</a></li>
				<li><a href="?page=generator">Generator</a></li>
				<li><a href="?page=inspector">Inspector</a></li>
				<li><a href="?page=manager">Manager</a></li>
				<li><a href="?page=utilities">Utilities</a></li>
				 
			</ul>
		</div>
	</div>
	<div data-role="content" >
		<div class="container_12">
			<?php
$page = '';
if ( isset( $_GET['page'] ) )
{
	$page = $_GET['page'];
	
	switch ( $page )
	{
	case 'generator':
		include 'cg_generate.php';
	break;
	
	case 'inspector':
	include 'cg_inspector.php';
	break;
	
	case 'manager':
	include 'cg_manage.php'; 
	break;
	
	case 'utilities':
	include 'cg_utilities.php'; 
	break;
	
	case 'settings':
		include 'cg_settings.php'; 
	break;
	}
} 
else {
	include 'cg_dashboard.php'; 
}
?>
		</div>
	</div>
	
</div>
<div id="cg_window" data-role="page">
	<iframe id="cg_window_preview" width="100%" height="100%"></iframe>
</div>
</body>
</html>