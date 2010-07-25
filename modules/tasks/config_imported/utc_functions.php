<?

// include parent system settings
include_once('../config.php');
include_once('settings.inc.php');

$conn=mysql_connect($db_host,$szDBUsername,$szDBPassword);
mysql_select_db($szDBName);

?>
