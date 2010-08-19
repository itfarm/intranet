<?php


//include_once($_SERVER['DOCUMENT_ROOT'].'/settings.inc.php');

// from include file
//Global $szRootPath, $szRootURL, $szSection;
Global $blGalleryDebug,$intDefaultVariation,$szFileUploadPath,$path_thumbs,$path_big;

// set this to true if you need to debug this module
//$blGalleryDebug = false;

// Any uploads will be stored using the fileupload sub-component. The path is stored below:
// if running on linux, use '/', if on pc use '\\'
$path_thumbs = $root_path."/modules/core/admin/gallery/thumbs";
$url_thumbs = $root_path."/modules/core/admin/gallery/thumbs";
$path_big = $root_path."/modules/core/admin/gallery/photos";
$url_big = $root_path."/modules/core/admin/gallery/photos";

?>