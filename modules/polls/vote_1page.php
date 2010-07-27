<?php

if (!isset($path)) $path = "./";
include_once($path."survey.inc.php");

if (isset($surv) && $surv != "")
	$survey = $surv;

if ($survey == "")
	error($row_survey, "survey not specified");

$row_survey = opensurvey($survey);

if ($row_survey["closed"] == 1)
	error($row_survey, "this survey is closed. no more answers taken. sorry!");

if ($row_survey["single_vote"] == 1)
{
	$res_ip = mysql_query("select * from nabopoll_ip where survey=$survey and ip=\"".$HTTP_SERVER_VARS['REMOTE_ADDR']."\"");
	if (mysql_numrows($res_ip) != 0)
		error($row_survey, "you already submitted an answer for this survey");
}
else if ($row_survey["single_vote"] == 2)
{
	$cookie = "nabopoll_".$row_survey["uid"];
	if (${$cookie} == "1")
		error($row_survey, "you already submitted an answer for this survey");
}

$res_question = mysql_query("select * from nabopoll_questions where survey=$survey");
if ($res_question == FALSE || mysql_numrows($res_question) == 0)
	error($row_survey, "questions not found");

// get the template and tags
$question_text = gettemplate($row_survey, 'vote');
include($path."includes/tags.inc.php");

// get special config for this template
$tpl = $template;
if ($tpl=="")
	$tpl = $row_survey["template"];
include($path.'templates/'.$tpl.'/config.inc.php');

echo '<form action="'.$path.'record_1page.php" method="post">';
echo '<input type="hidden" name="survey" value="'.$survey. '">';
while ($row_question = mysql_fetch_array($res_question))
{
	showquestion($row_survey, $row_question, SM_ONEPAGE);
}
echo '<input type="image" src="'.$path.$image_vote.'" value="vote" border="0" name="vote" align="absmiddle">';
echo '</form>';

closehtml($row_survey);

?>
