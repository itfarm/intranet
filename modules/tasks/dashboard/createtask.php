<?php 
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functions.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
	# include the header
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet,$szHeaderPath,$szFooterPath;

	$szSection = 'Navigation Manager';
	$szTitle = 'Create Task';
	$szSubSection = 'Task';
	$szSubSubSection = 'Create Task';
	
	$command=$_POST['command'];
	
	if ($command == "create_task") {
	
		//	user has already created a task
		$task_description=PrepareStringForInsert($_POST['task_description']);
		$task_classification_id=PrepareStringForInsert($_POST['task_classification_id']);
		$workload_classification_id=PrepareStringForInsert($_POST['workload_classification_id']);
		$priority_classification_id=PrepareStringForInsert($_POST['priority_classification_id']);
		$DeadlineDay=$_POST['DeadlineDay'];
		$DeadlineMonth=$_POST['DeadlineMonth'];	
		$DeadlineYear=$_POST['DeadlineYear'];	
		$assignee_can_close=$_POST['assignee_can_close'];

		$HasError = False;
		$task_id = GetNextIDNum('task_id','tbl_tasks');		

		
		// if any of the date fields filled out
		if ($DeadlineDay <> "" or $DeadlineMonth <> "" or $DeadlineYear <> "") {
			// if all the date fields filled out
			if ($DeadlineDay <> "" and $DeadlineMonth <> "" and $DeadlineYear <> "") {
				// if invalid date
				if (checkdate($DeadlineMonth,$DeadlineDay,$DeadlineYear)==false) {
					$HasError = True;
					echo "<P>You have not chosen a valid deadline date</p>";
				} else {
					// valid date
					$deadline = "'".$DeadlineYear."-".$DeadlineMonth."-".$DeadlineDay."'";
				}
			} else {
			// more than one field filled out but not all
				$HasError = True;
				echo "<P>You have left parts of the deadline date blank</p>";
			}
		} else {
			// date left blank
			$deadline = "null";
		}
		
		//echo $deadline;
		
		if  ($_POST['task_description'] == "") {
			echo "<p>You cannot leave the task description blank</p>";
			$HasError = True;
		}
		
		if  (domain('dcount','task_description','tbl_tasks',"task_description = ".$task_description) > 0) {
			echo "<p>A task with the same description (".$task_description.") has already been saved</p>";
			$HasError = True;
		}
			
		if (!$HasError) {

			$InsertSQL = "INSERT INTO tbl_tasks (task_id, task_description, task_classification_id, workload_classification_id, priority_classification_id, deadline, assignee_can_close, created_by, date_created, percent_completed) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$task_id.", ".$task_description.", ".$task_classification_id.",  ".$workload_classification_id.",  ".$priority_classification_id.", ".$deadline.", ".$assignee_can_close.", '".$_SESSION['id']."', '".date("Y-m-d H:i:s")."', 0)"; 

			//echo $InsertSQL;
			
			$InsertQueryRan = mysql_query($InsertSQL);
			
			//echo $InsertQueryRan;
			
			//echo mysql_affected_rows();
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				//include 'processtask.php';
				$message="Task Successfully created";
				echo "<p>$message</p>";
			} else {
				$message="Error in creating the task";
				echo "<p>$message</p>";
				// will continue to form section
			}
			
		}
	}
?>

		<form action='<?php echo $_SERVER['PHP_SELF'].'?page='.$page.'&tag=createtask' ?>' method='POST' name='createtaskform' >
			<table align=center>
				<tr><td>Task description:</td><td><textarea cols='50' rows='2' name='task_description'  class="vform"></textarea></td></tr>
				
				<tr><td>Task classification:</td><td><select name="task_classification_id" size=1 class="vform" >
										<?php
											echo DropDownLookupFiltered('tbl_setup_task_classifications','task_classification_id','task_classification', "status = 'Active'");
										 ?>
									</select>
									</td></tr>
				<tr><td>Workload:</td><td><select name="workload_classification_id" size=1 class="vform" >
										<?php
											echo DropDownLookupFiltered('tbl_setup_workload_classifications','workload_classification_id','workload_classification', "status = 'Active'");
										 ?>
									</select>
									</td></tr>
				<tr><td>Priority:</td><td><select name="priority_classification_id" size=1  class="vform">
										<?php
											echo DropDownLookupFiltered('tbl_setup_priority_classifications','priority_classification_id','priority_classification', "status = 'Active'", 'id');
										 ?>
									</select>
									</td></tr>
				<tr><td>Deadline:</td><td><select name="DeadlineDay" size=1  class="vform">
										<?php
											echo DateDropDownDay(31);
										 ?>
									</select>
									
									<select name="DeadlineMonth" size=1 class="vform">
											<?php
											echo DateDropDownMonth();
										 ?>						
									</select>
									
									<select name="DeadlineYear" size=1 class="vform" >
										<?php
											echo DateDropDownYear(date("Y"),date("Y")+5);
										 ?>
									</select>
									</td></tr>
									
				<tr><td>Assignee can close?</td><td><select name="assignee_can_close" size=1 class="vform" >
										<?php
											echo YesNoList();
										 ?>
									</select>
									</td></tr>	
				<tr>
				<td colspan=2>
				<input type="hidden" name="command" value="create_task"/>
				<input type='submit' value='Create' class="button" />
				</td></tr>
			</table>
		</form>
		
		<script language="JavaScript" type="text/javascript">
		var frmvalidator = new Validator("createtaskform");
		frmvalidator.addValidation("task_description","req","Please enter a task description");
		</script>
