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
$page="rules";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBConsultancy;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBConsultancy;
$crumbs[1]['url'] = $root_path.'modules/pages/service/index.php?menuid='.$menuid;
?>
<table width="960" border="0" cellpadding="0" cellspacing="0" background="<?=$root_path?>/skins/default/images/content_bckgrd.gif">
  <tr>
    <td colspan="3" align="left" valign="top"><img src="<?=$root_path?>/skins/default/images/content_top.gif" width="960" height="10" /></td>
  </tr>
  <tr>
    <td width="20" align="left" valign="top">&nbsp;</td>
    <td width="920" align="left" valign="top"><!--content starts here -->

<div id="content">
	<?=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
				   
	?> 
</div>

<div id="content"><? //=$LBPageTitle.$LBSection?></div>

<div id="content">
<div>
&nbsp;
</div>

<?  
    $sqlgetp=$christCMS->get_page_display("SM17","en");
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
    <td colspan="3" align="left" valign="top"><img src="<?=$root_path?>/skins/default/images/content_footer.gif" width="960" height="15" /></td>
  </tr>
</table>

 <table width="960" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="20" align="left" valign="top">&nbsp;</td>
     <td width="455" align="left" valign="top"><br /> 
<?php
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
