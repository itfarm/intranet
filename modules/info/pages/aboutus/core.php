<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$skinFolder='default';
$page="background";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBBackround;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBAboutUs;
$crumbs[1]['url'] = $root_path.'modules/pages/aboutus/index.php?menuid='.$menuid;
$crumbs[2]['name'] = $LBBackround;
$crumbs[2]['url'] = $root_path.'modules/pages/aboutus/background.php?menuid='.$menuid.'&submenuid='.$submenuid;
?>
<table width="960" border="0" cellpadding="0" cellspacing="0" background="<?=$root_path?>/skins/default/images/content_bckgrd.gif">
  <tr>
    <td colspan="3" align="left" valign="top"></td>
  </tr>
  <tr>
    <td width="20" align="left" valign="top">&nbsp;</td>
    <td width="920" align="left" valign="top"><!--content starts here -->
	<? //=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	//echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
				   
	?> 
</div>

<div id="content"><? //=$LBPageTitle.$LBSection?></div>
<div id="content">
<div>
&nbsp;
</div>

<?  
        if($submenuid==""){
            $submenuid=$menuid;  
        }
        $sqlgetp=$christCMS->get_page_display($submenuid,"en");
	$resultp = $christDB->f_ExecuteSql($sqlgetp);
	$recordcount = $christDB->f_GetSelectedRows();
	$arrPage = $christDB->f_GetRecord($resultp);
	if (!empty($arrPage['pageContent']))
		echo $arrPage['pageContent'];
	else
		echo  $LBcontNotFound;
?>
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
