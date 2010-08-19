<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

if ($answer == "")
	error("no answer specified");

connectdb();

$old = $answer;
if ($direction=="up")
	$new=$answer-1;
else
	$new=$answer+1;

$res = mysql_query("update nabopoll_answers set id=-1 where survey=$survey and question=$question and id=$new");
$res = mysql_query("update nabopoll_answers set id=$new where survey=$survey and question=$question and id=$old");
$res = mysql_query("update nabopoll_answers set id=$old where survey=$survey and question=$question and id=-1");

redirect("answer_edit.php?survey=".$survey."&question=".$question);

?>



