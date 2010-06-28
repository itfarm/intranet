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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Intranet System for IT PHARM</title>
<link rel="stylesheet" type="text/css" href="/intranet/modules/tasks/stylesheets/main.css" media="screen" />
</head>
<body>
<div id="header">
	<div id="menu">
		<ul>
			<li class="current"><a href="">Tasks</a></li>
			<li><a href="">Events</a></li>
			<li><a href="">News</a></li>
			<li><a href="">Gallery</a></li>
			<li><a href="">Projects</a></li>
			<li><a href="">Training</a></li>
			<li><a href="">Remainders</a></li>
			<li><a href="">Polls</a></li>
			<li><a href="">Chat</a></li>
		</ul>
	</div>
	<!-- end #menu -->
	<div id="logo">
		<h1><a href="#">Intranet</a></h1>
		<p>Prime Minister's office.| <?php echo $_SESSION['username'] ?> | <a href="<?php echo $logoutPage ?>" style="color:blue;">Logout</a></p>
	</div>
	<!-- end #logo -->
</div>
<!-- end #header -->
<?php submenu($page) ?>
<div id="page">
	<div id="content">
		<?php contents($page,$tag); ?>
	</div>
	<!-- end #content -->
	<?php sidebar($page) ?>
	<!-- end #sidebar -->
	<div style="clear: both;">&nbsp;</div>
</div>
<!-- end #page -->
<div id="footer">
	<p>Copyright &copy; 2010. All Rights Reserved. Design by IT PHARM.</p>
</div>
<!-- end #footer -->
</body>
</html>

<?php 
	}
	// End of session
?>
