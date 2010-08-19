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
	require_once("./dbcon.php");
	$remove_user_str="DELETE FROM chat_users WHERE username='" . $_SESSION['userid'] . "'";
	$result = mysql_query($remove_user_str) or die( mysql_error() );
	$remove_user_from_group_str="DELETE FROM chat_users_rooms WHERE username='" . $_SESSION['userid'] ."'";
	$result = mysql_query($remove_user_from_group_str) or die( mysql_error() );
	if( $result ) {
		header('Location: ./index.php');
	}
	else {
		header('Location: chatrooms.php');
	};
}
else {
	header("Location:./index.php");
};
?>
