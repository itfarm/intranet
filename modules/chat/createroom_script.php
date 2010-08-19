<?php
/*
 *      createroom_script.php
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
	$name= $_POST['name'];
	$numofuser=intval($_POST['numofuser']);
	if( intval($numofuser) <2 ) {
		$numofuser=2;
	};
		
	$file_name="chatroom-" . str_replace(" ","",$name) . "_temp.txt";
	//Create chat session file
	touch("room/" .$file_name);
	chmod("room/" .$file_name,"a+rwx");
	$insert_chartoom_str="INSERT INTO chat_rooms SET name='" . $name . "', numofuser='" . $numofuser . "', file='" . $file_name . "'";
	$result = mysql_query($insert_chartoom_str) or die( mysql_error() );
	if( $result ) {
		header('Location: ./room/?name=' . $name);
	}
	else {
		header('Location: ../chatrooms.php');
	};
}
else {
	header("Location:./index.php");
};
?>
