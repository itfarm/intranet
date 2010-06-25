<?
	include_once('../config.php');
	include_once('../config_imported/connect.inc.php');
	include_once('../config_imported/coresql.inc.php');
	include_once('../config_imported/functionsdate.inc.php');
	include_once('../config_imported/functionsgeneral.inc.php');
	include_once('../config_imported/functions.inc.php');
	// initialize host and database
    include_once('config_imported/settings.inc.php');
	global $szDBName,$szDBUsername,$szDBPassword;
	

function auth_debug($szDebugInfo,$szComment = ""){
	global $blAuthDebug, $dashboardPage, $profilePage, $root_dir;
	
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
	global $blAuthDebug, $dashboardPage, $profilePage, $root_dir;
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
		$this->HOST = $db_host;
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

?>
