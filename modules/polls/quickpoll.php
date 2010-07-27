<?php

if (!isset($path)) $path = "./";
include_once($path."survey.inc.php");

if (isset($surv) && $surv != "")
	$survey = $surv;

if ($survey == "")
{
	echo 'survey not specified';
	return;
}

if (!isset($result_url) || $result_url == "")
	$result_url = "quickpoll.php?surv=".$survey."&result=1";

if (!isset($result_target) || $result_target == "")
	$result_target = "_blank";

connectdb();

$res_survey = mysql_query("select * from nabopoll_surveys where id=$survey");
if ($res_survey == FALSE || mysql_numrows($res_survey) != 1)
{
	echo 'survey not found';
	return;
}
$row_survey = mysql_fetch_array($res_survey);

$res_question = mysql_query("select * from nabopoll_questions where survey=$survey and id=1");
if ($res_question == FALSE || mysql_numrows($res_question) != 1)
{
	echo 'question not found';
	return;
}
$row_question = mysql_fetch_array($res_question);

if ($row_survey["single_vote"] == 1)
{
	$res_ip = mysql_query("select * from nabopoll_ip where survey=$survey and ip=\"".$_SERVER['REMOTE_ADDR']."\"");
	if (mysql_numrows($res_ip) != 0)
		$result=1;
}
else if ($row_survey["single_vote"] == 2)
{
	$cookie = "nabopoll_".$row_survey["uid"];
	global ${$cookie};
	if (${$cookie} == "1")
		$result=1;
}

if (isset($result) && $result == 1)
{
	showquestionresult($row_survey, $row_question, 1);
}
else
{
	if ($row_survey["closed"] == 1)
	{
		echo 'this survey is closed. no more answers taken. sorry!';
		return;
	}

	echo '<form action="'.$path.'record.php" method="post">';
	echo '<input type="hidden" name="survey" value="'.$survey. '">';
	echo '<input type="hidden" name="question" value="1">';
	echo '<input type="hidden" name="quickpoll" value="1">';
	echo "\n";
	showquestion($row_survey, $row_question, 1);
	echo "</form>\n";
}

?>