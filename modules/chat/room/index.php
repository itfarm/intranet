<?php
@include('../../../cfg/config.php');
	$page = $_GET['page'];
	$tag =  $_GET['tag'];
	@session_start();
	if(!isset($_SESSION['username']))
	{
		@header("location:$loginPage?");
	}
	// Start of session
	$current_module = "Chat";

    if (isset($_GET['name']) && isset($_SESSION['userid'])): 
    
        require_once("../dbcon.php");
    
        $name = cleanInput($_GET['name']);

        $getRooms = "SELECT *
    			     FROM chat_rooms
    		         WHERE name = '$name'";
    		         
        $roomResults = mysql_query($getRooms);	
        	
        while ($rooms = mysql_fetch_array($roomResults)) {
            $file =  $rooms['file'];
        }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>PMO Intranet system</title>
    
    <link rel="stylesheet" type="text/css" href="../main.css"/>
    <link href="/intranet/modules/tasks/stylesheets/main.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2" type="text/javascript"></script>
    <script type="text/javascript" src="chat.js"></script>
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
		
			<div id="chat-header">
				
				<div id="you"><span>Chatting as:<b><?php echo $_SESSION['userid']?></b> | <a href="leaveroom.php?name=<?php echo $name ?>">Leave <b><?php echo $name; ?></b> Group</a></span></div>
				
			</div>
			
			<div id="section">
		
				<h2 style="font-size:4em"><?php echo ucwords($name); ?></h2>
						 
				<div id="chat-wrap">
					<div id="chat-area"></div>
				</div>
				
				<div id="userlist"></div>
					
					<form id="send-message-area" action="">
						<textarea id="sendie" maxlength='100'></textarea>
					</form>
				
			</div>
			
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

<?php
 
    else:
            header('Location: http://css-tricks.com/examples/Chat2/');
    endif; 
?>
