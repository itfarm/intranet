<?php


$qry_potential_assignees_SQL = "SELECT assignee_id
								FROM tbl_assignment_privileges
								WHERE user_id = '".$current_user_id."'";


$qry_leaders_SQL = "SELECT tbl_group_membership.*
				FROM tbl_group_membership inner join authuser on tbl_group_membership.member_id = authuser.id 
				Where role_in_group_type = 'Leader'
				AND status = 'Active'";


$qry_leaders_single_SQL = "SELECT qry_leaders.group_id, Count(*) AS NumberOfLeaders
							FROM (".$qry_leaders_SQL.") as qry_leaders
							GROUP BY qry_leaders.group_id
							HAVING Count(*)=1";

$qry_leaders_single_desc_SQL = " SELECT qry_leaders_single.group_id, qry_leaders.member_id AS group_leader_id, concat(name,' ',surname) AS group_leader_name
							FROM ((".$qry_leaders_single_SQL.") as qry_leaders_single INNER JOIN (".$qry_leaders_SQL.") as qry_leaders ON qry_leaders_single.group_id = qry_leaders.group_id) INNER JOIN authuser ON qry_leaders.member_id = authuser.id";

$qry_groups_active_desc_SQL = "SELECT tbl_groups.group_id, tbl_groups.group_name, tbl_groups.group_status, qry_leaders_single_desc.group_leader_id, qry_leaders_single_desc.group_leader_name, IF(IsNull(group_leader_id), group_name, CONCAT(group_name, ' (led by ', group_leader_name, ')')) AS group_desc
								FROM tbl_groups LEFT JOIN (".$qry_leaders_single_desc_SQL.") as qry_leaders_single_desc ON tbl_groups.group_id = qry_leaders_single_desc.group_id
								WHERE tbl_groups.group_status='active'";

$qry_users_active_desc_SQL = "SELECT authuser.id, authuser.name, authuser.surname, concat(name, ' ', surname) AS user_desc, authuser.status
								FROM authuser
								WHERE authuser.status='active'";

$qry_users_groups_active_desc_SQL = " SELECT id as user_group_id, user_desc as user_group_desc
									FROM (".$qry_users_active_desc_SQL.") as qry_users_active_desc
									UNION
									SELECT group_id as user_group_id, group_desc as user_group_desc
									FROM (".$qry_groups_active_desc_SQL.") as qry_groups_active_desc";

$qry_groups_all_desc_SQL = "SELECT tbl_groups.group_id, tbl_groups.group_name, tbl_groups.group_status, qry_leaders_single_desc.group_leader_id, qry_leaders_single_desc.group_leader_name, IF(IsNull(group_leader_id), group_name, CONCAT(group_name, ' (led by ', group_leader_name, ')')) AS group_desc
								FROM tbl_groups LEFT JOIN (".$qry_leaders_single_desc_SQL.") as qry_leaders_single_desc ON tbl_groups.group_id = qry_leaders_single_desc.group_id ";

$qry_users_all_desc_SQL = "SELECT authuser.id, authuser.name, authuser.surname, concat(name, ' ', surname) AS user_desc, authuser.status
								FROM authuser";

$qry_users_groups_all_desc_SQL = " SELECT id as user_group_id, user_desc as user_group_desc
									FROM (".$qry_users_all_desc_SQL.") as qry_users_all_desc
									UNION
									SELECT group_id as user_group_id, group_desc as user_group_desc
									FROM (".$qry_groups_all_desc_SQL.") as qry_groups_all_desc";

$qry_current_assignments_SQL = "SELECT tbl_assignments.task_id, Max(tbl_assignments.assignment_date) AS current_assignment_date
								FROM tbl_assignments
								GROUP BY tbl_assignments.task_id";

$qry_current_assignees_SQL = "SELECT qry_current_assignments.task_id, qry_current_assignments.current_assignment_date, tbl_assignments.assigned_to, tbl_assignments.task_viewable_by_id
							FROM (".$qry_current_assignments_SQL.") as qry_current_assignments INNER JOIN tbl_assignments ON (qry_current_assignments.current_assignment_date = tbl_assignments.assignment_date) AND (qry_current_assignments.task_id = tbl_assignments.task_id)";

$qry_current_assignees_with_creators_SQL = "SELECT tbl_tasks.task_id, IF(IsNull(assigned_to),created_by,assigned_to) AS assignee_id, qry_current_assignees.task_viewable_by_id
											FROM tbl_tasks LEFT JOIN (".$qry_current_assignees_SQL.") as qry_current_assignees ON tbl_tasks.task_id = qry_current_assignees.task_id";


$qry_ever_created_by_user_SQL = "SELECT tbl_tasks.task_id
								FROM tbl_tasks
								WHERE tbl_tasks.created_by='".$current_user_id."'
								AND task_closure_classification_id is null or task_closure_classification_id <> 'Voi'";


$qry_ever_assigned_by_user_SQL = "SELECT tbl_assignments.task_id
								FROM tbl_assignments inner join tbl_tasks on tbl_assignments.task_id = tbl_tasks.task_id
								WHERE tbl_assignments.assigned_by='".$current_user_id."'
								AND task_closure_classification_id is null or task_closure_classification_id <> 'Voi'";


$qry_ever_referred_to_user_SQL = "SELECT tbl_referrals.task_id
								FROM tbl_referrals inner join tbl_tasks on tbl_referrals.task_id = tbl_tasks.task_id
								WHERE tbl_referrals.referred_to='".$current_user_id."'
								AND task_closure_classification_id is null or task_closure_classification_id <> 'Voi'";

$qry_ever_referred_to_user_as_group_leader_SQL = "SELECT tbl_referrals.task_id
													FROM (tbl_referrals INNER JOIN tbl_group_membership ON tbl_referrals.referred_to = tbl_group_membership.group_id) inner join tbl_tasks on tbl_referrals.task_id = tbl_tasks.task_id
													WHERE tbl_group_membership.member_id='".$current_user_id."'
													AND tbl_group_membership.role_in_group_type='Leader'
													AND task_closure_classification_id is null or task_closure_classification_id <> 'Voi'";

$qry_ever_referred_to_user_as_group_member_SQL = "SELECT tbl_referrals.task_id
													FROM (tbl_referrals INNER JOIN tbl_group_membership ON tbl_referrals.referred_to = tbl_group_membership.group_id) inner join tbl_tasks on tbl_referrals.task_id = tbl_tasks.task_id
													WHERE tbl_group_membership.member_id='".$current_user_id."'
													AND tbl_group_membership.role_in_group_type<>'Leader'
													AND tbl_referrals.task_viewable_by_id='GPA'
													AND task_closure_classification_id is null or task_closure_classification_id <> 'Voi'";


$qry_currently_assigned_to_user_SQL = "SELECT qry_current_assignees_with_creators.task_id
								FROM (".$qry_current_assignees_with_creators_SQL.") as qry_current_assignees_with_creators inner join tbl_tasks on qry_current_assignees_with_creators.task_id = tbl_tasks.task_id
								WHERE qry_current_assignees_with_creators.assignee_id='".$current_user_id."'
								AND task_closure_classification_id is null or task_closure_classification_id <> 'Voi'";

$qry_currently_assigned_to_user_as_group_leader_SQL = "SELECT qry_current_assignees_with_creators.task_id
														FROM ((".$qry_current_assignees_with_creators_SQL.") as qry_current_assignees_with_creators INNER JOIN tbl_group_membership ON qry_current_assignees_with_creators.assignee_id = tbl_group_membership.group_id) inner join tbl_tasks on qry_current_assignees_with_creators.task_id = tbl_tasks.task_id 
														WHERE tbl_group_membership.member_id='".$current_user_id."'
														AND tbl_group_membership.role_in_group_type='Leader'
														AND task_closure_classification_id is null or task_closure_classification_id <> 'Voi'";

$qry_currently_assigned_to_user_as_group_member_SQL = "SELECT qry_current_assignees_with_creators.task_id
														FROM ((".$qry_current_assignees_with_creators_SQL.") as qry_current_assignees_with_creators INNER JOIN tbl_group_membership ON qry_current_assignees_with_creators.assignee_id = tbl_group_membership.group_id) inner join tbl_tasks on qry_current_assignees_with_creators.task_id = tbl_tasks.task_id 
														WHERE tbl_group_membership.member_id='".$current_user_id."'
														AND tbl_group_membership.role_in_group_type <>'Leader'
														AND qry_current_assignees_with_creators.task_viewable_by_id='GPA'
														AND task_closure_classification_id is null or task_closure_classification_id <> 'Voi'";


$qry_related_to_user_SQL = "SELECT qry_ever_created_by_user.*
							from (".$qry_ever_created_by_user_SQL.") as qry_ever_created_by_user
							UNION
							SELECT qry_ever_assigned_by_user.*
							from (".$qry_ever_assigned_by_user_SQL.") as qry_ever_assigned_by_user
							UNION
							SELECT qry_ever_referred_to_user.*
							from (".$qry_ever_referred_to_user_SQL.") as qry_ever_referred_to_user
							UNION
							SELECT qry_ever_referred_to_user_as_group_leader.*
							from (".$qry_ever_referred_to_user_as_group_leader_SQL.") as qry_ever_referred_to_user_as_group_leader
							UNION
							SELECT qry_ever_referred_to_user_as_group_member.*
							from (".$qry_ever_referred_to_user_as_group_member_SQL.") as qry_ever_referred_to_user_as_group_member
							UNION
							SELECT qry_currently_assigned_to_user.*
							from (".$qry_currently_assigned_to_user_SQL.") as qry_currently_assigned_to_user
							UNION
							SELECT qry_currently_assigned_to_user_as_group_leader.*
							from (".$qry_currently_assigned_to_user_as_group_leader_SQL.") as qry_currently_assigned_to_user_as_group_leader
							UNION
							SELECT qry_currently_assigned_to_user_as_group_member.*
							from (".$qry_currently_assigned_to_user_as_group_member_SQL.") as qry_currently_assigned_to_user_as_group_member
							";

$qry_related_to_user_distinct_SQL = "SELECT distinct qry_related_to_user.task_id
											FROM (".$qry_related_to_user_SQL.") as qry_related_to_user";

$qry_related_to_user_relationship_SQL = "SELECT task_id,
											EXISTS (SELECT task_id from (".$qry_ever_created_by_user_SQL.") as qry_ever_created_by_user where qry_ever_created_by_user.task_id = qry_related_to_user_distinct.task_id) AS ever_created_by_user,
											EXISTS (SELECT task_id from (".$qry_ever_assigned_by_user_SQL.") as qry_ever_assigned_by_user where qry_ever_assigned_by_user.task_id = qry_related_to_user_distinct.task_id) AS ever_assigned_by_user,
											EXISTS (SELECT task_id from (".$qry_ever_referred_to_user_SQL.") as qry_ever_referred_to_user where qry_ever_referred_to_user.task_id = qry_related_to_user_distinct.task_id) AS ever_referred_to_user,
											EXISTS (SELECT task_id from (".$qry_ever_referred_to_user_as_group_leader_SQL.") as qry_ever_referred_to_user_as_group_leader where qry_ever_referred_to_user_as_group_leader.task_id = qry_related_to_user_distinct.task_id) AS ever_referred_to_user_as_group_leader,
											EXISTS (SELECT task_id from (".$qry_ever_referred_to_user_as_group_member_SQL.") as qry_ever_referred_to_user_as_group_member where qry_ever_referred_to_user_as_group_member.task_id = qry_related_to_user_distinct.task_id) AS ever_referred_to_user_as_group_member,
											EXISTS (SELECT task_id from (".$qry_currently_assigned_to_user_SQL.") as qry_currently_assigned_to_user where qry_currently_assigned_to_user.task_id = qry_related_to_user_distinct.task_id) AS currently_assigned_to_user,
											EXISTS (SELECT task_id from (".$qry_currently_assigned_to_user_as_group_leader_SQL.") as qry_currently_assigned_to_user_as_group_leader where qry_currently_assigned_to_user_as_group_leader.task_id = qry_related_to_user_distinct.task_id) AS currently_assigned_to_user_as_group_leader,
											EXISTS (SELECT task_id from (".$qry_currently_assigned_to_user_as_group_member_SQL.") as qry_currently_assigned_to_user_as_group_member where qry_currently_assigned_to_user_as_group_member.task_id = qry_related_to_user_distinct.task_id) AS currently_assigned_to_user_as_group_member
										FROM (".$qry_related_to_user_distinct_SQL.") as qry_related_to_user_distinct";

$qry_join_users_groups_entities_SQL = "(Select id as user_group_entity_id, concat(name, ' ', surname) as user_group_entity_description from authuser)
										UNION
										(Select group_id as user_group_entity_id, group_name as user_group_entity_description from tbl_groups)
										UNION
										(Select entity_id as user_group_entity_id, entity_name as user_group_entity_description from tbl_entities)
										";

$qry_documents_user_tasks_SQL = "SELECT distinct tbl_task_documents.document_id
								FROM (".$qry_related_to_user_distinct_SQL.")  as qry_related_to_user_distinct INNER JOIN tbl_task_documents ON qry_related_to_user_distinct.task_id = tbl_task_documents.task_id
									";

$qry_documents_user_uploaded_SQL = "SELECT tbl_documents.document_id
								FROM tbl_documents
								WHERE tbl_documents.uploaded_by='".$current_user_id."'
								";

$qry_documents_intput_SQL = "SELECT distinct tbl_documents.document_id
								FROM tbl_documents
								WHERE tbl_documents.document_viewable_by_id='PUB'
								";

if (isset($current_user_id)) {
	$qry_documents_intput_SQL = $qry_documents_intput_SQL." or tbl_documents.document_viewable_by_id='INT' ";
}

$qry_documents_viewable_SQL = "Select qry_documents_user_tasks.document_id from (".$qry_documents_user_tasks_SQL.") as qry_documents_user_tasks
								UNION
								Select qry_documents_user_uploaded.document_id from (".$qry_documents_user_uploaded_SQL.") as qry_documents_user_uploaded
								UNION
								Select qry_documents_intput.document_id from (".$qry_documents_intput_SQL.") as qry_documents_intput
								";

$qry_document_subject_area_list_SQL = "Select document_id, GROUP_CONCAT(subject_area ORDER BY subject_area SEPARATOR '<br>') AS subject_area_list
										FROM tbl_setup_subject_areas INNER JOIN tbl_document_subject_areas ON tbl_setup_subject_areas.subject_area_id = tbl_document_subject_areas.subject_area_id
										GROUP BY document_id
										";


$qry_groups_active_SQL = "SELECT tbl_groups.*
							FROM tbl_groups
							WHERE tbl_groups.group_status='active'";


$qry_users_active_SQL = "SELECT authuser.id
						FROM authuser
						WHERE authuser.status='active'";


$qry_users_with_groups_active_SQL = "SELECT qry_users_active.*, qry_groups_active.*,  concat(group_name, IF(role_in_group_type='leader',' (L)','')) AS group_name_opt_L
									FROM ((".$qry_users_active_SQL.") as qry_users_active LEFT JOIN tbl_group_membership ON qry_users_active.id = tbl_group_membership.member_id) LEFT JOIN (".$qry_groups_active_SQL.") as qry_groups_active ON tbl_group_membership.group_id = qry_groups_active.group_id";

$qry_users_with_groups_active_list_SQL  = "SELECT qry_users_with_groups_active.id, GROUP_CONCAT(group_name_opt_L ORDER BY group_name_opt_L SEPARATOR '<br>') as group_membership_list
											FROM (".$qry_users_with_groups_active_SQL.") as qry_users_with_groups_active
											GROUP BY id";

$qry_group_members_active_SQL = "SELECT qry_users_active.*, qry_groups_active.*, tbl_group_membership.role_in_group_type, tbl_group_membership.role_in_group_description  
									FROM ((".$qry_users_active_SQL.") as qry_users_active inner JOIN tbl_group_membership ON qry_users_active.id = tbl_group_membership.member_id) inner JOIN (".$qry_groups_active_SQL.") as qry_groups_active ON tbl_group_membership.group_id = qry_groups_active.group_id";



