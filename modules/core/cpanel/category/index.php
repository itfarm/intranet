<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="index";
$adminMain="Category";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBCatAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBCatAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/category/index.php?menuid='.$menuid;
?>
<script language="JavaScript">
	function confirm_delete(pageURL){
		if (confirm('<?=$LBdeleteText?>')){
			window.location.href = pageURL;
		}
	}
</script>
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
<div>  
	 <table   border="0" align="center" width="70%" cellpadding="2" cellspacing="1" >
	    <tr class="table_tr"><td width="2%"><?=$LBcontNo?></td><td><?=$LBcontTitle?></td><td colspan="3" align="center" width="10%"><?=$LBcontAction?></td></tr>
			   <?php 
			   //fetching all events
				$sql=$christCMS->get_cat_items($langCode);
				$result = $christDB->f_ExecuteSql($sql);
				$recordcount = $christDB->f_GetSelectedRows();
				$i=1;
			    while ($arrCat = $christDB->f_GetRecord($result)) { 
			   ?>
			   
			           <? if(($i%2)==0){?>
							   <tr class="sectionLabel">
					             <td valign="top" ><?=$i?></td>
								 <td valign="top" ><?=$arrCat['catTitle']?></td>
								 <td valign="top" ><a href="<?=$root_path?>modules/core/admin/category/edit_cat.php?menuid=<?=$menuid?>&catID=<?=$arrCat['categoryID']?>"><img  src="<?=$root_path?>images/icons/editpage.png" width="16" height="16" border="0"></a></td>
								 <td valign="top" >&nbsp;|&nbsp;</td>
								 <td valign="top" ><a href="Javascript:confirm_delete('<?=$root_path?>modules/core/admin/category/delete_cat.php?menuid=<?=$menuid?>&catID=<?=$arrCat['categoryID']?>');"><img  src="<?=$root_path?>images/icons/delete.png" width="16" height="16" border="0"></a></td>
							   </tr>
					   <?}else{?>
							   <tr >
					             <td valign="top" ><?=$i?></td>
								 <td valign="top" ><?=$arrCat['catTitle']?></td>
								 <td valign="top" ><a href="<?=$root_path?>modules/core/admin/category/edit_cat.php?menuid=<?=$menuid?>&catID=<?=$arrCat['categoryID']?>"><img  src="<?=$root_path?>images/icons/editpage.png" width="16" height="16" border="0"></a></td>
								 <td valign="top" >&nbsp;|&nbsp;</td>
								 <td valign="top" ><a href="Javascript:confirm_delete('<?=$root_path?>modules/core/admin/category/delete_cat.php?menuid=<?=$menuid?>&catID=<?=$arrCat['categoryID']?>');"><img  src="<?=$root_path?>images/icons/delete.png" width="16" height="16" border="0"></a></td>
							   </tr>
					   <?}?>
			   <?
			   $i++;
			   }
			   ?>
	     
	   </table>
   </div>


<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>