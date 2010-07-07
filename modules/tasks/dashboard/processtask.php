
<?php
	$current_user_id = $_SESSION['id'];
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functionsspecial.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
    
	if ($task_id == "" ) {
		// coming from attaching something and not creating a task
		$task_id = $_GET['task_id'];
	}
	$command = $_GET['command'];

	if ($command == "attach_existing_entity") {
		// attach the entity to the task		
		$entity_id = PrepareStringForInsert($_POST['entity_id']);
		
		if ($_POST['entity_id'] == "") {
			echo "You have not selected an entity to link";
		} elseif (domain("dcount","entity_id","tbl_task_entities","task_id = ".$task_id." and entity_id = ".$entity_id) > 0 ) {
			echo "That entity is already attached to this task";	
		} else {
			
			$InsertSQL = "INSERT INTO tbl_task_entities (task_id, entity_id) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$task_id.", ".$entity_id.")"; 

			//echo $InsertSQL;
			
			$InsertQueryRan = mysql_query($InsertSQL);
			
			//echo $InsertQueryRan;
			
			//echo mysql_affected_rows();
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Entity successfully linked</P>";
			} else {
				echo "<P>Error linking entity</P>";
			}
		}
	} elseif ($command == "attach_new_entity") {
		$entity_name = PrepareStringForInsert($_POST['entity_name']);
		$entity_type_id = PrepareStringForInsert($_POST['entity_type_id']);
		$postal_address = PrepareStringForInsert($_POST['postal_address']);
		$physical_address = PrepareStringForInsert($_POST['physical_address']);
		$phone_numbers = PrepareStringForInsert($_POST['phone_numbers']);
		$email_addresses = PrepareStringForInsert($_POST['email_addresses']);
		$website = PrepareStringForInsert($_POST['website']);
		
		$HasError = false;
		
		$entity_id = PrepareStringForInsert(GetNextID8Dig("E","entity_id","tbl_entities"));
		//echo $entity_id;
		
		if ($_POST['entity_name'] == "") {
			echo '<p>You cannot leave the entity name blank</p>';
			$HasError = true;
		} elseif (domain('dcount','entity_name','tbl_entities',"entity_name = ".$entity_name) > 0) {
			echo "<p>An entity with the same name (".$entity_name.") has already been saved</p>";
			$HasError = true;
		}
		
		if (!$HasError) {
			// add the entity
			$InsertSQL = "INSERT INTO tbl_entities (entity_id, entity_name, entity_type_id, postal_address, physical_address, phone_numbers, email_addresses, website) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$entity_id.", ".$entity_name.", ".$entity_type_id.", ".$postal_address.", ".$physical_address.", ".$phone_numbers.", ".$email_addresses.", ".$website.")"; 
			
						
			$InsertEntityQueryRan = mysql_query($InsertSQL);

			// attach the entity to the task
			$InsertSQL = "INSERT INTO tbl_task_entities (task_id, entity_id) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$task_id.", ".$entity_id.")"; 

			$InsertLinkQueryRan = mysql_query($InsertSQL);
			
			if ($InsertEntityQueryRan and $InsertLinkQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Entity successfully created and attached</P>";
			} else {
				echo "<P>Error creating or attaching entity</P>";
			}
		}
	} elseif ($command == "attach_existing_document") {
		// attach the document to the task		
		$document_id = $_POST['document_id'];
		
		if ($document_id == "") {
			echo "You have not selected a document to link";
		} elseif (domain("dcount","document_id","tbl_task_documents","task_id = ".$task_id." and document_id = ".$document_id) > 0 ) {
			echo "That document is already attached to this task";	
		} else {
			
			$InsertSQL = "INSERT INTO tbl_task_documents (task_id, document_id) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$task_id.", ".$document_id.")"; 

			//echo $InsertSQL;
			
			$InsertQueryRan = mysql_query($InsertSQL);
			
			//echo $InsertQueryRan;
			
			//echo mysql_affected_rows();
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Document successfully linked</P>";
			} else {
				echo "<P>Error linking document</P>";
			}
		}
		
	} elseif ($command == "attach_new_note") {
		$note_text = PrepareStringForInsert($_POST['note_text']);
		$HasError = false;
		
		$task_note_id = GetNextIDNum("task_note_id","tbl_task_notes");
		
		if ($_POST['note_text'] == "") {
			echo '<p>You cannot leave the note text blank</p>';
			$HasError = true;
		} 
		
		if (!$HasError) {
			// add the not
			$InsertSQL = "INSERT INTO tbl_task_notes (task_note_id, task_id, user_id, date_written, note_text) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$task_note_id.", ".$task_id.", '".$_SESSION['id']."', '".date("Y-m-d H:i:s")."', ".$note_text.")"; 
			
			$InsertQueryRan = mysql_query($InsertSQL);
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Note successfully created</P>";
			} else {
				echo "<P>Error creating note</P>";
			}
		}
	} elseif ($command == "assign") {
		$user_group_id = PrepareStringForInsert($_POST['user_group_id']);
		$task_viewable_by_id = PrepareStringForInsert($_POST['task_viewable_by_id']);
		$HasError = false;
		
		$assignment_id = GetNextIDNum("assignment_id","tbl_assignments");
		
		if ($_POST['user_group_id'] == "") {
			echo '<p>You have not chosen an assignee</p>';
			$HasError = true;
		} 
		
		if (!$HasError) {
			// add the assignment
			$InsertSQL = "INSERT INTO tbl_assignments (assignment_id, task_id, assignment_date, assigned_by, assigned_to, task_viewable_by_id) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$assignment_id.", ".$task_id.", '".date("Y-m-d H:i:s")."', '".$_SESSION['id']."', ".$user_group_id.", ".$task_viewable_by_id.")"; 
			
			//echo $InsertSQL;
			$InsertQueryRan = mysql_query($InsertSQL);
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Assignment successful</P>";
			} else {
				echo "<P>Error assigning</P>";
			}
		}
	
	} elseif ($command == "refer") {
		$user_group_id = PrepareStringForInsert($_POST['user_group_id']);
		$referral_classification_id = PrepareStringForInsert($_POST['referral_classification_id']);
		$task_viewable_by_id = PrepareStringForInsert($_POST['task_viewable_by_id']);
		$HasError = false;
		
		$referral_id = GetNextIDNum("referral_id","tbl_referrals");
		
		if ($_POST['user_group_id'] == "") {
			echo '<p>You have not chosen an referee</p>';
			$HasError = true;
		} 
		
		if (!$HasError) {
			// add the referral
			$InsertSQL = "INSERT INTO tbl_referrals (referral_id, task_id, referral_date, referred_by, referred_to, task_viewable_by_id, referral_classification_id ) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$referral_id.", ".$task_id.", '".date("Y-m-d H:i:s")."', '".$_SESSION['id']."', ".$user_group_id.", ".$task_viewable_by_id.", ".$referral_classification_id.")"; 
			
			$InsertQueryRan = mysql_query($InsertSQL);
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Referral successful</P>";
			} else {
				echo "<P>Error referring</P>";
			}
		}	
	} elseif ($command == "percent_completed") {
		$percent_completed = $_POST['percent_completed'];
		$HasError = false;
		
		if ($percent_completed == "") {
			echo '<p>You have not chosen a percent completed</p>';
			$HasError = true;
		} 
		
		if (!$HasError) {
			// edit the percent completed
			$UpdateSQL = "UPDATE tbl_tasks 
							SET tbl_tasks.percent_completed = ".$percent_completed."
							WHERE task_id = ".$task_id;

			
			$UpdateQueryRan = mysql_query($UpdateSQL);
			
			if ($UpdateQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Update successful</P>";
			} else {
				echo "<P>Error updating</P>";
			}
		}	
	} elseif ($command == "close") {
		$percent_completed = $_POST['percent_completed'];
		$task_closure_classification_id = PrepareStringForInsert($_POST['task_closure_classification_id']);
		$task_outcome_classification_id = PrepareStringForInsert($_POST['task_outcome_classification_id']);
		
		$HasError = false;
		
		if ($_POST['task_closure_classification_id'] == "") {
			echo '<p>You have not chosen a task closure classification</p>';
			$HasError = true;
		} 
		
		if ($_POST['percent_completed'] == "") {
			echo '<p>You have not updated the percent completed</p>';
			$HasError = true;
		} 
		
		if (!$HasError) {
			// edit the closure fields
			$UpdateSQL = "UPDATE tbl_tasks 
							SET tbl_tasks.percent_completed = ".$percent_completed.", 
								tbl_tasks.task_closure_classification_id = ".$task_closure_classification_id.", 
								tbl_tasks.task_outcome_classification_id = ".$task_outcome_classification_id.", 
								tbl_tasks.date_closed = '".date("Y-m-d H:i:s")."'
							WHERE task_id = ".$task_id;

			
			$UpdateQueryRan = mysql_query($UpdateSQL);
			
			if ($UpdateQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Closure successful</P>";
			} else {
				echo "<P>Error closing</P>";
			}
		}	
	}

//*****************************************************************************
//  SHOW DETAILS OF CURRENT TASK
//*****************************************************************************
?>
<table align=center >
<col width="49%">
<col width="2%">
<col width="49%">
<tr class="backshade"><td> <td><td> </td></td> </td></tr>
<?php

	$qry_task_SQL = "SELECT tbl_tasks.*, tbl_setup_task_classifications.task_classification, tbl_setup_workload_classifications.workload_classification, tbl_setup_priority_classifications.priority_classification, DATE_FORMAT(Deadline,'%d %M %Y') AS deadline_formatted, authuser.name, authuser.surname, DATE_FORMAT(date_created,'%d %M %Y') AS date_created_formatted, tbl_setup_task_closure_classifications.task_closure_classification, tbl_setup_task_outcome_classifications.task_outcome_classification, DATE_FORMAT(date_closed,'%d %M %Y') AS date_closed_formatted 
						FROM (((((tbl_tasks LEFT JOIN tbl_setup_task_classifications ON tbl_tasks.task_classification_id = tbl_setup_task_classifications.task_classification_id) LEFT JOIN tbl_setup_workload_classifications ON tbl_tasks.workload_classification_id = tbl_setup_workload_classifications.workload_classification_id) LEFT JOIN tbl_setup_priority_classifications ON tbl_tasks.priority_classification_id = tbl_setup_priority_classifications.priority_classification_id) INNER JOIN authuser ON tbl_tasks.created_by = authuser.id) LEFT JOIN tbl_setup_task_closure_classifications ON tbl_tasks.task_closure_classification_id = tbl_setup_task_closure_classifications.task_closure_classification_id) LEFT JOIN tbl_setup_task_outcome_classifications ON tbl_tasks.task_outcome_classification_id = tbl_setup_task_outcome_classifications.task_outcome_classification_id
						WHERE tbl_tasks.task_id=".$task_id;

	//echo $qry_task_SQL;
	$qry_task_result = mysql_query($qry_task_SQL);

	if (!$qry_task_result) {
			exit('<p>Error performing task query: '.mysql_error().'</p>');
	} else {
		While ($qry_task_row = mysql_fetch_array($qry_task_result)) {
			// variables needed in rest of page
			$assignee_can_close = $qry_task_row['assignee_can_close'];
			$is_closed = $qry_task_row['date_closed'] <> '';
			$task_classification_id = $qry_task_row['task_classification_id'];
			$TaskOutcomeRelevant = domain("dcount","task_outcome_classification_id","tbl_setup_task_outcome_classifications","task_classification_id ='".$task_classification_id."'") > 0;
			$percent_completed = $qry_task_row['percent_completed'];
			?>
			
			<tr><td>
			<table >
			<tr class="bold"><td>Task description:</td><td><?php echo $qry_task_row['task_description'] ?></td></tr>
			<tr><td>Task classification:</td><td><?php echo $qry_task_row['task_classification'] ?></td></tr>
			<tr><td>Workload:</td><td><?php echo $qry_task_row['workload_classification'] ?></td></tr>
			<tr><td>Priority:</td><td><?php echo $qry_task_row['priority_classification'] ?></td></tr>
			<tr><td>Deadline:</td><td><?php echo $qry_task_row['deadline_formatted'] ?></td></tr>
			<tr><td>Date created:</td><td><?php echo $qry_task_row['date_created_formatted'] ?></td></tr>
			<tr><td>Created by:</td><td><?php echo $qry_task_row['name'].' '.$qry_task_row['surname'] ?></td></tr>
			<tr class="bold"><td>Currently assigned to:</td><td><?php echo currently_assigned_to($task_id, "name") ?></td></tr>
			<tr><td>Percent completed:</td><td><?php echo $qry_task_row['percent_completed'] ?>%</td></tr>
			<?php
				if ($TaskOutcomeRelevant == true) {
			?>
			<tr><td>Task outcome:</td><td><?php echo $qry_task_row['task_outcome_classification'] ?></td></tr>
			<?php
				}
			?>
			<tr><td>Task closure:</td><td><?php echo $qry_task_row['task_closure_classification'] ?></td></tr>
			<tr><td>Date closed:</td><td><?php echo $qry_task_row['date_closed_formatted'] ?></td></tr>
			</table>
			
			</td><td></td> <td>
			
			<table>
			
			<tr><td>Assignment history:</td><td>
			<table class="smallneat">
			<?php
			// show the assignments
			$qry_assignment_SQL = "SELECT tbl_assignments.task_id, tbl_assignments.assignment_date, qry_users_groups_all_desc.user_group_desc AS assigned_to_desc, concat(name,' ',surname) AS assigned_by_desc, DATE_FORMAT(assignment_date,'%d-%b-%y') as assignment_date_formatted
									FROM authuser INNER JOIN (tbl_assignments INNER JOIN (".$qry_users_groups_all_desc_SQL.") as qry_users_groups_all_desc ON tbl_assignments.assigned_to = qry_users_groups_all_desc.user_group_id) ON authuser.id = tbl_assignments.assigned_by
									WHERE tbl_assignments.task_id=".$task_id."
									ORDER BY tbl_assignments.assignment_date";

								  
			$qry_assignment_result = mysql_query($qry_assignment_SQL);
		
			if (!$qry_assignment_result) {
					exit('<p>Error performing referral query: '.mysql_error().'</p>');
			} else {
				While ($qry_assignment_row = mysql_fetch_array($qry_assignment_result)) {
					echo '<tr><td>'.$qry_assignment_row['assigned_by_desc'].'</td><td>to</td><td>'.$qry_assignment_row['assigned_to_desc'].'</td><td>'.$qry_assignment_row['assignment_date_formatted'].'</td></tr>';
				}
			}
			?>
			</table>
			</td></tr>
			
			<tr><td>Referrals:</td><td>
			<table class="smallneat">
			<?php
			// show the referrals
			$qry_referral_SQL = "SELECT tbl_referrals.task_id, tbl_referrals.referral_date, tbl_setup_referral_classifications.referral_classification, qry_users_groups_all_desc.user_group_desc AS referred_to_desc, concat(name,' ',surname) AS referred_by_desc, DATE_FORMAT(referral_date,'%d-%b-%y') as referral_date_formatted
									FROM authuser INNER JOIN (tbl_setup_referral_classifications RIGHT JOIN (tbl_referrals INNER JOIN (".$qry_users_groups_all_desc_SQL.") as qry_users_groups_all_desc ON tbl_referrals.referred_to = qry_users_groups_all_desc.user_group_id) ON tbl_setup_referral_classifications.referral_classification_id = tbl_referrals.referral_classification_id) ON authuser.id = tbl_referrals.referred_by
									WHERE task_id = ".$task_id."
									 ORDER BY referral_date";
								  
			$qry_referral_result = mysql_query($qry_referral_SQL);
		
			if (!$qry_referral_result) {
					exit('<p>Error performing referral query: '.mysql_error().'</p>');
			} else {
				While ($qry_referral_row = mysql_fetch_array($qry_referral_result)) {
					echo '<tr><td>'.$qry_referral_row['referred_by_desc'].'</td><td>to</td><td>'.$qry_referral_row['referred_to_desc'].'</td><td>'.$qry_referral_row['referral_date_formatted'].'</td><td>'.$qry_referral_row['referral_classification'].'</td></tr>';
				}
			}
			?>
			</table>
			</td></tr>
			
			<tr><td>External links:</td><td>
			<table>
			<?php	
			// show the linked entities
			$qry_entity_SQL = "SELECT tbl_task_entities.task_id, tbl_task_entities.entity_id, tbl_entities.entity_name, tbl_setup_entity_types.entity_type 
								FROM tbl_task_entities INNER JOIN tbl_entities ON (tbl_task_entities.entity_id = tbl_entities.entity_id)
  														LEFT JOIN tbl_setup_entity_types ON (tbl_entities.entity_type_id = tbl_setup_entity_types.entity_type_id)
								 WHERE task_id=".$task_id."
								  ORDER BY entity_name";
			$qry_entity_result = mysql_query($qry_entity_SQL);
		
			if (!$qry_entity_result) {
					exit('<p>Error performing entity query: '.mysql_error().'</p>');
			} else {
				While ($qry_entity_row = mysql_fetch_array($qry_entity_result)) {
					echo '<tr><td>'.$qry_entity_row['entity_name'].'</td><td>'.$qry_entity_row['entity_type'].'</td></tr>';
				}
			}
			?>
			</table>
			</td></tr>
			
		
			<tr><td>Document links:</td><td>
			<table>
			<?php
			// show the linked documents
			$qry_document_SQL = "SELECT tbl_task_documents.task_id, tbl_documents.document_id, tbl_documents.document_description, tbl_documents.document_classification_id, tbl_setup_document_classifications.document_classification, tbl_documents.document_status, tbl_documents.document_file_name 
								  FROM (tbl_setup_document_classifications RIGHT JOIN tbl_documents ON tbl_setup_document_classifications.document_classification_id = tbl_documents.document_classification_id) INNER JOIN tbl_task_documents ON tbl_documents.document_id = tbl_task_documents.document_id 
								 WHERE task_id=".$task_id."
								 ORDER BY document_description";
			$qry_document_result = mysql_query($qry_document_SQL);
		
			if (!$qry_document_result) {
					exit('<p>Error performing document query: '.mysql_error().'</p>');
			} else {
				While ($qry_document_row = mysql_fetch_array($qry_document_result)) {
					$filename = $qry_document_row['document_file_name'];
					echo '<tr class="islink" onClick="window.open(\''.$uploaddirrel.$filename.'\')">';
					echo '<td>'.$qry_document_row['document_description']."</td><td>".$qry_document_row['document_classification']."</td><td>".$qry_document_row['document_status'].'</td></tr>';
				}
			}
			
			?>
			</table>
			</td></tr>
			
			<tr><td>Notes:</td><td>
			<table>
			<?php
			// show the notes
			$qry_note_SQL = "SELECT tbl_task_notes.note_text, authuser.name, authuser.surname, DATE_FORMAT(date_written,'%d %M %Y') AS date_written_formatted
								FROM authuser INNER JOIN tbl_task_notes ON authuser.id = tbl_task_notes.user_id
								 WHERE task_id=".$task_id."
								  ORDER BY date_written, surname, name, note_text";
								  
			$qry_note_result = mysql_query($qry_note_SQL);
		
			if (!$qry_note_result) {
					exit('<p>Error performing note query: '.mysql_error().'</p>');
			} else {
				While ($qry_note_row = mysql_fetch_array($qry_note_result)) {
					echo '<tr><td>'.$qry_note_row['name']." ".$qry_note_row['surname']."</td><td>".$qry_note_row['date_written_formatted']."</td><td>".$qry_note_row['note_text']."</td></tr>";
				}
			}
			?>
			</table>
			</td></tr>
			

			
			<?php
		}  // end while
	}  // end of task
	
?>
			</table>
			</td></tr>
			<tr class="backshade"><td> <td><td> </td></td> </td></tr>


<?php
//*****************************************************************************
//  FORMS FOR PROCESSING TASKS
//*****************************************************************************
?>
			
<tr>
<td>

<?php
$user_is_creator = user_is_creator($task_id,$_SESSION['id']);
$user_is_current_assignee_as_user = user_is_current_assignee_as_user($task_id,$_SESSION['id']);
$user_is_current_assignee_as_group_leader = current_user_is_current_assignee_as_group_leader($task_id, $qry_currently_assigned_to_user_as_group_leader_SQL);

//echo $user_is_creator;
//echo $user_is_current_assignee_as_user ;
//echo $user_is_current_assignee_as_group_leader ;

if (!$is_closed) {
?>
	<input type="radio" name="visibility" value="attachentity" onClick="TaskAttachVisibility(document,this.value)"/> Link an external entity/person to this task <br>
	<input type="radio" name="visibility" value="attachdocument" onClick="TaskAttachVisibility(document,this.value)"/> Link a document to this task <br>
	<input type="radio" name="visibility" value="attachnewnote" onClick="TaskAttachVisibility(document,this.value)"/> Write a note on this task <br>
	<input type="radio" name="visibility" value="refer" onClick="TaskAttachVisibility(document,this.value)" /> Refer task <br>
	<?php	if ($user_is_creator or $user_is_current_assignee_as_user or $user_is_current_assignee_as_group_leader) {	?>
			<input type="radio" name="visibility" value="assign" onClick="TaskAttachVisibility(document,this.value)" /> Assign task <br>
	<?php	} ?>
	<?php	if ($user_is_current_assignee_as_user or $user_is_current_assignee_as_group_leader) {	?>
			<input type="radio" name="visibility" value="percentcompleted" onClick="TaskAttachVisibility(document,this.value)" /> Edit percent completed <br>
	<?php	} ?>
	<?php	if ($user_is_creator or (($user_is_current_assignee_as_user or $user_is_current_assignee_as_group_leader) and $assignee_can_close)) {	?>
		<input type="radio" name="visibility" value="close" onClick="TaskAttachVisibility(document,this.value)" /> Close task <br>
	<?php	}
} ?>

</td><td></td> <td>

<div id="attachentity" style="display:none">
	<input type="radio" id="attachexistingentityoption" name="visibilityentity" value="attachexistingentity" onClick="TaskAttachVisibility(document,this.value)" /> Link an existing external entity/person to this task <br>
	<input type="radio" name="visibilityentity" value="attachnewentity" onClick="TaskAttachVisibility(document,this.value)"/> Link a new external entity/person to this task <br>
</div>

<div id="attachexistingentity" style="display:none">
	<br>
	Search:
	<input type="text" onKeyUp="ShowEntities(this.value)" class="vform">
	<script languauge="JavaScript">
	ShowEntities('')
	</script>
	<div id='entity_list' class='ListBox'>

	</div>
	<?php
	echo '<form name="attach_existing_entity_form" method="Post" action="'. $dashboardPage.'&tag=processtask&task_id='.$task_id.'&command=attach_existing_entity">';
	?>
	<input type="text" id="entity_id" name="entity_id" class="vform" style="display:none"/>
	<input type="submit" value="Link" class="button" />
	</form>
</div>

<div id="attachnewentity" style="display:none">

	<?php
	echo '<form name="attach_new_entity_form" method="Post" action="'. $dashboardPage.'&tag=processtask&task_id='.$task_id.'&command=attach_new_entity">';
	?>
	<table>
	<tr><td>Name:</td><td><input type="text" name="entity_name" class="vform"/></td></tr>
	<tr><td>Type:</td><td><select name="entity_type_id" size=1 class="vform" >
										<?php
											echo DropDownLookupFiltered('tbl_setup_entity_types','entity_type_id','entity_type',"status ='Active'");
										 ?>
									</select>
									</td></tr>
	<tr><td>Postal address:</td><td><input type="text" name="postal_address" class="vform"/></td></tr>
	<tr><td>Physical address:</td><td><input type="text" name="physical_address" class="vform"/></td></tr>
	<tr><td>Phone numbers:</td><td><input type="text" name="phone_numbers" class="vform"/></td></tr>
	<tr><td>Email addresses:</td><td><input type="text" name="email_addresses" class="vform"/></td></tr>
	<tr><td>Website:</td><td><input type="text" name="website" class="vform"/></td></tr>
	</table>
	<input type="submit" value="Link" class="button" />
	</form>
	
	<script language="JavaScript" type="text/javascript">
		var frmvalidator = new Validator("attach_new_entity_form");
		frmvalidator.addValidation("entity_name","req","Please enter an entity name");
		</script>
</div>

<div id="attachdocument" style="display:none">
	<p>Search for a document:</p>
	<script languauge="JavaScript">
		ShowDocuments('','<?php echo $current_user_id ?>')
	</script>
	<input type="text" class="vform" onKeyUp="ShowDocuments(this.value,'<?php echo $current_user_id ?>')">
	
	<div id='document_list' class='ListBox'>

	</div>
	<?php
	echo '<form name="attach_existing_document_form" method="Post" action="'. $dashboardPage.'&tag=processtask&task_id='.$task_id.'&command=attach_existing_document">';
	?>
	<input type="text"  class="vform"id="document_id" name="document_id" style="display:none"/>
	<input type="submit" value="Link" class="button" />
	</form>
</div>

<div id="attachnewnote" style="display:none">
	Add a new note:
	<?php
	echo '<form name="attach_new_note_form" method="Post" action="'. $dashboardPage.'&tag=processtask&task_id='.$task_id.'&command=attach_new_note">';
	?>
	<table>
	<tr><td>Note:</td><td><textarea height=3 name="note_text" class="vform"></textarea></td></tr>
	</table>
	<input type="submit" value="Link" class="button" />
	</form>
	
	<script language="JavaScript" type="text/javascript">
		var frmvalidator = new Validator("attach_new_note_form");
		frmvalidator.addValidation("note_text","req","Please enter text in the note");
	</script>
</div>


<div id="assign" style="display:none">
	<p>Search for staff / staff groups:</p>
	<script languauge="JavaScript">
		ShowUsersGroups("","assign",'<?php echo $current_user_id ?>');
	</script>
	<input type="text" class="vform" onKeyUp="ShowUsersGroups(this.value,'assign','<?php echo $current_user_id ?>')">
	
	<div id='user_group_list_assign' class='ListBox'>

	</div>
	<?php
	echo '<form name="assign_form" method="Post" action="'. $dashboardPage.'&tag=processtask&task_id='.$task_id.'&command=assign">';
	?>
	<input type="text" class="vform" id="user_group_id_assign" name="user_group_id" style="display:none" />
	
	<div id="viewable_by_prompt_assign" style="visibility:hidden">
	Task viewable by: <select id="task_viewable_by_id_assign" name="task_viewable_by_id" size=1 class="vform" >
										<?php
											echo DropDownLookup('tbl_list_task_viewable_by','task_viewable_by_id','task_viewable_by');
										 ?>
									</select>
	</div>
	<input type="submit" value="Assign" class="button" />
	</form>
</div>

<div id="refer" style="display:none">
	<p>Search for staff / staff groups:</p>
	<script languauge="JavaScript">
		ShowUsersGroups("","refer",'<?php echo $current_user_id ?>');
	</script>
	<input type="text" class="vform" onKeyUp="ShowUsersGroups(this.value,'refer','<?php echo $current_user_id ?>')">
	
	<div id='user_group_list_refer' class='ListBox'>

	</div>
	<?php
	echo '<form name="refer_form" method="Post" action="'. $dashboardPage.'&tag=processtask&task_id='.$task_id.'&command=refer">';
	?>
	<input type="text" class="vform" id="user_group_id_refer" name="user_group_id" style="display:none"/>
	
	Referral type: <select name="referral_classification_id" size=1 class="vform" >
										<?php
											echo DropDownLookupFiltered('tbl_setup_referral_classifications','referral_classification_id','referral_classification',"status ='Active'");
										 ?>
									</select>
	
	<div id="viewable_by_prompt_refer" style="visibility:hidden">
	Task viewable by: <select id="task_viewable_by_id_refer" name="task_viewable_by_id" size=1 class="vform" >
										<?php
											echo DropDownLookup('tbl_list_task_viewable_by','task_viewable_by_id','task_viewable_by');
										 ?>
									</select>
	</div>
	<input type="submit" value="Refer" class="button" />
	</form>
</div>

<div id="percentcompleted" style="display:none">
	<?php
	echo '<form name="percent_completed_form" method="Post" action="'. $dashboardPage.'&tag=processtask&task_id='.$task_id.'&command=percent_completed">';
	?>
	<table>
	<tr><td>Percent completed:</td><td><select name="percent_completed" size=1 class="vform" >
										<?php
											echo DropDownTo100($percent_completed).'%';
										 ?>
									</select>%
									</td></tr>
	</table>
	<input type="submit" value="Edit" class="button" />
	</form>
	<script language="JavaScript" type="text/javascript">
		var frmvalidator = new Validator("percent_completed_form");
		frmvalidator.addValidation("percent_completed","req","Please choose a percent completed");
	</script>
</div>

<div id="close" style="display:none">
	<?php
	echo '<form name="close_form" method="Post" action="'. $dashboardPage.'&tag=processtask&task_id='.$task_id.'&command=close">';
	?>
	<table>
	<tr><td>Percent completed:</td><td><select name="percent_completed" size=1 class="vform" >
										<?php
											echo DropDownTo100($percent_completed).'%';
										 ?>
									</select>%
									</td></tr>
	<?php

	if ($TaskOutcomeRelevant == true) {
	?>
	<tr><td>Task Outcome:</td><td><select name="task_outcome_classification_id" size=1 class="vform" >
										<?php
											echo DropDownLookupFiltered('tbl_setup_task_outcome_classifications','task_outcome_classification_id','task_outcome_classification',"status = 'Active' and task_classification_id='".$task_classification_id."'");
										 ?>
									</select>
									</td></tr>
	<?php
	}
	?>
	<tr><td>Task Closure:</td><td><select name="task_closure_classification_id" size=1 class="vform" >
										<?php
											if (user_is_creator($task_id,$current_user_id)) {
												echo DropDownLookupFiltered('tbl_setup_task_closure_classifications','task_closure_classification_id','task_closure_classification', "status = 'Active'");
											} else {
												echo DropDownLookupFiltered('tbl_setup_task_closure_classifications','task_closure_classification_id','task_closure_classification', "status = 'Active' and task_closure_classification_id <> 'voi'");
											}
										 ?>
									</select>
									</td></tr>
	</table>
	<input type="submit" value="Close task" class="button" />
	</form>
	<script language="JavaScript" type="text/javascript">
		var frmvalidator = new Validator("close_form");
		frmvalidator.addValidation("task_closure_classification_id","req","Please choose a closure classification");
	</script>
</div>

</td>
</tr></table>

