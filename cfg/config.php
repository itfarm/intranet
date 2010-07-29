<?php
	$root_dir="/intranet/";
	$http_dir="/var/www";
	$tasksModule = $root_dir . "modules/tasks/";
	$eventsModule = $root_dir . "modules/events/";

	//	Database Server Configurations
	$db_host="localhost";
	$db_user="root";
	$db_password="root";
	$db_name="taskdata";
	
	// Database related functions
	function db_connection($db_host,$db_user,$db_password) {
		$dbcnx = mysql_connect($db_host,$db_user,$db_password);
		if (!$dbcnx)
		{
			$message = "<p>Database Server not found ".mysql_error()."</p>";
			exit($message);
		}
		else {
			return $dbcnx;
		}
	};
	function db_select($db_name,$dbcnx) {
		$db_select = mysql_select_db($db_name,$dbcnx);
		if( !$db_select ) {
			$message="<p>Database not found ".mysql_error()."</p>";
			exit($message);
		}
		else {
			return $db_select;
		}
	}

	
	//	Page URLs
	$verificationPage= $root_dir . "cfg/verification.php";
	$loginPage= $root_dir . "index.php";
	$logoutPage= $root_dir . "cfg/logout.php";
	$dashboardPage= $tasksModule . "main.php?page=dashboard";
	$eventsPage = $root_dir . "modules/core/admin/events/index.php?menuid=MM3";
	$newsPage = $root_dir . "modules/core/admin/news/index.php?menuid=MM12";
	$galleryPage = $root_dir . "modules/core/admin/gallery/admin/index.php?menuid=MM8";
	$projectPage = $root_dir . "modules/core/admin/projects/index.php?menuid=MM19";
	$trainingPage = $root_dir . "modules/core/admin/training/index.php?menuid=MM11";
	$faqPage = $root_dir ."modules/core/admin/faq/index.php?menuid=MM15";
	$chatPage = $root_dir . "modules/chat/";
	$pollPage = $root_dir . "modules/polls/index.php";
	$votePage = $root_dir . "modules/polls/vote.php";
	$resultPage = $root_dir . "modules/polls/result.php";
	$createPollPage = $root_dir . "modules/polls/admin/survey_edit.php";
	
	//	Submenu URLs and their names
	$main_url[0][0] = "Tasks";	$main_url[0][1] = $dashboardPage;
	$main_url[1][0] = "Events"; 	$main_url[1][1] = $eventsPage;
	$main_url[2][0] = "News";	$main_url[2][1] = $newsPage;
	$main_url[3][0] = "Gallery";		$main_url[3][1] = $galleryPage;
	$main_url[4][0] = "Projects";		$main_url[4][1] = $projectPage;
	$main_url[5][0] = "Training";		$main_url[5][1] = $trainingPage;
	//$main_url[6][0] = "Remainders";		$main_url[6][1] = $root_dir . "";
	$main_url[6][0] = "Chat";			$main_url[6][1] = $chatPage;
	$main_url[7][0] = "Polls";			$main_url[7][1] = $pollPage;
	$main_url[8][0] = "FAQ";			$main_url[8][1] = $faqPage;

	function main_menu($current_module) {
		global 	$tasksModule, $dashboardPage, $eventsModule, $eventsPage;
		global  $newsPage, $galleryPage, $projectPage, $trainingPage, $faqPage, $chatPage;
		global $main_url;
		
		echo '	<ul id="main">';
					// Generate submenu links
					for($incr = 0; $incr <=8; $incr++ ) {
						// Mark the current class
						if( $current_module == $main_url[$incr][0] ) {
							$class = "current_page";
						}
						else {
							$class = "";
						}
						// Display the submenu links
						echo '<li class="' .$class . '"><a href="' . $main_url[$incr][1] . '">' . $main_url[$incr][0] . '</a></li>';
					};
		echo '		</ul>';
	};
	
global $blnPrivateArea;

$szDBName = $db_name;
$szDBUsername = $db_user;
$szDBPassword = $db_password;
global $szDBName, $szDBUsername, $szDBPassword;

function auth_debug($szDebugInfo,$szComment = ""){
	global $blAuthDebug;
	
	// Is debug turned on?
	if ($blAuthDebug){
	
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

function auth_debug_enter($szFunctionName){
	global $blAuthDebug;
	if ($blAuthDebug){
		echo "<div style=\"background-color:#000000;color:#ffffff;\"><b>Entered:".$szFunctionName."</b></div>";
	}
}
	
class pmo_auth{
	

	var $HOST = "";	
	var $USERNAME = "";	
	var $PASSWORD = "";	
	var $DBNAME = "";	
	
	// Constructor
	function pmo_auth(){
		// assign variables from global include
		$this->HOST = "localhost";
		$this->USERNAME = $GLOBALS['szDBUsername'];	
		$this->PASSWORD = $GLOBALS['szDBPassword'];	
		$this->DBNAME = $GLOBALS['szDBName'];	
	}

	// AUTHENTICATE
	function authenticate($username, $password) {
		auth_debug_enter("authenticate($username, $password)");
	
		$query = "SELECT * FROM authuser WHERE uname='$username' AND passwd=MD5('$password') AND status <> 'inactive'";
		
		$UpdateRecords = "UPDATE authuser SET lastlogin = NOW(), logincount = IFNULL(logincount + 1,1) WHERE uname='$username'";
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		
		auth_debug($query,"Query:");
		$result = mysql_query($query); 
		auth_debug($result,"Result:");
		auth_debug(mysql_error(),"Query Error?");
		
		$numrows = mysql_num_rows($result);
		$row = mysql_fetch_array($result);
		
		// CHECK IF THERE ARE RESULTS
		// Logic: If the number of rows of the resulting recordset is 0, that means that no
		// match was found. Meaning, wrong username-password combination.
		if ($numrows == 0) {
			//Log the login attempt
			$this->log_bad_login($username);
			return 0;
		}
        /*
        elseif ($row["level"]==1) {  // ADMIN LOGIN
			$Update = mysql_query($UpdateRecords);
			return 1;
		}
        */
		else {
			auth_debug($UpdateRecords,"Query:");
			$Update = mysql_query($UpdateRecords);
			auth_debug($Update,"Result:");
			auth_debug(mysql_error(),"Query Error?");
			
			// query the list of groups for this user
			$userID = $row['id'];
			
			$q = "	SELECT authteam.*,authuserteam_mapping.intPrivileges
					FROM authteam,authuserteam_mapping,authuser
					WHERE authuser.id = $userID
					AND authuser.id = authuserteam_mapping.userid
					AND authteam.id = authuserteam_mapping.teamid
			";
			auth_debug($q,"Query:");
			$mygroups = mysql_query($q);
			auth_debug($mygroups,"Result:");
			auth_debug(mysql_error(),"Query Error?");
		
			// convert query to array
			$arrgroups = "";
			for ($i=0;$i<mysql_num_rows($mygroups);$i++){
				$grouprow = mysql_fetch_array($mygroups,MYSQL_ASSOC);
				$arrgroups[$grouprow['teamname']] = $grouprow['intPrivileges'];
			}
			
			// update session information
			session_start();
			$_SESSION['userInfo'] = $row; 
			$_SESSION['groupInfo'] = $arrgroups;
			
			
			return $row;
		}
	} // End: function authenticate

	//Function to log all bad logins
	function log_bad_login($username){
		auth_debug_enter("log_bad_login($username)");
		
		$szIPAddress = $_SERVER['REMOTE_ADDR'];
		$szAgent = addslashes($_SERVER['HTTP_USER_AGENT']);
		
		$query = "INSERT INTO authbad_login (szUserName,szIPAddress,szAgent,intTime) VALUES ('$username','$szIPAddress','$szAgent',NOW())";
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		
		auth_debug($query,"Query:");
		$result = mysql_query($query); 
		auth_debug($result,"Result:");
		auth_debug(mysql_error(),"Query Error?");
		
		return 0;
	}

	// MODIFY USERS
	function modify_user($userID, $username, $password, $name, $surname, $email,$mobile,$location, $arrteams, $level, $status, $prefix, $department, $address, $city, $zip, $country) {
		auth_debug_enter("modify_user($userID, $username, $password, $name, $surname, $email,$mobile,$location,  $arrteams, $level, $status, $prefix, $department, $address, $city, $zip, $country)");

		if (trim($level)=="") {
			return "blank level";
		}
		elseif (($username=="sa" AND $status=="inactive")) {
			return "sa cannot be inactivated";
		}
		elseif (($username=="admin" AND $status=="inactive")) {
			return "admin cannot be inactivated";
		}
		else {
		
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			
			$SelectedDB = mysql_select_db($this->DBNAME);
			
			// If $password is blank, make no changes to the current password
	        if (trim($password == ''))
	        {
	            $q = "
					UPDATE authuser 
					SET uname='$username', 
						name='$name',
						surname='$surname',
						email='$email',
						mobile='$mobile',
						location='$location',
						level='$level', 
						status='$status',
						prefix='$prefix',
						department='$department',
						address='$address',
						city='$city',
						zip='$zip',
						country='$country'
						
					WHERE id = $userID";
	        }
	        else
	        {
	            $q = "
					UPDATE authuser 
					SET passwd=MD5('$password'), 
						uname='$username', 
						name='$name',
						surname='$surname',
						email='$email',
						mobile='$mobile',
						location='$location',
						level='$level', 
						status='$status',
						prefix='$prefix',
						department='$department',
						address='$address',
						city='$city',
						zip='$zip',
						country='$country'
					WHERE id = $userID";
	        }
			
			auth_debug($q,"Query:");
			$result = mysql_query($q);
			auth_debug($result,"Result:");
			auth_debug(mysql_error(),"Query Error?");
			
			// remove previous group associations
			$q = "DELETE FROM authuserteam_mapping WHERE userid = $userID";
			
			auth_debug($q,"Query:");
			$result = mysql_query($q);
			auth_debug($result,"Result:");
			auth_debug(mysql_error(),"Query Error?");
			
			
			// add new group associations
			foreach ($arrteams as $teamID=>$team){
				if ($team['intPrivileges']){
					$q = "INSERT INTO authuserteam_mapping(userid, teamid, intPrivileges)
					  	VALUES ($userID, $teamID, ${team['intPrivileges']})";
					
					auth_debug($q,"Query:");
					$result = mysql_query($q);
					auth_debug($result,"Result:");
					auth_debug(mysql_error(),"Query Error?");
				}
			}
			
			return 1;
		}
		
	} // End: function modify_user
	
	// DELETE USERS
	function delete_user($userID) {
		auth_debug_enter("delete_user($userID)");

		if ($username == "sa") {
			return "User sa cannot be deleted.";
		}
		elseif ($username == "admin") {
			return "User admin cannot be deleted.";
		}
		elseif ($username == "test") {
			return "User test cannot be deleted.";
		}

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$q = "DELETE FROM  authuser WHERE id = $userID";
		auth_debug($q,"Query:");
		$result = mysql_query($q);
		auth_debug($result,"Result:");
		auth_debug(mysql_error(),"Query Error?");
		
		// remove previous group associations
		$q = "DELETE FROM authuserteam_mapping WHERE userid = $userID";
		auth_debug($q,"Query:");
		$result = mysql_query($q);
		auth_debug($result,"Result:");
		auth_debug(mysql_error(),"Query Error?");
	
		return mysql_error();
		
	} // End: function delete_user
	
	// ADD USERS
	function add_user($userID, $username, $password, $name, $surname, $email,$mobile,$location, $arrteams, $level, $status, $prefix, $department, $address, $city, $zip, $country) {
		auth_debug_enter("add_user($userID, $username, $password, $name,$surname, $email,$mobile,$location,  $arrteams, $level, $status, $prefix, $department, $address, $city, $zip, $country)");
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		// Check if all fields are filled up
		if (trim($username) == "") { 
			return "blank username";
		}
		// password check added 09-19-2003
		elseif (trim($password) == "") {
			return "blank password";
		}
		elseif (trim($level) == "") {
			return "blank level";
		}
		
		// Check if user exists
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qUserExists = "SELECT * FROM authuser WHERE id = $userID OR uname = $username";
		auth_debug($qUserExists,"Query:");
		$user_exists = mysql_query($qUserExists);
		auth_debug($user_exists,"Result (User Exists):");
		auth_debug(mysql_error(),"Query Error?");

		if ($user_exists) {
			return "user exists";
		}
		else {
			// Add user to DB			
			// OLD CODE - DO NOT REMOVE
			// $result = mysql_db_query($this->DBNAME, $qInsertUser);
			
			// REVISED CODE
			$q = "INSERT INTO authuser(uname, passwd, name, surname, email,mobile,location, level, status, lastlogin, logincount, prefix, department, address, city, zip, country)
				  			   VALUES ('$username', MD5('$password'), '$name', '$surname', '$email','$mobile','$location', '$level', '$status', NOW(), 0, '$prefix', '$department', '$address', '$city', '$zip', '$country')";

			auth_debug($q,"Query:");
			$result = mysql_query($q);
			auth_debug($result,"Result:");
			auth_debug(mysql_error(),"Query Error?");
			
			$userID = mysql_insert_id();
			
			// add new group associations
			foreach ($arrteams as $teamID=>$team){
				if ($team['intPrivileges']){
					$q = "
						INSERT INTO authuserteam_mapping(userid, teamid, intPrivileges)
					  	VALUES ($userID, $teamID, ${team['intPrivileges']})";

					auth_debug($q,"Query:");
					$result = mysql_query($q);
					auth_debug($result,"Result:");
					auth_debug(mysql_error(),"Query Error?");
				}
			}

			return mysql_insert_id();
		}
	} // End: function add_user


	// *****************************************************************************************
	// ************************************** G R O U P S ************************************** 
	// *****************************************************************************************

	// ADD TEAM
	function add_team($teamname, $teamlead, $status="active") {
		auth_debug_enter('add_team($teamname, $teamlead, $status="active")');
		
		$qGroupExists = "SELECT * FROM authteam WHERE teamname='$teamname'";
		$qInsertGroup = "INSERT INTO authteam(teamname, teamlead, status) 
				  			   VALUES ('$teamname', '$teamlead', '$status')";
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		// Check if all fields are filled up
		if (trim($teamname) == "") { 
			return "blank team name";
		}
		
		// Check if group exists
		// OLD CODE - DO NOT REMOVE
		// $group_exists = mysql_db_query($this->DBNAME, $qGroupExists);
		
		// REVISED CODE
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		auth_debug($qGroupExists,"Query:");
		$group_exists = mysql_query($qGroupExists);
		auth_debug($group_exists,"Result:");
		auth_debug(mysql_error(),"Query Error?");

		if (mysql_num_rows($group_exists) > 0) {
			return "group exists";
		}
		else {
			// Add user to DB
			// OLD CODE - DO NOT REMOVE
			// $result = mysql_db_query($this->DBNAME, $qInsertGroup);

			// REVISED CODE
			$SelectedDB = mysql_select_db($this->DBNAME);
			
			auth_debug($qInsertGroup,"Query:");
			$result = mysql_query($qInsertGroup);
			auth_debug($result,"Result:");
			auth_debug(mysql_error(),"Query Error?");

			return mysql_affected_rows();
		}
	} // End: function add_group


	// MODIFY TEAM
	function modify_team($teamid, $teamname, $teamlead, $status, $arrGroupPrivileges) {
		auth_debug_enter("modify_team($teamid, $teamname, $teamlead, $status, $arrGroupPrivileges)");
		
		$qUpdate = "UPDATE authteam 
					SET teamname='$teamname', 
						teamlead='$teamlead', 
						status='$status'
					WHERE id=$teamid";
		//$qUserStatus = "UPDATE authuser SET status='$status' WHERE team='$teamname'";

		if ($teamname == "Admin" AND $status=="inactive") {
			return "Admin team cannot be inactivated.";
		}
		elseif ($teamname == "Ungrouped" AND $status=="inactive") {
			return "Ungrouped team cannot be inactivated.";
		}
		else {		
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			
			// UPDATE STATUS IF STATUS OF TEAM IS INACTIVATED
			// OLD CODE - DO NOT REMOVE
			//$userresult = mysql_db_query($this->DBNAME, $qUserStatus);

			// REVISED CODE
			$SelectedDB = mysql_select_db($this->DBNAME);
			//$userresult = mysql_query($qUserStatus); 
	
			// OLD CODE - DO NOT REMOVE
			// $result = mysql_db_query($this->DBNAME, $qUpdate);
			
			// REVISED CODE
			auth_debug($qUpdate,"Query:");
			$result = mysql_query($qUpdate);
			auth_debug($result,"Result:");
			auth_debug(mysql_error(),"Query Error?");
			
			
			foreach ($arrGroupPrivileges AS $intUserID => $intPrivileges){
				
				$qUpdatePriv = "UPDATE authuserteam_mapping 
							SET intPrivileges=$intPrivileges
							WHERE teamID=$teamid
							AND userID=$intUserID";
							
				
				auth_debug($qUpdatePriv,"Query:");
				$result = mysql_query($qUpdatePriv);
				auth_debug($result,"Result:");
				auth_debug(mysql_error(),"Query Error?");
			}
			
			return 1;
		}
		
	} // End: function modify_team


	// DELETE TEAM
	function delete_team($teamid) {
		auth_debug_enter("delete_team($teamid)");
		$qDelete = "DELETE FROM authteam WHERE id=$teamid";
		$qUpdateMapping = "DELETE * FROM authuserteam_mapping WHERE teamid = $teamid;";
		
		
		if ($teamname == "Admin") {
			return "Admin team cannot be deleted.";
		}
		elseif ($teamname == "Ungrouped") {
			return "Ungrouped team cannot be deleted.";
		}
		elseif ($teamname == "Temporary") {
			return "Temporary team cannot be deleted.";
		}

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		// OLD CODE - DO NOTE REMOVE
		// $result = mysql_db_query($this->DBNAME, $qUpdateUser);

		// REVISED CODE
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		auth_debug($qUpdateMapping,"Query:");
		$result = mysql_query($qUpdateMapping);
		auth_debug($result,"Result:");
		auth_debug(mysql_error(),"Query Error?");

		// OLD CODE - DO NOT REMOVE
		// $result = mysql_db_query($this->DBNAME, $qDelete);
		
		// REVISED CODE
		auth_debug($qDelete,"Query:");
		$result = mysql_query($qDelete);
		auth_debug($result,"Result:");
		auth_debug(mysql_error(),"Query Error?");

		return mysql_error();
		
	} // End: function delete_team
	//to change password
	function changepwd($arrUserInfo){
		auth_debug_enter("changepwd($arrUserInfo)");
		
		$arrUser = $this->get_user($arrUserInfo['id']);

		if ($arrUser['passwd']!=md5($arrUserInfo['oldpasswd'])){
			$arrUserInfo['message']="The old password is wrong!";
			return $arrUserInfo;
		}
		$q = "UPDATE authuser SET passwd=md5('$arrUserInfo[newpasswd]') WHERE id='$arrUserInfo[id]'";
		$arrUserInfo['message']="Password changed!!";
		auth_debug($q,"Query:");
		$result = mysql_query($q);
		auth_debug($result,"Result:");
		auth_debug(mysql_error(),"Query Error?");
		return $arrUserInfo;
	}
	//get user
	function get_user($id){
		auth_debug_enter("get_user($id)");

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);

		$q = "SELECT * FROM authuser WHERE id=$id";
		auth_debug($q,"Query:");
		$result = mysql_query($q);
		auth_debug($result,"Result:");
		auth_debug(mysql_error(),"Query Error?");
		if (mysql_num_rows($result)!=0){
			return mysql_fetch_array($result);
		} else {
			return 0;
		}
	}

} // End: class auth


    function auth_display_message (){
		print "<p>ACCESS DENIED. You do not have permission for this.</p>";
	}
	
	/*
		1 = Browse only
		2 = Edit + Browse
		4 = Delete + Edit + Browse
		
	*/
	function auth_checkgroup ($groupName,$intPrivilege=1){
		// is the user a member of the group that has been passed in?
		if ((isset($_SESSION['groupInfo'][$groupName]) && $_SESSION['groupInfo'][$groupName] >= $intPrivilege)
			|| (isset($_SESSION['groupInfo']['Super Admin']) && $_SESSION['groupInfo']['Super Admin'] >= $intPrivilege)){
			return 1;
		}else{
			return 0;
		}
	}

	function auth_checkgroup_and_exit ($groupName,$intPrivilege=1){
		// is the user a member of the group that has been passed in?
		if ( !auth_checkgroup($groupName,$intPrivilege) ) {
		
			// if not display a message and exit.
			auth_display_message();
		}
	}

//	Audit trail functions

global $szSection,$szRootURL,$szRootPath,$szSiteTitle,$szWebmasterEmail,$szDBName,$szDBUsername,$szDBPassword;

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

function poll_contents($tag) {
	global $root_dir,$pollPage, $votePage, $resultPage, $createPollPage;
	@include_once ("config.inc.php");
	@include_once ("admin/admin.inc.php");
	
	$dbcnx = db_connection($server,$login,$passwd);
	$db_selected=db_select($database,$dbcnx);
	
	if($tag == "survey" || empty($tag)) {
		$query_str="SELECT * FROM  `nabopoll_surveys` ";
		$query = mysql_query($query_str);
		echo "<p class=\"bold important\">Choose a survey to poll</p>";
		echo "<table class=\"table\">
				<thead>
				  <tr class=\"important\">
					  <th>No.</th>
					  <th>Survey[Poll lists]</th>
				  </tr>
				 </thead>
				 <tbody>
			  ";
		for($incr=0;$incr< mysql_num_rows($query) ; $incr++) {
			$row = mysql_fetch_array($query);
			echo "<tr onClick=\"document.location.href='" . $votePage . "?surv=" .$row['id'] ."'\">
					<td>". $row['id'] ."</td>
					<td>". $row['title'] ."</td>
				</tr>";
		};
		echo "	</tbody>
				</table>";
	}
	elseif( $tag == "create" ) {
		@include_once("admin/survey_edit.php");
	}
	elseif( $tag == "results" ) {
		$query_str="SELECT * FROM  `nabopoll_surveys` ";
		$query = mysql_query($query_str);
		echo "<p class=\"bold important\">Choose a survey to view its results</p>";
		echo "<table class=\"table\">
				<thead>
				  <tr class=\"important\">
					  <th>No.</th>
					  <th>Survey[Poll lists]</th>
				  </tr>
				 </thead>
				 <tbody>
			  ";
		for($incr=0;$incr< mysql_num_rows($query) ; $incr++) {
			$row = mysql_fetch_array($query);
			echo "<tr onClick=\"document.location.href='" . $resultPage . "?surv=" .$row['id'] ."'\">
					<td>". $row['id'] ."</td>
					<td>". $row['title'] ."</td>
				</tr>";
		};
		echo "	</tbody>
				</table>";
	}
	elseif( $tag == "vote" ) {
		include("vote.php");
	}
	elseif($tag=="help" ) {
		echo '
      <p><b><u>HOW TO CREATE SURVEY</u></b></p>
      <p>With the right sidebar you can create a new survey, add questions and
		answers and of course edit approximately anything. Here is the meaning
		of the icons you\'ll see in the admin interface (I\'ll use the term &quot;
		item &quot; to generically designate a survey,
        a question or an answer - the current item is the item that is on the
        line where you clicked the icon):</p>
      <table border="0" width="100%">
        <tr>
          <td width="33%" valign="top" bgcolor="#666666">
            <div align="center"><b><font color="#FFFFFF">icon</font></b></div>
          </td>
          <td bgcolor="#666666">
            <div align="center"><b><font color="#FFFFFF">action</font></b></div>
          </td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/add.gif" width="16" height="16"></div>
          </td>
          <td>add an item in the database. before clicking edit the new item on
            the left of this icon</td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/alter.gif" width="16" height="16"></div>
          </td>
          <td>validate the changes you have made to the current item</td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/delete.gif" width="16" height="16"></div>
          </td>
          <td>delete an item. <b>no confirmation asked!!</b></td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/insert.gif" width="16" height="16"></div>
          </td>
          <td>insert an empty item before the current one</td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/up.gif" width="16" height="16"></div>
          </td>
          <td>move the current item up in the current list</td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/down.gif" width="16" height="16"></div>
          </td>
          <td>move the current item down in the current list</td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/inspect.gif" width="16" height="16"></div>
          </td>
          <td>go one level below: in survey view, this allows you to edit the
            questions of the current survey ; in question view this lets you edit
            the answers to the current question</td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/reset.gif" width="16" height="16"></div>
          </td>
          <td>this lets you reset the results of the current survey</td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/result.gif" width="16" height="16"></div>
          </td>
          <td>this lets you see the results of the current survey</td>
        </tr>
        <tr valign="top">
          <td width="33%" align="center" valign="middle">
            <div align="center"><img src="images/history.gif" width="16" height="16"></div>
          </td>
          <td>this lets you see the history of answers made to the current survey</td>
        </tr>
      </table>
      <p>You have several options for a survey:</p>
      <ul>
      <li><b>Single vote:</b> Allows or disallows a same person to vote multiple times to the survey. Check can be done using cookies or based on the IP address.<br>&nbsp;</li>
      <li><b>Log:</b> Enables the save of <b>all</b> the answers made to the survey. You\'ll be able to check exactly what each voter answered to each question.<br>&nbsp;</li>
      <li><b>Required:</b> If this is checked, then a voter must answer to all the questions of the survey.<br>&nbsp;</li>
      <li><b>Closed:</b> No more votes can be taken for that survey.<br>&nbsp;</li>
      </ul>
      <p>With the above information you should be able to create a survey questionaire.</p>
      ';
	};
};

function poll_sidebar($tag) {
	global $pollPage, $createPollPage;
	// Don't show page is create
	if( $tag != "create" ) {
		echo "
					<ul>
					<li>
						<h2>Polls &amp; Surveys</h2>
						<ul>
							<li><a href=". $pollPage .'?tag=survey' .">Surveys to Vote</a></li>
							<li><a href=". $createPollPage .">Create Poll List</a></li>
							<li><a href=". $pollPage .'?tag=results'.">View Results</a></li>
						</ul>
					</li>
					<li>
						<h2>Help</h2>
						<ul>
							<li><a href=", $pollPage. '?tag=help'.">Help on Polls</a></li>
						</ul>
					</li>
				</ul>
				";
	};
};
?>
