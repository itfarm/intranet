<?php

include_once("../includes/tags.inc.php");
include_once("admin.inc.php");

openadmin();
echo '<form action="config_alter.php" method="post">';

echo '<p><table><tr><td>';

// mysql
echo '<table border=1 cellspacing=0 cellpadding=5><tr><th colspan=3>MySQL configuration</th></tr>';
echo '<tr><th>&nbsp;</th><th>String</th><th>Environment Variable</th></tr>';

	// server
	echo '<tr><td>Server</td>';
	echo '<td align="center"><input type="text" class="txtfld" name="server" value="'.$server.'"></td>';
	echo '<td align="center"><input type="checkbox" class="txtfld" name="server_var"'.($server_var=="on"?" checked":"").'></td></tr>';

	// login
	echo '<tr><td>Login</td>';
	echo '<td align="center"><input type="text" class="txtfld" name="login" value="'.$login.'"></td>';
	echo '<td align="center"><input type="checkbox" class="txtfld" name="login_var"'.($login_var=="on"?" checked":"").'></td></tr>';

	// passwd
	echo '<tr><td>Password</td>';
	echo '<td align="center"><input type="text" class="txtfld" name="passwd" value="'.$passwd.'"></td>';
	echo '<td align="center"><input type="checkbox" class="txtfld" name="passwd_var"'.($passwd_var=="on"?" checked":"").'></td></tr>';

	// database
	echo '<tr><td>Database</td>';
	echo '<td align="center"><input type="text" class="txtfld" name="database" value="'.$database.'"></td>';
	echo '<td align="center"><input type="checkbox" class="txtfld" name="database_var"'.($database_var=="on"?" checked":"").'></td></tr>';

// end of mysql
echo '</table>';

echo '<p align="center"><input type="submit" value="save" class="txtfld"></form></p>';
closeadmin();

?>
