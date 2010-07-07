<?php
	@include('cfg/config.php');
	@session_start();
	if( isset($_SESSION['username']) )
	{
		@header("location:$dashboardPage");
	}
	else {
		
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
<link href="css/main.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/login.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
	<!-- start header -->
	<div id="header">
		<div id="logo">
			<h1><a href=""><span>Intranet</span></a></h1>
			<p>Prime minister's office</p>
		</div>
	</div>
	<!-- end header -->
	<!-- submenu -->
	<div id="submenu">
	</div>
	<!-- end subemnu -->

	<!-- start page -->
	<div id="page">
		<!-- start login -->
		<div id="login">
			<form method="POST" action="<?php echo $verificationPage ?>">
				<h3><?php echo $_GET['message'] ?></h3>
				<table>
					<tr>
						<td><p>Username</p></td>
						<td><input type="text" class="inBox" name="username"/> </td>
					</tr>
					<tr>
						<td><p>Password</p></td>
						<td><input type="password" class="inBox" name="password"/></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Login" class="button"/></td>
					</tr>
				</table>
			</form>
		</div>
		<!-- end login -->
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
	// End of session
?>
