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
$adminMain="Pages";
$current_module = "Projects";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBProjectAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $home_url;
$crumbs[1]['name'] = $LBProjectAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/projects/index.php?menuid='.$menuid;
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
<div>&nbsp;</div>
<div>  
	 <table   border="0" align="center" width="100%" cellpadding="2" cellspacing="1" >
	    <tr class="table_tr"><td width="2%"><?=$LBcontNo?></td><td><?=$LBcontTitle?></td><td colspan="3" align="center" width="10%"><?=$LBcontAction?></td></tr>
			   <?php 
			   //fetching all project
				$sql=$christCMS->get_project_items($projectID,$categoryID,$langCode,$archive,$status,$limitNews);
				$result = $christDB->f_ExecuteSql($sql);
				$recordcount = $christDB->f_GetSelectedRows();
				$i=1;
			    while ($arrNews = $christDB->f_GetRecord($result)) { 
			   ?>
			   
			           <? if(($i%2)==0){?>
							   <tr class="sectionLabel">
					             <td valign="top" ><?=$i?></td>
								 <td valign="top" ><?=$arrNews['projectTitle']?></td>
								 <td valign="top" ><a href="<?=$root_path?>modules/core/admin/projects/edit_project.php?menuid=<?=$menuid?>&projectID=<?=$arrNews['id']?>"><img  src="<?=$root_path?>images/icons/editpage.png" width="16" height="16" border="0"></a></td>
								 <td valign="top" >&nbsp;|&nbsp;</td>
								 <td valign="top" ><a href="Javascript:confirm_delete('<?=$root_path?>modules/core/admin/projects/delete_project.php?menuid=<?=$menuid?>&projectID=<?=$arrNews['id']?>');"><img  src="<?=$root_path?>images/icons/delete.png" width="16" height="16" border="0"></a></td>
							   </tr>
					   <?}else{?>
							   <tr >
					             <td valign="top" ><?=$i?></td>
								 <td valign="top" ><?=$arrNews['projectTitle']?></td>
								 <td valign="top" ><a href="<?=$root_path?>modules/core/admin/projects/edit_project.php?menuid=<?=$menuid?>&projectID=<?=$arrNews['id']?>"><img  src="<?=$root_path?>images/icons/editpage.png" width="16" height="16" border="0"></a></td>
								 <td valign="top" >&nbsp;|&nbsp;</td>
								 <td valign="top" ><a href="Javascript:confirm_delete('<?=$root_path?>modules/core/admin/projects/delete_project.php?menuid=<?=$menuid?>&projectID=<?=$arrNews['id']?>');"><img  src="<?=$root_path?>images/icons/delete.png" width="16" height="16" border="0"></a></td>
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
