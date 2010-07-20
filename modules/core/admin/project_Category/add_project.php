<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="add_project_category";
$adminMain="Category Project";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBProjectCategoryAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBProjectCategoryAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/project_Category/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
         $category     = $_POST['category'] ;
         $description  = $_POST['description'] ;     
		 $langCode = $_POST['langCode'];
		 $categoryID = $_POST['categoryID'];
         
		 $sql=$christCMS->add_project_category($categoryID,$category,$description,$langCode);
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
              <tr><td><?=$LBCategory?>:</td><td><input name="category" id="category" type="text" size="30" maxlength="200"  class="select" /></td></tr>
              <tr><td valign="top"><?=$LBDescription?>:</td><td><textarea name="description" id="description" cols="50" rows="15"></textarea></td></tr>
			  
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
			 
              <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBaddprojectcategory?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>