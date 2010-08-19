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
$adminMain="User";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBUserAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBUserAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/security/index.php?menuid='.$menuid;
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
	    <tr><td>
		
		</td></tr>
	    <tr class="table_tr"><td width="2%"><?=$LBcontNo?></td><td><?=$LBUserFullname?></td><td align="center"><?=$LBuserStatus?></td><td colspan="3" align="center" width="10%"><?=$LBcontAction?></td></tr>
			   <?php 
			   //fetching all events
				$sql=$christCMS->get_users();
				$result = $christDB->f_ExecuteSql($sql);
				$recordcount = $christDB->f_GetSelectedRows();
				$i=1;
			    while ($arrUser = $christDB->f_GetRecord($result)) { 
			   ?>
			   
			           <? if(($i%2)==0){?>
							   <tr class="sectionLabel">
					             <td valign="top" ><?=$i?></td>
								 <td valign="top" ><?=$arrUser['FName'].'&nbsp;'.$arrUser['OName'].'&nbsp;'.$arrUser['LName']?></td>
								 <td valign="top" align="center" ><?=$arrUser['userStatus']?></td>
								 <td valign="top" ><a href="<?=$root_path?>modules/core/security/edit_user.php?menuid=<?=$menuid?>&userID=<?=$arrUser['userID']?>"><img  src="<?=$root_path?>images/icons/editpage.png" width="16" height="16" border="0"></a></td>
								 <td valign="top" >&nbsp;|&nbsp;</td>
								 <td valign="top" ><a href="Javascript:confirm_delete('<?=$root_path?>modules/core/security/delete_user.php?menuid=<?=$menuid?>&userID=<?=$arrUser['userID']?>');"><img  src="<?=$root_path?>images/icons/delete.png" width="16" height="16" border="0"></a></td>
							   </tr>
					   <?}else{?>
							   <tr >
					              <td valign="top" ><?=$i?></td>
								 <td valign="top" ><?=$arrUser['FName'].'&nbsp;'.$arrUser['OName'].'&nbsp;'.$arrUser['LName']?></td>
								 <td valign="top" align="center" ><?=$arrUser['userStatus']?></td>
								 <td valign="top" ><a href="<?=$root_path?>modules/core/security/edit_user.php?menuid=<?=$menuid?>&userID=<?=$arrUser['userID']?>"><img  src="<?=$root_path?>images/icons/editpage.png" width="16" height="16" border="0"></a></td>
								 <td valign="top" >&nbsp;|&nbsp;</td>
								 <td valign="top" ><a href="Javascript:confirm_delete('<?=$root_path?>modules/core/security/delete_user.php?menuid=<?=$menuid?>&userID=<?=$arrUser['userID']?>');"><img  src="<?=$root_path?>images/icons/delete.png" width="16" height="16" border="0"></a></td>
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