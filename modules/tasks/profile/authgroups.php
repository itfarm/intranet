<?

	# initialise globals
	@include_once('../config.php');
	
	# include the header
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Users & Groups';
	$szTitle = 'Group Manager';
	$szSubSection = 'Group Manager';
?>




<?
	@include_once ('auth.php');
	$group = new pmo_auth();
	
	$dbcnx = db_connection($db_host,$db_user,$db_password);
	$SelectedDB = db_select($db_name,$dbcnx);
	

?>
<?
// Check if we have instantiated $action and $act variable
// If yes, get the value from previous posting
// If not, set values to null or ""
 
if (isset($_POST['action'])) 
{
	$id = $_POST['id'];
	$action = $_POST['action'];
	$act = "";
	$teamname = $_POST['teamname'];
	$teamlead = $_POST['teamlead'];
	$status = $_POST['status'];
	
	// work out priveleges array
	
	// loop through posted information
	$arrGroupPrivileges = array();
	if (isset($_POST['group_priv'])){
		foreach ($_POST['group_priv'] as $intGroupID => $arrPrivs){
			if (count($arrPrivs)){
				$arrGroupPrivileges[$intGroupID] = array_sum($arrPrivs);
			}else{
				$arrGroupPrivileges[$intGroupID] = 0;
			}
		}
	}

}
elseif (isset($_GET['act']))
{
	$act = $_GET['act'];
	$action = "";
}
else
{
	$id = 0;
	$action = "";
	$act = "";
	$teamname = "";
	$teamlead = "";
	$status = "";
}

$message = "";

// ADD GROUP
if ($action == "Add") {
	$situation = $group->add_team($teamname, $teamlead, $status);
	
	if ($situation == "blank team name") {
		$message = "Group Name field cannot be blank.";
		$action = "";
	}
	elseif ($situation == "group exists") {
		$message = "Team Group already exists in the database. Please enter a new one.";
		$action = "";
	}
	elseif ($situation == 1) {
		$message = "New Group added successfully.";
	}
	else {
		$message = "";
	}
}

// DELETE GROUP
if ($action=="Delete") {
	$delete = $group->delete_team($id);
	
	if ($delete) {
		$message = $delete;
		$action = "";
	}
	else {
		$id = 0;
		$teamname = "";
		$teamlead = "sa";
		$status = "active";
		$message = "The group has been deleted.<br>All users associated with the group are moved to the Ungrouped team";
	}
}

// MODIFY TEAM
if ($action == "Update") {

	$update = $group->modify_team($id, $teamname, $teamlead, $status, $arrGroupPrivileges);

	if ($update==1) {
		$message = "Group detail updated successfully.";
	}
	elseif ($update == "Admin Group cannot be inactivated.") {
		$message = $update;
		$action = "";
	}
	elseif ($update == "Ungrouped Group cannot be inactivated.") {
		$message = $update;
		$action = "";
	}
	elseif ($update == "Group Lead field cannot be blank.") {
		$message = $update;
		$action = "";
	}
	else {
		$message = "";
	}
}

// EDIT TEAM (accessed from clicking on username links)
if ($act == "Edit") {
    $id = $_GET['id'];
	$teamname = $_GET['teamname'];
    $teamlead = $_GET['teamlead'];
    $status = $_GET['status'];
    $message = "Modify Group details.";
}

// CLEAR FIELDS
if ($action == "Add New") {
	$id = 0;
	$teamname = "";
	$teamlead = "sa";
	$status = "active";
	$message = "New Group detail entry.";
}

// select users in the specified group
$listusers = mysql_query("
	SELECT * 
	FROM authuser,authuserteam_mapping 
	WHERE authuserteam_mapping.teamID = $id 
	AND authuser.ID = authuserteam_mapping.userID
	ORDER BY authuser.uname
");

?>


<h4>Manage groups that are available in the system</h4>
<div class="scrolldown">
<table border="0" cellspacing="0" cellpadding="0" align="left" width=100%>
<form name="AddTeam" method="Post" action="<?php echo $profilePage ?>&tag=managegroups">
<input type="hidden" name="id" value="<?= $id?>">
  <tr valign="top"> 
    <td width=50%> 
		
	   <table width="100%" border="0" cellspacing="1" cellpadding="4" align="center" class="adminTable">
       
        <tr bgcolor="#CCCCCC"> 
          	<td class="adminHeader vsmalltext">Group Name</td>
		  	<td class="adminHeader vsmalltext" align="center">Status</td>
        </tr>

		<?
			// Fetch rows from AuthUser table and display ALL users
			$qQuery = "SELECT * FROM authteam ORDER BY teamname";
			
			// OLD CODE - DO NOT REMOVE
			// $result = mysql_db_query($dbname, $qQuery);
			
			// REVISED CODE
			$result = mysql_query($qQuery);
			
			$row = mysql_fetch_array($result);
			$i = 1;
			while ($row) { 
				if($i==1){$i=2;}else{$i=1;} ?>
			
				<tr class="adminRow<?=$i?>">
			        <td class="smalltext">
				        <a href="<?php echo $profilePage ?>&tag=managegroups&act=Edit&id=<?=$row["id"]?>&teamname=<?=$row["teamname"]?>&teamlead=<?=$row["teamlead"]?>&status=<?=$row["status"]?>">
						<?=$row["teamname"];?>
						</a>
					</td>
	
			        <td class="smalltext" align="center">
						<?=$row["status"];?>
			        </td>
		        </tr>
				
			<?
				$row = mysql_fetch_array($result);
			}
		?>
     	<tr><td colspan=2 align=right><input type="submit" name="action" value="Add New" class=button></td></tr>
	  </table>
     
      </td>
	<td width=15>&nbsp;</td>
    <td>


	  <table width="100%" border="0" cellspacing="1" cellpadding="4" align="center" class="adminTable">
          <tr> 
            <td colspan=2  class="adminHeader">Group Details</td>
          </tr>
		  <? if ($message) { ?>
		  <tr bgcolor="#CCCCCC"> 
          	<td colspan=2 class="vsmalltext" align="center"><?=$message?></td>
		  </tr>
		  <? } ?>
        
          <tr valign="middle" class="adminRow1"> 
            <td class="smalltext" width=40% align=right>Group Name:</td>
            <td class="smalltext" width=60%>
              <?   
			  	if (($action == "Modify") || ($action=="Add") || ($act=="Edit")) {
					print "<input type=\"hidden\" name=\"teamname\" value=\"$teamname\">"; 
					print "<b>$teamname</b>";
				}
				else {	
					print "<input type=\"text\" name=\"teamname\" size=\"15\" value=\"$teamname\" class=vform>"; 
				}
				
			  ?>
              &nbsp;</td>
          </tr>
		  
		  <!-- remove up to here -->
		  
          <tr valign="middle" class="adminRow1"> 
            <td class="smalltext" align=right>Status:</td>
			<td class="smalltext">
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
              </select></td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" align=center> 
			  <?
					
				if (($action=="Add") || ($action == "Modify") || ($act=="Edit")) {
					$rnum = rand();
					//print "<a href=\"authgroup.php?rnum=$rnum\">add new</a>&nbsp;&nbsp;&nbsp;";
					print "<input type=\"submit\" name=\"action\" value=\"Modify\" class=button> ";
					print "<input type=\"submit\" name=\"action\" value=\"Delete\" class=button> ";
				}
				else {
					print "<input type=\"submit\" name=\"action\" value=\"Add\" class=button> ";
                }
				
				?>
                <input type="reset" name="Reset" value="Clear" class=button>
             </td>
          </tr>
        </table><br>
		
		<table width="100%" border="1" cellspacing="1" cellpadding="4" align="center" class="adminTable">
          <tr> 
            <td class="adminHeader">Group Members</td>
			<td class="adminHeader" align=center>Privileges</td>
          </tr>
		      
		<?
		  	// DISPLAY MEMBERS
		  	echo mysql_num_rows($listusers);
			if (mysql_num_rows($listusers)){
				mysql_data_seek($listusers,0);
			
			  	$row = mysql_fetch_array($listusers);
		?>
			<tr> 
            	<td>&nbsp;</td>
				<td class="smalltext" align="center"><b>Bse&nbsp;Edt&nbsp;Del</b></td>
          	</tr>


		<?		$i=0; // used to alternate style on rows
			  	while ($row) {
					
					$byteLength = 8;
					$szBinPriv = str_pad(decbin($row['intPrivileges']), $byteLength, '0', STR_PAD_LEFT);					if($i==1){$i=2;}else{$i=1;}
		?>
					 
					<tr valign="middle" class="adminRow<?=$i?>">
						<td class="smalltext"><?=$row["uname"]?></td>
						<td class="smalltext" align="center">
							<input type="hidden" name="group_priv[<?=$row['userID']?>][0]" value="0">
							<input type="checkbox" name="group_priv[<?=$row['userID']?>][1]" class="checkbox" value="1" <? if($szBinPriv[7]) echo 'checked'; ?>>
							<input type="checkbox" name="group_priv[<?=$row['userID']?>][2]" class="checkbox" value="2" <? if($szBinPriv[6]) echo 'checked'; ?>>
							<input type="checkbox" name="group_priv[<?=$row['userID']?>][4]" class="checkbox" value="4" <? if($szBinPriv[5]) echo 'checked'; ?>>	
						</td>
					</tr>
						
		<?			$row = mysql_fetch_array($listusers);
				}
		?>
				
				<tr> 
					<td colspan="2" align="center"><input type="submit" name="action" value="Update" class=button></td>
        		</tr>
			
		<?	
			}else{  ?>
				<tr valign="middle">
					<td class="smalltext">None.</td>
					<td class="authTableValue"></td>
				</tr>
		<? }?>
		  	
        </table>
      
    </td>
  </tr>
 </form>
</table>
</div>
