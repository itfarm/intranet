<?php
	# Initialisation of the ASDP
	# 
	# Include the parent config file
	# This should be the first include of any page of the ASDP
	
	# start the session
	session_start();
	
	# include the global settings
	include_once ('../config_imported/settings.inc.php');	
	//var_dump($_SESSION);
	# Define whether this is a private area or not & authenticate
	global $blnPrivateArea,$szHeaderPath,$szFooterPath;
	$blnPrivateArea = true;
	$szHeaderPath = $szRootPath."/lookfeel/header_admin.php";
	$szFooterPath = $szRootPath."/lookfeel/footer_admin.php";
	
	include ($szRootPath."/modules/authorisation/authconfig.php");	
	include ($szRootPath."/modules/authorisation/check.php");
	
	# define Top level Navigation Array if not defined already
	$i=1;$j=1;
	$arrStructure = array();

	// Admin - only include if member of the Admin Group
	if (auth_checkgroup('Admin'))
	{   
	    $arrStructure[$i] = array( 'name1' => 'Home', 'url' => $szRootURL.'/admin/index.php?intTypeID=1', 'width' => '30', 'height' => '50');
		$i++;
		
		// Personal Tools
		$arrStructure[$i] = array( 'name1' => 'Personal Tools', 'url' => $szRootURL.'/modules/personal_tools/index.php', 'width' => '30', 'height' => '50');
		$arrStructure[$i]['subsections'] = array(	
			1 => array( 'name1' => 'Introduction', 'url' => $szRootURL.'/modules/personal_tools/index.php', 'width' => '30', 'height' => '50'),
			//23=> array( 'name1' => 'My Profile', 'url' => $szRootURL.'/modules/personal_tools/profile.php', 'width' => '30', 'height' => '50'),
			2 => array( 'name1' => 'Change Password', 'url' => $szRootURL.'/modules/personal_tools/changepwd.php', 'width' => '30', 'height' => '50'),
			//4 => array( 'name' => 'Address Book', 'url' => $szRootURL.'/personal_tools/addressbook.php', 'width' => '30', 'height' => '50')
		);
		$i++;
		
		if (auth_checkgroup('User Admin')){
		
		
		$arrStructure[$i] = array( 'name1' => 'User Manager', 'url' => $szRootURL.'/modules/authorisation/admin/authuser.php', 'width' => '30', 'height' => '50', 'description' => 'The User Manager controls the users that have access to the the various parts of the administration suite.');
		$i++;
		$arrStructure[$i] = array( 'name1' => 'Group Manager', 'url' => $szRootURL.'/modules/authorisation/admin/authgroup.php', 'width' => '30', 'height' => '50', 'description' => 'The Group Manager controls which groups the users (defined in the user manager) belong to.');
		$i++;
		$arrStructure[$i] = array( 'name1' => 'System Logs', 'url' => $szRootURL.'/modules/user_tracking/admin/index.php', 'width' => '30', 'height' => '50', 'description' => 'The Group Manager controls which groups the users (defined in the user manager) belong to.');
		$i++;
		}
		
				
		$arrStructure[$i] = array( 'name1' => 'Navigation Manager', 'url' => $szRootURL.'/admin/index.php?page=view_tasks&tag=task', 'width' => '30', 'height' => '50');
		$arrStructure[$i]['subsections'] = array();
			$j=1;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Task', 'url' => $szRootURL.'/admin/index.php?page=view_tasks&tag=task', 'width' => '30', 'height' => '50', 'description' => 'Manage Task.');
				$arrStructure[$i]['subsections'][$j]['subsections'] = array();
				$k=1;
		        $arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'View Task', 'name2' => 'View Task', 'url' =>  $szRootURL.'/admin/index.php?page=view_tasks&tag=task', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Create Task', 'name2' => 'Create Task', 'url' => $szRootURL.'/admin/index.php?page=create_task&tag=task', 'width' => '', 'height' => '');
			    $k++;
			$j++;
			
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Document', 'url' => $szRootURL.'/admin/index.php?page=view_documents&tag=doc', 'width' => '30', 'height' => '50', 'description' => 'Manage Document.');
				$arrStructure[$i]['subsections'][$j]['subsections'] = array();
				$k=1;
		        $arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'View documents', 'name2' => 'View documents', 'url' =>  $szRootURL.'/admin/index.php?page=view_documents&tag=doc', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Upload document', 'name2' => 'Upload document', 'url' => $szRootURL.'/admin/index.php?page=upload_document&tag=doc', 'width' => '', 'height' => '');
			    $k++;
			$j++;
$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Newspapers', 'url' => $szRootURL.'/admin/index.php?page=view_newspaper&tag=paper', 'width' => '30', 'height' => '50', 'description' => 'Manage Newspapers.');
				$arrStructure[$i]['subsections'][$j]['subsections'] = array();
				$k=1;
		        $arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'View Newspaper', 'name2' => 'View Newspaper', 'url' =>  $szRootURL.'/admin/index.php?page=view_newspaper&tag=paper', 'width' => '', 'height' => '');
			    $k++;
$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'View Newspaper Cut', 'name2' => 'View Newspaper Cut', 'url' =>  $szRootURL.'/admin/index.php?page=view_newspaper_cut&tag=paper', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Create Newspaper Whole', 'name2' => 'Create Newspaper Whole', 'url' => $szRootURL.'/admin/index.php?page=create_newspaper&tag=paper', 'width' => '', 'height' => '');
			    $k++;
$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Create Newspaper Cut', 'name2' => 'Create Newspaper Cut', 'url' => $szRootURL.'/admin/index.php?page=create_newspaper_cut&tag=paper', 'width' => '', 'height' => '');
			    $k++;
			$j++;
			
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Staff Directory', 'url' => $szRootURL.'/admin/index.php?page=view_users&tag=dir', 'width' => '30', 'height' => '50', 'description' => 'Manage Document.');
			$j++;
			//echo "is true=".auth_checkgroup('Can Configure');
		 if (auth_checkgroup('Can Configure')){
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Configuration', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=task_classification&tag=conf', 'width' => '30', 'height' => '50', 'description' => 'Manage Document.');
				$arrStructure[$i]['subsections'][$j]['subsections'] = array();
				$k=1;
		        $arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Task', 'name2' => 'Task', 'url' =>  $szRootURL.'/admin/index.php?page=configure&setup=task_classification&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Priority', 'name2' => 'Priority', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=priority_classification&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Workload', 'name2' => 'Workload', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=workload_classification&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Referral', 'name2' => 'Referral', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=referral_classification&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Task closure', 'name2' => 'Task closure', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=task_closure_classification&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Task outcome', 'name2' => 'Task outcome', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=task_outcome_classification&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Document', 'name2' => 'Document', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=document_classification&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'File types', 'name2' => 'File types', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=file_type&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Files', 'name2' => 'Files', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=file&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Subject area', 'name2' => 'Subject area', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=subject_area&tag=conf', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Entity', 'name2' => 'Entity', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=entity_type&tag=conf', 'width' => '', 'height' => '');
			    $k++;
	$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Newspaper', 'name2' => 'Newspaper', 'url' => $szRootURL.'/admin/index.php?page=configure&setup=newspaper_type&tag=conf', 'width' => '', 'height' => '');
			    $k++;
			$j++;
		}
		
	  if (auth_checkgroup('Can Manage Users')){
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Administration', 'url' => $szRootURL.'/admin/index.php?page=manage_users&tag=adm', 'width' => '30', 'height' => '50', 'description' => 'Manage Document.');
				$arrStructure[$i]['subsections'][$j]['subsections'] = array();
				$k=1;
		        //$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Register new Member', 'name2' => 'Register new user', 'url' =>  $szRootURL.'/admin/index.php?page=create_user&tag=adm', 'width' => '', 'height' => '');
			    //$k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Manage Members', 'name2' => 'Manage users', 'url' => $szRootURL.'/admin/index.php?page=manage_users&tag=adm', 'width' => '', 'height' => '');
			    $k++;
				$arrStructure[$i]['subsections'][$j]['subsections'][$k] = array( 'name1' => 'Manage Sections', 'name2' => 'Manage groups', 'url' => $szRootURL.'/admin/index.php?page=manage_groups&tag=adm', 'width' => '', 'height' => '');
			    $k++;
				
			$j++;
		}
	 $i++;
	
	
	if (auth_checkgroup('Backup Admin')){
			$arrStructure[$i] = array( 'name1' => 'Backup Manager', 'url' => $szRootURL.'/modules/backup/index.php', 'width' => '30', 'height' => '50');
			// subsections
			$arrStructure[$i]['subsections'] = array();$j=1;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Information', 'url' => $szRootURL.'/modules/backup/index.php', 'width' => '30', 'height' => '50', 'description' => 'This tool allows the management of all the Information in the site.');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Configuration', 'url' => $szRootURL.'/modules/backup/config.php', 'width' => '30', 'height' => '50', 'description' => 'This tool allows the management of all the Configuration in the site.');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Import', 'url' => $szRootURL.'/modules/backup/import.php', 'width' => '30', 'height' => '50', 'description' => 'This tool allows the management of all the Import in the site.');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Backup', 'url' => $szRootURL.'/modules/backup/backup.php', 'width' => '30', 'height' => '50', 'description' => 'This tool allows the management of all the Backup in the site.');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Schedule Backup', 'url' => $szRootURL.'/modules/backup/scheduled.php', 'width' => '30', 'height' => '50', 'description' => 'This tool allows the management of all the Schedule Backup in the site.');
			$j++;
			$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'Database Info', 'url' => $szRootURL.'/modules/backup/db_info.php', 'width' => '30', 'height' => '50', 'description' => 'This tool allows the management of all the Database Info in the site.');
			$j++;
			//$arrStructure[$i]['subsections'][$j] = array( 'name1' => 'SQL Queries', 'url' => $szRootURL.'/modules/backup/sql_query.php', 'width' => '30', 'height' => '50', 'description' => 'This tool allows the management of all the SQL Queries in the site.');
			//$j++;
			$i++;
		}
	}

	##########################################################################
	# define Special Navigation Array for top level navigation for switiching
	# between Public Area, Private Area, and Administration.
	##########################################################################
	
	$i=1;
	$arrSpecialStructure = array();

	// Public Site
	$arrSpecialStructure[$i] = array( 'name1' => 'Help', 'name2' => 'Help', 'url' => $szRootURL.'/modules/help/index.php', 'width' => '30', 'height' => '50');
	$i++;

	// Logout
	$arrSpecialStructure[$i] = array( 'name1' => 'Logout', 'url' => $szRootURL.'/modules/authorisation/logout.php', 'width' => '30', 'height' => '50');
	$i++;

	


?>
