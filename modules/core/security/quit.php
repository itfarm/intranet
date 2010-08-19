<?
session_start();
require_once('root.php');
$_SESSION['userName']='';   
$_SESSION['userLogin']=False;
if(($userName=='')&&($userLogin==False)){
   ?>
     <script language="JavaScript">
	        var pageURL='<?=$root_path?>modules/core/security/access.php';
			window.location.href = pageURL;
      </script>
   <?
}
?>