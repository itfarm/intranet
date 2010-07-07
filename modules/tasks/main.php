<?php
	@include('config.php');
	$page = $_GET['page'];
	$tag =  $_GET['tag'];
	@session_start();
	if(!isset($_SESSION['username']))
	{
		@header("location:$loginPage?");
	}
	else {
		// Start of session
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Copyright IT Farm
Author: John Francis Mukulu <john.f.mukulu@gmail.com>
Website: http://bongolinux.webs.com/
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>PMO New Intranet system</title>
<meta name="keywords" content="" />
<meta name="Adhesive" content="" />
<link rel="stylesheet" type="text/css" href="/intranet/modules/tasks/stylesheets/main.css" media="screen" />
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/gen_validatorv2.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/DocumentListAjax.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/EntityListAjax.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/Event.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/SortedTable.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/UserGroupListAjax.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/visibility.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper">
	<!-- start header -->
	<div id="header">
		<div id="logo">
			<h1><a href=""><span>Intranet</span></a></h1>
			<p><?php echo $_SESSION['username'] ?> | <a href="<?php echo $logoutPage ?>" style="color:yellow;">Logout</a></p>
		</div>
		<div id="menu">
			<ul id="main">
				<li class="current_page"><a href="">Tasks</a></li>
				<li><a href="">Events</a></li>
				<li><a href="">News</a></li>
				<li><a href="">Gallery</a></li>
				<li><a href="">Projects</a></li>
				<li><a href="">Remainders</a></li>
				<li><a href="">Training</a></li>
				<li><a href="">Chat</a></li>
				<li><a href="">Polls</a></li>
			</ul>
		</div>
	</div>
	<!-- end header -->
	
	<!-- submenu -->
	<?php submenu($page) ?>
	<!-- end subemnu -->

	<!-- start page -->
	<div id="page">
		<!-- start content -->
		
		<div id="content">
			<?php contents($page,$tag); ?>
		</div>
		<!-- end content -->
		<!-- start sidebar-right -->
		<div id="sidebar-right" class="sidebar">
			<?php sidebar($page,$tag) ?>
		</div>
		<!-- end sidebar-right -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
</div>
<div id="footer-wrapper">
	<div id="footer">
		<p class="copyright">&copy;&nbsp;&nbsp;2009 All Rights Reserved &nbsp;&bull;&nbsp; Copyright <a href="">IT Farm</a>.</p>
	</div>
</div>
</body>
</html>
<?php
	}
?>
