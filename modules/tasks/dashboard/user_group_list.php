
<?php 
//var_dump($_GET);
//exit;
@include_once('../config.php');
@include_once('../config_imported/connect.inc.php');
	
$user_group_search=$_GET['user_group_search'];
$option=$_GET['option'];
$user_id=$_GET['user_id'];
$current_user_id = $user_id;

@include_once('../config_imported/coresql.inc.php');

$user_group_search_SQL = "SELECT user_group_id, user_group_desc
								FROM (".$qry_users_groups_active_desc_SQL.") as qry_users_groups_active_desc ";
$where_assignee_SQL = "";
$where_filter_SQL = "";
								
if ($option == "assign") {
	$where_assignee_SQL = " user_group_id in (".$qry_potential_assignees_SQL.")";
}

if ($user_group_search != '') {
	$where_filter_SQL = " user_group_desc like '%".$user_group_search."%'"; 
}

if ($where_assignee_SQL <> "") {
	$user_group_search_SQL = $user_group_search_SQL." WHERE ".$where_assignee_SQL;
	if ($where_filter_SQL <> "") {
		$user_group_search_SQL = $user_group_search_SQL." AND ".$where_filter_SQL;
	}
} elseif ($where_filter_SQL <> "") {
	$user_group_search_SQL = $user_group_search_SQL." WHERE ".$where_filter_SQL;
}

$user_group_search_SQL = $user_group_search_SQL." ORDER BY user_group_desc ";

//echo "current user:".$current_user_id;

echo "<table class = 'smallneat'>";

$user_group_search_result = mysql_query("$user_group_search_SQL");
	if (!$user_group_search_result) {
			exit('<p>Error performing user/group query: '.mysql_error().'</p>');
	}

	While ($user_group_search_row = mysql_fetch_array($user_group_search_result)) {
		echo '<tr class ="general">
					<td><input type="radio" name="user_group_id_display" value="'.$user_group_search_row["user_group_id"].'" onclick="AssignVisibility(document, \''.$option.'\', this.value)" /></td>
					<td>'.$user_group_search_row['user_group_desc'].'</td>
			</tr>';
	}
	
echo "</table>";


?>

