<?php 
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functions.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
    
?>

<form name="filter_form" method="Get" action="<?php echo $homePage ?>">
	<input type="text" name="page" value="view_users" style="display:none" />	
	<input type="text" name="search_string"  value="<?php echo $search_string?>" class="vform"/>
	<input type="submit" value="Filter" class="button" />
</form>	

<table style="text-align:left;" width="100%">
	<thead>
		<tr>
			<th> Group Name</th>
			<th> Group Status</th>
		</tr>
	</thead>
	<thead>
		<?php
			$group_query = mysql_query( $qry_groups_SQL );
			for( $incr = 0; $incr< mysql_num_rows($group_query); $incr++) {
				$row = mysql_fetch_array( $group_query );
				echo "<tr>";
					echo "<td>". $row['group_name'] . "</td>";
					echo "<td>". $row['group_status'] . "</td>";
				echo "</tr>";
			} 
		?>
	</thead>
</table>
