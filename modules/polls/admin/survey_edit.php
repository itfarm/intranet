<?php

$res_survey = mysql_query("select * from nabopoll_surveys order by id");

if ($res_survey == FALSE)

	error("database error");



openadmin();

$survey=0;



echo '<table cellspacing=0><tr bgcolor="gray">';

echo '<th><font color="white" size="-1">&nbsp;#&nbsp;</font></th>';

echo '<th><font color="white" size="-1">&nbsp;Title&nbsp;</font></th>';

echo '<th><font color="white" size="-1">&nbsp;URL&nbsp;</font></th>';

echo '<th><font color="white" size="-1">&nbsp;Template&nbsp;</font></th>';

echo '<th><font color="white" size="-1">&nbsp;Single Vote&nbsp;</font></th>';

echo '<th><font color="white" size="-1">&nbsp;Log&nbsp;</font></th>';

echo '<th><font color="white" size="-1">&nbsp;Required&nbsp;</font></th>';

echo '<th><font color="white" size="-1">&nbsp;Closed?&nbsp;</font></th>';

echo '<th><font color="white" size="-1">&nbsp;Actions&nbsp;</font></th>';

echo '</tr><tr><td>&nbsp;</td></tr>';



while ($row = mysql_fetch_array($res_survey))

{

	$survey = $row["id"];



	echo '<tr><td valign="top"><b><font size="-1">' . $survey . '</font></b></td>';



	echo '<form action="survey_alter.php" method="post">';

	echo '<input type="hidden" name="survey" value="' . $survey . '">';

	echo '<td valign="top"><input type="text" class="txtfld" size=30 name="title" value="' . $row["title"] . '"></td>';

	echo '<td valign="top"><input type="text" class="txtfld" size=30 name="url" value="' . $row["url"] . '"></td>';

	echo '<td valign="top" align="center">'; formtemplates($row["template"]); echo '</td>';

	echo '<td valign="top" align="center">'; formsinglevote($row["single_vote"]); echo '</td>';

	echo '<td valign="top" align="center"><input type="checkbox" name="log" ' . ($row["log"] == 1 ? "checked" : "") . '></td>';

	echo '<td valign="top" align="center"><input type="checkbox" name="required" ' . ($row["required"] == 1 ? "checked" : "") . '></td>';

	echo '<td valign="top" align="center"><input type="checkbox" name="closed" ' . ($row["closed"] == 1 ? "checked" : "") . '></td>';

	echo '<td><table><tr>';



	echo '<td><input type="image" src="../images/alter.gif" alt="edit" value="alter"></form></td>';



	echo '<form action="survey_delete.php" method="post" onsubmit="return confirmSubmit()">';

	echo '<input type="hidden" name="survey" value="' . $survey . '">';

	echo '<td><input type="image" src="../images/delete.gif" alt="delete" value="delete"></form></td>';



	echo '<form action="survey_reset.php" method="post" onsubmit="return confirmSubmit()">';

	echo '<input type="hidden" name="survey" value="' . $survey . '">';

	echo '<td><input type="image" src="../images/reset.gif" alt="reset answers" value="reset answers"></form></td>';



	echo '<form action="survey_history.php" method="post">';

	echo '<input type="hidden" name="survey" value="' . $survey . '">';

	echo '<td><input type="image" src="../images/history.gif" alt="see history" value="see history"></form></td>';



	echo '<td valign="top"><a href="../result.php?survey='.$survey.'" target="_blank"><img src="../images/result.gif" border=0 alt="see results"></a></td>';



	echo '<form action="question_edit.php" method="post">';

	echo '<input type="hidden" name="survey" value="' . $survey . '">';

	echo '<td><input type="image" src="../images/inspect.gif" alt="edit questions" value="edit questions"></form></td>';



	echo '</tr></table></td></tr>';

}



$survey++;

echo '<form action="survey_add.php" method="post">';

echo '<input type="hidden" name="survey" value="' . $survey . '">';

echo '<tr><td valign="top"><b><font size="-1">'.$survey.'</font></b></td>';

echo '<td valign="top"><input type="text" class="txtfld" size=30 name="title" value=""></td>';

echo '<td valign="top"><input type="text" class="txtfld" size=30 name="url" value=""></td>';

echo '<td valign="top" align="center">'; formtemplates(''); echo '</td>';

echo '<td valign="top" align="center">'; formsinglevote(1); echo '</td>';

echo '<td valign="top" align="center"><input type="checkbox" name="log"></td>';

echo '<td valign="top" align="center"><input type="checkbox" name="required" checked></td>';

echo '<td valign="top" align="center"><input type="checkbox" name="closed"></td>';

echo '<td><input type="image" src="../images/add.gif" alt="add" value="add" align="middle"></form></td></tr>';



echo '</table>';

closeadmin();



?>







