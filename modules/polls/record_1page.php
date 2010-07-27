<?php

if (!isset($path)) $path = "./";
include_once($path."survey.inc.php");
include_once($path."includes/tags.inc.php");

connectdb();

$res_survey = mysql_query("select * from nabopoll_surveys where id=$survey");
if ($res_survey == FALSE || mysql_numrows($res_survey) != 1)
	error($row_survey, "survey not found");
$row_survey = mysql_fetch_array($res_survey);

$res_question = mysql_query("select * from nabopoll_questions where survey=$survey");
if ($res_question == FALSE || mysql_numrows($res_question) == 0)
	error($row_survey, "questions not found");

$record = "";
while ($row_question = mysql_fetch_array($res_question))
{
	$question = $row_question["id"];
	if ($row_question["type"] == QT_MULTI)
	{
		// build the answer
		$answer = "";
		$ansid = 1;
		$res_answer = mysql_query("select * from nabopoll_answers where survey=$survey and question=$question");
		while ($row_answer = mysql_fetch_array($res_answer))
		{
			$var = "answer" . $question . "_" . $ansid;
			if (isset(${$var}) && ${$var} != "" && ${$var} != "off") $answer = $answer."1";
			else $answer = $answer."0";
			$ansid++;
		}
	}
	else
	{
		$var = "answer" . $question;
		$answer = ${$var};
	}
	$record = recordanswer($row_survey, $row_question, $answer, $record);
}
recordvote($row_survey, $record);

opensurvey($survey);
$survey_end = gettemplate($row_survey, 'survey_end');
$survey_end = surveytags($survey_end, $row_survey);
$survey_end = str_replace($tags["survey_results"], 'result.php?survey='.$survey, $survey_end);
echo $survey_end;
closehtml($row_survey);

?>
