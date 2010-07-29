<?php
	@include_once('./header.php');
?>
		<!-- start page -->
		<div id="page">
			<!-- start content -->
			<div id="content">
				<?php
					if (!isset($path)) $path = "./";					include_once($path."survey.inc.php");					if (isset($surv) && $surv != "") $survey = $surv;					if ($survey == "") error($row_survey, "survey not specified");					$row_survey = opensurvey($survey);					$res_question = mysql_query("select * from nabopoll_questions where survey=$survey order by id");					if ($res_question == FALSE || mysql_numrows($res_question) == 0) error($row_survey, "questions not found");					while ($row_question = mysql_fetch_array($res_question)) {						showquestionresult($row_survey, $row_question, 0);					}					$back_url = $row_survey["url"];					echo '<p><a href="' . $back_url . '">back</a></p>';					closehtml($row_survey);
				?>
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

