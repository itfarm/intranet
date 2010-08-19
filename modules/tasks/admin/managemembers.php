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
	$command=$_GET['command'];
	
	if ($command == "change_status") {
		$new_status = $_GET['new_status'];
		$user_id = $_GET['user_id'];
		
		$UpdateSQL = "Update authuser
									Set status = '".$new_status."'
									Where id = '".$user_id."'";
									
		//echo $UpdateSQL;
		
		$UpdateQueryRan = mysql_query($UpdateSQL);
		
		if ($UpdateQueryRan and mysql_affected_rows() == 1 ) {
			echo "<P>User status successfully updated</P>";
		} else {
			echo "<P>Error updating user status</P>";
		}
		
	} elseif ($command == "change_manage_users") {
		$new_can_manage_users = $_GET['new_can_manage_users'];
		$user_id = $_GET['user_id'];
		
		$UpdateSQL = "Update authuser
									Set can_manage_users = '".$new_can_manage_users."'
									Where id = '".$user_id."'";
									
		//echo $UpdateSQL;
		
		$UpdateQueryRan = mysql_query($UpdateSQL);
		
		if ($UpdateQueryRan and mysql_affected_rows() == 1 ) {
			echo "<P>User admin privileges successfully updated</P>";
		} else {
			echo "<P>Error updating user admin privileges</P>";
		}
		
	} elseif ($command == "change_configure") {
		$new_can_configure = $_GET['new_can_configure'];
		$user_id = $_GET['user_id'];
		
		$UpdateSQL = "Update authuser
									Set can_configure = '".$new_can_configure."'
									Where id = '".$user_id."'";
									
		//echo $UpdateSQL;
		
		$UpdateQueryRan = mysql_query($UpdateSQL);
		
		if ($UpdateQueryRan and mysql_affected_rows() == 1 ) {
			echo "<P>User configuration privileges successfully updated</P>";
		} else {
			echo "<P>Error updating user configuration privileges</P>";
		}
		
	}

	//*****************************************************************
	//Filter options
	//*****************************************************************
	
		$search_string = $_POST['search_string'];
		$user_status_option = $_POST['user_status_option'];

		// default values
		if ($user_status_option == "") {
			$user_status_option = "Active";
									
		}
?>
		<form name="filter_form" method="POST" action="<?php echo $adminpage . "&tag=managemembers" ?>">
		<table>		
			<tr><td>Status:</td>
					<td><select name="user_status_option" size=1 class="vform" >
								<?php
									echo DropDownLookup('tbl_list_group_user_status', 'group_user_status', 'group_user_status', 'Desc', $user_status_option, false);
								?>							
					</select>
					</td>
					<td>Search:</td>
					<td><input type="text" name="search_string" value="<?php echo $search_string?>" class="vform" /></td>	
					<td><input type="submit" value="Filter" class="button" /></td>
			</tr>
		</table>

		</form>	
<?php 
	//*****************************************************************
	//Display list of users and forms
	//*****************************************************************
	
?>
<div class="scrolldown">
	<table align=center class="smallneat">		
	<tr class="largeleft">
			<th>First Name</th>
			<th>Surname</th>
			<th>Sections</th>
			<th>Status</th>
			<!--<th>Admin</th>
			<th>Config</th>-->
			<th colspan=3></th>
			</tr>
						
	<?php
	// Display list of users***************************
	
	$qry_user_SQL ="SELECT authuser.*, qry_users_with_groups_active_list.group_membership_list
						FROM authuser left join (".$qry_users_with_groups_active_list_SQL.") as qry_users_with_groups_active_list on authuser.id = qry_users_with_groups_active_list.id
					WHERE authuser.status = '".$user_status_option."'
					AND (authuser.name Like '%".$search_string."%' 
						OR authuser.surname Like '%".$search_string."%' 
						OR qry_users_with_groups_active_list.group_membership_list Like '%".$search_string."%' 
						OR concat(name,' ',surname) Like '%".$search_string."%' 
						)
					ORDER BY name, surname";

	$qry_user_result = mysql_query($qry_user_SQL);

	if (!$qry_user_result) {
			exit('<p>Error performing user query: '.mysql_error().'</p>');
	} else {
		$i = 0;
			
		if (mysql_num_rows($qry_user_result) == 0) {
			echo "</table><P  class='centered'>No users meet the filter criteria</P>";
		}	
		While ($qry_user_row = mysql_fetch_array($qry_user_result)) {
			$i++;
			echo '<tr class="d'.($i & 1).'">';						
			?>
			
			<td>
				<?php echo $qry_user_row['name'] ?>
			</td>			
			<td>
				<?php echo $qry_user_row['surname'] ?>
			</td>
			<td>
				<?php echo $qry_user_row['group_membership_list'] ?>
			</td>
			<td>
					<select name="user_status_option" size=1  class="smallneat" onChange="window.location='<?php echo $adminpage ."&tag=managemembers" ?>&command=change_status&user_id=<?php echo $qry_user_row['id']?>&new_status='+this.value" class="vform">
								<?php
									echo DropDownLookup('tbl_list_group_user_status', 'group_user_status', 'group_user_status', 'Desc', $qry_user_row['status'], false);
								?>
					</select>
				</td>
			
			<!--<td>
					<select name="manage_users_option" size=1  class="smallneat" onChange="window.location='index.php?page=<?php echo $page ?>&command=change_manage_users&user_id=<?php echo $qry_user_row['id']?>&new_can_manage_users='+this.value">			
							<?php echo YesNoList($qry_user_row['can_manage_users'], false) ?>
					</select>
			</td>
			<td>
					<select name="configure_option" size=1  class="smallneat" onChange="window.location='index.php?page=<?php echo $page ?>&command=change_configure&user_id=<?php echo $qry_user_row['id']?>&new_can_configure='+this.value">
							<?php echo YesNoList($qry_user_row['can_configure'], false) ?>
					</select>
			</td>-->
						
			<td class="nobackground">
					<a href="<?php echo $adminpage . "&tag=editgroupsbyuser"?>&member_id=<?php echo $qry_user_row['id'] ?>">
					Sections
					</a>
			</td>		
			<td class="nobackground">
					<a href="<?php echo $adminpage . "&tag=editbyassignee"?>&assignee_id=<?php echo $qry_user_row['id'] ?>">
					Assigners
					</a>
			</td>
			<td class="nobackground">
					<a href="<?php echo $adminpage . "&tag=editbyassigner"?>&assigner_id=<?php echo $qry_user_row['id'] ?>">
					Assigees
					</a>
			</td>

			</tr>
				
<?php
		}
	}
echo '</table>';
?>
</div>
