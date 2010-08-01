<?php
	@include('../../cfg/config.php');
	$page = $_GET['page'];
	$tag =  $_GET['tag'];
	@session_start();
	if(!isset($_SESSION['username']))
	{
		@header("location:$loginPage?");
	}
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
	<link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" type="text/css" href="screen.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2" type="text/javascript"></script>
    <script type="text/javascript" src="check.js"></script>
	<link href="default.css" rel="stylesheet" type="text/css" />
	<script src="scripts.js" language="JavaScript" type="text/javascript"></script>
	<script type="text/javascript">
    	var chat = new Chat('<?php echo $file; ?>');
    	chat.init();
    	chat.getUsers(<?php echo "'" . $name ."','" .$_SESSION['userid'] . "'"; ?>);
    	var name = '<?php echo $_SESSION['userid'];?>';
    </script>
    <script type="text/javascript" src="settings.js"></script>

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
		<div id="page-wrap"> 
			
			<div id="section">
				<p><?php echo $_GET['message'] ?></p>
				<form method="post" action="createroom_script.php">
					<p>CREATE A PRIVATE CHAT ROOM</p>
					<fieldset >
						<legend>Chat Room Details</legend>
						<div>
							<label for="name">Room name</label> <input type="text" id="name" name="name">
						</div>
						<div>
							<label for="numofuser">Number of users</label> <input type="text" id="numofuser" name="numofuser">
						</div>
					</fieldset>
					<div><button type="submit" id="create" >Create</button></div>
				</form>

			</div>
			
			<div id="status">
				<?php if (isset($_GET['error'])): ?>
					<!-- Display error when returning with error URL param? -->
				<?php endif;?>
			</div>
			
		</div>
    
	</div>
	<div id="footer-wrapper">
		<div id="footer">
			<p class="copyright">&copy;&nbsp;&nbsp;2009 All Rights Reserved &nbsp;&bull;&nbsp; Copyright <a href="">IT Farm</a>.</p>
		</div>
	</div>
	</body>
</html>
