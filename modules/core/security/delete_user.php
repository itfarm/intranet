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
$adminMain="User";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBUserAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBUserAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/security/index.php?menuid='.$menuid;
    
		//var_dump($_GET);
		
		 $userID=$_GET['userID'];
		 $menuid=$_GET['menuid'];
		 //deleting user
		 $sql=$christCMS->delete_user_single($userID);
		 $resultpg = $christDB->f_ExecuteSql($sql);
         $arrError=$christDB->f_GetSqlError();
		 if(!empty($arrError['message'])){
		   echo $arrError['message'].$LBDeleteError.$arrError['code'];
		 }
		 
		 //deleting user permision
		 $sqlPerm=$christCMS->delete_user_permision($userID);
		 $resultPerm = $christDB->f_ExecuteSql($sqlPerm);
         $arrErrorPerm=$christDB->f_GetSqlError();
		 if(!empty($arrErrorPerm['message'])){
		   echo $arrErrorPerm['message'].$LBDeleteError.$arrErrorPerm['code'];
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
	        var pageURL='<?=$root_path?>modules/core/security/index.php?menuid=<?=$menuid?>';
			window.location.href = pageURL;
</script>
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>