<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="add_cat";
$adminMain="Category";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBCatAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBCatAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/category/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
         $catTitle     = $_POST['catTitle'] ;
         $catDescription  = $_POST['catDescription'] ;
         $langCode = $_POST['langCode'];
         //adding entry
		 $sql=$christCMS->add_category($catTitle,$catDescription,$langCode);
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
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?menuid=<?=$menuid?>" method="post" name="cat" id="cat">
		  <input type="Hidden" name="menuid" id="menuid" value="<?=$menuid?>" >
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
              <tr><td><?=$LBcontTitle?>:</td><td><input name="catTitle" id="catTitle" type="text" size="30" maxlength="50" class="select" /></td></tr>
              <tr><td valign="top"><?=$LBDescription?>:</td><td><textarea name="catDescription" id="catDescription" cols="50" rows="15"></textarea></td></tr>
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

              
              <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBaddCat?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>