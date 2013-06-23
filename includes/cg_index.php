<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>CodeGen - Version <?php echo CGManager::$CG_VERSION ?></title>

<!--CSS-->
<link rel="stylesheet" href="assets/css/codegen.css" type="text/css" media="screen" />

<!--jQuery Code-->
<script src="assets/js/jquery.js" type="text/javascript"></script>
<script src="assets/js/jquery-ui.js" type="text/javascript"></script>

<!--CodeGen JS-->
<script src="assets/js/CodeGen.js" type="text/javascript"></script>
<script src="assets/js/CodeGenUtilities.js" type="text/javascript"></script>

<!--jQuery Plugins-->
<script src="assets/js/jquery.debug.js" type="text/javascript"></script>
<script src="assets/js/jquery.json.js" type="text/javascript"></script>
<script src="assets/js/jquery.flash.js" type="text/javascript"></script>
<script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="assets/js/jquery.highlight.js" type="text/javascript"></script>
<script src="assets/js/JsonFormatter.js" type="text/javascript"></script>
</head>
<body> 
<div class="container_12">
	
	<div class="grid_12">
		<ul class="cg_main_nav">
			<li class="cg_img"><a href="index.php"><img src="assets/images/cg_logo.png" alt="CodeGen v. <?php echo CGManager::$CG_VERSION ?>"/></a></li>
			<li><a href="?page=generator">Generator</a></li>
			<li><a href="?page=inspector">Inspector</a></li>
			<li><a href="?page=manager">Manager</a></li>
			<li><a href="?page=utilities">Utilities</a></li>
			<li><a href="?page=settings">Settings</a></li>
			<li id="cg_global_loader"><img src="assets/images/cg_global_loader.gif" alt="loading..."/></li>
		</ul>
	</div>
	<div class="clear"></div>
	

	
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





	<div class="grid_12">
		<div class="cg_footer">
			<p class="cg_copywrites">Copywrite 2009 &copy; | See Google Code Page for Information.</p>
		</div>
	</div><!--/grid-->
	<div class="clear"></div>
</div>



<div id="cg_window">
	<iframe id="cg_window_preview" width="100%" height="100%"></iframe>
</div>




</body>
</html>