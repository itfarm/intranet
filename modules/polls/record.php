<?php
@include_once('./header.php');
echo '<!-- start page -->
		<div id="page">
		<!-- start content -->
		<div id="content">
			<div style="clear: both;">&nbsp;</div>';
if (!isset($path)) $path = "./";
include_once($path."survey.inc.php");
include_once($path."includes/nabopoll.inc.php");
include_once($path."includes/tags.inc.php");

connectdb();

if (!isset($quickpoll) || $quickpoll!=1) $quickpoll = 0;
if ($quickpoll==0)
{
	session_start();
	$survey = $_SESSION["survey"];
	$question = $_SESSION["question"];
}

$res_survey = mysql_query("select * from nabopoll_surveys where id=$survey");
if ($res_survey == FALSE || mysql_numrows($res_survey) != 1)
	error($row_survey, "survey not found");
$row_survey = mysql_fetch_array($res_survey);

$res_question = mysql_query("select * from nabopoll_questions where survey=$survey and id=$question");
if ($res_question == FALSE || mysql_numrows($res_question) != 1)
	error($res_question, "error in database");
$row_question = mysql_fetch_array($res_question);
if ($row_question["type"] == QT_MULTI)
{
	// build the answer
	$answer = "";
	$ansid = 1;
	$res_answer = mysql_query("select * from nabopoll_answers where survey=$survey and question=$question");
	while ($row_answer = mysql_fetch_array($res_answer))
	{
		$var = "answer_" . $ansid;
		if (isset(${$var}) && ${$var} != "" && ${$var} != "off") $answer = $answer."1";
		else $answer = $answer."0";
		$ansid++;
	}
}

if ($answer == "" && $row_survey["required"] == 1)
	error($row_survey, "please answer all the questions<br><a href='javascript: history.go(-1);'>back</a>");

$record = "";
$var = "answer" . $question;
${$var} = $answer;

if ($quickpoll==0)
	$_SESSION[$var] = $answer;

$question++;
$res_question = mysql_query("select * from nabopoll_questions where survey=$survey and id=$question");

if ($res_question == FALSE || mysql_numrows($res_question) == 0)
{
	// record all the answers
	$question = 1;

	while (true)
	{
		$res_question = mysql_query("select * from nabopoll_questions where survey=$survey and id=$question");
		if ($res_question == FALSE || mysql_numrows($res_question) == 0)
			break;
		$row_question = mysql_fetch_array($res_question);

		$var = "answer" . $question;
		if ($quickpoll == 0)
			$answer = $_SESSION[$var];
		$record = recordanswer($row_survey, $row_question, $answer, $record);

		$question++;
	}

	recordvote($row_survey, $record);

	if ($quickpoll!=1)
		session_destroy();

	if ($quickpoll!=1)
	{
		opensurvey($survey);
		$survey_end = gettemplate($row_survey, 'survey_end');
		$survey_end = surveytags($survey_end, $row_survey);
		$survey_end = str_replace($tags["survey_results"], 'result.php?survey='.$survey, $survey_end);
		echo $survey_end;
		closehtml($row_survey);
	}
	else
	{
		redirect(getenv("HTTP_REFERER"));
	}
}

if (!isset($quickpoll) || $quickpoll!=1)
	$_SESSION["question"] = $question;

if ($quickpoll!=1) redirect("vote.php?" . ((SID == "") ? "" : "&" . SID));
else redirect(getenv("HTTP_REFERER"));
echo '</div>
		<!-- end content -->
		<!-- start sidebar-right -->
		<div id="sidebar-right" class="sidebar">
			<?php poll_sidebar(); ?>
		</div>
		<!-- end sidebar-right -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->';@include_once('./footer.php');
?>
