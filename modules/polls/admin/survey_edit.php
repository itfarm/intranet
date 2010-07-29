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

?>
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
connectdb();
global $pollPage;

$res_survey = mysql_query("select * from nabopoll_surveys order by id");
if ($res_survey == FALSE)
	error("database error");

openadmin();
$survey=0;

echo '<table cellspacing=0><tr bgcolor="gray">';
echo '<th><font color="white" size="2">&nbsp;#&nbsp;</font></th>';
echo '<th><font color="white" size="2">&nbsp;Title&nbsp;</font></th>';
//echo '<th><font color="white" size="2">&nbsp;URL&nbsp;</font></th>';
echo '<th><font color="white" size="2">&nbsp;Template&nbsp;</font></th>';
echo '<th><font color="white" size="2">&nbsp;Single Vote&nbsp;</font></th>';
echo '<th><font color="white" size="2">&nbsp;Log&nbsp;</font></th>';
echo '<th><font color="white" size="2">&nbsp;Required&nbsp;</font></th>';
echo '<th><font color="white" size="2">&nbsp;Closed?&nbsp;</font></th>';
echo '<th><font color="white" size="2">&nbsp;Actions&nbsp;</font></th>';
echo '</tr>';

while ($row = mysql_fetch_array($res_survey))
{
	$survey = $row["id"];

	echo '<tr><td valign="top"><b><font size="2">' . $survey . '</font></b></td>';

	echo '<form action="survey_alter.php" method="post">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<td valign="top"><input type="text" class="txtfld" size=30 name="title" value="' . $row["title"] . '"></td>';
	echo '<input type="hidden" class="txtfld" size=30 name="url" value="' . $pollPage . '">';
	echo '<td valign="top" align="center">'; formtemplates($row["template"]); echo '</td>';
	echo '<td valign="top" align="center">'; formsinglevote($row["single_vote"]); echo '</td>';
	echo '<td valign="top" align="center"><input type="checkbox" name="log" ' . ($row["log"] == 1 ? "checked" : "") . '></td>';
	echo '<td valign="top" align="center"><input type="checkbox" name="required" ' . ($row["required"] == 1 ? "checked" : "") . '></td>';
	echo '<td valign="top" align="center"><input type="checkbox" name="closed" ' . ($row["closed"] == 1 ? "checked" : "") . '></td>';
	echo '<td><table><tr>';

	echo '<td><input type="image" src="../images/alter.gif" alt="edit" value="alter"></form></td>';

	echo '<form action="survey_delete.php" method="post" onsubmit="return confirmSubmit()">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<td><input type="image" src="../images/delete.gif" alt="delete" value="delete"></form></td>';

	echo '<form action="survey_reset.php" method="post" onsubmit="return confirmSubmit()">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<td><input type="image" src="../images/reset.gif" alt="reset answers" value="reset answers"></form></td>';

	echo '<form action="survey_history.php" method="post">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<td><input type="image" src="../images/history.gif" alt="see history" value="see history"></form></td>';

	echo '<td valign="top"><a href="../result.php?survey='.$survey.'" target="_blank"><img src="../images/result.gif" border=0 alt="see results"></a></td>';

	echo '<form action="question_edit.php" method="post">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<td><input type="image" src="../images/inspect.gif" alt="edit questions" value="edit questions"></form></td>';

	echo '</tr></table></td></tr>';
}

$survey++;
echo '<form action="survey_add.php" method="post">';
echo '<input type="hidden" name="survey" value="' . $survey . '">';
echo '<tr><td valign="top"><b><font size="2">'.$survey.'</font></b></td>';
echo '<td valign="top"><input type="text" class="txtfld" size=30 name="title" value=""></td>';
echo '<input type="hidden" class="txtfld" size=30 name="url" value="">';
echo '<td valign="top" align="center">'; formtemplates(''); echo '</td>';
echo '<td valign="top" align="center">'; formsinglevote(1); echo '</td>';
echo '<td valign="top" align="center"><input type="checkbox" name="log"></td>';
echo '<td valign="top" align="center"><input type="checkbox" name="required" checked></td>';
echo '<td valign="top" align="center"><input type="checkbox" name="closed"></td>';
echo '<td><input type="image" src="../images/add.gif" alt="add" value="add" align="middle"></form></td></tr>';

echo '</table>';
closeadmin();
?>
</div>
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



