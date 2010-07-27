<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

if ($answer == "")
	error("no answer specified");

connectdb();

$res = mysql_query("select max(id) as id from nabopoll_answers where survey=$survey and question=$question");
if ($res == TRUE && mysql_numrows($res) == 1)
{
	$maxid = mysql_result($res, 0, "id");

	for ($id = $maxid; $id>=$answer; $id--)
		$res = mysql_query("update nabopoll_answers set id=id+1 where survey=$survey and question=$question and id=$id");
}
$res = mysql_query("insert into nabopoll_answers values($survey,$question,$answer,\"\",0)");

redirect("answer_edit.php?survey=".$survey."&question=".$question);

?>



