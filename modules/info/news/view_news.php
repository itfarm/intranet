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
$page="index";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBNews;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBNews;
$crumbs[1]['url'] = $root_path.'modules/news/index.php?menuid='.$menuid;
?>
<table width="754" border="0" cellpadding="0" cellspacing="0" background="<?=$root_path?>/skins/default/images/content_bckgrd.gif">
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="18" align="left" valign="top">&nbsp;</td>
    <td width="711" align="left" valign="top"><!--content starts here -->

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

<div id="content">


<?                          $newsID=$_GET['newsID'];
                            $categoryID=$_GET['categoryID'];
			                $sqlNews=$christCMS->get_news_single($newsID,$categoryID,$langCode,$archive);
							$resultNews = $christDB->f_ExecuteSql($sqlNews);
							$arrErrorNews=$christDB->f_GetSqlError();
							 if(!empty($arrErrorNews['message'])){
							   echo $arrErrorNews['message'].$LBGetError.$arrErrorNews['code'];
							 }
							$recordcountNews = $christDB->f_GetSelectedRows();
						    
							if ($recordcountNews!=0)
							    {  
								   echo'<table width="100%" border="0" cellpadding="2" cellspacing="2">';
								   
								   while ($arrNews = $christDB->f_GetRecord($resultNews)) { 
								            
											echo'<tr><td valign="top" width="10%" >
											         <tr><td valign="top" ><b>'.$LBcontTitle.'</b>&nbsp;:</td><td valign="top" >&nbsp;'.$arrNews['newsTitle'].'</td></tr>
												
													 <tr><td valign="top" ><b>'.$LBBody.'</b>&nbsp;:</td><td valign="top" >&nbsp;'.$arrNews['newsBody'].'
													 </td></tr>
												';
												
												
										 }
								   echo'<tr><td colspan="2"><a href="'.$root_path.'modules/news/index.php?menuid='.$menuid.'">'.$LBBackNewsList.'</a></td></tr>
								   </table>';
								}
							else{
								echo  $LBcontNotFound;
								}
?>
</div>
<!--content ends here --></td>
    <td width="134" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
</table>

 
<?php							
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
