<?php 
	@include_once('../config.php');
	$dbcnx = db_connection($db_host,$db_user,$db_password) or die( mysql_error() );
	$db_select = db_select($db_name,$dbcnx) or die( mysql_error() );
	// Get POST Information
	$register = $_POST['register'];
	if( $register == "Register" ) {
		$name = $_POST['name'];
		$location = $_POST['location'];
		$owner = $_POST['owner'];
		$status = $_POST['status'];
		$query_string = "INSERT INTO resource SET " . "name = '" . $name . "', ".
						"location = '" . $location . "', " .
						"owner = '" . $owner . "', " .
						"status = '". $status ."';";
		$register_query = mysql_query($query_string) or die( mysql_error() );
		$message="Venue Registered";
		Header("location:$resourcePage?message=$message");
	}
	
?>
<p class="important">Register Resource</p>
<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
	<table>
		<tr>
			<td><label class="important">Resource Name</label></td>
			<td><input type="text" name="name" value=""></td>
		</tr>
		<tr>
			<td><label class="important">Resource Location</label></td>
			<td><input type="text" name="location" value=""></td>
		</tr>
		<tr>
			<td><label class="important">Resource Owner</label></td>
			<td><input type="text" name="owner" value=""></td>
		</tr>
		<tr>
			<td><label class="important">Resource status</label></td>
			<td>
				<select name="status">
					<option value="0" selected="selected">Available</option>
					<option value="1">Reserved</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"> <input type="submit" name="register" value="Register" class="button"> </td>
		</tr>
	</table>
</form>
