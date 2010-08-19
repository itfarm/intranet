<?
session_start();
$userName=$_SESSION['userName'];   
$userLogin=$_SESSION['userLogin'];
if(($userName=='')&&($userLogin==False)){
   ?>
     <script language="JavaScript">
	        var pageURL='<?=$root_path?>modules/core/security/access.php';
			window.location.href = pageURL;
      </script>
   <?
}
?>