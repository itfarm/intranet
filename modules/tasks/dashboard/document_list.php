
<?php 
//var_dump($_GET);
//exit;
@include_once('../config.php');
@include_once('../config_imported/connect.inc.php');


$document_search=$_GET['document_search'];
$current_user_id = $_GET['user_id'];

@include_once('../config_imported/coresql.inc.php');

// echo $entity_search;

$document_search_SQL = "
SELECT tbl_documents.document_id, tbl_documents.document_description, tbl_documents.document_keywords, tbl_documents.document_classification_id, tbl_setup_document_classifications.document_classification, tbl_documents.document_status 
FROM tbl_setup_document_classifications RIGHT JOIN tbl_documents ON tbl_setup_document_classifications.document_classification_id = tbl_documents.document_classification_id
WHERE tbl_documents.document_id in (".$qry_documents_viewable_SQL.") ";


if ($document_search != '') {
	$document_search_SQL = $document_search_SQL." AND document_description like '%".$document_search."%' or document_keywords like '%".$document_search."%'"; 
}

$document_search_SQL = $document_search_SQL." ORDER BY document_description ";

//echo $document_search_SQL;

echo "<table class = 'smallneat'>";
echo "<tr class='general'><th></th>
			<th>Name</th>
			<th>Classification</th>
			<th>Status</th>
		</tr>";

$document_search_result = mysql_query("$document_search_SQL");
	if (!$document_search_result) {
			exit('<p>Error performing document query: '.mysql_error().'</p>');
	}

	While ($document_search_row = mysql_fetch_array($document_search_result)) {
		echo '<tr class ="general">
					<td><input type="radio" name="document_id_display" value="'.$document_search_row["document_id"].'" onclick="document.getElementById(\'document_id\').value = this.value" /></td>
					<td>'.$document_search_row['document_description'].'</td>
					<td>'.$document_search_row['document_classification'].'</td>
					<td>'.$document_search_row['document_status'].'</td>
			</tr>';
	}
	
echo "</table>";


?>

