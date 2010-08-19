<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="add_project";
$adminMain="News";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBProjectAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $home_url;
$crumbs[1]['name'] = $LBProjectAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/projects/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
         $projectTitle     = $_POST['projectTitle'] ;
         $categoryID     = $_POST['categoryID'] ;
         $projectSummary  = $_POST['projectSummary'] ;
         $projectObjective = $_POST['projectObjective'];
		
         $langCode = $_POST['langCode'];
		 $archieve  = $_POST['archieve'];
		 $projectResult  = $_POST['projectResult'];
         $dtStarted    = $_POST['dtStarted'];
         $dtEnded    = $_POST['dtEnded'];
         $status    = $_POST['status'];
         
		 $sql=$christCMS->add_project($categoryID,$projectTitle,$projectSummary,$projectObjective,$langCode,$dtStarted,$dtEnded,$archive,$projectResult,$status);
		 $christDB->f_ExecuteSql($sql);
		 
    } 

?>



<div class="sectionLabel">
	<?=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
				   
	?> 
</div>
<div>&nbsp;</div>
<div><?=$LBPageTitle.'&nbsp;:&nbsp;'.$LBSection?></div>
<div>&nbsp;</div>
<div class="line"></div>
<div>&nbsp;</div>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?menuid=<?=$menuid?>" method="post" name="project" id="project">
		  <input type="Hidden" name="menuid" id="menuid" value="<?=$menuid?>" >
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
            <tr><td><?=$LBCategory?>:</td><td>   
								   <select name="categoryID" id="categoryID" style="width:100px;" class="select">
								   <option value=""></option>
								   <?php 
								  $sqlAll=$christCMS->get_all_category();
								   $resultAll = $christDB->f_ExecuteSql($sqlAll);
								   $recordcountAll = $christDB->f_GetSelectedRows();
								   while ($arrCatgory = $christDB->f_GetRecord($resultAll)) { ?>
								    <option value="<?=$arrCatgory['id']?>"><?=$arrCatgory['category']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>
              <tr><td><?=$LBcontTitle?>:</td><td><input name="projectTitle" id="projectTitle" type="text" size="30" maxlength="200"  class="select" /></td></tr>
              <tr><td valign="top"><?=$LBSummary?>:</td><td><textarea name="projectSummary" id="projectSummary" cols="50" rows="15"></textarea></td></tr>
			  <tr><td valign="top"><?=$LBObjective?>:</td><td><textarea name="projectObjective" id="projectObjective" cols="50" rows="15"></textarea></td></tr>
              <tr><td valign="top"><?=$LBResult?>:</td><td><textarea name="projectResult" id="projectResult" cols="50" rows="15"></textarea></td></tr>
			  
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
			  <tr><td><?=$LBProjectStatus?>:</td><td>   
								  <select name="status" id="status" style="width:100px;" class="select">
								   <option value=""></option>
								   <?php 
								   $sqlAll=$christCMS->get_all_status();
								   $resultAll = $christDB->f_ExecuteSql($sqlAll);
								   $recordcountAll = $christDB->f_GetSelectedRows();
								   while ($arrLangRow = $christDB->f_GetRecord($resultAll)) { ?>
								    <option value="<?=$arrLangRow['id']?>"><?=$arrLangRow['status']?></option>
								   <?php } ?>
								   </select>                         
                                    </td>
              </tr>
              <tr><td><?=$LBArchieve?></td><td>
						                       <select name="archieve" id="archieve" class="select">
											   <option value="No"><?=$LBNo?></option>
											   <option value="Yes"><?=$LBYes?></option>
											   </select>  
			                                </td>
			  </tr>
              <tr><td><?=$LBDateStarted?>:</td><td><input name="dtStarted" id="dtStarted" type="text" size="30"style="width:100px;" class="select" />
                       <!-- ggPosX and ggPosY not set, so popup will autolocate to the right of the graphic -->
	                   <a href="javascript:show_calendar('project.dtStarted');" onMouseOver="window.status='Date Picker'; overlib('<?=$LBdtText?>'); return true;" onMouseOut="window.status=''; nd(); return true;">
					   <img src="<?=$root_path?>images/icons/pickdt.png" width=16 height=16 border=0></a>
			  </td></tr>			  
			  <tr><td><?=$LBDateEnded?>:</td><td><input name="dtEnded" id="dtEnded" type="text" size="30"style="width:100px;" class="select" />
                       <!-- ggPosX and ggPosY not set, so popup will autolocate to the right of the graphic -->
	                   <a href="javascript:show_calendar('project.dtEnded');" onMouseOver="window.status='Date Picker'; overlib('<?=$LBdtText?>'); return true;" onMouseOut="window.status=''; nd(); return true;">
					   <img src="<?=$root_path?>images/icons/pickdt.png" width=16 height=16 border=0></a>
			  </td></tr>              
              <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBaddproject?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>
