<?php 
	// include the Globals (admin version)
	include($_SERVER['DOCUMENT_ROOT'].'/admin/config.inc.php');
	
	// include Generic News Module
	include('../../config.inc.php');
	include('../../lib/gnc_cat_functions.php');
	
	# security
	//auth_checkgroup_and_exit('Category Admin');
	
	# get type from database
	$arrType = gnc_item_type($_GET['intTypeID']);
	
	# include the header
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet,$szHeaderPath,$szFooterPath;
	$szTitle = 'Delete '.$_GET['szSubSection'].' '.$_GET['szSubSubSection'].' Category';
	$szSection = $_GET['szSection'];
	$szSubSection = $_GET['szSubSection'];
	$szSubSubSection = $_GET['szSubSubSection'];
	$additionalStyleSheet = '../../general.css';
	include($szHeaderPath);
	
	gnc_remove_category($_GET['intCategoryID'],$_GET['intTypeID']);
?>
<table cellspacing="1" cellpadding="4" border="0" width=100%>
<form>
<tr><td class="smalltext">The Category has been removed.<br>
	<br>
	<input type="button" name="cmdContinue" value="Continue" class="vform" onClick="window.location.href='index.php?intTypeID=<?=$_GET['intTypeID']?>&rnum=<?=rand(1,9999999)?>&intMemGroupID=<?=$_GET['intMemGroupID']?>&szSection=<?=$szSection?>&szSubSection=<?=$szSubSection?>&szSubSubSection=<?=$szSubSubSection?>'">
	</td></tr>
</form>
</table>


<?php 
	# include the footer
	include($szFooterPath);
?>
