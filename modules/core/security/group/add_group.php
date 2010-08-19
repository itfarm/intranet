<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="add_group";
$adminMain="User Group";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBGroupAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBGroupAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/security/group/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
         $groupTitle     = $_POST['groupTitle'] ;
         $groupDescription  = $_POST['groupDescription'] ;
         $groupStatus = $_POST['groupStatus'];
         $langCode = $_POST['langCode'];
         //adding entry
		 $sql=$christCMS->add_usergroup($groupTitle,$groupDescription,$groupStatus,$langCode);
		 $christDB->f_ExecuteSql($sql);
		 $arrError=$christDB->f_GetSqlError();
		 if(!empty($arrError['message'])){
		   echo $arrError['message'].$LBAddError.$arrError['code'];
		 }
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
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
              <tr><td><?=$LBcontTitle?>:</td><td><input name="groupTitle" id="groupTitle" type="text" size="30" maxlength="50" class="select" /></td></tr>
              <tr><td valign="top"><?=$LBDescription?>:</td><td><textarea name="groupDescription" id="groupDescription" cols="50" rows="15"></textarea></td></tr>
              <tr><td><?=$LBgroupStatus?></td><td>
						                       <select name="groupStatus" id="groupStatus" class="select">
											   <option value="Active"><?=$LBActive?></option>
											   <option value="Inactive"><?=$LBInactive?></option>
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
								    <option value="<?=$arrLangRow['langCode']?>"><?=$arrLangRow['langCaption']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>

              
              <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBaddGroup?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>