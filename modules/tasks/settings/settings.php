<?php
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functions.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
	//*****************************************************************
	//Process commands
	//*****************************************************************
	$setup = $tag;
	$table_name = 'tbl_setup_'.$setup.'s';
	$id_field_name = $setup.'_id';
	$description_field_name = $setup;
	
	if ($setup == 'task_outcome_classification') {
			$extra_filter_option = true;
			$parent_id_name = 'task_classification_id';
			$parent_table_name = 'tbl_setup_task_classifications';
			$parent_desc_name = 'task_classification';
	} else if ($setup == 'file') {
			$extra_filter_option = true;
			$parent_id_name = 'file_type_id';
			$parent_table_name = 'tbl_setup_file_types';
			$parent_desc_name = 'file_type';
	} else {
			$extra_filter_option = false;
	}
	
	if ($extra_filter_option == true) {
			$parent_id = $_GET['parent_id'];
			// needed for both create command and filter
	}
	
	$command=$_GET['command'];
	
	if ($command == "create_configuration") {
	
		//	user has already created a new configuration
		
		$id=PrepareStringForInsert($_POST['id']);
		$description=PrepareStringForInsert($_POST['description']);
		$status="'Active'";
		
		$HasError = False;

		if  ($_POST['id'] == "") {
			echo "<p>You cannot leave the id blank</p>";
			$HasError = True;
		}

		if  ($_POST['description'] == "") {
			echo "<p>You cannot leave the description blank</p>";
			$HasError = True;
		}

		if  (domain('dcount',$id_field_name,$table_name,$id_field_name." = '".$_POST['id']."'") > 0) {
			echo '<p>This ID code ('.$_POST['id'].') has already been used</p>';
			$HasError = True;
		}

		if  (domain('dcount',$description_field_name,$table_name,$description_field_name." = '".$_POST['description']."'") > 0) {
			echo '<p>This description ('.$_POST['description'].') has already been used</p>';
			$HasError = True;
		}

			
		if (!$HasError) {

			$InsertSQL = "INSERT INTO ".$table_name." (".$id_field_name.", ".$description_field_name.", status) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$id.", ".$description.", ".$status.")"; 
			
			if ($extra_filter_option == true) {
				$InsertSQL = "INSERT INTO ".$table_name." (".$id_field_name.", ".$description_field_name.", status, ".$parent_id_name.") "; 		
				$InsertSQL = $InsertSQL." VALUES (".$id.", ".$description.", ".$status.", '".$parent_id."')"; 	
			}
			
			//echo $InsertSQL;
			
			$InsertQueryRan = mysql_query($InsertSQL);
			
			//echo $InsertQueryRan;
			
			//echo mysql_affected_rows();
			
			if ($InsertQueryRan and mysql_affected_rows() == 1 ) {
				echo "<P>Configuration successfully added</P>";
			} else {
				echo "<P>Error adding configuration</P>";
			}
			
		}
	} elseif ($command == "change_status") {
		$new_status = $_GET['new_status'];
		$id = $_GET['id'];
		
		$UpdateSQL = "Update ".$table_name."
									Set status = '".$new_status."'
									Where ".$id_field_name." = '".$id."'";
									
		//echo $UpdateSQL;
		
		$UpdateQueryRan = mysql_query($UpdateSQL);
		
		if ($UpdateQueryRan and mysql_affected_rows() == 1 ) {
			echo "<P>Status successfully updated</P>";
		} else {
			echo "<P>Error updating status</P>";
		}
		
	} 
	$status_option = $_POST['status_option'];

	// default values
	if ($status_option == "") {
		$status_option = "Active";
								
	}
?>

		<form name="filter_form" method="post" action="<?php echo $settingsPage?>">
			<table>		
				<tr><td>Status:</td>
						<td><select name="status_option" size=1 class="vform"  >
									<?php
										echo DropDownLookup('tbl_list_group_user_status', 'group_user_status', 'group_user_status', 'Desc', $status_option, false);
									?>							
						</select>
						</td>
						
						<?php 
						if ($extra_filter_option == true) {
							echo '<td>'.str_replace('_', ' ', $parent_desc_name).':</td>';
							echo '<td><select name="parent_id" size=1  >';
							echo DropDownLookupFiltered($parent_table_name, $parent_id_name, $parent_desc_name, "status = 'active'", 'Desc', $parent_id);						
							echo '</select>';
							echo '</td>';
						}
						?>
						
						<td><input type="submit" value="Filter" class="button" /></td>
				</tr>
			</table>
		</form>	
<?php 
	//*****************************************************************
	//Display list of configuration and forms
	//*****************************************************************
	
?>
	<p class="bigleft">Configure <?php echo str_replace('_', ' ', $setup).'s' ?> </p>
	<table align=center class="smallneat">		
	<tr class="largeleft">
			<th>ID code</th>
			<th>Description</th>
			<th>Status</th>
			</tr>
			

			
			<?php
				//**************Create new configuration
				
				if (!($extra_filter_option == true && $parent_id == '')) {
					// no option to  create new classifcation if parent id supposed to be chosen but not chosen

					$action_target = $settingsPage ."&tag=$setup&command=create_configuration";
					if ($extra_filter_option == true) { 
						$action_target = $action_target.'&parent_id='.$parent_id;
					}
					?>
					
					<tr class="d0">
					<form action='<?php echo $action_target ?>' method='POST' name='createconfigurationform' >
					<td><input type="text" name='id' size=3 class="vform"/></td>
					<td><input type="text" name='description' size=50 class="vform"/></td>
					<td>Active</td>
					<td colspan=2><input type='submit' value='Create' class="button" /></td>
					</form>
					</tr>
					<script language="JavaScript" type="text/javascript">
					var frmvalidator = new Validator("createconfigurationform");
					frmvalidator.addValidation("id","req","Please enter a three digit ID code");
					frmvalidator.addValidation("description","req","Please enter a description");
					</script>			
			<?php
				}
	// Display list ***************************
	

	$qry_SQL = "SELECT ".$table_name.".*
										FROM ".$table_name."
										WHERE ".$table_name.".status = '".$status_option."'";
	if ($extra_filter_option == true) {
		$qry_SQL = $qry_SQL." AND ".$parent_id_name." = '".$parent_id."'";
	}
	
	$qry_SQL = $qry_SQL."ORDER BY ".$description_field_name;

	$qry_result = mysql_query($qry_SQL);

	if (!$qry_result) {
			exit('<p>Error performing query: '.mysql_error().'</p>');
	} else {
		$i = 0;
			
		if (mysql_num_rows($qry_result) == 0) {
			echo "<P  class='centered'>No configurations of this type and status setup</P>";
			//exit;	
		}	
		While ($qry_row = mysql_fetch_array($qry_result)) {
			$i++;
			echo '<tr class="d'.($i & 1).'">';						
			?>
			<td>
				<?php echo $qry_row[$id_field_name] ?>
			</td>
			<td>
				<?php echo $qry_row[$description_field_name] ?>
			</td>			
			<td>
					<?php 
						$action_target = "index.php?page=".$page."&setup=".$setup."&command=change_status&id=".$qry_row[$id_field_name];
						if ($extra_filter_option == true) {
							$action_target = $action_target."&parent_id=".$parent_id;
						}
					?>	
					<select name="status_option" size=1  class="smallneat" onChange="window.location='<?php echo $action_target ?>&new_status='+this.value" class="vform">
								<?php
									echo DropDownLookup('tbl_list_group_user_status', 'group_user_status', 'group_user_status', 'Desc', $qry_row['status'], false);
								?>
					</select>
				</td>
			</tr>
				
<?php
		}
	}
echo '</table>';
?>
