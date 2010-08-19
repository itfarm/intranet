<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="edit_group";
$adminMain="User Group";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBGroupAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBGroupAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/security/group/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
	     $groupID =$_POST['groupID'] ;
         $groupTitle     = $_POST['groupTitle'] ;
         $groupDescription  = $_POST['groupDescription'] ;
         $groupStatus = $_POST['groupStatus'];
         $langCode = $_POST['langCode'];
         //adding entry
		 $sql=$christCMS->update_usergroup_single($groupID,$groupTitle,$groupDescription,$groupStatus,$langCode);
		 $christDB->f_ExecuteSql($sql);
		 $arrErrorUp=$christDB->f_GetSqlError();
		 if(!empty($arrErrorUp['message'])){
		   echo $arrErrorUp['message'].$LBUpdateError.$arrErrorUp['code'];
		 }
    }else{
		$groupID=$_GET['groupID'];
		
		$sqlgetn=$christCMS->get_usergroup_single($groupID,$langCode);
		$resultn = $christDB->f_ExecuteSql($sqlgetn);
		$recordcount = $christDB->f_GetSelectedRows();
		$arrGroup = $christDB->f_GetRecord($resultn);
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
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?menuid=<?=$menuid?>" method="post" name="events" id="events">
		  <input type="Hidden" name="menuid" id="menuid" value="<?=$menuid?>" >
		  <input type="Hidden" name="groupID" id="id" value="<?=$arrGroup['groupID']?>" >
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
               <tr><td><?=$LBcontTitle?>:</td><td><input name="groupTitle" id="groupTitle" type="text" size="30" maxlength="50" class="select" value="<?=$arrGroup['groupTitle']?>" /></td></tr>
              <tr><td valign="top"><?=$LBDescription?>:</td><td><textarea name="groupDescription" id="groupDescription" cols="50" rows="15"><?=$arrGroup['groupDescription']?></textarea></td></tr>
              <tr><td><?=$LBgroupStatus?></td><td>
						                       <select name="groupStatus" id="groupStatus" class="select">
											   <option value="Active"<?if($arrGroup['groupStatus']=='Active'){echo 'selected';}?>><?=$LBActive?></option>
											   <option value="Inactive"<?if($arrGroup['groupStatus']=='Inactive'){echo 'selected';}?>><?=$LBInactive?></option>
											   </select> 
			                                </td>
			  </tr>
			  <tr><td><?=$LBLanguage?>:</td><td>   
								   <select name="langCode" id="langCode" style="width:100px;" class="select">
								   <option value=""></option>
								   <?php 
								   $sqlAll=$christCMS->get_language_all();
								   $resultAll = $christDB->f_ExecuteSql($sqlAll);
								   $recordcountAll = $christDB->f_GetSelectedRows();
								   while ($arrLangRow = $christDB->f_GetRecord($resultAll)) { ?>
								    <option value="<?=$arrLangRow['langCode']?>"<?if($arrGroup['langCode']==$arrLangRow['langCode']){echo 'selected';}?>><?=$arrLangRow['langCaption']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>              
			  <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBeditGroup?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>