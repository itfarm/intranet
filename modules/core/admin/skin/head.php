<?
@session_start();
	if(!isset($_SESSION['username']))
	{
		@header("location:$loginPage?");
	}
 /*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
//language selector script
@include($root_path .'cfg/config.php');
// require_once($root_path.'modules/core/security/usercheck.php');
require_once($root_path.'js/lang_ajax.php');
//load important scripts
require_once($root_path.'cfg/config_db.php');
require_once($root_path.'cfg/christCMSconfig.php');
require_once($root_path.'core/class_core_christcms.php');


$christCMS=new christCMS;
//fetching all language list available
$sqlAll=$christCMS->get_language_all();
$resultAll = $christDB->f_ExecuteSql($sqlAll);
$recordcountAll = $christDB->f_GetSelectedRows();
//var_dump($resultAll);	

$LBLanguage="Language";
$LBDate="Date";
$menuid=$_GET['menuid'];

//fetching default language 
//var_dump($_GET);
//var_dump($arrLangRow2 = $christDB->f_GetRecord($resultAll2));
$lgCode=$_GET['langCode'];
if($lgCode==''){
 //set default if no language selected
 $langCode='en';
}else{
 $langCode=$lgCode;
}

$langPath=$root_path.$cfgLanguagePath.$langCode.$cfgLanguageFile;
//including language file
require_once($langPath);
$userID=$_SESSION['userID'];

// Generating home url for events, news, gallery, projects, training
// and FAQ pages	
for($incr = 0; $incr <10; $incr++ ) {
	// Mark the current class
	if( $current_module == $main_url[$incr][0] ) {
		$home_url = $main_url[$incr][1];
		break;
	}
}
		
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title><?=$LBSiteTitle?></title>
	<!--
	<link href="<?=$root_path.$cfgAdminStyleFilePath?>" rel="stylesheet" type="text/css" />
	-->
	<link rel="stylesheet" type="text/css" href="/intranet/modules/tasks/stylesheets/main.css" media="screen" />
     <script  src="<?=$root_path?>js/dtpicker.js"  language="JavaScript"></script>
	 <script  src="<?=$root_path?>js/dtlib.js"  language="JavaScript"></script>
	 <script language="javascript" type="text/javascript" src="<?=$root_path?>modules/core/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	 <script language="javascript" type="text/javascript" src="<?=$root_path?>js/editor.js"></script>
</head>

<body>
<div id="wrapper">
	<!-- start header -->
	<div id="header">
		<div id="logo">
			<h1><a href=""><span>Intranet</span></a></h1>
			<p><?php echo $_SESSION['username'] ?> | <a href="<?php echo $logoutPage ?>" style="color:yellow;">Logout</a></p>
		</div>
		<div id="menu">
			<?php main_menu($current_module) ?>
		</div>
	</div>
	<!-- end header -->

	<!-- start page -->
		<div id="page">
				<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0"class="contentTable">
				<!-- page content area-->
				<tr>
					<td colspan="2" valign="top" >
					<table width="100%" cellpadding="2" cellpadding="2" border="0">
					<tr>
					<?
					if($adminMain!='Home'){
					?>
					<!--for sub menu if exist-->
					<td width="15%" valign="top" >
					
					<div class="sectionLabel"><?=$LBAdminMenu?></div>
						<table  cellpadding="2" cellspacing="2" border="0" >
							<br>
									<?php 
									//fetching all language sub menu
									//var_dump($_GET);
									$sqlSMenu=$christCMS->get_admin_sub_menu($langCode,$menuid);
									$resultSMenu = $christDB->f_ExecuteSql($sqlSMenu);
									$recordcountSMenu = $christDB->f_GetSelectedRows();
									while ($arrSMenu = $christDB->f_GetRecord($resultSMenu)) { 
									?>   
										 <tr>   
											 <td valign="top">
															 <!--<div class="Nav">-->
															  <img  src="<?=$root_path.'images/icons/'.$arrSMenu['image']?>" width="16" height="16" border="0">
															  <a  href="<?=$root_path.$arrSMenu['url']?>?menuid=<?=$menuid?>&submenuid=<?=$arrSMenu['id']?>"><?=$arrSMenu['submenu']?></a>
															  <!--</div>-->
											</td>
										 </tr>
									<?
									}
									?>
					
						</table>
					</td>
					<!--sub menu end here-->
					<?
					}
					?>
					<!-- for content-->
					<td width="80%" >
					
					
				   
				 
