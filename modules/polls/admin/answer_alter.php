<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

if ($prompt == "")
	error("text mandatory");

if ($answer == "")
	error("no answer specified");

connectdb();

$res = mysql_query("update nabopoll_answers set answer=\"$prompt\" where survey=$survey and question=$question and id=$answer");

redirect("answer_edit.php?survey=".$survey."&question=".$question);

?>



