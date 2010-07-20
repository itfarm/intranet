<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="edit_links";
$adminMain="Links";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBLinksAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBLinksAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/links/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
	     //var_dump($_POST);
		// exit;
		 $LinkID=$_POST['LinkID'];
         $CatID     = $_POST['catID'] ;
         $Name  = $_POST['Name'] ;
         $Url = $_POST['Url'];
		 $Description  = $_POST['Description'];
		 $langCode = $_POST['langCode'];
         //adding entry
		 $sql=$christCMS->update_link_single($LinkID,$CatID,$Name,$Description,$Url,$langCode);
		 $christDB->f_ExecuteSql($sql);
		 $arrErrorUp=$christDB->f_GetSqlError();
		 if(!empty($arrErrorUp['message'])){
		   echo $arrErrorUp['message'].$LBUpdateError.$arrErrorUp['code'];
		 }
    }else{
		$LinkID=$_GET['LinkID'];
		$CatID=$_GET['catID'];
		$sqlgetn=$christCMS->get_link_single($LinkID,$CatID,$langCode);
		$resultn = $christDB->f_ExecuteSql($sqlgetn);
		$recordcount = $christDB->f_GetSelectedRows();
		$arrLink = $christDB->f_GetRecord($resultn);
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
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?menuid=<?=$menuid?>" method="post" name="links" id="links">
		  <input type="Hidden" name="menuid" id="menuid" value="<?=$menuid?>" >
		  <input type="Hidden" name="LinkID" id="LinkID" value="<?=$arrLink['LinkID']?>" >
		  
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
			 <tr><td><?=$LBCategory?>:</td><td>   
								   <select name="catID" id="catID" style="width:100px;"class="select">
							       <option value=""></option>
								   <?php 
								   $sqlcat=$christCMS->get_cat_items($langCode);
								   $resultcat = $christDB->f_ExecuteSql($sqlcat);
								   $recordcountcat = $christDB->f_GetSelectedRows();
								   while ($arrCatRow = $christDB->f_GetRecord($resultcat)) { ?>
								    <option value="<?=$arrCatRow['categoryID']?>"<?if($arrCatRow['categoryID']==$arrLink['CatID']){echo 'selected';}?>><?=$arrCatRow['catTitle']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>
              <tr><td><?=$LBcontName?>:</td><td><input name="Name" id="Name" type="text" size="30" maxlength="50" class="select"value="<?=$arrLink['Name']?>" /></td></tr>
			  <tr><td><?=$LBUrl?>:</td><td><input name="Url" id="Url" type="text" size="30" maxlength="50" class="select"value="<?=$arrLink['Url']?>" /></td></tr>
              <tr><td valign="top"><?=$LBDescription?>:</td><td><textarea name="Description" id="Description" cols="50" rows="15"><?=$arrLink['Description']?></textarea></td></tr>
      
			  <tr><td><?=$LBLanguage?>:</td><td>   
								   <select name="langCode" id="langCode" class="select">
								   <option value=""></option>
								   <?php 
								   $sqlAll=$christCMS->get_language_all();
								   $resultAll = $christDB->f_ExecuteSql($sqlAll);
								   $recordcountAll = $christDB->f_GetSelectedRows();
								   while ($arrLangRow = $christDB->f_GetRecord($resultAll)) { ?>
								    <option value="<?=$arrLangRow['langCode']?>" <?if($arrLangRow['langCode']==$arrLink['langCode']){echo 'selected';}?>><?=$arrLangRow['langCaption']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>
			               
              <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBEditLink?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>