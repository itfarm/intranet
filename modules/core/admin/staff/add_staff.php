<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="add_staff";
$adminMain="Staff";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBStaffAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/cpanel/index.php';
$crumbs[1]['name'] = $LBStaffAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/staff/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
	
	    $fileName = $_FILES['userfile']['name']; 
        $tmpName  = $_FILES['userfile']['tmp_name']; 
        $fileSize = $_FILES['userfile']['size']; 
        $fileType = $_FILES['userfile']['type']; 
		
			  // get the file extension first
		$ext      = substr(strrchr($fileName, "."), 1); 
		$filePath = $root_path.$uploadDir . $fileName;
		
         $StaffName     = $_POST['StaffName'] ;
         $StaffTitle  = $_POST['StaffTitle'] ;
         $Description = $_POST['Description'];
		 $PhotoName  = $fileName;
         $PhotoType = $fileType;
         $PhotoSize = $fileSize;
		 $PhotoPath  = $filePath;
		// exit;
         
		 if($fileName!=''){
		 $result    = move_uploaded_file($tmpName, $filePath);
								if (!$result) {
									echo $LBFileError;
									exit;
								}
		}
		 $sqlpg=$christCMS->get_all_staff();
		 $resultpg = $christDB->f_ExecuteSql($sqlpg);
		 $recordcount = $christDB->f_GetSelectedRows();
		 //generating staffID
		 $pkeyPrefix="ST";
         $StaffID=$pkeyPrefix.($recordcount+1);
         //adding entry
		 $sql=$christCMS->add_staff($StaffID,$StaffName,$StaffTitle,$Description,$PhotoName,$PhotoType,$PhotoSize,$PhotoPath);
		 $christDB->f_ExecuteSql($sql);
		 $arrError=$christDB->f_GetSqlError();
		 if(!empty($arrError['message'])){
		   echo $arrError['message'].$LBAddError.$arrError['code'];
		 }
    }
  // echo $menuid;

?>



<div class="sectionLabel">
	<?=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
			//var_dump($arrLangRow = $christDB->f_GetRecord($resultAll));	   
	?> 
</div>
<div>&nbsp;</div>
<div><?=$LBPageTitle.'&nbsp;:&nbsp;'.$LBSection?></div>
<div>&nbsp;</div>
<div class="line"></div>
<div>&nbsp;</div>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?menuid=<?=$menuid?>" method="post" name="staff" id="staff" enctype="multipart/form-data">
		  <input type="Hidden" name="menuid" id="menuid" value="<?=$menuid?>" >
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
              <tr><td><?=$LBStaffName?>:</td><td><input name="StaffName" id="StaffName" type="text" size="30" maxlength="50" class="select" /></td></tr>
              <tr><td valign="top"><?=$LBStaffTitle?>:</td><td><textarea name="StaffTitle" id="StaffTitle" cols="50" rows="15"></textarea></td></tr>
			  <tr><td valign="top"><?=$LBDescription?>:</td><td><textarea name="Description" id="Description" cols="50" rows="15"></textarea></td></tr>
              <tr> <td><?=$LBPhoto?></td>
			<td colspan="0" >
			<input type="hidden" name="MAX_FILE_SIZE" value="20000000"><input name="userfile" type="file" id="userfile" > 
			</td>
			
			</tr>
              <tr><td colspan="2" valign="top" align="center"><input  type="submit" name="submitBtn" value="<?=$LBAddStaff?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>