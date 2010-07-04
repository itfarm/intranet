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
	$assignee_id = $_GET['assignee_id'];
	
	if ($command == "update_assignments") {
	
		//	user has already updated assignments
		$HasError = False;
			
		if (!$HasError) {
			
			$DeleteSQL = "Delete tbl_assignment_privileges.*
										From tbl_assignment_privileges
										Where assignee_id = '".$assignee_id."'"; 		
			
			$DeleteQueryRan = mysql_query($DeleteSQL);
			
			$NumberOfAssigners = 0;
			//var_dump($_POST);
			if(isset($_POST['id'])) {
				for($i = 0; $i < sizeof($_POST['id']); $i++) {
					$user_id = PrepareStringForInsert($_POST['id'][$i]);
					$InsertAssignerSQL = "INSERT INTO tbl_assignment_privileges (user_id, assignee_id) "; 		
					$InsertAssignerSQL = $InsertAssignerSQL." VALUES (".$user_id.", '".$assignee_id."')"; 	
					// echo $InsertAssignerSQL;
					$InsertAssignerQueryRan = mysql_query($InsertAssignerSQL);
					//echo '<br>This is set: ' . $_POST['assigner_id'][$i];
					if ($InsertAssignerQueryRan) {
						$NumberOfAssigners = $NumberOfAssigners + 1;
					}
				}
			}
			
			if ($DeleteQueryRan ) {
				echo '<P>'.$NumberOfAssigners.' assigners successfully saved</P>';
			} else {
				echo "<P>Error updating assigners</P>";
				// will continue to form section
			}
			
		}
	}

//*****************************************************
// Show form
//*****************************************************
	$assignee_type = substr($assignee_id,0,1);
	//echo $assignee_id;
    //echo domain('dfirst','concat(name, \' \', surname)','authuser',"id = '".$assignee_id."'");
	echo '<p class="bigleft">Assigners for:  ';
	if (($assignee_type != 'U')&&($assignee_type != 'G')) {
		//echo domain('dfirst','concat(name, \' \', surname)','authuser',"id = '".$assignee_id."'");
		echo domain('dfirst','concat(name, \' \', surname)','authuser',"id = '".$assignee_id."'");
		echo '</p>';
		echo '<p class="bigleft">This user can be assigned tasks by:</p>';
	} elseif ($assignee_type == 'G') {
		echo domain('dfirst','group_name','tbl_groups',"group_id = '".$assignee_id."'");	
		echo '</p>';
		echo '<p class="bigleft">This group can be assigned tasks by:</p>';
	}
	echo '</p>';
?>

		<form action='<?php echo $_SERVER['PHP_SELF'].'?page='.$page.'&assignee_id='.$assignee_id.'&command=update_assignments' ?>' method='POST' name='updateassignmentsform' >
			
				<?php echo TickBoxes("(".$qry_users_active_desc_SQL.") as qry_users_active_desc","id","user_desc", 6, true, 'tbl_assignment_privileges','user_id',"assignee_id = '".$assignee_id."'"); ?>
				<br>
	
				<input type='submit' value='Save' class="button" /></td></tr>
		</form>
		


