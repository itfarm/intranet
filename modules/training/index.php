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

<?
			                $sqls=$christCMS->get_training_items("en",$archive,"");
							$results = $christDB->f_ExecuteSql($sqls);
							$arrErrorEvents=$christDB->f_GetSqlError();
							 if(!empty($arrErrorEvents['message'])){
							   echo $arrErrorEvents['message'].$LBGetError.$arrErrorEvents['code'];
							 }
							$recordcountEvents = $christDB->f_GetSelectedRows();
						    
							if ($recordcountEvents!=0)
							    {  
								   echo'<table width="100%" border="0" cellpadding="2" cellspacing="2">
                                                                          <tr><td><b>'.$LBcontTitle.'</b></td></tr>';
								   
								   while ($arrs = $christDB->f_GetRecord($results)) { 
								            
											echo'<tr><td valign="top"  >
											          <a href="'.$root_path.'modules/training/view.php?menuid='.$menuid.'&tID='.$arrs['id'].'">'.$arrs['tTitle'].'</a></td>		
									


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
