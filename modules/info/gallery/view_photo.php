<?php
require_once('root.php');
$skinFolder='default';
$page="view_photo";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBAlbum;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'/index.php';
$crumbs[1]['name'] = $LBAlbum;
$crumbs[1]['url'] = $root_path.'modules/gallery/index.php?menuid='.$menuid;
include($root_path.'modules/core/admin/gallery/config.inc.php');
include($root_path.'modules/core/admin/gallery/lib/gallery_functions.php');
	
	//Get the photo
	$photo_id=$_GET['photo_id'];
	$arrPhoto = gallery_get_photo($photo_id);
?>

<table width="960" border="0" cellpadding="0" cellspacing="0" background="<?=$root_path?>/skins/default/images/content_bckgrd.gif">
  <tr>
    <td colspan="3" align="left" valign="top"><img src="<?=$root_path?>/skins/default/images/content_top.gif" width="960" height="10" /></td>
  </tr>
  <tr>
    <td width="20" align="left" valign="top">&nbsp;</td>
    <td width="920" align="left" valign="top"><!--content starts here -->

<div id="content">
	<?=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
				   
	?> 
</div>



<div id="content">

<table cellspacing="4" cellpadding="4" border="0" width=100%>
	<tr>
		<td class="adminContent" valign=top align="center"><img src="<?=$url_big?>/<?=$arrPhoto['photo_name']?>" width="500"></td>
	</tr>
	<tr>
		<td class="adminContent" align="center" valign=top><?=$arrPhoto['photo_description']?></td>
	</tr>
</table>
<br>
<a href="view_album.php?album_id=<?=$_GET['album_id']?>">&laquo;Go back to photo</a>
  </div>
<!--content ends here --></td>
    <td width="20" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><img src="<?=$root_path?>/skins/default/images/content_footer.gif" width="960" height="15" /></td>
  </tr>
</table>

 			
<?php 
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
