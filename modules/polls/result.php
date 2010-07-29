<?php
	@include('../../cfg/config.php');
	$tag =  $_GET['tag'];
	@session_start();
	if(!isset($_SESSION['username']))
	{
		@header("location:$loginPage?");
	}
	// Start of session
	$current_module = "Polls";
	global $pollPage;
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
	
	<style type="text/css">
			.table {
				width:100%;
				border: 1px #000000 none;
				text-align:left;
				font-size:1.3em;
			}
			tr th {
				font-weight:bold;
				text-size:3em;
			}
			tbody tr {
				color:blue;
			}
			tbody tr:hover {
				color:#000000;
				cursor: pointer;
			}
	</style>
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

