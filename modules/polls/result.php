<?php

if (!isset($path)) $path = "./";
include_once($path."survey.inc.php");

if (isset($surv) && $surv != "")
	$survey = $surv;

if ($survey == "")
	error($row_survey, "survey not specified");

$row_survey = opensurvey($survey);

$res_question = mysql_query("select * from nabopoll_questions where survey=$survey order by id");
if ($res_question == FALSE || mysql_numrows($res_question) == 0)
	error($row_survey, "questions not found");

while ($row_question = mysql_fetch_array($res_question))
{
	showquestionresult($row_survey, $row_question, 0);
}

$back_url = $row_survey["url"];

echo '<p><a href="' . $back_url . '">back</a></p>';
closehtml($row_survey);

?>
