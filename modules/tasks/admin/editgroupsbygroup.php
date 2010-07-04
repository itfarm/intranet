<?php
	//*****************************************************************
	//Process commands
	//*****************************************************************
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functions.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
	
	$group_id=$_GET['group_id'];
	//echo $group_id;
	$page=$_GET['page'];
	$command=$_GET['command'];
	
	if ($command == "add_member") {
	
		//	user has already added a member
			
		$member_id=$_POST['member_id'];
		$role_in_group_type=PrepareStringForInsert($_POST['role_in_group_type']);
		$role_in_group_description=PrepareStringForInsert($_POST['role_in_group_description']);
		
		$HasError = False;

		if  ($_POST['member_id'] == "") {
			echo "<p>You must choose a member</p>";
			$HasError = True;
		}
		
		if  ($_POST['role_in_group_type'] == "") {
			echo "<p>You must choose a membership type</p>";
			$HasError = True;
		}
			
		if (!$HasError) {

			$InsertSQL = "INSERT INTO tbl_group_membership (group_id, member_id, role_in_group_type, role_in_group_description) "; 		
			$InsertSQL = $InsertSQL." VALUES ('".$group_id."', '".$member_id."', ".$role_in_group_type.", ".$role_in_group_description.")"; 

			//echo $InsertSQL;
			
			$InsertQueryRan = mysql_query($InsertSQL);
			
			//echo $InsertQueryRan;
			
			//echo mysql_affected_rows();
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Member successfully added</P>";
			} else {
				echo "<P>Error adding member.  Perhaps the member is already in the group.</P>";
			}
			
		}
	} elseif ($command == "change_type") {
		$new_type = $_GET['new_type'];
		$member_id = $_GET['member_id'];
		
		$UpdateSQL = "Update tbl_group_membership
									Set role_in_group_type = '".$new_type."'
									Where group_id = '".$group_id."'
									AND member_id = '".$member_id."'";
									
		//echo $UpdateSQL;
		
		$UpdateQueryRan = mysql_query($UpdateSQL);
		
		if ($UpdateQueryRan and mysql_affected_rows() == 1 ) {
			echo "<P>Membership type successfully updated</P>";
		} else {
			echo "<P>Error updating membership type</P>";
		}
		
	} elseif ($command == "remove_member") {
		$member_id = $_GET['member_id'];
		
		$DeleteSQL = "Delete tbl_group_membership.* from tbl_group_membership
									Where group_id = '".$group_id."'
									AND member_id = '".$member_id."'";
									
		//echo $DeleteSQL;
		
		$DeleteQueryRan = mysql_query($DeleteSQL);
		
		if ($DeleteQueryRan and mysql_affected_rows() == 1 ) {
			echo "<P>Member successfully removed</P>";
		} else {
			echo "<P>Error removing member</P>";
		}
	}		

	 
	//*****************************************************************
	//Display list of groups members and forms
	//*****************************************************************
	echo '<p class="bigleft">Members of group:<br>';
	echo domain('dfirst','group_name','tbl_groups',"group_id = '".$group_id."'");
	echo '</p>';
	
	$number_of_leaders = domain('dcount','member_id','tbl_group_membership',"group_id = '".$group_id."' and role_in_group_type = 'Leader'");
	
	echo '<p>';
	if ($number_of_leaders==1) {
			// do nothing - it is OK
	} elseif ($number_of_leaders == 0) {
			echo 'Warning: This group has no leaders.  It is recommended that each group have a leader.';
	}	else {
			echo 'Warning: This group has '.$number_of_leaders.' leaders.  It is recommended that each group have only one leader.';
	}
	echo '</p>';
?>
	
	<table align=center class="smallneat">		
	<tr class="largeleft">
			<th>Member name</th>
			<th>Role in group</th>
			<th>Membership type</th>
			<th></th>
			</tr>
			
			<tr class="d0">
			<form action="<?php echo $adminpage . "&tag=editgroupsbygroup" ?>&group_id=<?php echo $group_id ?>&command=add_member" method='POST' name='addmemberform' >
			<td>
					<select name="member_id" size=1  class="vform" >
								<?php
									echo DropDownLookup('authuser', 'id', 'concat(name,\' \',surname)', 'Desc');
								?>
					</select>
			</td>
			<td><input type="text" name='role_in_group_description' class="vform" /></td>
			<td>
					<select name="role_in_group_type" size=1  class="vform" >
								<?php
									echo DropDownLookup('tbl_list_role_in_group_type', 'role_in_group_type', 'role_in_group_type');
								?>
					</select>
			</td>
			<td><input type='submit' value='Add member' class="button"/></td>
			</tr>
					</form>
	<script language="JavaScript" type="text/javascript">
	var frmvalidator = new Validator("addmemberform");
	frmvalidator.addValidation("member_id","req","Please choose a member");
	frmvalidator.addValidation("role_in_group_type","req","Please choose a membership type");
	</script>
			
	<?php
	// Display list of members***************************
	

	$qry_member_SQL = "SELECT qry_group_members_active.*, authuser.name, authuser.surname
										FROM (".$qry_group_members_active_SQL.") as qry_group_members_active inner join authuser on qry_group_members_active.id = authuser.id
										WHERE group_id = '".$group_id."'
										ORDER BY role_in_group_type, name, surname";

	$qry_member_result = mysql_query($qry_member_SQL);

	if (!$qry_member_result) {
			exit('<p>Error performing members query: '.mysql_error().'</p>');
	} else {
		$i = 0;
			
		if (mysql_num_rows($qry_member_result) == 0) {
			echo "</table><P  class='centered'>No members in this group</P>";
		}	
		While ($qry_member_row = mysql_fetch_array($qry_member_result)) {
			$i++;
			echo '<tr class="d'.($i & 1).'">';						
			?>
			
			<td>
				<?php echo $qry_member_row['name'].' '.$qry_member_row['surname'] ?>
			</td>
			<td>
				<?php echo $qry_member_row['role_in_group_description'] ?>
			</td>			
			<td>
					<select name="role_in_group_type" size=1  class="vform" onChange="window.location='<?php echo $adminpage . "&tag=editgroupsbygroup" ?>&group_id=<?php echo $group_id ?>&command=change_type&member_id=<?php echo $qry_member_row['user_id'] ?>&new_type='+this.value">
								<?php
									echo DropDownLookup('tbl_list_role_in_group_type', 'role_in_group_type', 'role_in_group_type', '', $qry_member_row['role_in_group_type'], false);
								?>
					</select>
				</td>
			<td>
					<a href="<?php echo $adminpage . "&tag=editgroupsbygroup" ?>&group_id=<?php echo $group_id ?>&command=remove_member&member_id=<?php echo $qry_member_row['user_id'] ?>">
					Remove
					</a>
			</td>		
			</tr>
				
<?php
		}
	}
echo '</table>';
?>
