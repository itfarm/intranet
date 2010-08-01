<?php
	include('config.php');
/*
 *      logout.php
 *      
 *      Copyright 2010 John Mukulu <john.f.mukulu@gmail.com>
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
if( isset($_SESSION['username']) )
{
		//add record user_log table
		$arrUserLog = array();
		$arrUserLog['szAction'] = 'User logs out';
		utc_add_update_user_log($arrUserLog);
		session_destroy();
		$message="Logged out Successfully!";
		Header("location:$loginPage?message=$message");
}
else {
		//add record user_log table
		$message="You have already logged out!";
		Header("location:$loginPage?message=$message");
};
?>

