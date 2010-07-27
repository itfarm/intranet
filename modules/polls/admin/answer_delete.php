<?php
include_once("admin.inc.php");

if ($survey == "")
	error("no survey specified");

if ($question == "")
	error("no question specified");

if ($answer == "")
	error("no answer specified");

connectdb();

$res = mysql_query("delete from nabopoll_answers where survey=$survey and question=$question and id=$answer");
$res = mysql_query("alter table nabopoll_answers disable keys");
$res = mysql_query("update nabopoll_answers set id=id-1 where survey=$survey and question=$question and id>=$answer");
$res = mysql_query("alter table nabopoll_answers enable keys");

redirect("answer_edit.php?survey=".$survey."&question=".$question);

?>



