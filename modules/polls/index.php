<?php
	@include('../../cfg/config.php');
	$tag =  $_GET['tag'];
	@session_start();
	if(!isset($_SESSION['username']))
	{
		@header("location:$loginPage?");
	}
	else {
		// Start of session
		$current_module = "Tasks";
		global $pollPage;
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
<title>PMO Intranet system</title>
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
			<div id="login-session-name">   
				Welcome
				<strong> <?php echo $_SESSION['username'] ?> </strong> 
				&nbsp;&nbsp;<a href="<?php echo $logoutPage ?>">Log out</a>
			</div>
		<div id="menu">
			<?php main_menu($current_module) ?>
		</div>
	</div>
	<!-- end header -->
	<!-- start page -->
	<div id="page">
		<!-- start content -->
		<div id="content">
			<div style="clear: both;">&nbsp;</div>
			<?php
				poll_contents($tag);
			?>
		</div>
		<!-- end content -->
		<!-- start sidebar-right -->
		<div id="sidebar-right" class="sidebar">
			<ul>
				<li>
					<h2>Polls &amp; Surveys</h2>
					<ul>
						<li><a href="<?php echo $pollPage .'?tag=vote' ?>">Surveys to Vote</a></li>
						<li><a href="<?php echo $pollPage .'?tag=create'?>">Create Poll List</a></li>
						<li><a href="<?php echo $pollPage .'?tag=results'?>">View Results</a></li>
					</ul>
				</li>
				<li>
					<h2>Help</h2>
					<ul>
						<li><a href="<?php echo $pollPage. '?tag=help'?>">Help on Polls</a></li>
					</ul>
				</li>
			</ul>
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
