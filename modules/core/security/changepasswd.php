<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="changepasswd";
$adminMain="User";
//require_once($root_path.'modules/core/admin/skin/head.php');
require_once($root_path.'skins/default/head.php');
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBUserAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBUserAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/security/index.php?menuid='.$menuid;
$error = '0';

if (isset($_POST['submitBtn'])){
	// Get user input
	$userID = $_POST['userID'];
	$userName = $_POST['username'];
	$password = $_POST['password'];
    
	$sql=$christCMS->chane_user_passwd($userID,$userName,$password);
	$result = $christDB->f_ExecuteSql($sql);
	$arrErrorCheck=$christDB->f_GetSqlError();
	 if(!empty($arrErrorCheck['message'])){
	   echo $arrErrorCheck['message'].$LBAddError.$arrError['code'];
	 }else{
	   $error=$LBChangeSucces;
	  }
	 //$arrErrorCheck['message'];
	//if ($recordcount > 0) {
	  // $_SESSION['userName']=$userName;
	  // $_SESSION['userLogin']=True;
	   //exit;
	?>
     
	<?
	}
//}

 
?>
<link href="<?=$root_path.'skins/'.$skinFolder.$cfgStyleLoginFilePath?>" rel="stylesheet" type="text/css" />

<div class="sectionLabel"><?=$LBPageTitle.'&nbsp;:&nbsp;'.$LBPassChange?></div>
<div align="center">
    <div id="mainLog" >
<?php if ($error != '') {?>
      
      <div align="center">
	  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
	  <input type="Hidden" name="userID" id="userID"  value="<?=$_SESSION['userID']?>">
	  <input type="Hidden" name="username" id="username"  value="<?=$_SESSION['userName']?>">
	  <table width="70%" border="0" >
          <tr><td>User ID:</td><td> <input class="vform" name="userID" type="text" disabled value="<?=$_SESSION['userID']?>"/></td></tr>
          <tr><td>Username:</td><td> <input class="vform" name="username" type="text" disabled value="<?=$_SESSION['userName']?>"/></td></tr>
          <tr><td>Password:</td><td> <input class="vform" name="password" type="password" /></td></tr>
          <tr><td>&nbsp;</td><td colspan="0" ><input  class="button" type="submit" name="submitBtn" value="<?=$LBEdit?>"  /></td></tr>
          
      </table></form></div>
      
     <!-- &nbsp;<a href="register.php">Register</a>-->
      
<?php 
}   
    if (isset($_POST['submitBtn'])){
?>
     

      <div align="center"><div id="result" >
        <table width="100%" ><tr><td><br/>
<?php
	if (!$error == '') {
	   echo $error;
	 }

?>
		<br/><br/><br/></td></tr></table>
	</div></div>
<?php            
    }
?>
	<div id="source"></div>
    </div></<br />
<br /><br />



<?
require_once($root_path.'skins/default/tail.php');
?>