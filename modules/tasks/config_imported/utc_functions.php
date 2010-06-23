<?

// include parent system settings
include_once('../config.php');
include_once('settings.inc.php');
global $szSection,$szRootURL,$szRootPath,$szSiteTitle,$szWebmasterEmail,$szDBName,$szDBUsername,$szDBPassword;

$conn=mysql_connect($db_host,$szDBUsername,$szDBPassword);
mysql_select_db($szDBName);

function utc_debug($szDebugInfo,$szComment = ""){
	global $blutcDebug;
	
	// Is debug turned on?
	if ($blutcDebug){
	
		// outout div border
		echo "<div style=\"padding:5px;border:1px solid #FF0000\">";
		
		// output comment
		if ($szComment != ""){echo "<b>".$szComment."</b><br>";}
		
		// output debug info
		if (is_string($szDebugInfo)){
			echo $szDebugInfo;
		}elseif (is_array($szDebugInfo)){
			echo "<pre style=\"margin:0px;padding:0px;\">";
			print_r ($szDebugInfo);
			echo "</pre>";
		}elseif (gettype($szDebugInfo) == "resource"){
			echo "<pre style=\"margin:0px;padding:0px;\">";
			echo "rows:".mysql_num_rows($szDebugInfo);
			echo "</pre>";
		}else{
			echo "<pre style=\"margin:0px;padding:0px;\">";
			var_dump ($szDebugInfo);
			echo "</pre>";
		}
		echo "</div>";
	}
}

function utc_debug_enter($szFunctionName){
	global $blutcDebug;
	if ($blutcDebug){
		echo "<div style=\"background-color:#000000;color:#ffffff;\"><b>Entered:".$szFunctionName."</b></div>";
	}
}

function utc_get_user_logs($intRows,$szSortBy,$szWhereClause){
	utc_debug_enter("utc_get_user_logs($intRows,$szSortBy,$szWhereClause)");
	
	// Get user logs sorted by a particular column
	// if intRows is 0, include all rows
	// if szSortBy is '', don't sort
	$sql= "SELECT * FROM user_log ";
	if ($szWhereClause != ''){
		$sql = $sql."
			WHERE $szWhereClause  ";}
	if ($szSortBy != ''){
		$sql = $sql."
			ORDER BY $szSortBy   ";}
	if ($intRows != 0){
		$sql = $sql."
			LIMIT 0,$intRows   ";}
	utc_debug($sql,"Get User Logs");
	//send the query to the database
	$results = mysql_query($sql);
	utc_debug($results,"the results");
	utc_debug(mysql_error(),"Query Error?");

	//check the status of $results recordset
	if (mysql_num_rows($results)){
	
		// convert result set into an array - need to retain order.
		$arrUserLogs = array();
		while ($arrUserLog=mysql_fetch_assoc($results)){
			utc_debug($arrUserLog,"The Row we are now looking at:" );
			$arrUserLogs[$arrUserLog['intUserLogID']] = $arrUserLog;
		}
		utc_debug($arrUserLogs,"Returned:");
		return $arrUserLogs;
	} else {
		utc_debug(0,"Returned:");
		return 0;
	}
	
	//free the recordset
	mysql_free_result($results);
}

function utc_get_user_log($intUserLogID){
	utc_debug_enter("utc_get_user_log($intUserLogID)");
	
	// MUST supply a User Log ID
	if ($intUserLogID == null){
		exit ('The UserLogID was not supplied');
	}
	
	//get a specific user log by ID and returns an array
	// SQL statement for selecting information about the Category
	$sql="SELECT *
			FROM intUserLogID
				WHERE intUserLogID=$intUserLogID";
	utc_debug($sql,"Get the User Log from the DB");
	
	//send the query to the database
	$qUserLog=mysql_query($sql);
	utc_debug($qUserLog,"Query Result");
	utc_debug(mysql_error(),"Query Error?");
	
	//check the status of $results recordset
	if ($qUserLog){
		$arrUserLog = array();
		$arrUserLog = mysql_fetch_assoc($qUserLog);
		utc_debug($arrUserLog,"Returned:");
		return $arrUserLog;
	} else {
		utc_debug(0,"Returned:");
		return 0;
	}

}

function utc_remove_user_log($intUserLogID=0){
	utc_debug_enter("utc_remove_user_log($intUserLogID)");
	
	// remove the User Log from the database
	// SQL statement for removing the Branch
	if ($intUserLogID!=0){
		$sql="DELETE FROM user_log
				WHERE intUserLogID=$intUserLogID";
	} else {
		$sql="DELETE FROM user_log";
	}
	utc_debug($sql,"Delete User Log");
	
	//send the query to the database
	$results=mysql_query($sql);
	utc_debug(mysql_error(),"Query Error?");
	
}

function utc_add_update_user_log($arrUserLog){
	// returns the updated array of the UserLog inserted or updated
	utc_debug_enter("utc_add_update_user_log($arrUserLog)");
	utc_debug($arrUserLog,"array passed in");
	
	//get all field values from an array
	$intUserID = $_SESSION['userInfo']['id'];
	$szSessionID = $_COOKIE['PHPSESSID'];
	$szIPAddress = $_SERVER['REMOTE_ADDR'];
	if (is_array($arrUserLog)){
		$intDocumentID = $arrUserLog['intDocumentID'];
		$intItemID = $arrUserLog['intItemID'];
		$intTypeID = $arrUserLog['intTypeID'];
		$intVariationID = $arrUserLog['intVariationID'];
		$szAction = $arrUserLog['szAction'];
	} else {
		$intDocumentID = '';
		$intItemID = '';
		$intTypeID = '';
		$intVariationID = '';
		$szAction = '';
	}
	
	//assign default values for integer fields
	if ($intDocumentID==''){
		$intDocumentID=0;
	}
	if ($intItemID==''){
		$intItemID=0;
	}
	if ($intTypeID==''){
		$intTypeID=0;
	}
	if ($intVariationID==''){
		$intVariationID=0;
	}
	
	//add record
	$sql="INSERT INTO user_log (
			intUserID,szSessionID,szIPAddress,intDocumentID,intItemID,intTimeStamp,szAction,intTypeID,intVariationID)
				VALUES ($intUserID,'$szSessionID','$szIPAddress',$intDocumentID,$intItemID,NOW(),'$szAction',$intTypeID,$intVariationID)";
	utc_debug($sql,"to be executed");
	$results=mysql_query($sql);
	utc_debug(mysql_error(),"Query Error?");
	utc_debug($arrUserLog,"updated row");
	return $arrUserLog;
}

function utc_get_users($intRows,$szSortBy,$szWhereClause){
	utc_debug_enter("utc_get_users($intRows,$szSortBy,$szWhereClause)");
	
	// Get users sorted by a particular column
	// if intRows is 0, include all rows
	// if szSortBy is '', don't sort
	$sql= "SELECT * FROM authuser ";
	if ($szWhereClause != ''){
		$sql = $sql."
			WHERE $szWhereClause  ";}
	if ($szSortBy != ''){
		$sql = $sql."
			ORDER BY $szSortBy   ";}
	if ($intRows != 0){
		$sql = $sql."
			LIMIT 0,$intRows   ";}
	utc_debug($sql,"Get User Logs");
	
	//send the query to the database
	$results = mysql_query($sql);
	utc_debug($results,"the results");
	utc_debug(mysql_error(),"Query Error?");

	//check the status of $results recordset
	if (mysql_num_rows($results)){
		// convert result set into an array - need to retain order.
		$arrUsers = array();
		while ($arrUser=mysql_fetch_assoc($results)){
			utc_debug($arrUser,"The Row we are now looking at:" );
			$arrUsers[$arrUser['id']] = $arrUser;
		}
		utc_debug($arrUsers,"Returned:");
		return $arrUsers;
	} else {
		utc_debug(0,"Returned:");
		return 0;
	}
	
	//free the recordset
	mysql_free_result($results);
}

?>
