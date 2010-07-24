<?php
	$current_user_id = $_SESSION['id'];
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functions.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
	
	function get_task_classification($task_classification_id) {
		$task_classification_string="SELECT task_classification FROM tbl_setup_task_classifications WHERE task_classification_id = '" . $task_classification_id ."'";
		$task_classification_query = mysql_query($task_classification_string);
		$task_classification = mysql_fetch_array($task_classification_query) or die( mysql_error() );
		$result = $task_classification['task_classification'];
		if( !empty($result) ) return $result;
		else return "nothing";
	};
	function get_workload_classification($workload_classification_id) {
		$workload_classification_string="SELECT workload_classification FROM tbl_setup_workload_classifications WHERE workload_classification_id = '" . $workload_classification_id ."'";
		$workload_classification_query = mysql_query($workload_classification_string);
		$workload_classification = mysql_fetch_array($workload_classification_query) or die( mysql_error() );
		$result = $workload_classification['workload_classification'];
		if( !empty($result) ) return $result;
		else return "nothing";
	};
	function get_priority_classification($priority_classification_id) {
		$priority_classification_string="SELECT priority_classification FROM tbl_setup_priority_classifications WHERE priority_classification_id = '" . $priority_classification_id ."'";
		$priority_classification_query = mysql_query($priority_classification_string);
		$priority_classification = mysql_fetch_array($priority_classification_query) or die( mysql_error() );
		$result = $priority_classification['priority_classification'];
		if( !empty($result) ) return $result;
		else return "nothing";
	};

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
					
	echo "<p>". $_GET['message'] . "</p>";
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
	<div class="scrolldown">
	<table class="sorted" style="font-size:90%">
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
					if ($openclosestatus != "open") {
						echo '	<th id="closure">Task closure</th>';
						echo '	<th id="closuredate">Date closed</th>';
					}
				?>	
		</tr>
		</thead>
		<tbody>
		<?php
		$qry_task_result = mysql_query($qry_task_SQL);
		if (!$qry_task_result) {
				exit('<p>Error performing task query: '.mysql_error().'</p>');
		}
		else {
			
			if (mysql_num_rows($qry_task_result) == 0) {
				echo "<P  class='centered'>No tasks meet the filter criteria</P>";
			}
			else {
				for( $incr=0; $incr< mysql_num_rows($qry_task_result); $incr++) {
					$row = mysql_fetch_array($qry_task_result);
					echo '<tr class="pointer" onClick="document.location.href=\''.$dashboardPage .'&tag=processtask&task_id='.$row['task_id'].'\'">';
						echo "<td>". $row['task_description'] ."</td>";
						echo "<td>". get_task_classification( $row['task_classification_id'] ) . "</td>";
						echo "<td>". get_workload_classification( $row['workload_classification_id'] ) ."</td>";
						echo "<td>". get_priority_classification( $row['priority_classification_id'] ) ."</td>";
						echo "<td>". $row['deadline'] ."</td>";
						echo "<td>". $row['created_by'] ."</td>";
						echo "<td>". $row['date_created'] ."</td>";
						echo "<td>". $row['percent_completed'] ."%</td>";
						if( $openclosestatus != "open" ) {
							echo "<td>". $row['task_closure_classification'] . "</td>";
							echo "<td>". $row['date_closed_formatted'] . "</td>";
						};
					echo "</tr>";
				};
			};
		}
	?>
	</tbody>
	</table>
	</div>
