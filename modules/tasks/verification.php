<?php
	include('config.php');
	//Database related functions
	function db_connection($db_host,$db_user,$db_password) {
		$dbcnx = mysql_connect($db_host,$db_user,$db_password);
		if (!$dbcnx)
		{
			$error = "<p>Database Server not found ".mysql_error()."</p>";
			exit($error);
		}
		else {
			return $dbcnx;
		}
	};
	function db_select($db_name,$dbcnx) {
		$db_select = mysql_select_db($db_name,$dbcnx);
		if( !$db_select ) {
			$error="<p>Database not found ".mysql_error()."</p>";
			exit($error);
		}
		else {
			return $db_select;
		}
	}
	$error="it gets to verification";
	//	Get username and password
	$username= $_POST['username'];
	$password= $_POST['password'];
	

	//Header("location:$loginPage?error=$error");
	
	// Establish Connection with database
	$dbcnx = db_connection($db_host,$db_user,$db_password);
	//	Select database
	$db_select = db_select($db_name,$dbcnx);

	if( empty($username) || empty($password) ) {
		$error = "Empty username or password";
		Header("location:$loginPage?error=$error");
	}
	else {
		$query_string = "SELECT * FROM authuser WHERE uname = '$username' AND passwd = MD5('$password')";
		$query_verification = mysql_query($query_string);
		
		if(mysql_num_rows($query_verification) == 1)
		{
			$row = mysql_fetch_array($query_verification);
			session_start();
			$_SESSION['username']  = $username;
			Header("location:$homePage");
		}
		else
		{
			$error = "ACCESS DEINIED!<br/>Invalid Username or password";
			Header("location:$loginPage?error=$error");
		}
	}

?>
