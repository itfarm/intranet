<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

if ($prompt == "")
	error("text mandatory");

connectdb();

$res = mysql_query("insert into nabopoll_questions values($survey, $question, \"$prompt\", $type, 0)");

redirect("question_edit.php?survey=" . $survey);

?>



