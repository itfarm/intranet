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
$LBSection=$LBEvents;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBEvents;
$crumbs[1]['url'] = $root_path.'modules/events/index.php?menuid='.$menuid;
?>
><!--content starts here -->

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
<div>&nbsp;</div>
<div><? //=$LBPageTitle.'&nbsp;:&nbsp;'.$LBSection?></div>
<div>&nbsp;</div>
<div class="line"></div>
<p>TTCF has participated in some major events including: </p>
<?
			                $sqlEvents=$christCMS->get_event_items($categoryID,$langCode,$archive,$limitEvent);
							$resultEvents = $christDB->f_ExecuteSql($sqlEvents);
							$arrErrorEvents=$christDB->f_GetSqlError();
							 if(!empty($arrErrorEvents['message'])){
							   echo $arrErrorEvents['message'].$LBGetError.$arrErrorEvents['code'];
							 }
							$recordcountEvents = $christDB->f_GetSelectedRows();
						    
							if ($recordcountEvents!=0)
							    {  
								   echo'<table width="100%" border="0" cellpadding="2" cellspacing="2">';
								   
								   while ($arrEvents = $christDB->f_GetRecord($resultEvents)) { 
								            
											echo'<tr><td valign="top" width="50%" >
											         <a href="'.$root_path.'modules/events/view_events.php?menuid='.$menuid.'&eventID='.$arrEvents['id'].'&categoryID='.$arrEvents['categoryID'].'">'.$arrEvents['eventTitle'].'</a>
													 <br>'.$arrEvents['eventSummary'].'
													 </td>
												';
												
												
										 }
								   echo'</tr></table>';
								}
							else{
								echo  $LBcontNotFound;
								}?>
                             </div>
<!--content ends here -->mjjj</td>
  
  
								<?
					
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
