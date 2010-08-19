<?php
require_once('root.php');
$skinFolder='default';
$page="view_album";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBAlbum;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'/index.php';
$crumbs[1]['name'] = $LBAlbum;
$crumbs[1]['url'] = $root_path.'modules/gallery/index.php?menuid='.$menuid;
include($root_path.'modules/core/admin/gallery/config.inc.php');
include($root_path.'modules/core/admin/gallery/lib/gallery_functions.php');
?>

<table width="960" border="0" cellpadding="0" cellspacing="0" background="<?=$root_path?>/skins/default/images/content_bckgrd.gif">
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
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

<?php 

	//Get All Albums of this type
	$album_id=$_GET['album_id'];
	$arrPhotos = gallery_get_photos($album_id);
	
	if ($arrPhotos){
		
		$blnNewAlbum=true;
		// loop around category
		foreach ($arrPhotos as $arrPhoto) {	
				?>
				<tr>
					<td class="adminContent" valign=top align="center"><a href="view_photo.php?photo_id=<?=$arrPhoto['photo_id']?>&album_id=<?=$arrPhoto['album_id']?>" title="<?=$arrPhoto['photo_description']?>"><img src="<?=$url_thumbs?>/<?=$arrPhoto['photo_name']?>" border="0"></a></td>
					<td class="adminContent" valign=top><?=$arrPhoto['photo_description']?></td>
				</tr>
	<?
		} 
	}
	?>

</table>
<br>
<a href="<?=$root_path?>modules/gallery/index.php?menuid=<?=$menuid?>">&laquo;Go back to album</a>
 </div>
<!--content ends here --></td>
    <td width="20" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
</table>
	
<?php 
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
