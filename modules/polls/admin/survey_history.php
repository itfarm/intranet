<?php
include_once("admin.inc.php");

connectdb();
openadmin();

$res_history = mysql_query("select * from nabopoll_history where survey=$survey order by instant");
if ($res_history == FALSE)
	error("database error");
	
echo '<table cellspacing=0><tr bgcolor="gray">';
echo '<th><font color="white" size="-1">&nbsp;IP&nbsp;</font></th>';
echo '<th><font color="white" size="-1">&nbsp;Date&nbsp;</font></th>';
echo '<th><font color="white" size="-1">&nbsp;Answers&nbsp;</font></th>';
echo '</tr><tr><td>&nbsp;</td></tr>';

while ($row = mysql_fetch_array($res_history))
{
	echo '<tr><td valign="top"><font size="-1">&nbsp;' . $row["ip"] . '&nbsp;</font></td>';
	echo '<td valign="top"><font size="-1">&nbsp;' . $row["instant"] . '&nbsp;</font></td>';
	echo '<td valign="top"><font size="-1">&nbsp;' . $row["answers"] . '&nbsp;</font></td></tr>';
}

echo '</table>';
echo '<p><a href="survey_edit.php">back</a></p>';
closeadmin();

?>



