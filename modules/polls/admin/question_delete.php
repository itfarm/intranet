<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

connectdb();

$res = mysql_query("delete from nabopoll_questions where survey=$survey and id=$question");
$res = mysql_query("delete from nabopoll_answers where survey=$survey and question=$question");

$res = mysql_query("alter table nabopoll_questions disable keys");
$res = mysql_query("update nabopoll_questions set id=id-1 where survey=$survey and id>=$question");
$res = mysql_query("alter table nabopoll_questions enable keys");

$res = mysql_query("alter table nabopoll_answers disable keys");
$res = mysql_query("update nabopoll_answers set question=question-1 where survey=$survey and question>=$question");
$res = mysql_query("alter table nabopoll_answers enable keys");

redirect("question_edit.php?survey=" . $survey);

?>



