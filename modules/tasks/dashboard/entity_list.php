
<?php 
//var_dump($_GET);
//exit;
@include_once('../config.php');
@include_once('../config_imported/connect.inc.php');

$entity_search=$_GET['entity_search'];

// echo $entity_search;

$entity_search_SQL = "
SELECT tbl_entities.entity_id, tbl_entities.entity_name, tbl_entities.entity_type_id, tbl_setup_entity_types.entity_type 
FROM  tbl_entities  LEFT JOIN tbl_setup_entity_types ON (tbl_entities.entity_type_id = tbl_setup_entity_types.entity_type_id) ";


if ($entity_search != '') {
	$entity_search_SQL = $entity_search_SQL." WHERE entity_name like '%".$entity_search."%'"; 
}

$entity_search_SQL = $entity_search_SQL."ORDER BY entity_name ";


echo "<table class = 'smallneat'>";
echo "<tr class='general'><th></th>
			<th>Name</th>
			<th>Type</th>
		</tr>";

$entity_search_result = mysql_query("$entity_search_SQL");
	if (!$entity_search_result) {
			exit('<p>Error performing entity query: '.mysql_error().'</p>');
	}

	While ($entity_search_row = mysql_fetch_array($entity_search_result)) {
		echo '<tr class ="general">
					<td><input type="radio" name="entity_id_display" value="'.$entity_search_row["entity_id"].'" onclick="document.getElementById(\'entity_id\').value = this.value" /></td>
					<td>'.$entity_search_row['entity_name'].'</td>
					<td>'.$entity_search_row['entity_type'].'</td>
			</tr>';
	}
	
echo "</table>";


?>

