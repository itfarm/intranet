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
<table width="694" border="0" cellpadding="0" cellspacing="0" background="<?=$root_path?>/skins/default/images/content_bckgrd.gif">
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="20" align="left" valign="top">&nbsp;</td>
    <td width="673" align="left" valign="top"><!--content starts here -->

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


<?
			                $sqlEvents=$christCMS->get_event_items($categoryID,"en",$archive,$status,"");
							$resultEvents = $christDB->f_ExecuteSql($sqlEvents);
							$arrErrorEvents=$christDB->f_GetSqlError();
							 if(!empty($arrErrorEvents['message'])){
							   echo $arrErrorEvents['message'].$LBGetError.$arrErrorEvents['code'];
							 }
							$recordcountEvents = $christDB->f_GetSelectedRows();
						    
							if ($recordcountEvents!=0)
							    {  
								   echo'<table width="100%" border="0" cellpadding="2" cellspacing="2" >
                                                                          <tr class="table_tr"><td>'.$LBcontTitle.'</td><td>'.$LBLocation.'</td><td>'.$LBStartDt.'</td><td>'.$LBEndDt.'</td></tr>';
								   
								   while ($arrEvents = $christDB->f_GetRecord($resultEvents)) { 
								            
											echo'<tr><td valign="top"  >
											         <a href="'.$root_path.'modules/events/view_events.php?menuid='.$menuid.'&eventID='.$arrEvents['id'].'&categoryID='.$arrEvents['categoryID'].'">'.$arrEvents['eventTitle'].'</a></td>
<td>'.$arrEvents['eventLocation'].'</td>
<td>'.$arrEvents['startDt'].'</td>
<td>'.$arrEvents['endDt'].'</td>
												';
												
												
										 }
								   echo'</tr></table>';
								}
							else{
								echo  $LBcontNotFound;
								}
?>
 </div>
<!--content ends here --></td>
    <td width="267" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
</table>


<?php					
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
