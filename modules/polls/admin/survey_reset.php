<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

connectdb();

$res = mysql_query("update nabopoll_answers set count=0 where survey=$survey");
$res = mysql_query("delete from nabopoll_ip where survey=$survey");
$res = mysql_query("delete from nabopoll_history where survey=$survey");
$res = mysql_query("update nabopoll_surveys set uid=".getuniqueid()." where id=$survey");

// reset counters and delete free text answers
$res_question = mysql_query("select * from nabopoll_questions where survey=$survey");
while ($row_question = mysql_fetch_array($res_question))
{
	if ($row_question["type"] == QT_FREE)
		$res = mysql_query("delete from nabopoll_answers where survey=$survey and question=".$row_question["id"]);
	$res = mysql_query("update nabopoll_questions set votes=0 where survey=$survey and id=".$row_question["id"]);
}

redirect("survey_edit.php");

?>



