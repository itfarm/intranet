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
	
	$member_id=$_GET['member_id'];
	$page=$_GET['page'];
	$command=$_GET['command'];
	
	if ($command == "add_to_group") {
	
		//	user has already added member to group
			
		$group_id=$_POST['group_id'];
		$role_in_group_type=PrepareStringForInsert($_POST['role_in_group_type']);
		$role_in_group_description=PrepareStringForInsert($_POST['role_in_group_description']);
		
		$HasError = False;

		if  ($_POST['group_id'] == "") {
			echo "<p>You must choose a group</p>";
			$HasError = True;
		}

		if  ($_POST['role_in_group_type'] == "") {
			echo "<p>You must choose a membership type</p>";
			$HasError = True;
		}

			
		if (!$HasError) {

			$InsertSQL = "INSERT INTO tbl_group_membership (group_id, member_id, role_in_group_type, role_in_group_description) "; 		
			$InsertSQL = $InsertSQL." VALUES ('".$group_id."', '".$member_id."', ".$role_in_group_type.", ".$role_in_group_description.")"; 

			// echo $InsertSQL;
			
			$InsertQueryRan = mysql_query($InsertSQL);
			
			//echo $InsertQueryRan;
			
			//echo mysql_affected_rows();
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Membership successfully added</P>";
			} else {
				echo "<P>Error adding membership.  Perhaps the user is already in the group.</P>";
			}
			
		}
	} elseif ($command == "change_type") {
		$new_type = $_GET['new_type'];
		$group_id = $_GET['group_id'];
		
		$UpdateSQL = "Update tbl_group_membership
									Set role_in_group_type = '".$new_type."'
									Where group_id = '".$group_id."'
									AND member_id = '".$member_id."'";
									
		echo $UpdateSQL;
		
		$UpdateQueryRan = mysql_query($UpdateSQL);
		
		if ($UpdateQueryRan and mysql_affected_rows() == 1 ) {
			echo "<P>Membership type successfully updated</P>";
		} else {
			echo "<P>Error updating membership type</P>";
		}
		
	} elseif ($command == "remove_from_group") {
		$group_id = $_GET['group_id'];
		
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
	//Display list of groups this person is a member of
	//*****************************************************************
	echo '<p class="bigleft">Group membership for:  ';
	echo domain('dfirst','concat(name, \' \', surname)','authuser',"id = '".$member_id."'");
	echo '</p>';
	?>	
	<table align=center class="smallneat">		
	<tr class="largeleft">
			<th>Group name</th>
			<th>Role in group</th>
			<th>Membership type</th>
			<th></th>
			</tr>
			
			<tr class="d0">
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>?page=<?php echo $page ?>&member_id=<?php echo $member_id ?>&command=add_to_group" method='POST' name='addtogroupform' >
			<td>
					<select name="group_id" size=1  class="vform" >
								<?php
									echo DropDownLookup('tbl_groups', 'group_id', 'group_name', 'Desc');
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
			<td><input type='submit' value='Add to group' class="button" /></td>
			</tr>
					</form>
	<script language="JavaScript" type="text/javascript">
	var frmvalidator = new Validator("addtogroupform");
	frmvalidator.addValidation("group_id","req","Please choose a group");
		frmvalidator.addValidation("role_in_group_type","req","Please choose a membership type");
	</script>
			
	<?php
	// Display list of groups***************************
	

	$qry_group_SQL = "SELECT qry_group_members_active.*
										FROM (".$qry_group_members_active_SQL.") as qry_group_members_active 
										WHERE id = '".$member_id."'
										ORDER BY role_in_group_type, group_name";

  //echo $qry_group_SQL; 
	$qry_group_result = mysql_query($qry_group_SQL);

	if (!$qry_group_result) {
			exit('<p>Error performing groups query: '.mysql_error().'</p>');
	} else {
		$i = 0;
			
		if (mysql_num_rows($qry_group_result) == 0) {
			echo "<P  class='centered'>This user is not a member of any groups</P>";
			//exit;	
		}	
		While ($qry_group_row = mysql_fetch_array($qry_group_result)) {
			$i++;
			echo '<tr class="d'.($i & 1).'">';						
			?>
			
			<td>
				<?php echo $qry_group_row['group_name'] ?>
			</td>
			<td>
				<?php echo $qry_group_row['role_in_group_description'] ?>
			</td>			
			<td>
					<select name="role_in_group_type" size=1  class="vform" onChange="window.location='index.php?page=<?php echo $page ?>&member_id=<?php echo $member_id ?>&command=change_type&group_id=<?php echo $qry_group_row['group_id'] ?>&new_type='+this.value">
								<?php
									echo DropDownLookup('tbl_list_role_in_group_type', 'role_in_group_type', 'role_in_group_type', '', $qry_group_row['role_in_group_type'], false);
								?>
					</select>
				</td>
			<td>
					<a href="index.php?page=<?php echo $page ?>&member_id=<?php echo $member_id ?>&command=remove_from_group&group_id=<?php echo $qry_group_row['group_id'] ?>">
					Remove
					</a>
			</td>		
			</tr>
				
<?php
		}
	}
echo '</table>';
?>
