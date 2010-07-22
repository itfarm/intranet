<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="delete_events";
$adminMain="Events";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBTrainingAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $home_url;
$crumbs[1]['name'] = $LBTrainingAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/training/index.php?menuid='.$menuid;
    
		//var_dump($_GET);
		
		 $tID=$_GET['tID'];
		 $menuid=$_GET['menuid'];
		$sql=$christCMS->delete_training_single($tID,$langCode);
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
	        var pageURL='<?=$root_path?>modules/core/admin/training/index.php?menuid=<?=$menuid?>';
			window.location.href = pageURL;
</script>
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>
