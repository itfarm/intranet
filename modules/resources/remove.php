<?php
	
	@include_once('../../cfg/config.php');
	
	$dbcnx = db_connection($db_host,$db_user,$db_password) or die( mysql_error() );
	$db_select = db_select($db_name,$dbcnx) or die( mysql_error() );
	// Get POST Information
	$id = $_GET['id'];
	if( !empty($id) ) {
		
		$query_string = "DELETE FROM resource WHERE " . "id = '" . $id  ."';";
		$register_query = mysql_query($query_string) or die( mysql_error() );
		$message = "Resource Removed successfully";
		Header("location:$resourcePage?message=$message");
	}
?>
