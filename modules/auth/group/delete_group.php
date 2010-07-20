<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="delete_user";
$adminMain="User Group";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBGroupAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBGroupAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/security/group/index.php?menuid='.$menuid;
    
		//var_dump($_GET);
		
		 $groupID=$_GET['groupID'];
		 $menuid=$_GET['menuid'];
		 
		 echo$sql=$christCMS->delete_usergroup_single($groupID,$langCode);
		 $resultpg = $christDB->f_ExecuteSql($sql);
         $arrError=$christDB->f_GetSqlError();
		 if(!empty($arrError['message'])){
		   echo $arrError['message'].$LBDeleteError.$arrError['code'];
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

<script language="JavaScript">
	        var pageURL='<?=$root_path?>modules/core/security/group/index.php?menuid=<?=$menuid?>';
			window.location.href = pageURL;
</script>
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>