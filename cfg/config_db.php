<?php
 /*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#
##################################################################################
*/
include('root.php');
require_once($root_path.'core/class_core_mysql.php');

$serverhost = "localhost";
$serveruser = "root";
$serverpwd  = "root";
$dbname     = "intranet";

$christDB   = new christMysqlDB($serverhost,$serveruser,$serverpwd,$dbname);
?>
