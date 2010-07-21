<?php 
require_once('root.php');
$skinFolder='default';
$page="index";
$current_module = "Gallery";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBAlbum;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBAlbum;
$crumbs[1]['url'] = $root_path.'modules/core/admin/gallery/admin/index.php?menuid='.$menuid;
	// include Generic News Module
	include('../config.inc.php');
	include('../lib/gallery_functions.php');	
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
<tr><td class="smalltext">Listed below are the Albums.</td>
	<td align=right valign=bottom><input type="button" name="asd" value="add new" class="button" onClick="window.location.href='edit_album.php?album_id=0'"></td></tr>
</table>

<script language="JavaScript">
	function confirm_delete(szURL){
		if (confirm('Are you sure you wish to delete this Album?')){
			window.location.href = szURL;
		}
	}
</script>

<table cellspacing="0" cellpadding="4" border="0" width=100% class="adminTable">

<?php 

	//Get All Albums of this type
	$arrAlbums = gallery_get_albums();
	
	if ($arrAlbums){
		
		$blnNewAlbum=true;
		// loop around category
		foreach ($arrAlbums as $arrAlbum) {	
		
				if ($blnNewAlbum){ $rowclass = 'adminRow1'; $blnNewAlbum=false; } else { $rowclass = 'adminRow2'; $blnNewAlbum=true; }
				?>
				<tr class="<?=$rowclass?>">
					<td class="adminContent" valign=top width="50"><img src="<?=$url_thumbs?>/<?=$arrAlbum['album_thumb']?>"></td>
					<td class="adminContent" valign=top rowspan="2"><?=$arrAlbum['album_description']?></td>
				    <td class="adminContent" align=center valign=top rowspan="2" width="4">
						<table border="0">
							<tr>
								<td><a href="photos.php?album_id=<?=$arrAlbum['album_id']?>"><img src="../images/images.gif" alt="Manage Album" title="Manage Album" width="15" height="15" border="0"></a></td>
								<td><a href="edit_album.php?album_id=<?=$arrAlbum['album_id']?>"><img src="../images/edit.gif" alt="Edit this Album" title="Edit this Album" width="15" height="15" border="0"></a></td>
								<td><a href="Javascript:confirm_delete('delete_album.php?album_id=<?=$arrAlbum['album_id']?>');"><img src="../images/delete.gif" alt="Delete this Album" title="Delete this Album" width="15" height="15" border="0"></a></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="<?=$rowclass?>">
					<td class="adminContent" valign=top><a href="edit_album.php?album_id=<?=$arrAlbum['album_id']?>"><?=$arrAlbum['album_name']?></a></td>
				</tr>
	<?
		} 
	}
	?>

</table>
<br>

<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>
