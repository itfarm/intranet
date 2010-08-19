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
	$szTitle = 'Edit '.$_GET['szSubSection'].' '.$_GET['szSubSubSection'].' Category';
	$szSection = $_GET['szSection'];
	$szSubSection = $_GET['szSubSection'];
	$szSubSubSection = $_GET['szSubSubSection'];

	include($szHeaderPath);
	
	// initiales the ID variable from the URL
	$intCategoryID = $_GET['intCategoryID'];
	
	# does this category need to be updated?
	if (isset($_POST['action']) && ($_POST['action'] == "update")){
		
		
		gnc_debug($_POST,"POST variables");
		
		// build array from posted data
		$arrCategory = array();
		$arrCategory = $_POST;
		
		gnc_debug($arrCategory,"Item to be updated by POST");
		
		// update the item in the database, and update our item array
		$arrCategory = gnc_add_update_category($arrCategory,$arrCategory['intTypeID']);
		
		gnc_debug($arrCategory,"Updated item");
		
		// update category ID variable
		$intCategoryID = $arrCategory['intCategoryID'];
		
	}
		
	if($intCategoryID == 0){
		// create completely new Category
		
		// build blank array
		$arrCategory = array();
		// update the intCategoryID
		$arrCategory['intCategoryID']=0;
		$arrCategory['intTypeID']=$_GET['intTypeID'];
	}else{
		// amend an existing item.
		
		// get the item out of the database
		$arrCategory = gnc_get_category($intCategoryID,$_GET['intTypeID']);
	}

?>

To update this category, fill in the boxes below with the desired content and press the update button.<br>
<br>
		
<table cellspacing="1" cellpadding="5" border="0" width=100% class="adminTable">
<form action="#" method="post" name="gnc_update" id="gnc_update">
<input type="hidden" name="intCategoryID" value="<?=$arrCategory['intCategoryID']?>">
<input type="hidden" name="intTypeID" value="<?=$arrCategory['intTypeID']?>">
<tr>
    <td class="adminHeader" align=right>Field</td>
    <td class="adminHeader">Value</td>
</tr>
<tr class="adminRow1">
	<td class="adminContent" align=right valign=top>Category</td>
	<td class="adminContent"><input type="text" class="vform" size="30" name="szCategory" value="<?=$arrCategory['szCategory']?>">
<tr>
	<td>&nbsp;</td>
	<td><input  class="button" type="submit" name="action" value="update"></td></tr>
</form>
</table>
<br>
<table cellspacing="2" cellpadding="2" border="0">
<tr>
    <td><a href="index.php?intTypeID=<?=$arrCategory['intTypeID']?>&intMemGroupID=<?=$_GET['intMemGroupID']?>&szSection=<?=$szSection?>&szSubSection=<?=$szSubSection?>&szSubSubSection=<?=$szSubSubSection?>"><img src="../images/back.gif" width="15" height="15" alt="" border="0"></a></td>
    <td><b><a href="index.php?intTypeID=<?=$arrCategory['intTypeID']?>&intMemGroupID=<?=$_GET['intMemGroupID']?>&szSection=<?=$szSection?>&szSubSection=<?=$szSubSection?>&szSubSubSection=<?=$szSubSubSection?>">Back to list of Categories</a></b></td>
</tr>
</table>

<?php 
	# include the footer
	include($szFooterPath);
?>
