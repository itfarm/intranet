<?php 
	@include_once('../config.php');
	$dbcnx = db_connection($db_host,$db_user,$db_password) or die( mysql_error() );
	$db_select = db_select($db_name,$dbcnx) or die( mysql_error() );
	$id= $_SESSION['id'];
	$form_changed = "false";
	// Get POST Information
	$form_changed = $_POST['changed'];
	if( $form_changed == "true" ) {
		$username = $_POST['username'];
		$firstname = $_POST['name'];
		$surname = $_POST['surname'];
		$mobile = $_POST['mobile'];
		$email = $_POST['email'];
		$department = $_POST['department'];
		$id = $_POST['id'];
		$query_string = "UPDATE authuser SET " . "uname = '" . $username . "', ".
						"name = '" . $firstname . "', " .
						"surname = '" . $surname . "', " .
						"email = '". $email . "', " .
						"mobile = '". $mobile . "', " .
						"department = '". $department . "'" .
						" WHERE id = '" . $id . "';";
		$biography_query = mysql_query($query_string) or die( mysql_error() );
		$form_changed = "false";
		echo "<p>Autobiography updated</p>";
	}
	
?>
<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
	<?php
		$autobiography_query = mysql_query( "SELECT uname, name, surname, email, mobile, department FROM authuser WHERE id =" . $id );
		$row = mysql_fetch_array($autobiography_query);
	?>
	<table>
		<tr>
			<td><label>Username</label></td>
			<td><input type="text" name="username" value="<?php echo $row['uname']?>"></td>
		</tr>
		<tr>
			<td><label>Firstname</label></td>
			<td><input type="text" name="name" value="<?php echo $row['name']?>"></td>
		</tr>
		<tr>
			<td><label>Surname</label></td>
			<td><input type="text" name="surname" value="<?php echo $row['surname']?>"></td>
		</tr>
		<tr>
			<td><label>Phone</label></td>
			<td><input type="text" name="mobile" value="<?php echo $row['mobile']?>"></td>
		</tr>
		<tr>
			<td><label>E-mail</label></td>
			<td><input type="text" name="email" value="<?php echo $row['email']?>"></td>
			<input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="hidden" name="changed" value="true">
		</tr>
		<tr>
			<td><label>Department</label></td>
			<td><input type="text" name="department" value="<?php echo $row['department']?>"></td>
		</tr>
		<tr>
			<td> <input type="submit" name="change" value="Submit" class="button"> </td>
		</tr>
	</table>
</form>
