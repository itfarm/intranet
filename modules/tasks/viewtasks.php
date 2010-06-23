<?php 
	include_once('config.php');
	include_once('config_imported/connect.inc.php');
	include_once('config_imported/coresql.inc.php');
	include_once('config_imported/functionsdate.inc.php');
	include_once('config_imported/functionsgeneral.inc.php');
	include_once('config_imported/functions.inc.php');
	// initialize host and database
    include_once('config_imported/settings.inc.php');
	
	// security
	//	auth_checkgroup_and_exit('Admin');
	
	// include the header
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet,$szHeaderPath,$szFooterPath;

	$szSection = 'Navigation Manager';
	$szTitle = 'View Task';
	$szSubSection = 'Task';
	$szSubSubSection = 'View Task';

	$openclosestatus = $_POST['openclosestatus'];
	$taskrelationship = $_POST['taskrelationship'];

	// default values
	if ($openclosestatus == "") {
		$openclosestatus = "open";
	}

	if ($taskrelationship == "") {
		$taskrelationship = "all";
	}

	switch ($openclosestatus) {
		case "open":
			$condition_open_close = "date_closed is null";
			break;
		case "closed":
			$condition_open_close = "date_closed is not null";
			break;
		case "all":
			$condition_open_close = "1=1";
			break;
	}

	switch ($taskrelationship) {
		case "all":
			$condition_relationship = "1=1";
			break;
		case "assignedto":
			$condition_relationship = "currently_assigned_to_user or currently_assigned_to_user_as_group_leader or currently_assigned_to_user_as_group_member";
			break;
		case "assignedby":
			$condition_relationship = "ever_assigned_by_user";
			break;
		case "created":
			$condition_relationship = "ever_created_by_user";
			break;

	}


$qry_task_SQL = "SELECT tbl_tasks.*, 
						ever_created_by_user, 
						ever_assigned_by_user, 
						ever_referred_to_user, 
						ever_referred_to_user_as_group_leader, 
						ever_referred_to_user_as_group_member, 
						currently_assigned_to_user, 
						currently_assigned_to_user_as_group_leader,
						currently_assigned_to_user_as_group_member,
						tbl_setup_task_classifications.task_classification, 
						tbl_setup_workload_classifications.workload_classification, 
						tbl_setup_priority_classifications.priority_classification, 
						authuser.name, authuser.surname, 
						tbl_setup_task_closure_classifications.task_closure_classification, 
						tbl_setup_task_outcome_classifications.task_outcome_classification, 
						DATE_FORMAT(date_created,'%d-%b-%y') AS date_created_formatted, 
						DATE_FORMAT(Deadline,'%d-%b-%y') AS deadline_formatted, 
						DATE_FORMAT(date_closed,'%d-%b-%y') AS date_closed_formatted
						FROM (
								authuser INNER JOIN (
									(
										(
											(
												(
													tbl_tasks LEFT JOIN tbl_setup_task_classifications ON
													tbl_tasks.task_classification_id = tbl_setup_task_classifications.task_classification_id
												)
												LEFT JOIN tbl_setup_workload_classifications ON
												tbl_tasks.workload_classification_id = tbl_setup_workload_classifications.workload_classification_id
											)
											LEFT JOIN tbl_setup_priority_classifications ON
											tbl_tasks.priority_classification_id = tbl_setup_priority_classifications.priority_classification_id
										)
										LEFT JOIN tbl_setup_task_closure_classifications ON
										tbl_tasks.task_closure_classification_id = tbl_setup_task_closure_classifications.task_closure_classification_id
									)
									LEFT JOIN tbl_setup_task_outcome_classifications ON
									tbl_tasks.task_outcome_classification_id = tbl_setup_task_outcome_classifications.task_outcome_classification_id
								)
							ON authuser.id = tbl_tasks.created_by
						)
						INNER JOIN (".$qry_related_to_user_relationship_SQL.") as qry_related_to_user_relationship ON
						tbl_tasks.task_id = qry_related_to_user_relationship.task_id
					WHERE ".$condition_open_close." AND ".$condition_relationship." 
					ORDER BY currently_assigned_to_user desc, currently_assigned_to_user_as_group_leader desc,
					currently_assigned_to_user_as_group_member, priority_classification_id, deadline";

?>

	

<form name="filter_form" method="POST" action="<?php echo $homePage ?>">
	<table>		
		<tr><td>Open/Closed:</td><td><select name="openclosestatus" size=1 class="vform"  >
							<option value='open' <?php if ($openclosestatus=='open') {echo 'selected="selected"';}?> >Open tasks only</option>
							<option value='closed' <?php if ($openclosestatus=='closed') {echo 'selected="selected"';}?>>Closed tasks only</option>
							<option value='all' <?php if ($openclosestatus=='all') {echo 'selected="selected"';}?>>Open and closed tasks</option>
				</select>
				</td></tr>
		<tr><td>Your relationship to task:</td><td><select name="taskrelationship" size=1 class="vform"  >
							<option value='all' <?php if ($taskrelationship=='open') {echo 'selected="selected"';}?>>All tasks related to you</option>";
							<option value='assignedto' <?php if ($taskrelationship=='assignedto') {echo 'selected="selected"';}?>>Tasks now assigned TO you</option>";
							<option value='assignedby' <?php if ($taskrelationship=='assignedby') {echo 'selected="selected"';}?>>Tasks ever assigned BY you</option>";
							<option value='created' <?php if ($taskrelationship=='created') {echo 'selected="selected"';}?>>Tasks created by you</option>";
				</select>
				</td></tr>		
		<tr><td colspan=2 style="text-align:centre">

			<input type="submit" value="Filter" class="button" />
			</td></tr>
	</table>
</form>	

		
	<table class="sorted" style="font-size:90%">
			<COL><COL><COL><COL><COL><COL><COL><COL>
			<?php
				if ($openclosestatus <> "open") {
				?>
					<COL><COL>
				<?php
				}
			?>
			<COL width=12><COL width=12><COL width=12><COL width=12><COL width=12><COL width=12><COL width=12><COL width=12>
	<thead>
	<tr>
			<th id="desc">Task description</th>
			<th id="classification">Task classification</th>
			<th id="workload">Workload</th>
			<th id="priority">Priority</th>
			<th id="deadline">Deadline</th>
			<th id="datecreated">Date created</th>
			<th id="currentlyassignedto">Currently assigned to</th>
			<th id="percentcompleted">% done</th>
			<?php
				if ($openclosestatus <> "open") {
				?>
				<th id="closure">Task closure</th>
				<th id="closuredate">Date closed</th>
				<?php
				}
			?>
			<th id="ever_created_by_user" class="ever_created_by_user1"> </th>	
			<th id="ever_assigned_by_user" class="ever_assigned_by_user1"> </th>
			<th id="ever_referred_to_user" class="ever_referred_to_user1"> </th>
			<th id="ever_referred_to_user_as_group_leader" class="ever_referred_to_user_as_group_leader1"> </th>
			<th id="ever_referred_to_user_as_group_member" class="ever_referred_to_user_as_group_member1"> </th>
			<th id="currently_assigned_to_user" class="currently_assigned_to_user1"> </th>
			<th id="currently_assigned_to_user_as_group_leader" class="currently_assigned_to_user_as_group_leader1"> </th>
			<th id="currently_assigned_to_user_as_group_member" class="currently_assigned_to_user_as_group_member1"> </th>
			
	</tr>
	</thead>
	<tbody>
	<?php
	$qry_task_result = mysql_query($qry_task_SQL);

	if (!$qry_task_result) {
			exit('<p>Error performing task query: '.mysql_error().'</p>');
	} else {
		//$i = 0;
		
		if (mysql_num_rows($qry_task_result) == 0) {
			echo "<P  class='centered'>No tasks meet the filter criteria</P>";
			//exit;	
		}	
		
		While ($qry_task_row = mysql_fetch_array($qry_task_result)) {
			// Temp:To be implemented later.
			//echo '<tr onClick="document.location.href=\'../admin/index.php?task_id='.$qry_task_row['task_id'].'&page=process_task\'" >';
			?>

			<td axis="string" headers="desc">
				<?php echo $qry_task_row['task_description'] ?></td>
			<td axis="string" headers="classification">
				<?php echo $qry_task_row['task_classification'] ?></td>
			<td axis="string" headers="workload" 
				title="<?php echo $qry_task_row['workload_classification_id'] ?>">
				<?php echo $qry_task_row['workload_classification'] ?></td>
			<td axis="string" headers="priority" 
				title="<?php echo $qry_task_row['priority_classification_id'] ?>">
				<?php echo $qry_task_row['priority_classification'] ?></td>			
			<td axis="date" headers="deadline" 
				title="<?php echo NullToLateDate(substr($qry_task_row['deadline'],0,10)) ?>">
				<?php echo $qry_task_row['deadline_formatted'] ?></td>
			<td axis="date" headers="datecreated" 
				title="<?php echo NullToEarlyDate(substr($qry_task_row['date_created'],0,10)) ?>">
				<?php echo $qry_task_row['date_created_formatted'] ?></td>
			<td axis="string" headers="currentlyassignedto">
				<?php echo currently_assigned_to($qry_task_row['task_id'], "name") ?></td>
			<td axis="number" headers="percentcompleted" style="text-align:right" 
				title="<?php echo $qry_task_row['percent_completed'] ?>">
				<?php echo $qry_task_row['percent_completed'] ?>%</td>
	
			<?php
				if ($openclosestatus <> "open") {
				?>
					<td axis="string" headers="closure">
						<?php echo $qry_task_row['task_closure_classification'] ?></td>
					<td axis="date" headers="closuredate" title="
						<?php echo NullToEarlyDate(substr($qry_task_row['date_closed'],0,10)) ?>">
						<?php echo $qry_task_row['date_closed_formatted'] ?></td>
				<?php
				}
			?>
				
			<td headers="ever_created_by_user" 
				class="ever_created_by_user<?php echo $qry_task_row['ever_created_by_user'] ?>"
				title="-<?php echo $qry_task_row['ever_created_by_user'] ?>"> <?php echo $qry_task_row['ever_created_by_user'] ?> </td>
			<td headers="ever_assigned_by_user" 
				class="ever_assigned_by_user<?php echo $qry_task_row['ever_assigned_by_user'] ?>"
				title="-<?php echo $qry_task_row['ever_assigned_by_user'] ?>"> </td>
			<td headers="ever_referred_to_user" 
				class="ever_referred_to_user<?php echo $qry_task_row['ever_referred_to_user'] ?>"
				title="-<?php echo $qry_task_row['ever_referred_to_user'] ?>"> </td>
			<td headers="ever_referred_to_user_as_group_leader" 
				class="ever_referred_to_user_as_group_leader<?php echo $qry_task_row['ever_referred_to_user_as_group_leader'] ?>"
				title="-<?php echo $qry_task_row['ever_referred_to_user_as_group_leader'] ?>"> </td>
			<td headers="ever_referred_to_user_as_group_member" 
				class="ever_referred_to_user_as_group_member<?php echo $qry_task_row['ever_referred_to_user_as_group_member'] ?>"
				title="-<?php echo $qry_task_row['ever_referred_to_user_as_group_member'] ?>"> </td>
			<td headers="currently_assigned_to_user" 
				class="currently_assigned_to_user<?php echo $qry_task_row['currently_assigned_to_user'] ?>"
				title="-<?php echo $qry_task_row['currently_assigned_to_user'] ?>"> </td>
			<td headers="currently_assigned_to_user_as_group_leader" 
				class="currently_assigned_to_user_as_group_leader<?php echo $qry_task_row['currently_assigned_to_user_as_group_leader'] ?>"
				title="-<?php echo $qry_task_row['currently_assigned_to_user_as_group_leader'] ?>"> </td>
			<td headers="currently_assigned_to_user_as_group_member" 
				class="currently_assigned_to_user_as_group_member<?php echo $qry_task_row['currently_assigned_to_user_as_group_member'] ?>"
				title="-<?php echo $qry_task_row['currently_assigned_to_user_as_group_member'] ?>"> </td>
			
			</tr>

			
			<?php
		}
	}
?>
</tbody>
</table>
	
<?php 
	// include the footer
	//include($szFooterPath);
?>
