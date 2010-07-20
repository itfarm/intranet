<?
 /*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
//define page for language selection
$page="index";
//load site path
require_once('root.php');
//language selector script
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
$LBLanguage="Language";
$LBDate="Date";
?>
<span id="pageWindow">



<?
//fetching default language 
//var_dump($_GET);
$lgCode=$_GET['langCode'];
$menuid=$_GET['menuid'];
$submenuid=$_GET['submenuid'];
if($lgCode==''){
 //set default if no language selected
 $langCode='en';
}else{
 $langCode=$lgCode;
}

$langPath=$root_path.$cfgLanguagePath.$langCode.$cfgLanguageFile;
//including language file
require_once($langPath);
$skinFolder='default';

?>



 
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$LBSiteTitle.'-'.$LBHome?></title>
	
    <link href="<?=$root_path.'skins/'.$skinFolder.$cfgStyleFilePath?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?=$root_path?>skins/default/javascript/slide.js"></script>
<script language="JavaScript" src="<?=$root_path?>js/slidepics.js">//onload="runSlideShow()"</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


 

<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" id="container">
  <tr>
    <td width="960" align="left" valign="top" id="header"><!--header --><table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" rowspan="3" align="left" valign="top"><img src="<?=$root_path?>skins/default/images/logo.jpg" width="200" height="150" /></td>
    <td width="730" align="left" valign="middle" class="topNavigation"><table width="400" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="380" align="left" valign="middle" background="<?=$root_path?>skins/default/images/top_navigation.jpg"><font color="#FFFFFF"><?php 
       include($root_path.'skins/default/menu/menu_bottom_tab.php');
     ?></td>
        <td width="10" align="left" valign="top"><img src="<?=$root_path?>skins/default/images/top_navigation_curve.jpg" width="10" height="40" /></td>
      </tr>
    </table></td>
    <td width="30" rowspan="3" align="left" valign="top" >&nbsp;</td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="bannerImageCell" ><img src="<?=$root_path?>skins/default/images/banner_graph.jpg" width="510" height="80" /><img src="<?=$root_path?>skins/default/images/picture_01.jpg" width="220" height="80" /></td>
    </tr>
  <tr>
    <td align="left" valign="middle" class="navigation"><!--navigation --><?php 
   include($root_path.'skins/default/menu/menu_top_tab.php');
   ?></td>
    </tr>
</table>
</td>
  </tr>
  
  <tr>
    <td width="960" align="left" valign="top" ><table width="960" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="190" align="left" valign="top" id="sidebar_left"><!--sidebar left --><table width="190" border="0" cellpadding="0" cellspacing="0" background="<?=$root_path?>skins/default/images/news_bckgrd.gif">
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="20" align="left" valign="top">&nbsp;</td>
    <td width="160" align="center" valign="top" ><br />
    <br />
    
    <script type="text/javascript">
//new fadeshow(IMAGES_ARRAY_NAME, slideshow_width, slideshow_height, borderwidth, delay, pause (0=no, 1=yes), optionalRandomOrder)
new fadeshow(fadeimages, 90, 112, 0, 3000, 1, "R");
</script><br />
<br />
<script type="text/javascript">
//new fadeshow(IMAGES_ARRAY_NAME, slideshow_width, slideshow_height, borderwidth, delay, pause (0=no, 1=yes), optionalRandomOrder)
new fadeshow(fadeimages, 90, 112, 0, 3000, 1, "R");
</script>
<br /></td>
    <td width="10" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><img src="<?=$root_path?>skins/default/images/news_footer.jpg" width="190" height="10" /></td>
    </tr>
</table>
</td>
        <td width="520" align="left" valign="top" id="content" class="picture_02">			

<!-- ########## header ends ######## -->
