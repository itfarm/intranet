<?
 /*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
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

<div id="bluemenu2" class="bluetabs">
<ul>
   <?php 
   //fetching all language main menu
   $i=1;
	$sqlMMenu2=$christCMS->get_main_menu($langCode);
	$resultMMenu2 = $christDB->f_ExecuteSql($sqlMMenu2);
	$recordcountMMenu2 = $christDB->f_GetSelectedRows();
   while ($arrMMenu2 = $christDB->f_GetRecord($resultMMenu2)) {
	$MenuSection2=$arrMMenu2['msection']; 
	if($MenuSection2=='Bottom'){
   ?>
  <li>
  <a href="<?=$root_path.$arrMMenu2['url']?>?menuid=<?=$arrMMenu2['menuid']?>" rel="dropmenu2<?=$arrMMenu2['menuid']?>_b"><?=${$arrMMenu2['menu']}?></a>|
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
$sqlMMenu22=$christCMS->get_main_menu($langCode);
$resultMMenu22 = $christDB->f_ExecuteSql($sqlMMenu22);
$recordcountMMenu22 = $christDB->f_GetSelectedRows();
while ($arrMMenu22 = $christDB->f_GetRecord($resultMMenu22)) {
  $MenuSection22=$arrMMenu22['msection']; 
  if($MenuSection22=='Bottom'){
     $menuid22 =$arrMMenu22['menuid'];
 ?>                                                
		<div id="dropmenu2<?=$arrMMenu22['menuid']?>_b" class="dropmenudiv_b">
		<?
							
			$sqlSMenu2=$christCMS->get_sub_menu($langCode,$menuid22);
			$resultSMenu2 = $christDB->f_ExecuteSql($sqlSMenu2);
			$recordcountSMenu2 = $christDB->f_GetSelectedRows();
			while ($arrSMenu2 = $christDB->f_GetRecord($resultSMenu2)) { 
		?> 
		     <a href="<?=$root_path.$arrSMenu2['url']?>?menuid=<?=$arrSMenu2['menuid']?>&submenuid=<?=$arrSMenu2['id']?>"><?=${$arrSMenu2['submenu']}?></a>
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
tabdropdown.init("bluemenu2")
</script>

