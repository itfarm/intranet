<!--
        index.html
        
        Copyright 2010 John Francis Mukulu <john.f.mukulu@gmail.com>
        
        This program is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.
        
        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.
        
        You should have received a copy of the GNU General Public License
        along with this program; if not, write to the Free Software
        Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
        MA 02110-1301, USA.
-->
<?php
	include('config.php');
	session_start();
	if( isset($_SESSION['username']) )
	{
		header("location:$dashboardPage");
	}
	else {
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Login Form</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.18" />
</head>

<body>
	<form action="<?php echo $verificationPage ?>" method="post" class="form">
		<h5><?php echo $_GET['message'] ?></h5>
		<fieldset>
			<legend>Login Form</legend>
			<p><label for="username">Username</label> <input name="username" id="input" type="text"></p>
			<p><label for="password">Password</label> <input name="password" id="input" type="password"></p>
			<p class="submit"><input value="Login" type="submit"></p>
		</fieldset>
	</form>
</body>
</html>

<?php
	}
	// End of session
?>
