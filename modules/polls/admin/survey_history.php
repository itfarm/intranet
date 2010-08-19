<?php
include_once("admin.inc.php");@include('../../../cfg/config.php');
$tag =  $_GET['tag'];
@session_start();
if(!isset($_SESSION['username']))
{
	@header("location:$loginPage?");
}
// Start of session
$current_module = "Polls";
global $pollPage;

connectdb();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Copyright IT Farm
Author: John Francis Mukulu <john.f.mukulu@gmail.com>
Website: http://bongolinux.webs.com/
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>PMO Intranet system</title>
	<meta name="keywords" content="" />
	<meta name="Adhesive" content="" />
	<link rel="stylesheet" type="text/css" href="/intranet/modules/tasks/stylesheets/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/intranet/modules/tasks/stylesheets/table_style.css" media="screen" />
	<style type="text/css">
			.table {
				width:100%;
				border: 1px #000000 none;
				text-align:left;
				font-size:1.3em;
			}
			tr th {
				font-weight:bold;
				text-size:3em;
			}
			tbody tr {
				color:blue;
			}
			tbody tr:hover {
				color:yellow;
				cursor: pointer;
			}
	</style>
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
		<!-- start content -->
		<div id="content">
			<div style="clear: both;">&nbsp;</div>

<?php
echo '<div class="scrolldown">';
openadmin();

$res_history = mysql_query("select * from nabopoll_history where survey=$survey order by instant");
if ($res_history == FALSE)
	error("database error");

echo '<table cellspacing=0><tr>';
echo '<th><font  size="-1">&nbsp;IP&nbsp;</font></th>';
echo '<th><font  size="-1">&nbsp;Date&nbsp;</font></th>';
echo '<th><font  size="-1">&nbsp;Answers&nbsp;</font></th>';
echo '</tr>';

while ($row = mysql_fetch_array($res_history))
{
	echo '<tr><td valign="top"><font size="-1">&nbsp;' . $row["ip"] . '&nbsp;</font></td>';
	echo '<td valign="top"><font size="-1">&nbsp;' . $row["instant"] . '&nbsp;</font></td>';
	echo '<td valign="top"><font size="-1">&nbsp;' . $row["answers"] . '&nbsp;</font></td></tr>';
}

echo '</table>';echo '</div>';
echo '<p><a href="survey_edit.php">back</a></p>';
closeadmin();

?></div>
		<!-- end content -->
		<!-- start sidebar-right -->
		<div id="sidebar-right" class="sidebar">
			<?php poll_sidebar($tag); ?>
		</div>
		<!-- end sidebar-right -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
<?php
@include_once('../footer.php');
?>




