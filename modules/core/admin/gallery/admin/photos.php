<?php 
$page="photos";
require_once('root.php');
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBAlbum;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $home_url;
$crumbs[1]['name'] = $LBAlbum;
$crumbs[1]['url'] = $root_path.'modules/core/admin/gallery/index.php?menuid='.$menuid;
	// include Generic News Module
	include('../config.inc.php');
	include('../lib/gallery_functions.php');	
	
	$album_id=$_GET['album_id'];
	
	
	
	
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
<tr><td class="smalltext">Listed below are the Photos.</td>
	<td align=right valign=bottom><input type="button" name="asd" value="add new" class="button" onClick="window.location.href='edit_photo.php?photo_id=0&album_id=<?=$album_id?>'"></td></tr>
</table>

<script language="JavaScript">
	function confirm_delete(szURL){
		if (confirm('Are you sure you wish to delete this photo?')){
			window.location.href = szURL;
		}
	}
</script>

<table cellspacing="0" cellpadding="4" border="0" width=100% class="adminTable">

<?php 

	//Get All Albums of this type
	$arrPhotos = gallery_get_photos($album_id);
	
	if ($arrPhotos){
		
		$blnNewPhoto=true;
		// loop around category
		foreach ($arrPhotos as $arrPhoto) {	
		
				if ($blnNewPhoto){ $rowclass = 'adminRow1'; $blnNewPhoto=false; } else { $rowclass = 'adminRow2'; $blnNewPhoto=true; }
				?>
				<tr class="<?=$rowclass?>">
					<td class="adminContent" valign=top width="50"><img src="<?=$url_thumbs?>/<?=$arrPhoto['photo_name']?>"></td>
					<td class="adminContent" valign=top><?=$arrPhoto['photo_description']?></td>
				    <td class="adminContent" align=center valign=top width="5">
						<a href="Javascript:confirm_delete('delete_photo.php?photo_id=<?=$arrPhoto['photo_id']?>&album_id=<?=$arrPhoto['album_id']?>');"><img src="../images/delete.gif" alt="Delete this Photo" title="Delete this Photo" width="15" height="15" border="0"></a>
					</td>
				</tr>
	<?
		} 
	}
	?>

</table>
<br>
<table cellspacing="2" cellpadding="2" border="0">
<tr>
    <td><a href="index.php"><img src="../images/back.gif" width="15" height="15" alt="" border="0"></a></td>
    <td><b><a href="index.php">Back to list of Albums</a></b></td>
</tr>
</table>
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>
