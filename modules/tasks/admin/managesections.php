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
	
	if ($command == "create_group") {
	
		//	user has already created a group
		
			
		$group_name=PrepareStringForInsert($_POST['group_name']);
		$group_status="'Active'";

		$HasError = False;

		$group_id = GetNextID8Dig('G','group_id','tbl_groups');

		
		
		if  ($_POST['group_name'] == "") {
			echo "<p>You cannot leave the group name blank</p>";
			$HasError = True;
		}

		if  (domain('dcount','group_id','tbl_groups',"group_name = '".$_POST['group_name']."'") > 0) {
			echo '<p>A group with the same name ('.$_POST['group_name'].') has already been registered</p>';
			$HasError = True;
		}
			
		if (!$HasError) {

			$InsertSQL = "INSERT INTO tbl_groups (group_id, group_name, group_status) "; 		
			$InsertSQL = $InsertSQL." VALUES ('".$group_id."', ".$group_name.", ".$group_status.")"; 

			//echo $InsertSQL;
			
			$InsertQueryRan = mysql_query($InsertSQL);
			
			//echo $InsertQueryRan;
			
			//echo mysql_affected_rows();
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Group successfully registered</P>";
			} else {
				echo "<P>Error creating group</P>";
			}
			
		}
	} elseif ($command == "change_status") {
		$new_status = $_GET['new_status'];
		$group_id = $_GET['group_id'];
		
		$UpdateSQL = "Update tbl_groups
									Set group_status = '".$new_status."'
									Where group_id = '".$group_id."'";
									
		//echo $UpdateSQL;
		
		$UpdateQueryRan = mysql_query($UpdateSQL);
		
		if ($UpdateQueryRan and mysql_affected_rows() == 1 ) {
			echo "<P>Group status successfully updated</P>";
		} else {
			echo "<P>Error updating group status</P>";
		}
		
	}

	//*****************************************************************
	//Filter options
	//*****************************************************************
	
		$search_string = $_POST['search_string'];
		$group_status_option = $_POST['group_status_option'];

		// default values
		if ($group_status_option == "") {
			$group_status_option = "Active";
									
		}
?>
		<form name="filter_form" method="POST" action="<?php echo $adminpage . "&tag=managesections" ?>">
		<input type="text" name="page" value="<?php echo $page ?>" style="display:none" />
		<table>		
			<tr><td>Status:</td>
					<td><select name="group_status_option" size=1 class="vform"  >
								<?php
									echo DropDownLookup('tbl_list_group_user_status', 'group_user_status', 'group_user_status', 'Desc', $group_status_option, false);
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
	//Display list of groups and forms
	//*****************************************************************
	
?>

	<table align=center class="smallneat">		
	<tr class="largeleft"><th>Section name</th>
			<th>Status</th>
			<th colspan=2></th>
			</tr>
			
			<tr class="d0">
			<td><form action='<?php echo $adminpage ."&tag=managesections" ?>' method='POST' name='creategroupform' >
					<input type="text" name='group_name' size=50 class="vform"/>
			</td>
			<td>Active</td>
			<td colspan=2><input type='submit' value='Create section' class="button" /></td>
			</tr>
					</form>
	<script language="JavaScript" type="text/javascript">
	var frmvalidator = new Validator("creategroupform");
	frmvalidator.addValidation("group_name","req","Please enter a group name");
	</script>
			
	<?php
	// Display list of groups***************************
	

	$qry_group_SQL = "SELECT tbl_groups.*
										FROM tbl_groups
										WHERE tbl_groups.group_status = '".$group_status_option."'
										AND (tbl_groups.group_name Like '%".$search_string."%' )
										ORDER BY group_name";

	$qry_group_result = mysql_query($qry_group_SQL);

	if (!$qry_group_result) {
			exit('<p>Error performing group query: '.mysql_error().'</p>');
	} else {
		$i = 0;
			
		if (mysql_num_rows($qry_group_result) == 0) {
			echo "</table><P  class='centered'>No groups meet the filter criteria</P>";	
		}	
		While ($qry_group_row = mysql_fetch_array($qry_group_result)) {
			$i++;
			echo '<tr class="d'.($i & 1).'">';						
			?>
			
			<td>
				<?php echo $qry_group_row['group_name'] ?>
			</td>			
			<td>
					<select name="group_status_option" size=1  class="smallneat" onChange="window.location='index.php?page=<?php echo $page ?>&command=change_status&group_id=<?php echo $qry_group_row['group_id']?>&new_status='+this.value" class="vform">
								<?php
									echo DropDownLookup('tbl_list_group_user_status', 'group_user_status', 'group_user_status', 'Desc', $qry_group_row['group_status'], false);
								?>
					</select>
				</td>
			<td>
					<a href="<?php echo $adminpage . "&tag=editgroupsbygroup"?>&group_id=<?php echo $qry_group_row['group_id'] ?>">
					Members
					</a>
			</td>		
			<td>
					<a href="<?php echo $adminpage . "&tag=editbyassignee"?>&assignee_id=<?php echo $qry_group_row['group_id'] ?>">
					Assigners
					</a>
			</td>
			</tr>
				
<?php
		}
	}
echo '</table>';
?>
