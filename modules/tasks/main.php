<?php
	include('config.php');
	$page_tag = $_GET['page'];
	session_start();
	if(!isset($_SESSION['username']))
	{
		header("location:$loginPage?");
	}
	else {
		// Start of session
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Intranet System for ITIDO</title>
<link rel="stylesheet" type="text/css" href="/intranet/modules/tasks/stylesheets/main.css" media="screen" />
</head>
<body>
<div id="header">
	<div id="menu">
		<ul>
			<li class="current"><a href="#">Events</a></li>
			<li><a href="#">News</a></li>
			<li><a href="#">Gallery</a></li>
			<li><a href="#">Projects</a></li>
			<li><a href="#">Training</a></li>
			<li><a href="#">Remainders</a></li>
			<li><a href="#">Polls</a></li>
			<li><a href="#">Chat</a></li>
		</ul>
	</div>
	<!-- end #menu -->
	<div id="logo">
		<h1><a href="#">Intranet</a></h1>
		<p>Internal Network services.</p>
	</div>
	<!-- end #logo -->
</div>
<!-- end #header -->
<?php submenu($page_tag) ?>
<div id="page">
	<div id="content">
	<h2>Contents stays here!</h2>
	<h3><?php echo $url_dashboard . "    " . $url_profile ?></h3>
<!--
		<div class="post">
			<h2 class="title">Welcome to our website </h2>
			<p class="byline"><small>Posted by FreeCssTemplates</small></p>
			<div class="entry">
				<p><strong>Cellulose </strong> is a free template from <a href="http://www.freecsstemplates.org/">Free CSS Templates</a> released under a <a href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution</a>. You're free to use this template for both commercial or personal use. I only ask that you link back to <a href="http://www.freecsstemplates.org/">my site</a> in some way. Enjoy :)</p>
			</div>
			<div class="meta">
				<p class="links"><a href="#" class="comments">Comments (32)</a> &nbsp;&bull;&nbsp;&nbsp; <a href="#" class="more">Read full post &raquo;</a></p>
			</div>
		</div>
		<div class="post">
			<h2 class="title">Lorem Ipsum Dolor Volutpat</h2>
			<p class="byline"><small>Posted by FreeCssTemplates</small></p>
			<div class="entry">
				<p>Curabitur tellus. Phasellus tellus turpis, iaculis in, faucibus lobortis, posuere in, lorem. Donec a ante. Donec neque purus, adipiscing id, eleifend a, cursus vel, odio. Vivamus varius justo sit amet leo. Morbi sed libero. Vestibulum blandit augue at mi. Praesent fermentum lectus eget diam. Nam cursus, orci sit amet porttitor iaculis, ipsum massa aliquet nulla, non elementum mi elit a mauris.</p>
				<ul>
					<li><a href="#">Magna lacus bibendum mauris</a></li>
					<li><a href="#">Velit semper nisi molestie</a></li>
					<li><a href="#">Magna lacus bibendum mauris</a></li>
					<li><a href="#">Velit semper nisi molestie</a></li>
				</ul>
			</div>
			<div class="meta">
				<p class="links"><a href="#" class="comments">Comments (32)</a> &nbsp;&bull;&nbsp;&nbsp; <a href="#" class="more">Read full post &raquo;</a></p>
			</div>
		</div>
-->
	</div>
	<!-- end #content -->
	<?php sidebar($page_tag) ?>
	<!-- end #sidebar -->
	<div style="clear: both;">&nbsp;</div>
</div>
<!-- end #page -->
<div id="footer">
	<p>Copyright &copy; 2010. All Rights Reserved. Design by John Francis Mukulu.</p>
</div>
<!-- end #footer -->
</body>
</html>

<?php 
	}
	// End of session
?>
