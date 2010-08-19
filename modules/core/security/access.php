<?
session_start();
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
require_once($root_path.'cfg/config_db.php');
require_once($root_path.'cfg/christCMSconfig.php');
require_once($root_path.'core/class_core_christcms.php');
$christCMS=new christCMS;
$skinFolder='default';
$page="access";
$error = '0';

if (isset($_POST['submitBtn'])){
	// Get user input
	$userName = $_POST['username'];
	$password = $_POST['password'];
    
	$sql=$christCMS->get_user_check($userName,$password);
	$result = $christDB->f_ExecuteSql($sql);
	$recordcount = $christDB->f_GetSelectedRows();
	$arrUserInfo = $christDB->f_GetRecord($result);
	$arrErrorCheck=$christDB->f_GetSqlError();
	 if(!empty($arrErrorCheck['message'])){
	   echo $arrErrorCheck['message'].$LBAddError.$arrError['code'];
	 }
	 //$arrErrorCheck['message'];
	if ($recordcount > 0) {
	   $_SESSION['userName']=$userName;
	   $_SESSION['userID']=$arrUserInfo['userID'];
	   $_SESSION['userLogin']=True;
	   //exit;
	?>
      <script language="JavaScript">
	        var pageURL='<?=$root_path?>modules/core/admin/index.php';
			window.location.href = pageURL;
      </script>
	<?
	}else{
	   $error='Wrong username or password';
	}


}

 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title><?=$LBSiteTitle?></title>

	<link href="<?=$root_path.'skins/'.$skinFolder.$cfgStyleLoginFilePath?>" rel="stylesheet" type="text/css" />
</head>

<body>
<br /><br />

<div align="center">
    <div id="mainLog" >
<?php if ($error != '') {?>
      
      <div align="center"><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform"><table width="100%" border="0" >
        
          <tr><td>Username:</td><td> <input class="text" name="username" type="text"  /></td></tr>
          <tr><td>Password:</td><td> <input class="text" name="password" type="password" /></td></tr>
          <tr><td colspan="2" align="center"><input class="text" type="submit" name="submitBtn" value="Login" /></td></tr>
          
      </table></form></div>
      
     <!-- &nbsp;<a href="register.php">Register</a>-->
      
<?php 
}   
    if (isset($_POST['submitBtn'])){
?>
      <div class="caption"><?=$sitemap?> Secured Area:</div>

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



<??>
