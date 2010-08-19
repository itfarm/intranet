<html>
<head>
<title>nabopoll installation</title>
<link rel="stylesheet" href="admin.css" type="text/css">
</head>

<body>
<table align="center">
<tr height=100>
<td align="center">Welcome to nabopoll 1.2 Installation Procedure</td>
</tr>
<tr>
<td align="center">
<font size=\"-1\">

<?

include_once ("admin.inc.php");

if (!isset($server)) $server = "";
if (!isset($server_var)) $server_var = "";
if (!isset($login)) $login = "";
if (!isset($login_var)) $login_var = "";
if (!isset($passwd)) $passwd = "";
if (!isset($passwd_var)) $passwd_var = "";
if (!isset($database)) $database = "";
if (!isset($database_var)) $database_var = "";

if (!isset($step) || $step=="")
{
	echo '<p><b><font color="red">it is recommended to backup your database before proceeding!</font></b><br>&nbsp;</p>';

	echo '<form action="install.php" method="post">';
	echo '<input type="hidden" name="step" value=2>';

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

	echo '<p align="center"><input type="submit" value="next >>" class="txtfld"></form></p>';

}
else if ($step==2)
{
	$file = fopen("../config.inc.php","w");
	fputs($file, "<?php\n\n");

	fputs($file, "\$server = '".$server."';\n");
	fputs($file, "\$server_var = '".$server_var."';\n\n");

	fputs($file, "\$login = '".$login."';\n");
	fputs($file, "\$login_var = '".$login_var."';\n\n");

	fputs($file, "\$passwd = '".$passwd."';\n");
	fputs($file, "\$passwd_var = '".$passwd_var."';\n\n");

	fputs($file, "\$database = '".$database."';\n");
	fputs($file, "\$database_var = '".$database_var."';\n\n");

	fputs($file, "?>");
	fclose($file);

	include_once ("admin.inc.php");
	connectdb();

	$version = "";
	$upgrade_ok = true;

	$result = mysql_list_tables($database_var == "on" ? getenv($database) : $database);
	$i = 0; $count = 0;
	while ($i < mysql_num_rows($result))
	{
		$tb_name = mysql_tablename ($result, $i);

		if ($tb_name == "nabopoll_version")
		{
			$res = mysql_query("select * from nabopoll_version");
			if ($res == TRUE && mysql_num_rows($res)==1)
			{
				$version = mysql_result($res, 0, "version");
				break;
			}
		}

		if (!(strpos($tb_name, "nabopoll_") === false))
			$count++;

		$i++;
	}

	if ($version == "")
	{
		if ($count == 0)
			$upgrade_ok = false;
		else if ($count==4)
			$version = "1.0";
		else
		{
			echo 'an inconsistency was found in the database. the upgrade option will not be available';
			$upgrade_ok = false;
		}
	}

	if ($version != "")
		echo 'version of nabopoll installed: '.$version.'<br>';

	if ($version >= $nabopoll_version)
	{
		echo 'the version installed is newer (or same) than this package. the upgrade option will not be available';
		$upgrade_ok = false;
	}

	if ($upgrade_ok == true)
		echo '<p>choose what you want to do:</p>';

	echo '<table><tr>';

	echo '<td><form action="install.php" method="post">';
	echo '<input type="hidden" name="step" value=3>';
	echo '<input type="hidden" name="type" value="clean">';
	echo '<input type="submit" value="clean install >>" class="txtfld">';
	echo '</form></td>';

	if ($upgrade_ok == true)
	{
		echo '<td><form action="install.php" method="post">';
		echo '<input type="hidden" name="step" value=3>';
		echo '<input type="hidden" name="type" value="upgrade">';
		echo '<input type="hidden" name="from" value="'.$version.'">';
		echo '<input type="submit" value="upgrade >>" class="txtfld">';
		echo '</form></td>';
	}
	else
	{
		echo '<td><form action="survey_edit.php" method="post">';
		echo '<input type="submit" value="edit surveys>>" class="txtfld">';
		echo '</form></td>';
	}

	echo '</tr></table>';
}
else if ($step==3)
{
	$res = false;

	include_once ("admin.inc.php");
	connectdb();

	if ($type=="clean")
	{
		// remove all the nabopoll_tables
		$result = mysql_list_tables($database_var == "on" ? getenv($database) : $database);
		$i = 0; $count = 0;
		while ($i < mysql_num_rows($result))
		{
			$tb_name = mysql_tablename ($result, $i);
			if (!(strpos($tb_name, "nabopoll_") === false))
				mysql_query("drop table ".$tb_name);
			$i++;
		}

		$res = runsqlscript("sql/nabopoll.sql");
	}
	else if ($type=="upgrade")
	{
		if ($from=="1.0")
		{
			$res = runsqlscript("sql/10to11.sql");
			$res = runsqlscript("sql/11to12.sql");
		}
		if ($from=="1.1")
		{
			$res = runsqlscript("sql/11to12.sql");
		}
	}

	if ($res == false)
	{
		echo 'error during database setup... that\'s not good!!';
	}
	else
	{
		echo 'everything seems fine!<br>';
		echo '<a href="survey_edit.php">let\'s go!</a>';
	}
}

?>

</td>
</tr>
</table>
</font>
</body>
</html>
