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

<form name="filter_form" method="POST" action="<?php echo $homePage ?>">
	<input type="text" name="page" value="dashboard" style="display:none" />
	<input type="text" name="tag" value="viewteams" style="display:none" />
	<input type="text" name="search_string"  value="<?php echo $search_string?>" class="vform"/>
	<input type="submit" value="Filter" class="button" />
</form>	
<div class="scrolldown">
<table style="text-align:left;" width="100%">
	<thead>
		<tr>
			<th> Team Name</th>
			<th> Team Leader</th>
			<th> Team Status</th>
		</tr>
	</thead>
	<thead>
		<?php
			$qry_team_SQL = $qry_team_SQL . " WHERE teamname Like '%".$search_string."%' 
						OR teamlead Like '%".$search_string."%'
						OR status Like '%".$search_string."%' 
						";
			$team_query = mysql_query( $qry_team_SQL );
			for( $incr = 0; $incr< mysql_num_rows($team_query); $incr++) {
				$row = mysql_fetch_array( $team_query );
				echo "<tr>";
					echo "<td>". $row['teamname'] . "</td>";
					echo "<td>". $row['teamlead'] . "</td>";
					echo "<td>". $row['status'] . "</td>";
				echo "</tr>";
			} 
		?>	
	</thead>
</table>

</div>
