<?php
include_once("admin.inc.php");
$back_url = "/poll/survey_edit.php";

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

connectdb();

$res_survey = mysql_query("select * from nabopoll_surveys where id=$survey");
if ($res_survey == FALSE || mysql_num_rows($res_survey) == 0)
	error("survey not found");

$res_question = mysql_query("select * from nabopoll_questions where survey=$survey and id=$question");
if ($res_question == FALSE || mysql_num_rows($res_question) == 0)
	error("question not found");

$res_answers = mysql_query("select * from nabopoll_answers where survey=$survey and question=$question order by id");
if ($res_answers == FALSE)
	error("database error");

openadmin();
$answer=0;

echo '<table cellspacing=0><tr bgcolor="gray">';
echo '<th><font color="white" size="-1">&nbsp;#&nbsp;</font></th>';
echo '<th><font color="white" size="-1">&nbsp;Answer&nbsp;</font></th>';
echo '<th><font color="white" size="-1">&nbsp;Actions&nbsp;</font></th>';
echo '</tr><tr><td>&nbsp;</td></tr>';

$count = mysql_num_rows($res_answers);

while ($row = mysql_fetch_array($res_answers))
{
	$answer = $row["id"];

	echo '<tr><td valign="top"><b><font size="-1">' . $answer . '</font></b></td>';

	echo '<form action="answer_alter.php" method="post">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<input type="hidden" name="question" value="' . $question . '">';
	echo '<input type="hidden" name="answer" value="' . $answer . '">';
	echo '<td valign="top"><input type="text" class="txtfld" size=30 name="prompt" value="' . $row["answer"] . '"></td>';

	echo '<td><table><tr>';

	echo '<td><input type="image" src="../images/alter.gif" alt="edit" value="edit"></form></td>';

	echo '<form action="answer_delete.php" method="post" onsubmit="return confirmSubmit()">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<input type="hidden" name="question" value="' . $question . '">';
	echo '<input type="hidden" name="answer" value="' . $answer . '">';
	echo '<td><input type="image" src="../images/delete.gif" alt="delete" value="delete"></form></td>';

	echo '<form action="answer_insert.php" method="post">';
	echo '<input type="hidden" name="survey" value="' . $survey . '">';
	echo '<input type="hidden" name="question" value="' . $question . '">';
	echo '<input type="hidden" name="answer" value="' . $answer . '">';
	echo '<td><input type="image" src="../images/insert.gif" alt="insert before" value="insert before">';
	echo '</form></td>';

	if ($count != mysql_num_rows($res_answers))
	{
		echo '<form action="answer_move.php" method="post">';
		echo '<input type="hidden" name="survey" value="' . $survey . '">';
		echo '<input type="hidden" name="question" value="' . $question . '">';
		echo '<input type="hidden" name="answer" value="' . $answer . '">';
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
		echo '<form action="answer_move.php" method="post">';
		echo '<input type="hidden" name="survey" value="' . $survey . '">';
		echo '<input type="hidden" name="question" value="' . $question . '">';
		echo '<input type="hidden" name="answer" value="' . $answer . '">';
		echo '<input type="hidden" name="direction" value="down">';
		echo '<td><input type="image" src="../images/down.gif" alt="move down" value="move down">';
		echo '</form></td>';
	}
	else
	{
		echo '<td width=16></td>';
	}

	echo '</tr></table></td></tr>';
	$count--;
}

$answer++;
echo '<form action="answer_add.php" method="post">';
echo '<input type="hidden" name="survey" value="' . $survey . '">';
echo '<input type="hidden" name="question" value="' . $question . '">';
echo '<input type="hidden" name="answer" value="' . $answer . '">';
echo '<tr><td valign="top"><b><font size="-1">'.$answer.'</font></b></td>';
echo '<td valign="top"><input type="text" class="txtfld" size=30 name="prompt" value=""></td>';
echo '<td><input type="image" src="../images/add.gif" alt="add" value="add"></form></td></tr>';

echo '</table>';

echo '<p><a href="question_edit.php?survey='.$survey.'">back</a></p>';
closeadmin();

?>



