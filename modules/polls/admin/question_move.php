<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

connectdb();

$old = $question;
if ($direction=="up")
	$new=$question-1;
else
	$new=$question+1;

$res = mysql_query("update nabopoll_questions set id=-1 where survey=$survey and id=$new");
$res = mysql_query("update nabopoll_answers set question=-1 where survey=$survey and question=$new");

$res = mysql_query("update nabopoll_questions set id=$new where survey=$survey and id=$old");
$res = mysql_query("update nabopoll_answers set question=$new where survey=$survey and question=$old");

$res = mysql_query("update nabopoll_questions set id=$old where survey=$survey and id=-1");
$res = mysql_query("update nabopoll_answers set question=$old where survey=$survey and question=-1");

redirect("question_edit.php?survey=" . $survey);

?>



