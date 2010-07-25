<?php 
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functionsspecial.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
	global $docs_dir;
	$uploaddirrel = $docs_dir;
	# include the header
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet,$szHeaderPath,$szFooterPath;

	$szSection = 'Navigation Manager';
	$szTitle = 'View documents';
	$szSubSection = 'Document';
	$szSubSubSection = 'View documents';

	//include($szHeaderPath);
	
$search_string = $_GET['search_string'];

$qry_document_SQL = "SELECT tbl_documents.*, authuser.name, authuser.surname, tbl_setup_document_classifications.document_classification, qry_join_users_groups_entities.user_group_entity_description, tbl_list_document_viewable_by.document_viewable_by, concat(name,' ',surname) as uploaded_by_desc, DATE_FORMAT(date_uploaded,'%d-%b-%y') AS date_uploaded_formatted, qry_document_subject_area_list.subject_area_list, concat(tbl_documents.file_id, ' - ', tbl_setup_files.file) as file_desc, DATE_FORMAT(document_date,'%d-%b-%y') AS document_date_formatted 
						FROM (((((tbl_documents LEFT JOIN tbl_setup_document_classifications ON tbl_documents.document_classification_id = tbl_setup_document_classifications.document_classification_id) LEFT JOIN (".$qry_join_users_groups_entities_SQL.") as qry_join_users_groups_entities ON tbl_documents.primary_author_id =  qry_join_users_groups_entities.user_group_entity_id) LEFT JOIN authuser ON tbl_documents.uploaded_by = authuser.id) LEFT JOIN tbl_list_document_viewable_by ON tbl_documents.document_viewable_by_id = tbl_list_document_viewable_by.document_viewable_by_id) left join (".$qry_document_subject_area_list_SQL.") as qry_document_subject_area_list on  qry_document_subject_area_list.document_id = tbl_documents.document_id) left join tbl_setup_files on tbl_documents.file_id = tbl_setup_files.file_id
					WHERE tbl_documents.document_id in (".$qry_documents_viewable_SQL.") 
					AND (tbl_documents.document_description Like '%".$search_string."%' 
						OR tbl_documents.document_keywords Like '%".$search_string."%' 
						OR tbl_setup_document_classifications.document_classification Like '%".$search_string."%' 
						OR qry_join_users_groups_entities.user_group_entity_description Like '%".$search_string."%' 
						OR concat(name,' ',surname) Like '%".$search_string."%' 
						OR qry_document_subject_area_list.subject_area_list Like '%".$search_string."%' 
						OR concat(tbl_documents.file_id, ' - ', tbl_setup_files.file) Like '%".$search_string."%' 
						)
					ORDER BY date_uploaded desc";

//echo $qry_documents_viewable_SQL;
//echo $qry_document_SQL;
?>
	

	<form name="filter_form" method="Get" action="<?php echo $dashboardPage?>">
		<input type="text" name="page" value="dashboard" style="display:none" />
		<input type="text" name="tag" value="viewdocs" style="display:none" />
		<input type="text" name="search_string" value="<?php echo $search_string?>" class="vform" />
		<input type="submit" value="Filter" class="button"/>
	</form>	
<div class="scrolldown">
	<table class="sorted" style="font-size:90%">
	<thead>
	<tr>
			<th>Document description</th>
			<th>Keywords</th>
			<th>File</th>
			<th>Date</th>
			<th>Classification</th>
			<th>Subject areas</th>
			<th>Primary author</th>
			<th>Uploaded by</th>
			<th>Date uploaded</th>
			<th>Status</th>
			<th>Viewable by</th>		
			<th>File type</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$qry_document_result = mysql_query($qry_document_SQL);

	if (!$qry_document_result) {
			exit('<p>Error performing document query: '.mysql_error().'</p>');
	} else {
		//$i = 0;
		
		if (mysql_num_rows($qry_document_result) == 0) {
			echo "</tbody></table><P  class='centered'>No documents meet the filter criteria</P>";
		}
		else {
			While ($qry_document_row = mysql_fetch_array($qry_document_result)) {
				//$i++;
			//class="d'.($i & 1).'"			
				$filename = $qry_document_row['document_file_name'];
				$extension =  substr($filename,strrpos($filename,"."));
			
				echo "fullname:" . $uploaddirrel.$filename;
				echo '<tr onClick="window.location=\''.$uploaddirrel.$filename.'\'">';
				?>

				<td axis="string" headers="desc">
					<?php echo $qry_document_row['document_description'] ?></td>
				<td axis="string" headers="keywords">
					<?php echo $qry_document_row['document_keywords'] ?></td>
				<td axis="string" headers="file">
					<?php echo $qry_document_row['file_desc'] ?></td>
				<td axis="date" headers="documentdate" 
					title="<?php echo NullToLateDate(substr($qry_document_row['document_date'],0,10)) ?>">
					<?php echo $qry_document_row['document_date_formatted'] ?></td>
				<td axis="string" headers="classification">
					<?php echo $qry_document_row['document_classification'] ?></td>
				<td axis="string" headers="subjectareas">
					<?php echo $qry_document_row['subject_area_list'] ?></td>		
				<td axis="string" headers="author"> 
					<?php echo $qry_document_row['user_group_entity_description'] ?></td>			
				<td axis="string" headers="uploadedby">
					<?php echo $qry_document_row['uploaded_by_desc'] ?></td>
				<td axis="date" headers="dateuploaded" 
					title="<?php echo substr($qry_task_row['date_uploaded'],0,10) ?>">
					<?php echo $qry_document_row['date_uploaded_formatted'] ?></td>
				<td axis="string" headers="status">
					<?php echo $qry_document_row['document_status'] ?></td>
				<td axis="string" headers="viewableby">
					<?php echo $qry_document_row['document_viewable_by'] ?></td>
				<td axis="string" headers="extension">
					<?php if($extension==".pdf"){ ?>
							   <img border="0" src="<?php $szRootURL?>/images/icons/pdf.gif" width="30" height="30">
					<?php }elseif($extension==".doc"){?>
							   <img border="0" src="<?php $szRootURL?>/images/icons/doc.gif" width="30" height="30">
					<?php }elseif($extension==".ppt"){?>
							   <img border="0" src="<?php $szRootURL?>/images/icons/ppt.gif" width="30" height="30">
					<?php }elseif($extension==".xls"){?>
							   <img border="0" src="<?php $szRootURL?>/images/icons/xls.gif" width="30" height="30">
					<?php }?>
					</td>
				</tr>
				<?php
			}
		}
	}
?>
</tbody>
	</table>
</div>
