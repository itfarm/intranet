<?php 
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functionsspecial.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
    $search_string = $_POST['search_string'];
?>

<form name="filter_form" method="POST" action="<?php echo $homePage ?>">
	<input type="text" name="page" value="staffroaster" style="display:none" />
	<input type="text" name="tag" value="viewgroups" style="display:none" />
	<input type="text" name="search_string"  value="<?php echo $search_string?>" class="vform"/>
	<input type="submit" value="Filter" class="button" />
</form>	
<div class="scrolldown">
<table style="text-align:left;" width="100%">
	<thead>
		<tr>
			<th> Group Name</th>
			<th> Group Status</th>
		</tr>
	</thead>
	<thead>
		<?php
			$qry_groups_SQL = $qry_groups_SQL . " WHERE group_name Like '%".$search_string."%' 
						OR group_status Like '%".$search_string."%' 
						";
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
</div>
