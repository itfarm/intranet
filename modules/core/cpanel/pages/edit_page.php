<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="edit_page";
$adminMain="Pages";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBPageAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBPageAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/pages/index.php?menuid='.$menuid;

    $pageID=$_GET['pageID'];
	$sqlgetp=$christCMS->get_page_single($pageID,$langCode);
	$resultp = $christDB->f_ExecuteSql($sqlgetp);
	$recordcount = $christDB->f_GetSelectedRows();
	$arrPage = $christDB->f_GetRecord($resultp);
	
    if (isset($_POST['submitBtn'])) {
	     $pageID     = $_POST['pageID'] ;
         $pageTitle     = $_POST['pageTitle'];
         $pageContent  = $_POST['pageContent'] ;
         $langCode = $_POST['langCode'];
         $dtCreated    = $_POST['dtCreated'] ;
         $pageStatus = $_POST['pageStatus'] ;
		 //editing page entries
		 $sql=$christCMS->update_page_single($pageID,$pageTitle,$pageContent,$langCode,$dtCreated,$pageStatus);
		 $christDB->f_ExecuteSql($sql);
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
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?menuid=<?=$menuid?>" method="post" name="page" id="page">
		  <input type="Hidden" name="menuid" id="menuid" value="<?=$menuid?>" >
		  <input type="Hidden" name="pageID" id="pageID" value="<?=$arrPage['pageID']?>" >
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
              <tr><td><?=$LBcontTitle?>:</td><td><input name="pageTitle" id="pageTitle" type="text" size="30" maxlength="50" value="<?=$arrPage['pageTitle']?>" /></td></tr>
              <tr><td valign="top"><?=$LBcontent?>:</td><td><textarea name="pageContent" id="pageContent" cols="50" rows="15"><?=$arrPage['pageContent']?></textarea></td></tr>
              <tr><td><?=$LBLanguage?>:</td><td>   
								   <select name="langCode" id="langCode" class="select">
								   <option value=""></option>
								   <?php 
								   $sqlAll=$christCMS->get_language_all();
								   $resultAll = $christDB->f_ExecuteSql($sqlAll);
								   $recordcountAll = $christDB->f_GetSelectedRows();
								   while ($arrLangRow = $christDB->f_GetRecord($resultAll)) { ?>
								    <option value="<?=$arrLangRow['langCode']?>" <?if($arrLangRow['langCode']==$arrPage['langCode']){echo 'selected';}?>><?=$arrLangRow['langCaption']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>
			  <tr><td><?=$LBcontStatus?></td><td>
						                       <select name="pageStatus" id="pageStatus" class="select">
											   <option value="visible"<?if($arrPage['langCode']=='visible'){echo 'selected';}?>><?=$LBvisible?></option>
											   <option value="Invisible"<?if($arrPage['langCode']=='Invisible'){echo 'selected';}?>><?=$LBinvisible?></option>
											   </select> 
			                                </td>
			  </tr>
              <tr><td><?=$LBcontDate?>:</td><td><input name="dtCreated" id="dtCreated" type="text" size="30" />
                       <!-- ggPosX and ggPosY not set, so popup will autolocate to the right of the graphic -->
	                   <a href="javascript:show_calendar('page.dtCreated');" onMouseOver="window.status='Date Picker'; overlib('<?=$LBdtText?>'); return true;" onMouseOut="window.status=''; nd(); return true;">
					   <img src="<?=$root_path?>images/icons/pickdt.png" width=16 height=16 border=0></a>

			  </td></tr>
              
              <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBeditPage?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>