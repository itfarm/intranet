<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="edit_user";
$adminMain="User";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBUserAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBUserAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/security/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
         //$userName  = $_POST['userName'] ;
         //$password  = $_POST['password'] ;
		 $userID = $_POST['userID'];
         $FName = $_POST['FName'];
		 $LName  = $_POST['LName'];
         $OName = $_POST['OName'] ;
         $Tel = $_POST['Tel'];
		 $Mobile  = $_POST['Mobile'];
         $RoomNo  = $_POST['RoomNo'];
		 $userStatus =$_POST['userStatus'];
		 $dtCreated  =$_POST['dtCreated'];
		 $lastLogin  ="";
		 //process permissions
		 $arrPerms=array();
		 if (isset($_POST['permision'])){
					foreach ($_POST['permision'] as $groupID => $arrPermisions){
						if (count($arrPermisions)){
							$arrPerms[$groupID]['intPermision'] = array_sum($arrPermisions);
						}else{
							$arrPerms[$groupID]['intPermision'] = 0;
						}
					}
	     }
		
		 $sql=$christCMS->update_user_single($userID,$FName,$LName,$OName,$Tel,$Mobile,$RoomNo,$userStatus,$dtCreated,$lastLogin);
		 $christDB->f_ExecuteSql($sql);
		 $arrError=$christDB->f_GetSqlError();
		 if(!empty($arrError['message'])){
		   echo $arrError['message'].$LBUpdateError.$arrError['code'];
		 }
		 //clear user permisions
		 $sqlClearPerm=$christCMS->delete_user_permision($userID);
		 $christDB->f_ExecuteSql($sqlClearPerm);
		 //add user permissions
         
		foreach ($arrPerms as $groupID=>$group){
				if ($group['intPermision']){
				     $intPermision=$group['intPermision'];
					 
					 $sqlPerm=$christCMS->add_user_permision($userID,$groupID,$intPermision);
					 $christDB->f_ExecuteSql($sqlPerm);
					 $arrErrorPerm=$christDB->f_GetSqlError();
					 if(!empty($arrErrorPerm['message'])){
					   echo $arrErrorPerm['message'].$LBUpdateError.$arrError['code'];
					 }
				}
			}
			?>
			<script language="JavaScript">
	        var pageURL='<?=$root_path?>modules/core/security/index.php?menuid=<?=$menuid?>';
			window.location.href = pageURL;
           </script>
			<?
    }else{
		$userID=$_GET['userID'];
		
		$sqlgetU=$christCMS->get_user_single($userID,$userStatus);
		$resultn = $christDB->f_ExecuteSql($sqlgetU);
		$recordcount = $christDB->f_GetSelectedRows();
		$arrUser = $christDB->f_GetRecord($resultn);
		$arrError=$christDB->f_GetSqlError();
	
	}
  // echo $menuid;

?>



<div class="sectionLabel">
	<?=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
			//var_dump($arrLangRow = $christDB->f_GetRecord($resultAll));	   
	?> 
</div>
<div>&nbsp;</div>
<div><?=$LBPageTitle.'&nbsp;:&nbsp;'.$LBSection?></div>
<div>&nbsp;</div>
<div class="line"></div>
<div>&nbsp;</div>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?menuid=<?=$menuid?>" method="post" name="user" id="user">
		  <input type="Hidden" name="menuid" id="menuid" value="<?=$menuid?>" >
		  <input type="Hidden" name="userID" id="userID" value="<?=$arrUser['userID']?>" >
		  
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
			  <tr><td colspan="2" class="sectionLabel"><?=$LBuserDetails?></td></tr>
              <tr><td><?=$LBuserName?>:</td><td><input name="userName" id="userName" type="text" size="30" maxlength="50" class="select" disabled value="<?=$arrUser['userName']?>"  /></td></tr>
              <tr><td><?=$LBFName?>:</td><td><input name="FName" id="FName" type="text" size="30" maxlength="50" class="select" value="<?=$arrUser['FName']?>" /></td></tr>
              <tr><td><?=$LBLName?>:</td><td><input name="LName" id="LName" type="text" size="30" maxlength="100" class="select" value="<?=$arrUser['LName']?>"/></td></tr>
	          <tr><td><?=$LBOName?>:</td><td><input name="OName" id="OName" type="text" size="30" maxlength="100" class="select" value="<?=$arrUser['OName']?>"/></td></tr>
			  <tr><td><?=$LBTel?>:</td><td><input name="Tel" id="Tel" type="text" size="30" maxlength="100" class="select" value="<?=$arrUser['Tel']?>"/></td></tr>
			  <tr><td><?=$LBMobile?>:</td><td><input name="Mobile" id="Mobile" type="text" size="30" maxlength="100" class="select" value="<?=$arrUser['Mobile']?>"/></td></tr>
			  <tr><td><?=$LBRoomNo?>:</td><td><input name="RoomNo" id="RoomNo" type="text" size="30" maxlength="100" class="select" value="<?=$arrUser['RoomNo']?>"/></td></tr>
			  <tr><td><?=$LBuserStatus?></td><td>
						                       <select name="userStatus" id="userStatus" class="select">
											   <option value="Active"<?if($arrUser['userStatus']=='Active'){echo 'selected';}?>><?=$LBActive?></option>
											   <option value="Inactive"<?if($arrUser['userStatus']=='Inactive'){echo 'selected';}?>><?=$LBInactive?></option>
											   </select> 
			                                </td>
			  </tr>
			  <tr><td><?=$LBdtCreated?>:</td><td><input name="dtCreated" id="dtCreated" type="text" size="30"style="width:100px;" class="select" />
                       <!-- ggPosX and ggPosY not set, so popup will autolocate to the right of the graphic -->
	                   <a href="javascript:show_calendar('user.dtCreated');" onMouseOver="window.status='Date Picker'; overlib('<?=$LBdtText?>'); return true;" onMouseOut="window.status=''; nd(); return true;">
					   <img src="<?=$root_path?>images/icons/pickdt.png" width=16 height=16 border=0></a>

			  </td></tr>
              <tr><td colspan="2" class="sectionLabel"><?=$LBPermision?></td></tr>
               <tr><td colspan="2">
			       <table cellspacing="2" cellpadding="2" border="0" width=100%>
						<tr>
							<td align=center>&nbsp;</td>
							<td align=center><?=$LBDelete?></td>
							<td align=center><?=$LBWrite?></td>
							<td align=center><?=$LBRead?></td>
						</tr>
		                <?
					  	$sqlPerm=$christCMS->get_usergroup_items($langCode);
					    $resultPerm = $christDB->f_ExecuteSql($sqlPerm);
					    $recordcount = $christDB->f_GetSelectedRows();
						$arrPermisions=array();
						//$i=1;
						while ($arrPermRow = $christDB->f_GetRecord($resultPerm)) { 
						      $groupTitle = $arrPermRow['groupTitle'];
							  $groupID=$arrPermRow['groupID'];
							  //fetch user permisions
							  $sqlUserPerm=$christCMS->get_user_permision($userID,$groupID);
					          $resultUserPerm = $christDB->f_ExecuteSql($sqlUserPerm);
						      $arrUserPermRow = $christDB->f_GetRecord($resultUserPerm);
							 // var_dump($arrUserPermRow);
							  //$arrUserPermRow['intPermision'];
							  $byteLength = 8;
					          $BinPermision = str_pad(decbin($arrUserPermRow['intPermision']), $byteLength, '0', STR_PAD_LEFT);
							?>
							<tr><td class=""><?=$groupTitle?></td>
								<td align=center class=""><input type="checkbox" class="checkbox" name="permision[<?=$arrPermRow['groupID']?>][1]" value="1"<? if($BinPermision[7]) echo 'checked'; ?> ></td>
								<td align=center class=""><input type="checkbox" class="checkbox" name="permision[<?=$arrPermRow['groupID']?>][2]" value="2" <? if($BinPermision[6]) echo 'checked'; ?>></td>
								<td align=center class=""><input type="checkbox" class="checkbox" name="permision[<?=$arrPermRow['groupID']?>][4]" value="4"<? if($BinPermision[5]) echo 'checked'; ?>></td>
							</tr>
							<?
						//$i++;
						}
					    ?>
		              	</table>
			   </td></tr>
              <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBeditUser?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>