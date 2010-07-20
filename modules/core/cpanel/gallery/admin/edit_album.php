<?php 
require_once('root.php');
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBAlbum;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBAlbum;
$crumbs[1]['url'] = $root_path.'modules/core/admin/gallery/admin/index.php?menuid='.$menuid;
	// include Generic News Module
	include('../config.inc.php');
	include('../lib/gallery_functions.php');	
	// initiales the ID variable from the URL
	$album_id = $_GET['album_id'];
	
	# does this category need to be updated?
	if (isset($_POST['action']) && ($_POST['action'] == "update")){
		gallery_debug($_POST,"POST variables");
		// build array from posted data
		$arrAlbum = array();
		$arrAlbum = $_POST;
		
		gallery_debug($arrAlbum,"Item to be updated by POST");
		
		// update the item in the database, and update our item array
		$arrAlbum = gallery_add_update_album($arrAlbum);
		gallery_debug($arrAlbum,"Updated item");
		
		// update album ID variable
		$album_id = $arrAlbum['album_id'];
		
	}

	if($album_id==0){
		// create completely new Category
		
		// build blank array
		$arrAlbum = array();
		// update the intCategoryID
		$arrAlbum['album_id']=0;
		$arrAlbum['dtCreated']=date('Y-m-d G:i:s');
		$arrAlbum['dtUpdated']=date('Y-m-d G:i:s');
	}else{
		// amend an existing item.
		// get the item out of the database
		$arrAlbum = gallery_get_album($album_id);
	}

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
To update this album, fill in the boxes below with the desired content and press the update button.<br>
<br>
		
<table cellspacing="1" cellpadding="5" border="0" width=100% class="adminTable">
<form action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="album_id" value="<?=$arrAlbum['album_id']?>">
<tr>
    <td class="adminHeader" align=right>Field</td>
    <td class="adminHeader">Value</td>
</tr>
<tr class="adminRow1">
	<td class="adminContent" align=right valign=top>Name</td>
	<td class="adminContent"><input type="text" class="vform" size="30" name="album_name" value="<?=$arrAlbum['album_name']?>"></td>
</tr>
<tr class="adminRow2">
	<td class="adminContent" align=right valign=top>Description</td>
	<td class="adminContent"><textarea class="vform" rows="5" cols="50" name="album_description"><?=$arrAlbum['album_description']?></textarea></td>
</tr>
<tr class="adminRow1">
	<td class="adminContent" align=right valign=top>Thumb</td>
	<td class="adminContent"><input type="file" class="vform" size="65" name="photo"></td>
</tr>
<tr class="adminRow2">
	<td class="adminContent" align=right valign=top>Date Created</td>
	<td class="adminContent"><input type="text" class="vform" size="30" name="dtCreated" value="<?=$arrAlbum['dtCreated']?>" readonly></td>
</tr>
<tr class="adminRow1">
	<td class="adminContent" align=right valign=top>Date Updated</td>
	<td class="adminContent"><input type="text" class="vform" size="30" name="dtUpdated" value="<?=$arrAlbum['dtUpdated']?>" readonly></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input  class="button" type="submit" name="action" value="update"></td>
</tr>
</form>
</table>
<br>
<table cellspacing="2" cellpadding="2" border="0">
<tr>
    <td><a href="index.php"><img src="../images/back.gif" width="15" height="15" alt="" border="0"></a></td>
    <td><b><a href="index.php">Back to list of Albums</a></b></td>
</tr>
</table>
<?php
require_once($root_path.'modules/core/admin/skin/tail.php');
?>
