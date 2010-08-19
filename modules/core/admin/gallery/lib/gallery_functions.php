<?

/************************************************************************/
/* INTRANET: Photo Gallery                                              */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2009 by UCC Ltd                                        */
/* http://www.ucc.co.tz                                                 */
/*                                                                      */
/************************************************************************/


// include parent system settings
//include_once($_SERVER['DOCUMENT_ROOT'].'/settings.inc.php');
//global $szSection,$szRootURL,$szRootPath,$szSiteTitle,$szWebmasterEmail,$szDBName,$szDBUsername,$szDBPassword;

//$conn=mysql_connect("localhost","root","kwizesoft");
//mysql_select_db('wri');

function gallery_debug($szDebugInfo,$szComment = ""){
	global $blGalleryDebug;
	// Is debug turned on?
	if ($blGalleryDebug){
		// outout div border
		echo "<div style=\"padding:5px;border:1px solid #FF0000\">";
	 // output debug info
		if (is_string($szDebugInfo)){
			echo $szDebugInfo;
		}elseif (is_array($szDebugInfo)){
			echo "<pre style=\"margin:0px;padding:0px;\">";
			print_r ($szDebugInfo);
			echo "</pre>";
		}elseif (gettype($szDebugInfo) == "resource"){
			echo "<pre style=\"margin:0px;padding:0px;\">";
			echo "rows:".mysql_num_rows($szDebugInfo);
			echo "</pre>";
		}else{
			echo "<pre style=\"margin:0px;padding:0px;\">";
			var_dump ($szDebugInfo);
			echo "</pre>";
		}
		echo "</div>";
	}
}

function gallery_debug_enter($szFunctionName){
	global $blGalleryDebug;
	if ($blGalleryDebug){
		echo "<div style=\"background-color:#000000;color:#ffffff;\"><b>Entered:".$szFunctionName."</b></div>";
	}
}

function gallery_remove_album($album_id){
	global $path_thumbs;
	gallery_debug_enter("gallery_remove_album($album_id)");
	// remove the album from the database
	// SQL statement for removing the album
	unlink($path_thumbs."/".gallery_get_thumb($album_id));
	$sql="DELETE FROM album WHERE album_id=$album_id";
	gallery_debug($sql,"Delete album");
	//send the query to the database
	$results=mysql_query($sql);
	gallery_debug(mysql_error(),"Query Error?");
	
}

function gallery_remove_photo($photo_id){
	global $path_thumbs,$path_big;
	gallery_debug_enter("gallery_remove_photo($photo_id)");
	// remove the photo from the database
	// SQL statement for removing the photo
	$filename=gallery_get_photo_name($photo_id);
	unlink($path_thumbs."/".$filename);
	unlink($path_big."/".$filename);
	$sql="DELETE FROM tbl_photo WHERE photo_id=$photo_id";
	gallery_debug($sql,"Delete photo");
	//send the query to the database
	$results=mysql_query($sql);
	gallery_debug(mysql_error(),"Query Error?");
	
}

function gallery_add_update_album($arrAlbum){
	// returns the updated array of the item inserted or updated
	gallery_debug_enter("gallery_add_update_album($arrAlbum)");
	gallery_debug($arrAlbum,"array passed in");

	// get the album id
	$album_id = $arrAlbum['album_id'];

	//find out whether the item already exists
	$sql="SELECT * FROM album WHERE album_id=$album_id";
	gallery_debug($sql,"Does this album exist");
	$blnAlbumExists = mysql_num_rows(mysql_query($sql));
	gallery_debug($blnAlbumExists,"Does this album exist");

	if ($blnAlbumExists){
		$arrAlbum['dtUpdated'] = date('Y-m-d G:i:s');
		$sql="UPDATE album SET ";
		$sql.=" album_name = '$arrAlbum[album_name]', album_description = '$arrAlbum[album_description]', dtUpdated = '$arrAlbum[dtUpdated]'";
		$sql.=" WHERE album_id=$album_id";
		gallery_debug($sql,"to be executed");
		$results=mysql_query($sql);
		gallery_debug(mysql_error(),"Query Error?");
	} else {
		// inserting a completely new album
		$arrAlbum['dtCreated'] = date('Y-m-d G:i:s');
		$arrAlbum['dtUpdated'] = date('Y-m-d G:i:s');
		$sql="INSERT INTO album (album_name,album_description,album_thumb,dtCreated,dtUpdated) VALUES ";
		$sql.="('$arrAlbum[album_name]','$arrAlbum[album_description]','".gallery_create_thumb($_FILES)."','$arrAlbum[dtCreated]','$arrAlbum[dtUpdated]')";
		gallery_debug($sql,"to be executed");
		$results=mysql_query($sql);
		gallery_debug(mysql_error(),"Query Error?");
	}
	return $arrItem;
}

function gallery_add_update_photo($arrPhoto){
	// returns the updated array of the item inserted or updated
	gallery_debug_enter("gallery_add_update_photo($arrPhoto)");
	gallery_debug($arrPhoto,"array passed in");
	$arrPhoto['photo_name'] = gallery_create_thumb($_FILES,true);
	$arrPhoto['photo_type'] = $_FILES['photo']['type'];
	$arrPhoto['photo_size'] = $_FILES['photo']['size'];

	// get the photo id
	$photo_id = $arrPhoto['photo_id'];
	//find out whether the item already exists
	$sql="SELECT * FROM tbl_photo WHERE photo_id=$photo_id";
	gallery_debug($sql,"Does this photo exist");
	$blnPhotoExists = mysql_num_rows(mysql_query($sql));
	gallery_debug($blnPhotoExists,"Does this photo exist");
	if ($blnPhotoExists){
		$arrAlbum['dtUpdated'] = date('Y-m-d G:i:s');
		$sql="UPDATE tbl_photo SET ";
		$sql.=" album_id = '$arrPhoto[album_id]', photo_name = '$arrPhoto[photo_name]',"; 
		$sql.=" photo_type = '$arrPhoto[photo_type]', photo_size = '$arrPhoto[photo_size]', ";
		$sql.=" photo_description = '$arrPhoto[photo_description]', dtUpdated = '$arrPhoto[dtUpdated]'";
		$sql.=" WHERE album_id=$album_id";
		gallery_debug($sql,"to be executed");
		$results=mysql_query($sql);
		gallery_debug(mysql_error(),"Query Error?");
	} else {
		// inserting a completely new album
		$arrPhoto['dtCreated'] = date('Y-m-d G:i:s');
		$arrPhoto['dtUpdated'] = date('Y-m-d G:i:s');
		$sql="INSERT INTO tbl_photo (album_id, photo_name, photo_type, ";
		$sql.="photo_size, photo_description, dtCreated, dtUpdated) VALUES ";
		$sql.="($arrPhoto[album_id],'$arrPhoto[photo_name]','$arrPhoto[photo_type]',";
		$sql.="'$arrPhoto[photo_size]','$arrPhoto[photo_description]',";
		$sql.="'$arrPhoto[dtCreated]','$arrPhoto[dtUpdated]')";
		gallery_debug($sql,"to be executed");
		$results=mysql_query($sql);
		gallery_debug(mysql_error(),"Query Error?");
	}
	return $arrPhoto;
}

function gallery_get_albums($intRows=0,$szSortBy=''){
	gallery_debug_enter("gallery_get_albums($intRows=0,$szSortBy='')");
	// Get items sorted by a particular column
	$sql="SELECT * FROM album ";
	if ($szSortBy != ''){
		$sql = $sql."
			ORDER BY $szSortBy   ";}
	if ($intRows != 0){
		$sql = $sql."
			LIMIT 0,$intRows   ";}
	gallery_debug($sql,"to be executed");
	//send the query to the database
	$results = mysql_query($sql);
	gallery_debug($results,"the results");
	gallery_debug(mysql_error(),"Query Error?");
	//check the status of $results recordset
	if (mysql_num_rows($results)){
		// convert result set into an array - need to retain order.
		$arrAlbums = array();
		$arrAlbum = mysql_fetch_assoc($results);
		while ($arrAlbum){
			gallery_debug($arrAlbum,"The Row we are now looking at:");
			$arrAlbums[$arrAlbum['album_id']] = $arrAlbum;
			// get next row
			$arrAlbum = mysql_fetch_assoc($results);
		}
		gallery_debug($arrAlbums,"Returned:");
		return $arrAlbums;
	} else {
		gallery_debug(0,"Returned:");
		return 0;
	}
}

function gallery_get_photos($album_id, $intRows=0,$szSortBy=''){
	gallery_debug_enter("gallery_get_photos($album_id, $intRows=0,$szSortBy='')");
	// Get items sorted by a particular column
	$sql="SELECT * FROM tbl_photo ";
	$sql.= " WHERE album_id=$album_id ";
	if ($szSortBy != ''){
		$sql = $sql."
			ORDER BY $szSortBy   ";}
	if ($intRows != 0){
		$sql = $sql."
			LIMIT 0,$intRows   ";}
	gallery_debug($sql,"to be executed");
	//send the query to the database
	$results = mysql_query($sql);
	gallery_debug($results,"the results");
	gallery_debug(mysql_error(),"Query Error?");
	//check the status of $results recordset
	if (mysql_num_rows($results)){
		// convert result set into an array - need to retain order.
		$arrPhotos = array();
		$arrPhoto = mysql_fetch_assoc($results);
		while ($arrPhoto){
			gallery_debug($arrPhoto,"The Row we are now looking at:");
			$arrPhotos[$arrPhoto['photo_id']] = $arrPhoto;
			// get next row
			$arrPhoto = mysql_fetch_assoc($results);
		}
		gallery_debug($arrPhotos,"Returned:");
		return $arrPhotos;
	} else {
		gallery_debug(0,"Returned:");
		return 0;
	}
}


function gallery_get_album($album_id){
	gallery_debug_enter("gallery_get_album($album_id)");
	// SQL statement for selecting information about the Category
	$sql="SELECT *	FROM album
				WHERE album_id=$album_id ";
	gallery_debug($sql,"Get the Album from the DB");
	//send the query to the database
	$qAlbum=mysql_query($sql);
	gallery_debug($qAlbum,"Query Result");
	gallery_debug(mysql_error(),"Query Error?");
	//check the status of $results recordset
	if ($qAlbum){
		$arrAlbum = array();
		$arrAlbum=mysql_fetch_assoc($qAlbum);
		gallery_debug($arrAlbum,"Returned:");
		return $arrAlbum;
	} else {
		gallery_debug(0,"Returned:");
		return 0;
	}
}

function gallery_get_photo($photo_id){
	gallery_debug_enter("gallery_get_photo($photo_id)");
	// SQL statement for selecting information about the Category
	$sql="SELECT *	FROM tbl_photo
				WHERE photo_id=$photo_id ";
	gallery_debug($sql,"Get the photo from the DB");
	//send the query to the database
	$qPhoto=mysql_query($sql);
	gallery_debug($qPhoto,"Query Result");
	gallery_debug(mysql_error(),"Query Error?");
	//check the status of $results recordset
	if ($qPhoto){
		$arrPhoto = array();
		$arrPhoto=mysql_fetch_assoc($qPhoto);
		gallery_debug($arrPhoto,"Returned:");
		return $arrPhoto;
	} else {
		gallery_debug(0,"Returned:");
		return 0;
	}
}

function gallery_create_thumb($arrFile,$isPhoto=false){
	global $path_thumbs,$path_big;
	
	//the new width of the resized image, in pixels.
	$img_thumb_width = 100; // 
	
	$extlimit = "yes"; //Limit allowed extensions? (no for all extensions allowed)
	//List of allowed extensions if extlimit = yes
	$limitedext = array(".gif",".jpg",".png",".jpeg",".bmp");
	
	//the image -> variables
	$file_type = $arrFile['photo']['type'];
	$file_name = $arrFile['photo']['name'];
	$file_size = $arrFile['photo']['size'];
	$file_tmp = $arrFile['photo']['tmp_name'];

	//check if you have selected a file.
	if(!is_uploaded_file($file_tmp)){
		echo "Error: Please select a file to upload!. <br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>";
		return 0;
	}
	
	//check the file's extension
	$ext = strrchr($file_name,'.');
	$ext = strtolower($ext);
	
	//uh-oh! the file extension is not allowed!
	if (($extlimit == "yes") && (!in_array($ext,$limitedext))) {
		echo "Wrong file extension.  <br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>";
		return 0;
	}
	
	//so, whats the file's extension?
	$getExt = explode ('.', $file_name);
	$file_ext = $getExt[count($getExt)-1];
	
	//create a random file name
	$rand_name = md5(time());
	$rand_name= rand(0,999999999);
	
	//the new width variable
	$ThumbWidth = $img_thumb_width;
	
	//////////////////////////
	// CREATE THE THUMBNAIL //
	//////////////////////////
	   
	//keep image type
	if($file_size){
		if($file_type == "image/pjpeg" || $file_type == "image/jpeg"){
			$new_img = imagecreatefromjpeg($file_tmp);
		} elseif ($file_type == "image/x-png" || $file_type == "image/png"){
			$new_img = imagecreatefrompng($file_tmp);
		} elseif ($file_type == "image/gif"){
			$new_img = imagecreatefromgif($file_tmp);
		}
		
		//list the width and height and keep the height ratio.
		list($width, $height) = getimagesize($file_tmp);
		
		//calculate the image ratio
		$imgratio=$width/$height;
		if ($imgratio>1){
			$newwidth = $ThumbWidth;
			$newheight = $ThumbWidth/$imgratio;
		}else{
			$newheight = $ThumbWidth;
			$newwidth = $ThumbWidth*$imgratio;
		}
		
		//function for resize image.
		if (function_exists(imagecreatetruecolor)){
			$resized_img = imagecreatetruecolor($newwidth,$newheight);
		}else{
			die("Error: Please make sure you have GD library ver 2+");
		}
		
		//the resizing is going on here!
		imagecopyresized($resized_img, $new_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		//finally, save the image
		ImageJpeg ($resized_img,"$path_thumbs/$rand_name.$file_ext");
		ImageDestroy($resized_img);
		ImageDestroy($new_img);
		
		//Upload the photo
		if ($isPhoto){
			move_uploaded_file ($file_tmp, "$path_big/$rand_name.$file_ext");
		}
		return $rand_name.".".$file_ext;           
	} else {
		return 0;
	}

}

function gallery_get_thumb($id){
	gallery_debug_enter("gallery_get_thumb($id)");
	// SQL statement for selecting information about the Category
	$sql="SELECT * FROM album WHERE album_id=$id";
	gallery_debug($sql,"Get the photo from the DB");
	//send the query to the database
	$qThumb=mysql_query($sql);
	gallery_debug($qThumb,"Query Result");
	gallery_debug(mysql_error(),"Query Error?");
	//check the status of $results recordset
	if ($qThumb){
		$arrFile = array();
		$arrFile=mysql_fetch_assoc($qThumb);
		gallery_debug($arrFile,"Returned:");
		return $arrFile['album_thumb'];
	} else {
		gallery_debug(0,"Returned:");
		return 0;
	}
}

function gallery_get_photo_name($id){
	gallery_debug_enter("gallery_get_photo_name($id)");
	// SQL statement for selecting information about the Category
	$sql="SELECT * FROM tbl_photo WHERE photo_id=$id";
	gallery_debug($sql,"Get the photo from the DB");
	//send the query to the database
	$qPhoto=mysql_query($sql);
	gallery_debug($qPhoto,"Query Result");
	gallery_debug(mysql_error(),"Query Error?");
	//check the status of $results recordset
	if ($qPhoto){
		$arrFile = array();
		$arrFile=mysql_fetch_assoc($qPhoto);
		gallery_debug($arrFile,"Returned:");
		return $arrFile['photo_name'];
	} else {
		gallery_debug(0,"Returned:");
		return 0;
	}
}
?>