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
$adminMain="Home";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';

?>



<div class="sectionLabel" >
  <?=$LBPageTitle.'&nbsp;:&nbsp;'.$LBSection?>
 
</div>
<div>&nbsp;</div>
<div class="line"></div>
<div align="center">  
	 <table   border="0" align="center" width="60%" cellpadding="2" cellspacing="2" >
	    
			   <?php 
			   //fetching all language main menu
				$sqlMMenu=$christCMS->get_admin_main_menu($langCode);
				$resultMMenu = $christDB->f_ExecuteSql($sqlMMenu);
				$recordcountMMenu = $christDB->f_GetSelectedRows();
				$i=0;
			    while ($arrMMenu = $christDB->f_GetRecord($resultMMenu)) { 
			   ?>
			   
			           <? if(($i%3)==0){echo'<tr>';}?>
			           <td class="sectionLabel" width="20%" height="20%" align="center" valign="top" >
					      <a href="<?=$root_path.$arrMMenu['url']?>?menuid=<?=$arrMMenu['menuid']?>"><?//=$arrMMenu['menu']?>
						  <img  src="<?=$root_path.'images/icons/'.$arrMMenu['image']?>" width="35" height="35" border="0"></a>
						  <br>
						  <?=$arrMMenu['description']?>
					   </td>
					  
					   
					   
			   <?
			   $i++;
			   }
			   ?>
	     </tr>
	   </table>
   </div>
<div class="line"></div>

<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>