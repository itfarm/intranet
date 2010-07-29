<?php
	@include_once('./header.php');
?>
		<!-- start page -->
		<div id="page">
			<!-- start content -->
			<div id="content">
								<?php
					if (!isset($path)) $path = "./";
					include_once($path."survey.inc.php");					if (isset($_SESSION["survey"])) $survey = $_SESSION["survey"];					if (isset($_SESSION["question"])) $question = $_SESSION["question"];					if (isset($surv) && $surv != "") {						$survey = $surv;						$question = 1;					}					if (!isset($survey) || $survey == "")						error($row_survey, "survey not specified");					if (!isset($question) || $question == "")						$question = 1;					// record session stuff					$_SESSION["survey"] = $survey;					$_SESSION["question"] = $question;					$row_survey = opensurvey($survey);					if ($row_survey["closed"] == 1) error($row_survey, "this survey is closed. no more answers taken. sorry!");					if ($row_survey["single_vote"] == 1) {						$res_ip = mysql_query("select * from nabopoll_ip where survey=$survey and ip=\"".$HTTP_SERVER_VARS['REMOTE_ADDR']."\"");						if (mysql_numrows($res_ip) != 0)							error($row_survey, "you already submitted an answer for this survey");					}					else if ($row_survey["single_vote"] == 2) {						$cookie = "nabopoll_".$row_survey["uid"];						if (${$cookie} == "1") error($row_survey, "you already submitted an answer for this survey");					}					$res_question = mysql_query("select * from nabopoll_questions where survey=$survey and id=$question");					if ($res_question == FALSE || mysql_numrows($res_question) != 1) error($row_survey, "question not found");					$row_question = mysql_fetch_array($res_question);					echo '<form action="'.$path.'record.php" method="post">';					echo '<input type="hidden" name="quickpoll" value="0">';					echo '<input type="hidden" name="' . session_name().'" value="'.session_id(). '">';					showquestion($row_survey, $row_question, 0);					echo '</form>';					closehtml($row_survey);				?>
			</div>
			<!-- end content -->
			<!-- start sidebar-right -->
			<div id="sidebar-right" class="sidebar">
				<?php poll_sidebar($tag) ?>
			</div>
			<!-- end sidebar-right -->
			<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
<?php
	@include_once('./footer.php');
?>
