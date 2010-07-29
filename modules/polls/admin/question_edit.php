<?php
include_once("admin.inc.php");
$back_url = "/poll/survey_edit.php";
include_once("admin.inc.php");
@include('../../../cfg/config.php');
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
if ($survey == "")
	error("no survey specified");

connectdb();

$res_survey = mysql_query("select * from nabopoll_surveys where id=$survey");
if ($res_survey == FALSE || mysql_num_rows($res_survey) == 0)
	error("survey not found");

$res_questions = mysql_query("select * from nabopoll_questions where survey=$survey order by id");
if ($res_questions == FALSE)
	error("database error");

openadmin();
$question=0;

echo '<table cellspacing=0><tr bgcolor="gray">';
echo '<th><font color="white" size="-1">&nbsp;#&nbsp;</font></th>';
echo '<th><font color="white" size="-1">&nbsp;Question&nbsp;</font></th>';
echo '<th><font color="white" size="-1">&nbsp;Type&nbsp;</font></th>';
echo '<th><font color="white" size="-1">&nbsp;Actions&nbsp;</font></th>';
echo '</tr><tr><td>&nbsp;</td></tr>';

$count = mysql_num_rows($res_questions);

while ($row = mysql_fetch_array($res_questions))
{
	$question = $row["id"];

	echo '<tr><td valign="top"><b><font size="-1">' . $question . '</font></b></td>';

	echo '<form action="question_alter.php" method="post">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<input type="hidden" name="question" value="' . $question . '">';
	echo '<td valign="top"><input type="text" class="txtfld" size=30 name="prompt" value="' . $row["question"] . '"></td>';

	echo '<td valign="top" align="center">';
	echo '<select name="type">';
	echo '<option value="'.QT_SINGLE.'"' . (($row["type"] == QT_SINGLE) ? ' selected' : '') . '>Single choice</option>';
	echo '<option value="'.QT_MULTI.'"' .  (($row["type"] == QT_MULTI) ? ' selected' : '')  . '>Multi choice</option>';
	echo '<option value="'.QT_FREE.'"' .   (($row["type"] == QT_FREE) ? ' selected' : '')   . '>Free Text</option>';
	echo '</select>';
	echo '</td>';

	echo '<td><table><tr>';

	echo '<td><input type="image" src="../images/alter.gif" alt="edit" value="edit"></form></td>';

	echo '<form action="question_delete.php" method="post" onsubmit="return confirmSubmit()">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<input type="hidden" name="question" value="' . $question . '">';
	echo '<td><input type="image" src="../images/delete.gif" alt="delete" value="delete"></form></td>';

	echo '<form action="question_insert.php" method="post">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<input type="hidden" name="question" value="' . $question . '">';
	echo '<td><input type="image" src="../images/insert.gif" alt="insert before" value="insert before">';
	echo '</form></td>';

	if ($count != mysql_num_rows($res_questions))
	{
		echo '<form action="question_move.php" method="post">';
		echo '<input type="hidden" name="survey" value="' . $survey . '">';
		echo '<input type="hidden" name="question" value="' . $question . '">';
		echo '<input type="hidden" name="direction" value="up">';
		echo '<td><input type="image" src="../images/up.gif" alt="move up" value="move up">';
		echo '</form></td>';
	}
	else
	{
		echo '<td width=16></td>';
	}

	if ($count != 1)
	{
		echo '<form action="question_move.php" method="post">';
		echo '<input type="hidden" name="survey" value="' . $survey . '">';
		echo '<input type="hidden" name="question" value="' . $question . '">';
		echo '<input type="hidden" name="direction" value="down">';
		echo '<td><input type="image" src="../images/down.gif" alt="move down" value="move down">';
		echo '</form></td>';
	}
	else
	{
		echo '<td width=16></td>';
	}

	if ($row["type"] != 2)
	{
		echo '<form action="answer_edit.php" method="post">';
		echo '<input type="hidden" name="survey" value="' . $survey . '">';
		echo '<input type="hidden" name="question" value="' . $question . '">';
		echo '<td><input type="image" src="../images/inspect.gif" alt="edit answers" value="edit answers">';
		echo '</form></td>';
	}

	echo '</tr></table></td></tr>';
	$count--;
}

$question++;
echo '<form action="question_add.php" method="post">';
echo '<input type="hidden" name="survey" value="' . $survey . '">';
echo '<input type="hidden" name="question" value="' . $question . '">';
echo '<tr><td valign="top"><b><font size="-1">'.$question.'</font></b></td>';
echo '<td valign="top"><input type="text" class="txtfld" size=30 name="prompt" value=""></td>';
echo '<td valign="top" align="center"><select name="type"><option value="'.QT_SINGLE.'">Single choice</option><option value="'.QT_MULTI.'">Multi choice</option><option value="'.QT_FREE.'">Free Text</option></select></td>';
echo '<td><input type="image" src="../images/add.gif" alt="add" value="add"></form></td></tr>';

echo '</table>';

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



