<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($title == "")
	error("title mandatory");

if ($testip == "") $testip = 0;
else $testip = 1;

if ($log == "") $log = 0;
else $log = 1;

if ($required == "") $required = 0;
else $required = 1;

if ($closed == "") $closed = 0;
else $closed = 1;

connectdb();

$res = mysql_query("update nabopoll_surveys set title=\"$title\", url=\"$url\", template=\"$template\", single_vote=$single_vote, log=$log, required=$required, closed=$closed where id=$survey");

redirect("survey_edit.php");

?>



