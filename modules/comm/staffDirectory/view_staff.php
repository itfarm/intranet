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
$page="view_staff";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBStaff;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBStaff;
$crumbs[1]['url'] = $root_path.'modules/staff/index.php?menuid='.$menuid;
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


<div id="content">

<?                          $StaffID=$_GET['StaffID'];
                            $categoryID=$_GET['categoryID'];
			                $sqlStaff=$christCMS->get_staff_single($StaffID);
							$resultStaff = $christDB->f_ExecuteSql($sqlStaff);
							$arrErrorStaff=$christDB->f_GetSqlError();
							 if(!empty($arrErrorStaff['message'])){
							   echo $arrErrorStaff['message'].$LBGetError.$arrErrorStaff['code'];
							 }
							$recordcountStaff = $christDB->f_GetSelectedRows();
						    
							if ($recordcountStaff!=0)
							    {  
								   echo'<table width="100%" border="0" cellpadding="2" cellspacing="2">';
								   
								   while ($arrStaff = $christDB->f_GetRecord($resultStaff)) { 
								            //$filePath = $root_path.$uploadDir . $fileName;
											echo'<tr><td valign="top" width="10%" >
											         <tr><td valign="top" ><b>'.$LBcontTitle.'</b>&nbsp;:</td><td valign="top" >&nbsp;'.$arrStaff['StaffName'].'</td></tr>
													 <tr><td valign="top" ><b>'.$LBDescription.'</b>&nbsp;:</td><td valign="top" >&nbsp;<i>'.$arrStaff['Description'].'</i></td></tr>';
													 if($arrStaff['PhotoName']!=""){
													 echo'<tr><td valign="top" ><b>'.$LBPhoto.'</b>&nbsp;:</td><td valign="top" >&nbsp;<img src="'.$root_path.'docs/'.$arrStaff['PhotoName'].'" width="50" height="50" border="0">
													 </td></tr>
												';
												}
												//.readfile($arrStaff['PhotoPath']).
												
										 }
								   echo'<tr><td colspan="2"><a href="'.$root_path.'modules/staff/index.php?menuid='.$menuid.'">'.$LBBackTofList.'</a></td></tr>
								   </table>';
								}
							else{
								echo  $LBcontNotFound;
								}
?>
</div>


<?php								
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
