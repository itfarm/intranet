<?php
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functionsspecial.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');

	//var_dump($_POST);
	$command=$_GET['command'];
	
	if ($command == "upload_document") {
	
		//	user has already uploaded a document
		$document_description=PrepareStringForInsert($_POST['document_description']);
		$document_keywords=PrepareStringForInsert($_POST['document_keywords']);
		$file_id=PrepareStringForInsert($_POST['file_id']);
		$document_classification_id=PrepareStringForInsert($_POST['document_classification_id']);
		$primary_author_id=PrepareStringForInsert($_POST['primary_author_id']);
		$document_status=PrepareStringForInsert($_POST['document_status']);
		$document_viewable_by_id=PrepareStringForInsert($_POST['document_viewable_by_id']);
		$DocumentDay=$_POST['DocumentDay'];
		$DocumentMonth=$_POST['DocumentMonth'];	
		$DocumentYear=$_POST['DocumentYear'];
		$HasError = False;

		// if any of the date fields filled out
		if ($DocumentDay <> "" or $DocumentMonth <> "" or $DocumentYear <> "") {
			// if all the date fields filled out
			if ($DocumentDay <> "" and $DocumentMonth <> "" and $DocumentYear <> "") {
				// if invalid date
				if (checkdate($DocumentMonth,$DocumentDay,$DocumentYear)==false) {
					$HasError = True;
					echo "<P>You have not chosen a valid document date</p>";
				} else {
					// valid date
					$document_date = "'".$DocumentYear."-".$DocumentMonth."-".$DocumentDay."'";
				}
			} else {
			// more than one field filled out but not all
				$HasError = True;
				echo "<P>You have left parts of the document date blank</p>";
			}
		} else {
			// date left blank
			$document_date = "null";
		}
		
		$maximum_used_id = domain('dmax','document_id','tbl_documents');
		if ($maximum_used_id == "" ) {
			$maximum_used_id = 0;
		}
		$document_id = $maximum_used_id + 1;
		


		
		
		
		if  ($_POST['document_description'] == "") {
			echo "<p>You cannot leave the document description blank</p>";
			$HasError = True;
		}
		
		if  (domain('dcount','document_description','tbl_documents',"document_description = ".$document_description) > 0) {
			echo "<p>A document with the same description (".$document_description.") has already been saved</p>";
			$HasError = True;
		}
			
		if (!$HasError) {

			// upload file stuff
			
			$upload_file_name = 'doc_'.sprintf("%07s", $document_id).'_'.basename($_FILES['upfile']['name']);
			$upload_path_and_file_name = $uploaddir.$upload_file_name;
			
			if (!move_uploaded_file($_FILES['upfile']['tmp_name'], $upload_path_and_file_name)) {
				echo "File upload problem";
			}
			
			// insert stuff
			$document_file_name = PrepareStringForInsert($upload_file_name);
			
			$InsertSQL = "INSERT INTO tbl_documents (document_id, 
													document_description, 
													document_keywords, 
													file_id, 
													document_date,
													document_classification_id, 
													primary_author_id, 
													document_status, 
													document_viewable_by_id, 
													uploaded_by, 
													date_uploaded,  
													document_file_name) "; 		
			$InsertSQL = $InsertSQL." VALUES (".$document_id.", 
											".$document_description.", 
											".$document_keywords.", 
											".$file_id.", 
											".$document_date.", 
											".$document_classification_id.",  
											".$primary_author_id.",  
											".$document_status.", 
											".$document_viewable_by_id.", 
											'".$_SESSION['id']."', 
											'".date("Y-m-d H:i:s")."', 
											".$document_file_name.")"; 	
			$InsertQueryRan = mysql_query($InsertSQL);
			// echo $InsertSQL;
			$MainQuerySuccessful = $InsertQueryRan and mysql_affected_rows() == 1;
			
			if(isset($_POST['subject_area_id'])) {
				for($i = 0; $i < sizeof($_POST['subject_area_id']); $i++) {
					$subject_area_id = PrepareStringForInsert($_POST['subject_area_id'][$i]);
					$InsertSubjectSQL = "INSERT INTO tbl_document_subject_areas (document_id, subject_area_id) "; 		
					$InsertSubjectSQL = $InsertSubjectSQL." VALUES (".$document_id.", ".$subject_area_id.")"; 	
					//echo $InsertSubjectSQL;
					$InsertSubjectQueryRan = mysql_query($InsertSubjectSQL);
					//echo '<br>This is set: ' . $_POST['subject_area_id'][$i];
				}
			}
			
			if ($MainQuerySuccessful ) {
				$message="Document Successfully uploaded";
				Header("location:$dashboardPage?message=$message");
			} else {
				$message="Error in uploading document";
				Header("location:$dashboardPage?message=$message");
				// will continue to form section
			}
			
		}
	}
?>

		<form enctype="multipart/form-data" action='<?php echo $_SERVER['PHP_SELF'] ?>?page=dashboard&tag=uploaddocs' method='POST' name='uploaddocumentform' >
			<table align=center width="100%">
				<tr><td>Document description:</td><td><textarea cols='50' rows='2' name='document_description' class="vform"></textarea></td></tr>
				<tr><td>Document keywords:</td><td><textarea cols='50' rows='2' name='document_keywords' class="vform"></textarea></td></tr>
				<tr><td>File:</td><td><select name="file_id" size=1 class="vform">
										<?php
											echo DropDownLookupFiltered('tbl_setup_files','file_id', "concat(file_id, ' - ', file)","status = 'Active'");
										 ?>
									</select>
									</td></tr>	

				<tr><td>Document date:</td><td><select name="DocumentDay" size=1 class="vform">
										<?php
											echo DateDropDownDay(31);
										 ?>
									</select>
									
									<select name="DocumentMonth" size=1 class="vform">
											<?php
											echo DateDropDownMonth();
										 ?>						
									</select>
									
									<select name="DocumentYear" size=1 class="vform">
										<?php
											echo DateDropDownYear(date("Y")-10,date("Y"));
										 ?>
									</select>
									</td></tr>

				<tr><td>Classification:</td><td><select name="document_classification_id" size=1 class="vform">
										<?php
											echo DropDownLookupFiltered('tbl_setup_document_classifications','document_classification_id','document_classification', "status = 'Active'");
										 ?>
									</select>
									</td></tr>
				<tr><td>Subject areas:</td><td>

						<?php echo TickBoxes("(select * from tbl_setup_subject_areas where status = 'Active') as qry_active_subject_areas","subject_area_id","subject_area", 3); ?>
									
							</td></tr>
				<tr><td>Primary author:</td><td><select name="primary_author_id" size=1 class="vform">
										<?php
											echo DropDownLookup('('.$qry_join_users_groups_entities_SQL.') as qry_currently_assigned_to_user_as_group_leader','user_group_entity_id','user_group_entity_description');
										 ?>
									</select>
									</td></tr>
				<tr><td>Status:</td><td><select name="document_status" size=1 class="vform" >
										<?php
											echo DropDownLookup('tbl_list_document_status','document_status','document_status');
										 ?>
									</select>
									</td></tr>	
				<tr><td>Viewable by:</td><td><select name="document_viewable_by_id" size=1 class="vform">
										<?php
											echo DropDownLookup('tbl_list_document_viewable_by','document_viewable_by_id','document_viewable_by');
										 ?>
									</select>
									</td></tr>	
				<tr><td>Browse for file:</td><td><input type="file" name="upfile" class="vform"></td></tr>					
				<tr><td colspan=2>
					<input type='hidden' name="upload_document" value='command' />
					<input type='submit' value='Create' class="button" />
				</td></tr>
			</table>
		</form>
		
		<script language="JavaScript" type="text/javascript">
		var frmvalidator = new Validator("uploaddocumentform");
		frmvalidator.addValidation("document_description","req","Please enter a document description");
		</script>


