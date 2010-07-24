<?php 
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functions.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
    $search_string = $_POST['search_string'];
?>

<form name="filter_form" method="post" action="<?php echo $homePage ?>">
	<input type="text" name="page" value="dashboard" style="display:none" />
	<input type="text" name="tag" value="viewroles" style="display:none" />
	<input type="text" name="search_string"  value="<?php echo $search_string?>" class="vform"/>
	<input type="submit" value="Filter" class="button" />
</form>	
<div class="scrolldown">
<table style="text-align:left;" width="100%">
	<thead>
		<tr>
			<th> Role title</th>
		</tr>
	</thead>
	<thead>
		<?php
			 $group_query = mysql_query( $qry_roles_in_groups_SQL . " WHERE role_in_group_type Like '%".$search_string."%'" ) or die( mysql_error() );
			for( $incr = 0; $incr< mysql_num_rows($group_query); $incr++) {
				$row = mysql_fetch_array( $group_query );
				echo "<tr>";
					echo "<td>". $row['role_in_group_type'] . "</td>";
				echo "</tr>";
			} 
		?>
	</thead>
</table>
</div>
