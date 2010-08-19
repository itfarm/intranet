<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

if ($answer == "")
	error("no answer specified");

if ($prompt == "")
	error("text mandatory");

connectdb();

$res = mysql_query("insert into nabopoll_answers values($survey, $question, $answer, \"$prompt\", 0)");

redirect("answer_edit.php?survey=".$survey."&question=".$question);

?>



