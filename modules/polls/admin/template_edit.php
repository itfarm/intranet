<?php

include_once("../includes/tags.inc.php");
include_once("admin.inc.php");

openadmin();

echo '<table border=1 cellspacing=0 cellpadding=5>';
echo '<tr><th>Template</th><th>Parameter</th><th>Value</th><th>Sample</th><th>&nbsp;</th></tr>';

$path = "../templates";
$folder = opendir($path);
while ($file = readdir($folder))
{
	if ($file != "." && $file != ".." && is_dir($path.'/'.$file) && $file != "cvs" && $file != "CVS")
	{
		$image_vote = "";
		$image_pct_normal = "";
		$image_pct_max = "";
		$image_pct_white = "";
		$bar_width = 100;
		$bar_height = 12;
		$pct_decimal = 1;

		@include_once($path.'/'.$file.'/config.inc.php');

		$rows = 6;

		// start of form
		echo '<form action="template_alter.php" method="post">';
		echo '<input type="hidden" name="template" value="'.$file.'">';
		echo '<tr><td rowspan='.$rows.' valign="top"><b>'.$file.'</b></td>';

		// vote
		echo '<td>Vote Submit</td>';
		echo '<td align="center"><input type="text" class="txtfld" name="image_vote" value="'.$image_vote.'"></td>';
		echo '<td align="center"><img src="../'.$image_vote.'"></td>';

		// save
		echo '<td rowspan='.$rows.' valign="top"><input type="image" src="../images/alter.gif" alt="edit" value="alter"></td></tr>';

		// result normal
		echo '<tr><td>Result Normal</td>';
		echo '<td align="center"><input type="text" class="txtfld" name="image_pct_normal" value="'.$image_pct_normal.'"></td>';
		echo '<td align="center">'.getbar(100, $bar_width, $bar_height, getimage($image_pct_normal,'../',$file,'pctnormal'), getimage($image_pct_white,'../',$file,'pctwhite')).'</td></tr>';

		// result max
		echo '<tr><td>Result Max</td>';
		echo '<td align="center"><input type="text" class="txtfld" name="image_pct_max" value="'.$image_pct_max.'"></td>';
		echo '<td align="center">'.getbar(100, $bar_width, $bar_height, getimage($image_pct_max,'../',$file,'pctmax'), getimage($image_pct_white,'../',$file,'pctwhite')).'</td></tr>';

		// white
		echo '<tr><td>Result Padding</td>';
		echo '<td align="center"><input type="text" class="txtfld" name="image_pct_white" value="'.$image_pct_white.'"></td>';
		echo '<td align="center">'.getbar(0, $bar_width, $bar_height, getimage($image_pct_white,'../',$file,'pctwhite'), getimage($image_pct_white,'../',$file,'pctwhite')).'</td></tr>';

		// width
		echo '<tr><td>Result Bar (w*h)</td>';
		echo '<td><input type="text" class="txtfld" size=5 name="bar_width" value="'.$bar_width.'">&nbsp;*&nbsp;&nbsp;<input type="text" class="txtfld" size=5 name="bar_height" value="'.$bar_height.'"></td>';
		echo '<td>&nbsp;</td></tr>';

		// decimals
		echo '<tr><td>Result % Decimals</td>';
		echo '<td><input type="text" class="txtfld" size=5 name="pct_decimal" value="'.$pct_decimal.'"></td>';
		echo '<td>&nbsp;</td></tr>';

		// end of form
		echo '</form>';

		// separator
		echo '<tr><td colspan=20 height=3 bgcolor="black"></td></tr>';
	}
}
closedir($folder);

closeadmin();

?>
