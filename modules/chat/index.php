<?php
	@include('../../cfg/config.php');
	$page = $_GET['page'];
	$tag =  $_GET['tag'];
	@session_start();
	if(!isset($_SESSION['username']))
	{
		@header("location:$loginPage?");
	}
	else {
		// Start of session
		$current_module = "Chat";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>PMO Intranet system</title>
	<meta name="keywords" content="" />
	<meta name="Adhesive" content="" />
	<link href="/intranet/modules/tasks/stylesheets/main.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="default.css" rel="stylesheet" type="text/css" />
	<script src="scripts.js" language="JavaScript" type="text/javascript"></script>
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
		  <div id="chatheader">
			<form id="chatForm" name="chatForm" onsubmit="return false;" action="">
			  <label for="name">Username:</label><input type="text" size="12" maxlength="30" name="name" value="<?php echo $_SESSION['username']?>"id="name" onblur="checkName();" />
			  <label for="chatbarText">Your text message:</label> <input type="text" size="55" maxlength="500" name="chatbarText" id="chatbarText" onblur="checkStatus('');" onfocus="checkStatus('active');" /> <input onclick="sendComment();" type="submit" id="submit" name="submit" value="submit" />
			</form>
		  </div>
		  <div id="chatcontent">

			<div id="chatoutput">
			  
			  <ul id="outputList">
						<li><span class="name">PMO Chat:</span>Hi! Welcome to Prime Minister's office intranet Chat session.</li>
			  </ul>
			</div>
		  </div>
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
