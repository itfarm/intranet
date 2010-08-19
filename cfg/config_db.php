<?php
 /*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#
##################################################################################
*/
include('root.php');
require_once($root_path.'core/class_core_mysql.php');
require_once('config.php');

$serverhost = $db_host;
$serveruser = $db_user;
$serverpwd  = $db_password;
$dbname     = $db_name;

$christDB   = new christMysqlDB($serverhost,$serveruser,$serverpwd,$dbname);
?>
