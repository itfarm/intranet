<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

if ($prompt == "")
	error("text mandatory");

connectdb();

$res = mysql_query("update nabopoll_questions set question=\"$prompt\", type=$type where survey=$survey and id=$question");

redirect("question_edit.php?survey=" . $survey);

?>



