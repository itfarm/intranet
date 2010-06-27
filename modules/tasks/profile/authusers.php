<?
	# initialise globals
	# @Generate top menu do deprecated if no effect
	#include('config.inc.php');
	@include_once('../config.php');
	
	# include the header
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Users & Groups';
	$szTitle = 'User Manager';
	$szSubSection = 'User Manager';
	@include_once ('auth.php');
	
	$user = new pmo_auth();
	
	$dbcnx = db_connection($db_host,$db_user,$db_password);
	$SelectedDB = db_select($db_name,$dbcnx);

?>
<?

// initialise the group list

// query the list of groups
$listgroups = mysql_query("SELECT * from authteam");
	
// convert query to array
$arrgroups = array();
for ($i=0;$i<mysql_num_rows($listgroups);$i++){
	$row = mysql_fetch_array($listgroups,MYSQL_ASSOC);
	$arrgroups[$row['id']] = $row;
	$arrgroups[$row['id']]['intPrivileges'] = 0;
}



// Get initial values from superglobal variables
// Let's see if the admin clicked a link to get here
// or was originally here already and just pressed 
// a button or clicked on the User List


if (isset($_POST['action'])&& $_POST['action'] != "Add New") 
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$email = $_POST['email'];
	$prefix = $_POST['prefix'];
	$department = $_POST['department'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$zip = $_POST['zip'];
	$country = $_POST['country'];
	$mobile = $_POST['mobile'];
	$location = $_POST['location'];
	
	// work out priveleges array
	
	// loop through posted information
	$arrGroupPrivileges = array();
	if (isset($_POST['group_priv'])){
		foreach ($_POST['group_priv'] as $intGroupID => $arrPrivs){
			if (count($arrPrivs)){
				$arrgroups[$intGroupID]['intPrivileges'] = array_sum($arrPrivs);
			}else{
				$arrgroups[$intGroupID]['intPrivileges'] = 0;
			}
		}
	}
	
	/*
	// update the team array
	for ($i=1; $i <= count($arrgroups); $i++){
		if (isset($_POST['team'.$i])){
			$arrgroups[$_POST['team'.$i]]['intPrivileges'] = 1;
		}
	}
	*/
	
	$id = $_POST['id'];
	$level = $_POST['level'];
	$status = $_POST['status'];
	$action = $_POST['action'];
	$act = "";
}
elseif (isset($_GET['act']))
{
	$act = $_GET['act'];
	$action = "";
}
else
{
	$action = "";
	$id = 0;
	$username = "";
	$password = "";	
	$name = "";
	$surname = "";
	$email = "";
	$prefix = "";
	$department = "";
	$address = "";
	$city = "";
	$zip = "";
	$country = "";
	$team = "";
	$level = "";
	$status = "";
	$action = "";
	$act = "";
	$mobile = "";
	$location = "";
}



$message = "";

// ADD USER
if ($action == "Add") {
	$situation = $user->add_user($id, $username, $password, $name, $surname, $email, $mobile,$location,$arrgroups, $level, $status, $prefix, $department, $address, $city, $zip, $country);
	
	if ($situation == "blank username") {
		$message = "Username field cannot be blank.";
		$action = "";
	}
	elseif ($situation == "username exists") {
		$message = "Username already exists in the database. Please enter a new one.";
		$action = "";
	}
	elseif ($situation == "blank password") {
		$message = "Password field cannot be blank for new members.";
		$action = "";
	}
	elseif ($situation == "blank level") {
		$message = "Level field cannot be blank.";
		$action = "";
	}
	else{
		// returned inserted ID
		$message = "New user added successfully.";
	}
	
	// update inserted ID
	$id = $situation;
}

// DELETE USER
if ($action=="Delete") {
	// Delete record in authuser table
	$delete = $user->delete_user($id);
	
	if ($delete) {
		$message = $delete;
	}
	else {
		$id = 0;
		$username = "";
		$password = "";
		$name = "";
		$surname = "";
		$email = "";
		$prefix = "";
		$department = "";
		$address = "";
		$city = "";
		$zip = "";
		$country = "";
		$mobile = "";
		$location = "";
		$team = "Ungrouped";
		$level = "";
		$status = "active";
		$message = "The user has been deleted.";
	}
}

// MODIFY USER
if ($action == "Modify") {
	$update = $user->modify_user($id, $username, $password, $name, $surname, $email,$mobile,$location,$arrgroups, $level, $status, $prefix, $department, $address, $city, $zip, $country);

	if ($update==1) {
		$message = "User detail updated successfully.";
	}
	elseif ($update == "blank level") {
		$message = "Level field cannot be blank.";
		$action = "";
	}
	elseif ($update == "sa cannot be inactivated") {
		$message = "This user cannot be inactivated.";
		$action = "";
	}
	elseif ($update == "admin cannot be inactivated") {
		$message = "This user cannot be inactivated";
		$action = "";
	}
	else {
		$message = "";
	}
}

// EDIT USER (accessed from clicking on username links)
if ($act == "Edit") 
{
    $id = $_GET['id'];
	$listusers = mysql_query("SELECT * from authuser where id='$id'");
	
	// query to find out selected groups
	$mygroups = mysql_query("
		SELECT authteam.*,authuserteam_mapping.intPrivileges
		FROM authteam,authuserteam_mapping,authuser
		WHERE authuser.id=$id
		AND authuser.id = authuserteam_mapping.userid
		AND authteam.id = authuserteam_mapping.teamid
	");
		
	// update above array to show the groups selected
	while ($row = mysql_fetch_array($mygroups)){
		
		$arrgroups[$row['id']]['intPrivileges'] = $row['intPrivileges'];
	}
	
	
	/* MySQL 4.1 - it should be like this:
	SELECT 	*
		FROM authteam LEFT JOIN (SELECT authuser.id as userID,
				authuserteam_mapping.teamid AS teamID
				FROM authuser, authuserteam_mapping
				WHERE authuser.uname='sa'
				AND authuser.id = authuserteam_mapping.userid) AS dTable 
		ON authteam.id = dTable.teamID
	*/
	
	$rows = mysql_fetch_array($listusers);
	
	$username = $rows["uname"];
	$surname = $rows["surname"];
	$name = $rows["name"];
	$email = $rows["email"];
	$prefix = $rows["prefix"];
	$department = $rows["department"];
	$address = $rows["address"];
	$city = $rows["city"];
	$zip = $rows["zip"];
	$country = $rows["country"];
	$mobile = $rows['mobile'];
	$location = $rows['location'];

	$password = "";
	$team = $rows["team"];
	$level = $rows["level"];
	$status = $rows["status"];

	$message = "Modify user details.";
}

// CLEAR FIELDS
if ($action == "Add New") {
	$id = 0;
	$username = "";
	$password = "";
	$name = "";
	$surname = "";
	$email = "";
	$prefix = "";
	$department = "";
	$address = "";
	$city = "";
	$zip = "";
	$country = "";
	$mobile = "";
	$location = "";
	$team = "";
	$level = "";
	$status = "active";
	$message = "New user detail entry.";
	
	$action = "";
	$id = 0;
	$username = "";
	$password = "";	
	$name = "";
	$surname = "";
	$email = "";
	$team = "";
	$level = "";
	$status = "";
	$action = "";
	$act = "";
}


?>


<h4>Manage users available in the sytstem</h4>
<script language="JavaScript" src="<?php echo $root_dir ?>javascripts/gen_validatorv2.js"></script>


<table border="0" cellspacing="0" cellpadding="0" align="left">
<form name="AddUser" method="Post" action="<?php echo $profilePage ?>&tag=manageusers">
<input type="hidden" name="id" value="<?= $id?>">
<input type="hidden" name="level" value="1">
  <tr valign="top"> 
    <td width=50%> 

	  	
		<table class="adminTable" width="100%" border="1" cellspacing="1" cellpadding="4" align="left">
		<thead>
			<tr> 
			  <th class="adminHeader vsmalltext" align="left">Username</td>
			  <th class="adminHeader vsmalltext" align="left">Status</td>
			  <th class="adminHeader vsmalltext" align="left">Last Login</td>
			  <th class="adminHeader vsmalltext" align="left">Count</td>
			</tr>
        </thead>
        <tbody>
		<?
			// Fetch rows from AuthUser table and display ALL users
			
			$result = mysql_query("SELECT * FROM authuser ORDER BY uname");
			
			$row = mysql_fetch_array($result);
			$i = 1;
			while ($row) 
			{ 	if($i==1){$i=2;}else{$i=1;}
				?>
				<tr class="adminRow<?=$i?>">
		        	<td class="smalltext">
						<a href="<?php echo $profilePage ?>&tag=manageusers&act=Edit&id=<?=$row['id']?>"><?=$row['name']?>&nbsp;<?=$row['surname']?></a>
		       		</td>
		        	<td class="smalltext" align="center">
						<?=$row['status']?>
		        	</td>
		        	<td class="smalltext" align="center">
		        		<?=date("d M y",strtotime($row['lastlogin']))?>
		        	</td>
		        	<td class="smalltext" align="center">
						<?=$row['logincount']?>
		        	</td>
		        </tr>
				
				<?
				$row = mysql_fetch_array($result);
			}
		?>
     	<tr><td colspan=4 align=right><input type="submit" name="action" value="Add New" class="button"></td></tr>
	  </tbody>
	  </table>
	  
      </td>
	<td width=15>&nbsp;</td>
    <td> 
	  
	  	<table class="adminTable" width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
          <tr> 
            <td colspan="2" class="adminHeader">User Details</td>
          </tr>
		  <? if ($message) { ?>
		  <tr bgcolor="#CCCCCC"> 
          	<td colspan=2 class="adminRow2 vsmalltext" align="center"><?=$message?></td>
		  </tr>
		  <? } ?>
          <tr valign="middle"> 
            <td class="adminRow2 smalltext" width="30%">Username</td>
            <td class="adminRow2 smalltext" width="70%"><input class=vform type="text" name="username" size="20" maxlength="30" value="<?=$username?>">
              <?   /*
			  	if (($action == "Modify") || ($action=="Add") || ($act=="Edit")) {
					print "<input type=\"hidden\" name=\"username\" value=\"$username\">"; 
					print "$username";
				}
				else {	
					print "<input type=\"text\" name=\"username\" size=\"20\" maxlength=\"15\" value=\"$username\">"; 
				}
				*/
			  ?>
              &nbsp;</td>
          </tr>
		  
		  
          <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Password</td>
            <td class="adminRow2 smalltext"><? print "<input class=vform type=\"password\" name=\"password\" size=\"20\" maxlength=\"15\" value=\"$password\">"; ?><br>
			<!-- Leave the password field blank if you want to retain the old password. --> 
			Leave blank to retain old password.
			</td>
          </tr>
		  
		   <!-- 	prefix	-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Prefix</td>
            <td class="adminRow2 smalltext">
			<select name="prefix" class="vform">
				<option value="" <? if ($prefix=="") echo "selected"; ?>>Select ...</option>
				<option value="Mr" <? if ($prefix=="Mr") echo "selected"; ?>>Mr</option>
				<option value="Mrs" <? if ($prefix=="Mrs") echo "selected"; ?>>Mrs</option>
				<option value="Miss" <? if ($prefix=="Miss") echo "selected"; ?>>Miss</option>
			</select>
			<br></td>
          </tr>
		  
		  <!-- 	first name	-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Firstname</td>
            <td class="adminRow2 smalltext"><input class=vform type="text" name="name" size="20" maxlength="30" value="<?=$name?>"><br></td>
          </tr>
		  
		  <!--	surname		-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Surname</td>
            <td class="adminRow2 smalltext"><input class=vform type="text" name="surname" size="20" maxlength="30" value="<?=$surname?>"><br></td>
          </tr>
		  
		  <!--	email		-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Email</td>
            <td class="adminRow2 smalltext"><input class=vform type="text" name="email" size="20" maxlength="30" value="<?=$email?>"><br></td>
          </tr>
		  
		  <!--	department		-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Department</td>
            <td class="adminRow2 smalltext"><input class=vform type="text" name="department" size="20" maxlength="30" value="<?=$department?>"><br></td>
          </tr>
		  		  
		  <!--	address		-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Address</td>
            <td class="adminRow2 smalltext"><input class=vform type="text" name="address" size="20" maxlength="30" value="<?=$address?>"><br></td>
          </tr>
		  		  
		  <!--	city		-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>City</td>
            <td class="adminRow2 smalltext"><input class=vform type="text" name="city" size="20" maxlength="30" value="<?=$city?>"><br></td>
          </tr>
		  		  
		  <!--	zip		-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Zip</td>
            <td class="adminRow2 smalltext"><input class=vform type="text" name="zip" size="20" maxlength="30" value="<?=$zip?>"><br></td>
          </tr>
		  		  
		  <!--	country		-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Country</td>
            <td class="adminRow2 smalltext"><input class=vform type="text" name="country" size="20" maxlength="30" value="<?=$country?>"><br></td>
          </tr>
		  
		    <!--	mobile		-->
		  
		  <tr valign="middle"> 
            <td class="adminRow1 smalltext" valign=top>Mobile</td>
            <td class="adminRow1 smalltext"><input class=vform type="text" name="mobile" size="20" maxlength="30" value="<?=$mobile?>"><br></td>
          </tr>
		    <!--	location		-->
		  
		  <tr valign="middle"> 
            <td class="adminRow2 smalltext" valign=top>Location</td>
            <td class="adminRow2 smalltext"><input class=vform type="text" name="location" size="20" maxlength="30" value="<?=$location?>"><br></td>
          </tr>
		  
		  
          <tr valign="middle"> 
            <!-- <td class="adminRow2 smalltext" valign="top">Team</td> -->
            <td colspan=2 class="adminRow2">
				<table cellspacing="2" cellpadding="2" border="0" width=100%>
				<tr>
					<td align=center>&nbsp;</td>
					<td align=center>Bse</td>
					<td align=center>Edt</td>
					<td align=center>Del</td>
				</tr>
                <?
			  	// DISPLAY TEAMS, these will be passed to this page by 
				$i=1;

			  	foreach ($arrgroups as $row){
					$teamlist = $row["teamname"];
					$checked = ($row["selected"]) ? "checked" : "" ;
					$j = $i%2+1;
					$byteLength = 8;
					$szBinPriv = str_pad(decbin($row['intPrivileges']), $byteLength, '0', STR_PAD_LEFT);
                    //echo '<br>'.$szBinPriv[7].'<br>';
					?>
					<tr><td class="adminRow<?=$j?> smalltext"><?=$teamlist?></td>
						<td align=center class="adminRow<?=$j?> smalltext"><input type="checkbox" class="checkbox" name="group_priv[<?=$row['id']?>][1]" value="1" <? if($szBinPriv[7]) echo 'checked'; ?>></td>
						<td align=center class="adminRow<?=$j?> smalltext"><input type="checkbox" class="checkbox" name="group_priv[<?=$row['id']?>][2]" value="2" <? if($szBinPriv[6]) echo 'checked'; ?>></td>
						<td align=center class="adminRow<?=$j?> smalltext"><input type="checkbox" class="checkbox" name="group_priv[<?=$row['id']?>][4]" value="4" <? if($szBinPriv[5]) echo 'checked'; ?>></td>
					</tr>
					<?
				$i++;
				}
			    ?>
              	</table></td>
          </tr>
		  
		  <!--
          <tr valign="middle"> 
		  	<td class="authTableName" valign="top">Level</td>
            <td class="authTableValue"> 
              <? //print "<input type=\"text\" name=\"level\" size=\"4\" maxlength=\"4\" value=\"$level\">"; ?>
              </td>
          </tr>
		  -->
		  
          <tr valign="middle">
		  	<td class="adminContent" valign="top">Status</td> 
            <td class="adminContent">
              <select name="status" class=vform>
                <?
			  	// ACTIVE / INACTIVE
				if ($status == "inactive") {
					print "<option value=\"active\">Active</option>";
                	print "<option value=\"inactive\" selected>Inactive</option>";
				}
				else {
					print "<option value=\"active\" selected>Active</option>";
                	print "<option value=\"inactive\">Inactive</option>";
				}
              
			  ?>
              </select>
              </td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" class="authTableFooter" align=center> 
               
                <?
					
				if (($action=="Add") || ($action == "Modify") || ($act=="Edit")) {
					$rnum = rand();
					print "<input type=\"submit\" style=\"width:60px\" class=button name=\"action\" value=\"Modify\"> ";
					print "<input type=\"submit\" style=\"width:60px\" class=button name=\"action\" value=\"Delete\"> ";
				}
				else {
					print "<input type=\"submit\" style=\"width:60px\" class=button name=\"action\" value=\"Add\"> ";
                }
				
				?>
                <input type="reset" class=button style="width:60px" name="Reset" value=" Clear ">
                
            </td>
          </tr>
        </table>
	  
      
    </td>
  </tr>
  </form>
  
  <!--
  
  <script language="JavaScript">
  
 	var vAddUser  = new Validator("AddUser");
	
	vAddUser.addValidation("username","req","Please enter your Username");
	vAddUser.addValidation("name","req","Please enter your first name");
	vAddUser.addValidation("surname","req","Please enter your surname");
	vAddUser.addValidation("email","req","Please enter your email address");
	
  </script>	
  
  -->
</table>
