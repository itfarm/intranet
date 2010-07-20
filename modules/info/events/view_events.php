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

<?                          $eventID=$_GET['eventID'];
                            $categoryID=$_GET['categoryID'];
			                $sql=$christCMS->get_event_single($eventID,$categoryID,"en",$archive);
							$result = $christDB->f_ExecuteSql($sql);
							$arrError=$christDB->f_GetSqlError();
							 if(!empty($arrError['message'])){
							   echo $arrError['message'].$LBGetError.$arrError['code'];
							 }
							$recordcount = $christDB->f_GetSelectedRows();
						    
							if ($recordcount!=0)
							    {  
								   echo'<table width="100%" border="0" cellpadding="2" cellspacing="2">';
								   
								   while ($arrEvent = $christDB->f_GetRecord($result)) { 
								            
											echo'<tr><td valign="top" width="10%" >
											         <tr><td valign="top" ><b>'.$LBcontTitle.'</b>&nbsp;:</td><td valign="top" >&nbsp;'.$arrEvent['eventTitle'].'</td></tr>
													 <tr><td valign="top" ><b>'.$LBSummary.'</b>&nbsp;:</td><td valign="top" >&nbsp;<i>'.$arrEvent['eventSummary'].'</i></td></tr>
													 <tr><td valign="top" ><b>'.$LBBody.'</b>&nbsp;:</td><td valign="top" >&nbsp;'.$arrEvent['eventBody'].'
													 </td></tr>
													 <tr><td valign="top" ><b>'.$LBLocation.'</b>&nbsp;:</td><td valign="top" >&nbsp;'.$arrEvent['eventLocation'].'
													 </td></tr><tr><td valign="top" ><b>'.$LBStartDt.'</b>&nbsp;:</td><td valign="top" >&nbsp;'.$arrEvent['startDt'].'
													 </td></tr><tr><td valign="top" ><b>'.$LBEndDt.'</b>&nbsp;:</td><td valign="top" >&nbsp;'.$arrEvent['endDt'].'
													 </td></tr>
												';
												
												
										 }
								   echo'<tr><td colspan="2"><a href="'.$root_path.'modules/events/index.php?menuid='.$menuid.'">'.$LBBackEventsList.'</a></td></tr>
								   </table>';
								}
							else{
								echo  $LBcontNotFound;
								}
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
