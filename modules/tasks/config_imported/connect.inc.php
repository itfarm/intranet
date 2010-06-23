<?php
	include_once('../config.php');
	//Connect to the database server
	$dbcnx = db_connection($db_host,$db_user,$db_password);
    $db_select = db_select($db_name,$dbcnx);

?>



