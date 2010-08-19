<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

connectdb();

$res = mysql_query("select max(id) as id from nabopoll_questions where survey=$survey");
$maxid = mysql_result($res, 0, "id");
for ($id = $maxid; $id>=$question; $id--)
{
	$res = mysql_query("update nabopoll_questions set id=id+1 where survey=$survey and id=$id");
	$res = mysql_query("update nabopoll_answers set question=question+1 where survey=$survey and question=$id");
}

$res = mysql_query("insert into nabopoll_questions values($survey,$question,\"\",0)");

redirect("question_edit.php?survey=" . $survey);

?>



