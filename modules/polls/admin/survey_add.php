<?php
include_once("admin.inc.php");

if (!isset($survey) || $survey == "")
	error("no survey specified");

if (!isset($title) || $title == "")
	error("title mandatory");

if ($single_vote == "")
	$single_vote = 0;

if (!isset($log) || $log == "") $log = 0;
else $log = 1;

if (!isset($required) || $required == "") $required = 0;
else $required = 1;

if (!isset($closed) || $closed == "") $closed = 0;
else $closed = 1;

connectdb();

$res = mysql_query("insert into nabopoll_surveys values($survey, \"$title\", \"$url\", \"$template\", $single_vote, ".getuniqueid().", $log, $required, $closed)");

redirect("survey_edit.php");

?>



