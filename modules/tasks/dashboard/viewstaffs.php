<?php 
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functions.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
	
	# include the header
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet,$szHeaderPath,$szFooterPath;

	$szSection = 'Navigation Manager';
	$szTitle = 'Staff Directory';
	$szSubSection = 'Staff Directory';
	$szSubSubSection = 'Staff Directory';

	//include($szHeaderPath);
	?>
<?php

$search_string = $_GET['search_string'];

$qry_user_SQL = "SELECT authuser.*, qry_users_with_groups_active_list.group_membership_list
						FROM authuser left join (".$qry_users_with_groups_active_list_SQL.") as qry_users_with_groups_active_list on authuser.id = qry_users_with_groups_active_list.id
					WHERE (authuser.name Like '%".$search_string."%' 
						OR authuser.surname Like '%".$search_string."%' 
						OR qry_users_with_groups_active_list.group_membership_list Like '%".$search_string."%' 
						OR concat(name,' ',surname) Like '%".$search_string."%' 
						OR location Like '%".$search_string."%' 
						)
					ORDER BY name, surname";


//echo $qry_user_SQL;
?>

	

	<form name="filter_form" method="Get" action="<?php echo $homePage ?>">
		<input type="text" name="page" value="dashboard" style="display:none" />
		<input type="text" name="tag" value="viewstaffs" style="display:none" />	
		<input type="text" name="search_string"  value="<?php echo $search_string?>" class="vform"/>
		<input type="submit" value="Filter" class="button" />
	</form>	

	<table class="sorted" style="font-size:90%">
	<thead>
	<tr>
			<th id="firstname">First name</th>
			<th id="surname">Surname</th>
			<th id="groupmembershiplist">Section membership</th>
			<th id="landline_phone">Landline phone</th>
			<th id="mobile_phone">Mobile phone</th>
			<th id="email">Email</th>
			<th id="officelocation">Office location</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$qry_user_result = mysql_query($qry_user_SQL);

	if (!$qry_user_result) {
			exit('<p>Error performing user query: '.mysql_error().'</p>');
	} else {

		
		if (mysql_num_rows($qry_user_result) == 0) {
			echo "</tbody></table><P  class='centered'>No staff meet the filter criteria</P>";	
		}	
		While ($qry_user_row = mysql_fetch_array($qry_user_result)) {
			if ($qry_user_row['email'] <> '') {
				echo '<tr onClick="parent.location=\'mailto:'.$qry_user_row['email'].'\'">';
			} else {
				echo '<tr>';		
			} 
			
			?>

			<td axis="string" headers="firstname">
				<?php echo $qry_user_row['name'] ?></td>
			<td axis="string" headers="surname">
				<?php echo $qry_user_row['surname'] ?></td>
			<td axis="string" headers="groupmembershiplist">
				<?php echo $qry_user_row['group_membership_list'] ?></td>
			<td axis="string" headers="landline_phone">
				<?php echo $qry_user_row['tel'] ?></td>		
			<td axis="string" headers="mobile_phone"> 
				<?php echo $qry_user_row['mobile'] ?></td>			
			<td axis="string" headers="email">
				<?php echo $qry_user_row['email'] ?></td>
			<td axis="string" headers="officelocation">
				<?php echo $qry_user_row['location'] ?></td>
			</tr>

			
			<?php
		}
	}
?>
</tbody>
</table>
