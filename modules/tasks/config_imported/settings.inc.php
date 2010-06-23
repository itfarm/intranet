<?php
	include_once('../config.php');
	// System Settings

	global $szRootURL,$szRootPath,$szSiteTitle,$szWebmasterEmail,$arrStructure,$arrVariations,$intDefaultVariation;
	global $szDBName,$szDBUsername,$szDBPassword,$szDiscussionAdmin,$szDiscussionPassword;
	
	$szDiscussionAdmin = "Admin";
	$szDiscussionPassword = "password";
	// Initialise Globals
	if ( strpos(strtolower($root_dir),".local") ){
		// local settings
		$szRootURL = "http://".$db_host;
		$szRootPath = $root_dir;
		$szSiteTitle = 'Task Management System -MOWI';
		$szWebmasterEmail = 'jacobkwize@uccmail.co.tz';
		$szDBName = $db_name;
		$szDBUsername = $db_user;
		$szDBPassword = $db_password;
	}else{
		// live settings
		$szRootURL = "http://".$db_host;
		$szRootPath = $root_dir;
		$szSiteTitle = 'Task Management System -MOWI';
		$szWebmasterEmail = 'jacobkwize@uccmail.co.tz';
		$szDBName = $db_name;
		$szDBUsername = $db_user;
		$szDBPassword = $db_password;
	}
	
	//////////////////////////////////////////////////// 
	// multilangual component //
	////////////////////////////////////////////////////
	// define array regarding language variations available.
	// User status
	$arrVariations = array (
		1 => array( 'name' => 'English', 'shortname' => 'Eng')//,
		//2 => array( 'name' => 'Kiswahili', 'shortname' => 'Kis'),
	);
	
	// define the variation preferences
	// This can be removed and placed where the session is setup. Therefore, 
	// Users can set their own preference. Otherwise, it it a default preference list for all.
	// NOTE:  PREFERENCE => VARIATION ID
	$arrVariationPreference = array (
		1 => 1//,
		//2 => 2
	);
	
	if (!isset($_SESSION['arrVariationPreference'])){
		// store it in the session variable
		$_SESSION['arrVariationPreference']=$arrVariationPreference;
	}
	
	// define the default variation
	$intDefaultVariation = 1;
	
	include_once ("config.inc.php");
	include_once ("utc_functions.php");
	
?>
