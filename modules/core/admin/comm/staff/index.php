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
$LBSection=$LBStaff;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBStaff;
$crumbs[1]['url'] = $root_path.'modules/core/admin/comm/staff/index.php?menuid='.$menuid;
?>


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
<div id="header1">

<?
			                $sqlStaff=$christCMS->get_all_staff();
							$resultStaff = $christDB->f_ExecuteSql($sqlStaff);
							$arrErrorStaff=$christDB->f_GetSqlError();
							 if(!empty($arrErrorStaff['message'])){
							   echo $arrErrorStaff['message'].$LBGetError.$arrErrorStaff['code'];
							 }
							$recordcountStaff = $christDB->f_GetSelectedRows();
						    
							if ($recordcountStaff!=0)
							    {  
								   echo'<table width="100%" border="0" cellpadding="2" cellspacing="2" id="smallTextTable">';
                                                                   echo'<tr><b><td>S/N</td><td>Name</td><td>'.$LBcontTitle.'</td><td>'.$LBPhoto.'</td></b></tr>';
								   $i=1;
								   while ($arrStaff = $christDB->f_GetRecord($resultStaff)) { 
								            
											echo'<tr><td valign="top">'.$i.'</td><td valign="top" width="50%" >';
											?>
											         <a href="<?=$root_path?>modules/staff/view_staff.php?menuid=<?=$menuid?>&StaffID=<?=$arrStaff['StaffID']?>"><?=$arrStaff['StaffName']?></a>
													
											<?	
											echo'<td valign="top">'.$arrStaff['StaffTitle'].'</td><td valign="top"><img src="'.$root_path.'docs/'.$arrStaff['PhotoName'].'" width="50" height="50" border="0"></td></tr>';
										 
                                                                                        $i++;
                                                                                 }
								   echo'</table>';
								}
							else{
								echo  $LBcontNotFound;
								}
?>



<?php					
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
