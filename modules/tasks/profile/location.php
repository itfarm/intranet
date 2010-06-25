<?php 
	@include_once('../config.php');
	$dbcnx = db_connection($db_host,$db_user,$db_password) or die( mysql_error() );
	$db_select = db_select($db_name,$dbcnx) or die( mysql_error() );
	$id= $_SESSION['id'];
?>
<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
	<?php
		$location_query = mysql_query( "SELECT location, address, city, zip, country FROM authuser WHERE id =" . $id );
		$row = mysql_fetch_array($location_query);
	?>
	<table>
		<tr>
			<td><label>Location</label></td>
			<td><input type="text" name="username" value="<?php echo $row['location']?>"></td>
		</tr>
		<tr>
			<td><label>Address</label></td>
			<td><input type="text" name="address" value="<?php echo $row['address']?>"></td>
		</tr>
		<tr>
			<td><label>City</label></td>
			<td><input type="text" name="city" value="<?php echo $row['city']?>"></td>
		</tr>
		<tr>
			<td><label>Zip</label></td>
			<td><input type="text" name="zip" value="<?php echo $row['zip']?>"></td>
		</tr>
		<tr>
			<td><label>Country</label></td>
			<td><input type="text" name="country" value="<?php echo $row['country']?>"></td>
			<input type="hidden" name="id" value="<?php echo $id ?>">
		</tr>
		<tr>
			<td> <input type="submit" name="change" value="Submit" class="button"> </td>
		</tr>
	</table>
</form>
