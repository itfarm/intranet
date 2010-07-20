<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="edit_faq";
$adminMain="FAQ";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBFAQAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBFAQAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/faq/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
	     $faqID     = $_POST['faqID'] ;
         $question     = $_POST['question'] ;
         $answer  = $_POST['answer'] ;
         $catID = $_POST['categoryID'] ;
         $langCode = $_POST['langCode'];
         //adding entry
		 $sql=$christCMS->update_faq_single($faqID,$question,$answer,$catID,$langCode);
		 $christDB->f_ExecuteSql($sql);
		 $arrErrorUp=$christDB->f_GetSqlError();
		 if(!empty($arrErrorUp['message'])){
		   echo $arrErrorUp['message'].$LBUpdateError.$arrErrorUp['code'];
		 }
    }else{
		$faqID=$_GET['faqID'];
		$catID=$_GET['catID'];
		$sqlgetn=$christCMS->get_faq_single($faqID,$catID,$langCode);
		$resultn = $christDB->f_ExecuteSql($sqlgetn);
		$recordcount = $christDB->f_GetSelectedRows();
		$arrFAQ = $christDB->f_GetRecord($resultn);
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
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?menuid=<?=$menuid?>" method="post" name="news" id="news">
		  <input type="Hidden" name="menuid" id="menuid" value="<?=$menuid?>" >
		  <input type="Hidden" name="faqID" id="faqID" value="<?=$arrFAQ['faqID']?>" >
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
              <tr><td valign="top"><?=$LBQuestion?>:</td><td><textarea name="question" id="question" cols="50" rows="15"><?=$arrFAQ['question']?></textarea></td></tr>
			  <tr><td valign="top"><?=$LBAnswer?>:</td><td><textarea name="answer" id="answer" cols="50" rows="15"><?=$arrFAQ['answer']?></textarea></td></tr>
			  <tr><td><?=$LBCategory?>:</td><td>   
								   <select name="categoryID" id="categoryID" style="width:100px;"class="select">
								   <option value=""></option>
								   <?php 
								   $sqlcat=$christCMS->get_cat_items($langCode);
								   $resultcat = $christDB->f_ExecuteSql($sqlcat);
								   $recordcountcat = $christDB->f_GetSelectedRows();
								   while ($arrCatRow = $christDB->f_GetRecord($resultcat)) { ?>
								    <option value="<?=$arrCatRow['categoryID']?>"<?if($arrCatRow['categoryID']==$arrFAQ['catID']){echo 'selected';}?>><?=$arrCatRow['catTitle']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>
			  <tr><td><?=$LBLanguage?>:</td><td>   
								   <select name="langCode" id="langCode" class="select">
								   <option value=""></option>
								   <?php 
								   $sqlAll=$christCMS->get_language_all();
								   $resultAll = $christDB->f_ExecuteSql($sqlAll);
								   $recordcountAll = $christDB->f_GetSelectedRows();
								   while ($arrLangRow = $christDB->f_GetRecord($resultAll)) { ?>
								    <option value="<?=$arrLangRow['langCode']?>" <?if($arrLangRow['langCode']==$arrFAQ['langCode']){echo 'selected';}?>><?=$arrLangRow['langCaption']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>

              
              <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBeditFAQ?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>