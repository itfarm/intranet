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
$page="index";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBFAQ;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBFAQ;
$crumbs[1]['url'] = $root_path.'modules/faq/index.php?menuid='.$menuid;
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
			                $sql=$christCMS->get_faq_items($catID,"en",$limitFAQ);
							$result = $christDB->f_ExecuteSql($sql);
							$arrError=$christDB->f_GetSqlError();
							 if(!empty($arrError['message'])){
							   echo $arrError['message'].$LBGetError.$arrError['code'];
							 }
							$recordcount = $christDB->f_GetSelectedRows();
						    
							if ($recordcount!=0)
							    {  
								   echo'<table width="100%" border="0" cellpadding="2" cellspacing="2">';
								   $i=1;
								   while ($arrFAQ = $christDB->f_GetRecord($result)) { 
								            
											echo'<tr><td valign="top" width="2%" >'.$i.'</td>
											         <td valign="top" width="50%" >
											         <a href="'.$root_path.'modules/faq/view_faq.php?menuid='.$menuid.'?>&faqID='.$arrFAQ['faqID'].'&categoryID='.$arrFAQ['catID'].'">'.$arrFAQ['question'].'</a>
													 </td>
												';
												
												$i++;
										 }
								   echo'</tr></table>';
								}
							else{
								echo  $LBcontNotFound;
								}
?>
</div>
<?php					
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
