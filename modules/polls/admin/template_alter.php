<?php

$file = fopen("../templates/".$template."/config.inc.php","w");
fputs($file, "<?php\n\n");

fputs($file, "\$image_vote = '".$image_vote."';\n");
fputs($file, "\$image_pct_normal = '".$image_pct_normal."';\n");
fputs($file, "\$image_pct_max = '".$image_pct_max."';\n");
fputs($file, "\$image_pct_white = '".$image_pct_white."';\n\n");
fputs($file, "\$bar_width = '".$bar_width."';\n\n");
fputs($file, "\$bar_height = '".$bar_height."';\n\n");
fputs($file, "\$pct_decimal = '".$pct_decimal."';\n\n");

fputs($file, "?>");
fclose($file);

include('admin.inc.php');
write1pixelgif($image_pct_normal, '../templates/'.$template.'/pctnormal.gif');
write1pixelgif($image_pct_max, '../templates/'.$template.'/pctmax.gif');
write1pixelgif($image_pct_white, '../templates/'.$template.'/pctwhite.gif');

header("Location: template_edit.php");
?>