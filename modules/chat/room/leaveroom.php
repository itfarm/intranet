<?php
/*
 *      leaveroom.php
 *      
 *      Copyright 2010 Live session user <bongo@bongo>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
session_start();
if( isset($_SESSION['userid']) ) {
	require_once("../dbcon.php");
	$name= $_GET['name'];
	$remove_user_from_group_str="DELETE FROM chat_users_rooms WHERE username='" . $_SESSION['userid'] . "' AND room='" . $name ."'";
	$result = mysql_query($remove_user_from_group_str) or die( mysql_error() );
	if( $result ) {
		// Clean temporary rooms if have no users
		$empty_temp_str="SELECT * FROM chat_rooms WHERE file LIKE '%_temp.txt%'";
		$empty_temp_query = mysql_query($empty_temp_str);
		for( $incr=0;$incr< mysql_num_rows($empty_temp_query); $incr++ ) {
			$row = mysql_fetch_array($empty_temp_query);
			// Check if temp chat sessions are still used.
			$users_using_temp_str= "SELECT * from chat_users_rooms WHERE room='" . $row['name'] . "'";
			$users_using_temp_query = mysql_query($users_using_temp_str) or die( mysql_error() );
			if( mysql_num_rows($users_using_temp_query) > 0 ) {
				echo "<p>Some dudes are still using " . $row['name'] ."</p>";
			}else {
				echo "<p>No body is using " . $row['name'] ."</p>";
				// If no body is using them. remove them
				$remove_chartoom_str="DELETE FROM chat_rooms WHERE name='" . $row['name'] . "'";
				$result = mysql_query($remove_chartoom_str) or die( mysql_error() );
			};
		};
		header('Location: ../chatrooms.php');
	}
	else {
		header('Location: ./?name=' . $name);
	};
}
else {
	header("Location:../index.php");
};
?>
