<?php
	@include_once('./config.php');
	//Database related functions
	//	Get username and password
	$username= $_POST['username'];
	$password= $_POST['password'];

	//Header("location:$loginPage?error=$error");
	
	// Establish Connection with database
	$dbcnx = db_connection($db_host,$db_user,$db_password);
	//	Select database
	$db_select = db_select($db_name,$dbcnx);
	echo "db_host:" . $db_host . "<br/>";
	echo "db_user:" . $db_user ."<br/>";
	echo "db_password:" . $db_password . "<br/>";
	if( empty($username) || empty($password) ) {
		$message = "Empty username or password";
		Header("location:$loginPage?message=$message");
	}
	else {
		$query_string = "SELECT * FROM authuser WHERE uname = '$username' AND passwd = MD5('$password')";
		$query_verification = mysql_query($query_string);
		
		if(mysql_num_rows($query_verification) == 1)
		{
			$row = mysql_fetch_array($query_verification);
			session_start();
			$_SESSION['username']  = $username;
			$_SESSION['id'] = $row['id'];
			Header("location:$dashboardPage");
		}
		else
		{
			$message = "ACCESS DEINIED!<br/>Invalid Username or password";
			Header("location:$loginPage?message=$message");
		}
	}

?>
