<?php
@include_once('connect.inc.php');
function currently_assigned_to ($task_id, $return_option) {

	if (domain("dcount","assignment_id","tbl_assignments","task_id = ".$task_id) == 0) {
		// not yet assigned to anyone therefore assigned to creator
		$assigned_to_id = domain("dfirst","created_by","tbl_tasks","task_id = ".$task_id); 
	} else {
		// has been assigned
		$recent_assign_date = domain("dmax","assignment_date","tbl_assignments","task_id = ".$task_id);
		$assigned_to_id = domain("dfirst","assigned_to","tbl_assignments","assignment_date = '".$recent_assign_date."' and task_id = ".$task_id);
	}


	
	if ($return_option == "id") {
		return $assigned_to_id;
	} elseif ($return_option == "name") {
		if ((substr($assigned_to_id,0,1) != "U")&&(substr($assigned_to_id,0,1) != "G") ){//changed
			$assigned_to_name = domain("dfirst","concat(name, ' ', surname)", "authuser","id = '".$assigned_to_id."'");
		} elseif (substr($assigned_to_id,0,1) == "G") {
			$assigned_to_group_name = domain("dfirst","group_name", "tbl_groups","group_id = '".$assigned_to_id."'");		
			$group_leader_name = group_leader($assigned_to_id, "name");
			$assigned_to_name = $assigned_to_group_name." (led by ".$group_leader_name.")";
		}
		return $assigned_to_name;
	}
}

function group_leader($group_id, $return_option) {
	$number_of_leaders = domain("dcount","member_id","tbl_group_membership","group_id = '".$group_id."' and role_in_group_type = 'Leader'");
	if ($number_of_leaders == 0) {
		return "no leader";
	} elseif ($number_of_leaders > 1) {
		return "multiple leaders";
	} else {
		$leader_id = domain("dfirst","member_id","tbl_group_membership","group_id = '".$group_id."' and role_in_group_type = 'Leader'");
	}
	
	if ($return_option == "id") {
		return $leader_id;
	} elseif ($return_option == "name") {
		if (substr($leader_id,0,1) == "U") {
			$leader_name = domain("dfirst","concat(name, ' ', surname)", "authuser","id = '".$leader_id."'");
		} 
		return $leader_name;
	}
	
}

function user_is_creator($task_id,$user_id) {
	$creator_of_this_task = domain("dfirst","created_by","tbl_tasks","task_id = ".$task_id);
	return $creator_of_this_task == $user_id;
}

function user_is_current_assignee_as_user($task_id,$user_id) {
	$current_assignee_id = currently_assigned_to($task_id, "id");
	return  $current_assignee_id == $user_id;
}

function current_user_is_current_assignee_as_group_leader($task_id,$qry_currently_assigned_to_user_as_group_leader_SQL) {
	return domain("dcount","task_id","(".$qry_currently_assigned_to_user_as_group_leader_SQL.") as qry_currently_assigned_to_user_as_group_leader","task_id = ".$task_id) > 0;
}



?>
