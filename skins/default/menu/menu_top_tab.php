<?
 /*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
$sec=$_GET['sec'];

?>
<script type="text/javascript" src="<?=$root_path?>skins/default/menu/js/dropdowntabs.js">

/***********************************************
* Drop Down Tabs Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<!-- CSS for Drop Down Tabs Menu -->
<link rel="stylesheet" type="text/css" href="<?=$root_path?>skins/default/menu/css/menutabs.css" />
<?php if($sec=='on'){  ?>
   <div id="bluemenu" class="bluetabs" >
<?php }else{   ?>
  <div id="bluemenu" class="bluetabs" >
<?php }?>

<ul>
   <?php 
   //fetching all language main menu
   $i=1;
	$sqlMMenu=$christCMS->get_main_menu($langCode);
	$resultMMenu = $christDB->f_ExecuteSql($sqlMMenu);
	$recordcountMMenu = $christDB->f_GetSelectedRows();
   while ($arrMMenu = $christDB->f_GetRecord($resultMMenu)) {
	$MenuSection=$arrMMenu['msection']; 
	if($MenuSection=='Top'){
   ?>
  <li>
  <a href="<?=$root_path.$arrMMenu['url']?>?menuid=<?=$arrMMenu['menuid']?>" rel="dropmenu<?=$arrMMenu['menuid']?>_b"><?=${$arrMMenu['menu']}?></a>
  </li>
   <?
   }
   $i++;
  }
   ?>

</ul>
</div>

<!--drop down menu -->   
<?
$i=1;
$sqlMMenu2=$christCMS->get_main_menu($langCode);
$resultMMenu2 = $christDB->f_ExecuteSql($sqlMMenu2);
$recordcountMMenu2 = $christDB->f_GetSelectedRows();
while ($arrMMenu2 = $christDB->f_GetRecord($resultMMenu2)) {
  $MenuSection2=$arrMMenu2['msection']; 
  if($MenuSection2=='Top'){
     $menuid2 =$arrMMenu2['menuid'];
 ?>                                                
		<div id="dropmenu<?=$arrMMenu2['menuid']?>_b" class="dropmenudiv_b">
		<?
							
			$sqlSMenu=$christCMS->get_sub_menu($langCode,$menuid2);
			$resultSMenu = $christDB->f_ExecuteSql($sqlSMenu);
			$recordcountSMenu = $christDB->f_GetSelectedRows();
			while ($arrSMenu = $christDB->f_GetRecord($resultSMenu)) { 
		?> 
		     <a href="<?=$root_path.$arrSMenu['url']?>?menuid=<?=$arrSMenu['menuid']?>&submenuid=<?=$arrSMenu['id']?>"><?=${$arrSMenu['submenu']}?></a>
		<?
		  }
		?>
		
		</div>
<?
}
$i++;
 }
?>



<script type="text/javascript">
//SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
tabdropdown.init("bluemenu")
</script>

