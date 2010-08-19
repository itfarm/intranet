<?php

	//var_dump($_POST);
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functions.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
	$command=$_GET['command'];
	$assigner_id = $_GET['assigner_id'];
	echo "we get here";
	if ($command == "update_assignments") {
	
		//	user has already updated assignments
		$HasError = False;
			
		if (!$HasError) {
			
			$DeleteSQL = "Delete tbl_assignment_privileges.*
										From tbl_assignment_privileges
										Where user_id = '".$assigner_id."'"; 		
			
			$DeleteQueryRan = mysql_query($DeleteSQL);
			
			$NumberOfAssignees = 0;
			//var_dump($_POST);
			//exit;
			if(isset($_POST['id'])) {
				for($i = 0; $i < sizeof($_POST['id']); $i++) {
					$user_id = PrepareStringForInsert($_POST['id'][$i]);
					$InsertAssigneeSQL = "INSERT INTO tbl_assignment_privileges (user_id, assignee_id) "; 		
					$InsertAssigneeSQL = $InsertAssigneeSQL." VALUES ('".$assigner_id."', ".$user_id.")"; 	
					//echo $InsertAssigneeSQL;
					$InsertAssigneeQueryRan = mysql_query($InsertAssigneeSQL);
					//echo '<br>This is set: ' . $_POST['assignee_id'][$i];
					if ($InsertAssigneeQueryRan) {
						$NumberOfAssignees = $NumberOfAssignees + 1;
					}
				}
			}

			if(isset($_POST['group_id'])) {
				for($i = 0; $i < sizeof($_POST['group_id']); $i++) {
					$group_id = PrepareStringForInsert($_POST['group_id'][$i]);
					$InsertAssigneeSQL = "INSERT INTO tbl_assignment_privileges (user_id, assignee_id) "; 		
					$InsertAssigneeSQL = $InsertAssigneeSQL." VALUES ('".$assigner_id."', ".$group_id.")"; 	
					//echo $InsertAssigneeSQL;
					$InsertAssigneeQueryRan = mysql_query($InsertAssigneeSQL);
					//echo '<br>This is set: ' . $_POST['assignee_id'][$i];
					if ($InsertAssigneeQueryRan) {
						$NumberOfAssignees = $NumberOfAssignees + 1;
					}
				}
			}

			
			if ($DeleteQueryRan ) {
				echo '<P>'.$NumberOfAssignees.' assignees successfully saved</P>';
			} else {
				echo "<P>Error updating assignees</P>";
				// will continue to form section
			}
			
		}
	}

//*****************************************************
// Show form
//*****************************************************

	echo '<p class="bigleft">Assignment privileges for:  ';
	echo domain('dfirst','concat(name, \' \', surname)','authuser',"id = '".$assigner_id."'");
	echo '</p>';
?>
<div class="scrolldown">
		<form action='<?php echo $_SERVER['PHP_SELF'].'?page='.$page.'&assigner_id='.$assigner_id.'&command=update_assignments' ?>' method='POST' name='updateassignmentsform' >
			
				<p class="bigleft">This user can assign to (users):</p>
				<?php echo TickBoxes("(".$qry_users_active_desc_SQL.") as qry_users_active_desc","id","user_desc", 6, true, 'tbl_assignment_privileges','assignee_id',"user_id = '".$assigner_id."'"); ?>
				<br>
				<p class="bigleft">This user can assign to (groups):</p>
				<?php echo TickBoxes("(".$qry_groups_active_desc_SQL.") as qry_groups_active_desc","group_id","group_desc", 3, true, 'tbl_assignment_privileges','assignee_id',"user_id = '".$assigner_id."'"); ?>
				<br>		
	
				<input type='submit' value='Save' class="button" /></td></tr>
		</form>
</div>


