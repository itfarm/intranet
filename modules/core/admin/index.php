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
$LBSection=$LBTraining;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBTraining;
$crumbs[1]['url'] = $root_path.'modules/training/index.php?menuid='.$menuid;
?>
<!--content starts here -->

<div id="content">
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

<div><? //=$LBPageTitle.'&nbsp;:&nbsp;'.$LBSection?></div>
<div class="line"></div>
<?      if($menuid==""){
            $menuid="MM1";  
        }
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
		echo  $LBcontNotFound; ?>
<!--contents ends -->     </td><td width="240" align="left" valign="top" class="picture_02news"><p><br />
    <?
                                        $limitNews=3;
			                $sqlNews=$christCMS->get_news_items($categoryID,$langCode,$archive,$limitNews);
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
								            
											echo'<tr><td valign="top" width="50%" align="justify"  >
											         <a href="'.$root_path.'modules/info/news/view_news.php?menuid='.$menuid.'?&newsID='.$arrNews['id'].'&categoryID='.$arrNews['categoryID'].'">'.$arrNews['newsTitle'].'</a>
											<br>'.substr(strip_tags($arrNews['newsSummary']),0,200).'&nbsp; <a href="'.$root_path.'modules/news/view_news.php?menuid='.$menuid.'?&newsID='.$arrNews['id'].'&categoryID='.$arrNews['categoryID'].'">|| More</a> 
													 </td>
												';
												
												
										 }
								   echo'</tr></table>';
								}
							else{
								echo  $LBcontNotFound;
								}
?>
</div>
<!--content ends here -->

<?php					
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
