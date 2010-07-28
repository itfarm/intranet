<?php
	@include('../../cfg/config.php');
	$page = $_GET['page'];
	$tag =  $_GET['tag'];
	@session_start();
	if(!isset($_SESSION['username']))
	{
		@header("location:$loginPage?");
	}
	$current_module = "Polls";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Copyright IT Farm
Author: John Francis Mukulu <john.f.mukulu@gmail.com>
Website: http://bongolinux.webs.com/
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>PMO Intranet system</title>
<meta name="keywords" content="" />
<meta name="Adhesive" content="" />
<link rel="stylesheet" type="text/css" href="/intranet/modules/tasks/stylesheets/main.css" media="screen" />
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/gen_validatorv2.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/DocumentListAjax.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/EntityListAjax.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/Event.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/SortedTable.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/UserGroupListAjax.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/visibility.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper">
	<!-- start header -->
	<div id="header">
			<div id="login-session-name">   
				Welcome
				<strong> <?php echo $_SESSION['username'] ?> </strong> 
				&nbsp;&nbsp;<a href="<?php echo $logoutPage ?>">Log out</a>
			</div>
		<div id="menu">
			<?php main_menu($current_module) ?>
		</div>
	</div>
		<!-- end header -->
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
				<?php poll_sidebar() ?>
			</div>
			<!-- end sidebar-right -->
			<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
</div>
<div id="footer-wrapper">
	<div id="footer">
		<p class="copyright">&copy;&nbsp;&nbsp;2009 All Rights Reserved &nbsp;&bull;&nbsp; Copyright <a href="">IT Farm</a>.</p>
	</div>
</div>
</body>
</html>
