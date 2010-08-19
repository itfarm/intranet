<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

connectdb();

$res = mysql_query("delete from nabopoll_surveys where id=$survey");
$res = mysql_query("delete from nabopoll_questions where survey=$survey");
$res = mysql_query("delete from nabopoll_answers where survey=$survey");
$res = mysql_query("delete from nabopoll_ip where survey=$survey");
$res = mysql_query("delete from nabopoll_history where survey=$survey");

$res = mysql_query("alter table nabopoll_surveys disable keys");
$res = mysql_query("update nabopoll_surveys set id=id-1 where id>=$survey");
$res = mysql_query("alter table nabopoll_questions enable keys");

$res = mysql_query("alter table nabopoll_questions disable keys");
$res = mysql_query("update nabopoll_questions set survey=survey-1 where survey>=$survey");
$res = mysql_query("alter table nabopoll_questions enable keys");

$res = mysql_query("alter table nabopoll_answers disable keys");
$res = mysql_query("update nabopoll_answers set survey=survey-1 where survey>=$survey");
$res = mysql_query("alter table nabopoll_answers enable keys");

$res = mysql_query("alter table nabopoll_ip disable keys");
$res = mysql_query("update nabopoll_ip set survey=survey-1 where survey>=$survey");
$res = mysql_query("alter table nabopoll_ip enable keys");

$res = mysql_query("alter table nabopoll_history disable keys");
$res = mysql_query("update nabopoll_history set survey=survey-1 where survey>=$survey");
$res = mysql_query("alter table nabopoll_history enable keys");

redirect("survey_edit.php");

?>



