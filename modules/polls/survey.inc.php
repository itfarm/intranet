<?php

include_once($path."includes/nabopoll.inc.php");

function gettemplate($row_survey, $tpl)
{
	global $path;
	global $template;

	$tmpl = $template;
	if ($tmpl == "")
		$tmpl = $row_survey["template"];

	$filename = $path.'templates/'.$tmpl.'/'.$tpl.'.tpl';
	$fd = fopen($filename, "r");
	$content = fread($fd, filesize ($filename));
	fclose($fd);
	return $content;
}

function surveytags($string, $row_survey)
{
	global $path;

	include($path."includes/tags.inc.php");

	$logo = '<p><font size="-2">powered by</font>
	<br><a href="http://www.nabocorp.com/nabopoll" target="_blank">
	<img src="'.$path.'images/nabopoll.gif" border=0 align="absmiddle" alt="nabopoll"></a></p>';

	$string = str_replace($tags["survey_id"], $row_survey["id"], $string);
	$string = str_replace($tags["survey_text"], $row_survey["title"], $string);
	$string = str_replace($tags["survey_url"], $row_survey["url"], $string);
	$string = str_replace($tags["nabopoll_logo"], $logo, $string);

	return $string;
}

function questiontags($string, $row_answer)
{
	global $path;
	include($path."includes/tags.inc.php");

	$string = str_replace($tags["question_id"], $row_answer["id"], $string);
	$string = str_replace($tags["question_text"], $row_answer["question"], $string);

	return $string;
}

function opensurvey($survey)
{
	connectdb();
	$res_survey = mysql_query("select * from nabopoll_surveys where id=$survey");
	if ($res_survey == FALSE || mysql_numrows($res_survey) != 1)
		error($row_survey, "survey not found");
	$row_survey = mysql_fetch_array($res_survey);

	header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
	header("Pragma: no-cache");                                   // HTTP/1.0

	$header = gettemplate($row_survey, 'header');
	$header = surveytags($header, $row_survey);
	echo $header;

	return $row_survey;
}

function closehtml($row_survey)
{
	$footer = gettemplate($row_survey, 'footer');
	$footer = surveytags($footer, $row_survey);
	echo $footer;
	//exit();
}

function error($row_survey, $error_msg)
{
	global $path;

	include($path."includes/tags.inc.php");

	if ($error_msg != "")
	{
		echo '<p align="center">'.$error_msg.'</p>';
		//exit();
	}

	if ($opened == false)
		openhtml("error");

	$error = gettemplate('error');
	$error = surveytags($error);
	$error = str_replace($tags["error_msg"], error_msg, $error);

	echo $error;
	closehtml();
	//exit();
}

// $mode: SM_NORMAL, SM_QUICK...
function showquestion($row_survey, $row_question, $mode)
{
	global $path;
	global $template;
	$count = 0;

	// get the template and tags
	$question_text = gettemplate($row_survey, 'vote');
	include($path."includes/tags.inc.php");

	// get special config for this template
	$tpl = $template;
	if ($tpl=="")
		$tpl = $row_survey["template"];
	include($path.'templates/'.$tpl.'/config.inc.php');

	// replace survey and question tags
	$question_text = surveytags($question_text, $row_survey);
	$question_text = questiontags($question_text, $row_question);
	$answer_name = ($mode == SM_ONEPAGE) ? "answer" . $row_question["id"] : "answer";

	if ($row_question["type"] == QT_FREE)
	{
		$start = strpos($question_text, $tags["answer_start"]);
		$end = strpos($question_text, $tags["answer_end"]);

		// build the answer
		$answer_tmpl = substr($question_text, $start, $end-$start+strlen($tags["answer_end"]));
		$answer = substr($answer_tmpl, strlen($tags["answer_start"]), strlen($answer_tmpl)-strlen($tags["answer_start"])-strlen($tags["answer_end"]));
		$answer = str_replace($tags["answer_radio"], "&nbsp;&nbsp;&nbsp;", $answer);
		$answer = str_replace($tags["answer_id"], $row_question["id"], $answer);
		$answer = str_replace($tags["answer_text"], '<input type="text" name="'.$answer_name.'" size=40>', $answer);
		$question_text = substr($question_text, 0, $start) . $answer . substr($question_text, $end+strlen($tags["answer_end"]));
	}
	else
	{
		// type of option
		$type = "radio";
		if ($row_question["type"] == QT_MULTI)
			$type = "checkbox";

		// get the list of answers
		$survey_id = $row_survey["id"];
		$question_id = $row_question["id"];
		$res_answer = mysql_query("select * from nabopoll_answers where survey=$survey_id and question=$question_id order by id");
		if ($res_answer == FALSE || mysql_numrows($res_answer) == 0)
			error($row_survey, "error in database");

		while ($row_answer = mysql_fetch_array($res_answer))
		{
			$count++;

			// get the answer template
			$start = strpos($question_text, $tags["answer_start"]);
			$end = strpos($question_text, $tags["answer_end"]);
			if ($start==FALSE || $end==FALSE)
			{
				if ($mode==SM_QUICK)
				{
					echo 'error in template';
					return;
				}
				else
				{
					error($row_survey, "error in template");
				}
			}
			$answer_tmpl = substr($question_text, $start, $end-$start+strlen($tags["answer_end"]));

			// final answer name
			$real_answer_name = $answer_name;
			if ($row_question["type"] == QT_MULTI)
				$real_answer_name = $real_answer_name."_".$count;

			// build the answer
			$answer = substr($answer_tmpl, strlen($tags["answer_start"]), strlen($answer_tmpl)-strlen($tags["answer_start"])-strlen($tags["answer_end"]));
			$answer = str_replace($tags["answer_radio"],' <input type="'.$type.'" name="'.$real_answer_name.'" value="'.$row_answer["id"].'">', $answer);
			$answer = str_replace($tags["answer_id"], $row_answer["id"], $answer);
			$answer = str_replace($tags["answer_text"], $row_answer["answer"], $answer);

			// if this is the last answer then we stop adding the template
			if ($count == mysql_numrows($res_answer))
				$answer_tmpl = "";

			// new string
			$question_text = substr($question_text, 0, $start) . $answer . $answer_tmpl . substr($question_text, $end+strlen($tags["answer_end"]));
		}
	}

	if ($mode == SM_ONEPAGE)
	{
		// remove last tags
		$question_text = str_replace($tags["question_submit"], "", $question_text);

		// link to results
		if ($mode == SM_QUICK)
			$question_text = str_replace($tags["survey_results"], "", $question_text);
	}
	else
	{
		// put the submit image
		$question_text = str_replace($tags["question_submit"], '<input type="image" src="'.$path.$image_vote.'" value="vote" border="0" name="vote" align="absmiddle">', $question_text);

		// link to results
		if ($mode == SM_QUICK)
			$question_text = str_replace($tags["survey_results"], $path.'quickpoll.php?survey='.$row_survey["id"].'&result=1', $question_text);
	}

	// done
	echo $question_text;
}

function showquestionresult($row_survey, $row_question, $quickpoll)
{
	global $path;
	global $template;

	// get the template and tags
	$result_text = gettemplate($row_survey, 'result');
	include($path."includes/tags.inc.php");

	// get special config for this template
	$tpl = $template;
	if ($tpl=="")
		$tpl = $row_survey["template"];
	include($path.'templates/'.$tpl.'/config.inc.php');

	// for backward compatibility
	if (!isset($bat_width) || $bar_width == "") $bar_width = 100;
	if (!isset($bar_height) || $bar_height == "") $bar_height = 12;
	if (!isset($pct_decimal) || $pct_decimal == "") $pct_decimal = 1;

	// replace survey and question tags
	$result_text = surveytags($result_text, $row_survey);
	$result_text = questiontags($result_text, $row_question);

	// get the list of answers
	$survey_id = $row_survey["id"];
	if ($quickpoll==1) $question_id = 1;
	else $question_id = $row_question["id"];
	$res_answer = mysql_query("select * from nabopoll_answers where survey=$survey_id and question=$question_id order by id");
	if ($res_answer == FALSE || mysql_numrows($res_answer) == 0)
	{
		if ($quickpoll==1)
		{
			echo 'error in database';
			return;
		}
		else
		{
			error($row_survey, "error in database");
		}
	}

	$count = 0;
	$votes = 0;
	$max = 0;
	while ($row_answer = mysql_fetch_array($res_answer))
	{
		$vote = $row_answer["count"];
		$votes = $votes + $vote;
		if ($vote > $max)
			$max = $vote;
	}

	if ($row_question["votes"] != 0)
		$votes = $row_question["votes"];

	mysql_data_seek($res_answer,0);

	while ($row_answer = mysql_fetch_array($res_answer))
	{
		$vote = $row_answer["count"];
		if ($votes==0)
		{
			$vote = 0;
			$pct = 0;
		}
		else
		{
			$pct = $vote/$votes*100;
		}

		$barnormal = getimage($image_pct_normal, $path, $tpl, "pctnormal");
		$barmax = getimage($image_pct_max, $path, $tpl, "pctmax");
		$barwhite = getimage($image_pct_white, $path, $tpl, "pctwhite");

		if ($max !=0 && $vote == $max)
			$bar = getbar($pct, $bar_width, $bar_height, $barmax, $barwhite);
		else
			$bar = getbar($pct, $bar_width, $bar_height, $barnormal, $barwhite);

		$count++;

		$start = strpos($result_text, $tags["answer_start"]);
		$end = strpos($result_text, $tags["answer_end"]);

		if ($start==FALSE || $end==FALSE)
		{
			if ($quickpoll==1)
			{
				echo 'error in template';
				return;
			}
			else
			{
				error($row_survey, "error in template");
			}
		}

		$answer_tmpl = substr($result_text, $start, $end-$start+strlen($tags["answer_end"]));

		$answer = substr($answer_tmpl, strlen($tags["answer_start"]), strlen($answer_tmpl)-strlen($tags["answer_start"])-strlen($tags["answer_end"]));
		$answer = str_replace($tags["answer_id"], $row_answer["id"], $answer);
		$answer = str_replace($tags["answer_text"], $row_answer["answer"], $answer);
		$answer = str_replace($tags["answer_bar"], $bar, $answer);
		$answer = str_replace($tags["answer_vote"], $vote, $answer);
		$answer = str_replace($tags["answer_pct"], round($pct,$pct_decimal), $answer);

		if ($count == mysql_numrows($res_answer))
			$answer_tmpl = "";

		$result_text = substr($result_text, 0, $start) . $answer . $answer_tmpl . substr($result_text, $end+strlen($tags["answer_end"]));
	}

	if ($row_question["votes"] != 0)
		$votes = $row_question["votes"];

	$result_text = str_replace($tags["question_votes"], $votes, $result_text);
	echo $result_text;
}

function recordvote($row_survey, $record)
{
	$survey = $row_survey["id"];

	if ($row_survey["log"] == 1)
	{
		$record = substr($record, 0, strlen($record)-1);
		$now = date("Y-m-d H:i:s");
		mysql_query("insert into nabopoll_history values($survey, \"".$_SERVER['REMOTE_ADDR']."\", '$now', \"$record\")");
	}

	if ($row_survey["single_vote"] == 1)
	{
		mysql_query("insert into nabopoll_ip values($survey, \"".$_SERVER['REMOTE_ADDR']."\")");
	}
	else if ($row_survey["single_vote"] == 2)
	{
		$cookie = "nabopoll_".$row_survey["uid"];
		setcookie($cookie, "1", time()+3600*24*365*10, "/");
	}
}

function recordanswer($row_survey, $row_question, $answer, $record)
{
	$survey = $row_survey["id"];
	$question = $row_question["id"];

	if ($answer == "" && $row_survey["required"] == 1)
		error($row_survey, "please answer all the questions<br><a href='javascript: history.go(-1);'>back</a>");

	if ($row_question["type"] == QT_FREE)
	{
		if ($answer != "")
		{
			$record = $record . '[' . $answer . "]-";

			$res_answer = mysql_query("select * from nabopoll_answers where survey=$survey and question=$question and answer=\"".$answer."\"");
			if ($res_answer == FALSE || mysql_num_rows($res_answer) == 0)
			{
				$res_answer = mysql_query("select max(id)+1 as id from nabopoll_answers where survey=$survey and question=$question");
				if ($res_answer == FALSE)
				{
					$id = 1;
				}
				else
				{
					$row_answer = mysql_fetch_array($res_answer);
					$id = $row_answer["id"];
					if ($id == "") $id = 1;
				}
				mysql_query("insert into nabopoll_answers values($survey, $question, $id, \"$answer\", 1)");
			}
			else
			{
				$row_answer = mysql_fetch_array($res_answer);
				$id = $row_answer["id"];
				$res_answer = mysql_query("update nabopoll_answers set count=count+1 where survey=$survey and question=$question and id=$id");
			}

			mysql_query("update nabopoll_questions set votes=votes+1 where survey=$survey and id=$question");
		}
	}
	else
	{
		if ($answer == "")
			$answer = 0;

		$record = $record . $answer . "-";

		if ($answer != 0)
		{
			if ($row_question["type"] == QT_SINGLE)
			{
				$res_answer = mysql_query("update nabopoll_answers set count=count+1 where survey=$survey and question=$question and id=$answer");
				if ($res_answer == FALSE)
				{
					echo $survey.' | '.$question.' | '.$answer.'<br>';
					error($row_survey, "answer not found");
				}
			}
			else
			{
				// parse the answer
				$ansid = 1;
				$res_answer = mysql_query("select * from nabopoll_answers where survey=$survey and question=$question");
				while ($row_answer = mysql_fetch_array($res_answer))
				{
					if ($answer[$ansid-1] == "1")
					{
						$res_update = mysql_query("update nabopoll_answers set count=count+1 where survey=$survey and question=$question and id=$ansid");
						if ($res_update == FALSE)
						{
							echo $survey.' | '.$question.' | '.$answer.'<br>';
							error($row_survey, "answer not found");
						}
					}
					$ansid++;
				}
			}

			mysql_query("update nabopoll_questions set votes=votes+1 where survey=$survey and id=$question");
		}
	}

	return $record;
}

?>
