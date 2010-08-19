<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$skinFolder='default';
$page="guiding";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBGuiding;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBAboutUs;
$crumbs[1]['url'] = $root_path.'modules/pages/aboutus/index.php?menuid='.$menuid;
$crumbs[2]['name'] = $LBGuiding;
$crumbs[2]['url'] = $root_path.'modules/pages/aboutus/guiding.php?menuid='.$menuid.'&submenuid='.$submenuid;
?>


<div id="content">
	<?=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
				   
	?> 
</div>
<div id="content">


<?  
        if($submenuid==""){
            $submenuid=$menuid;  
        }
        $sqlgetp=$christCMS->get_page_display($submenuid,"en");
	$resultp = $christDB->f_ExecuteSql($sqlgetp);
	$recordcount = $christDB->f_GetSelectedRows();
	$arrPage = $christDB->f_GetRecord($resultp);
	if (!empty($arrPage['pageContent']))
		echo $arrPage['pageContent'];
	else
		echo  $LBcontNotFound;
?>
</div>


 
<?php
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
