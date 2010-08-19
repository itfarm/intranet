<?php 
require_once('root.php');
$page="delete_album";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBAlbum;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $home_url;
$crumbs[1]['name'] = $LBAlbum;
$crumbs[1]['url'] = $root_path.'modules/core/gallery/index.php?menuid='.$menuid;
	// include Generic News Module
	include('../config.inc.php');
	include('../lib/gallery_functions.php');

	gallery_remove_album($_GET['album_id']);
?>
<div class="sectionLabel">
	<?=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
			//var_dump($arrLangRow = $christDB->f_GetRecord($resultAll));	   
	?> 
</div>
<table cellspacing="1" cellpadding="4" border="0" width=100%>
<form>
<tr><td class="smalltext">The Album has been removed.<br>
	<br>
	<input type="button" name="cmdContinue" value="Continue" class="vform" onClick="window.location.href='index.php'">
	</td></tr>
</form>
</table>


<?php
require_once($root_path.'modules/core/admin/skin/tail.php');
?>
