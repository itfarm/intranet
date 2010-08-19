<?php

// make sure get/post variables exist
$err = error_reporting(0);
import_request_variables("GP", "");
error_reporting($err);

// this the mode of the survey
define("SM_NORMAL", 0);
define("SM_QUICK", 1);
define("SM_ONEPAGE", 2);

// this is the type of question
define("QT_SINGLE", 0);
define("QT_MULTI", 1);
define("QT_FREE", 2);

function connectdb()
{
	global $path;
	include($path."config.inc.php");

	// build connection parameters
	$s = $server_var == "on" ? getenv($server) : $server;
	$l = $login_var == "on" ? getenv($login) : $login;
	$p = $passwd_var == "on" ? getenv($passwd) : $passwd;
	$d = $database_var == "on" ? getenv($database) : $database;

	// connect, select db
	$link = mysql_connect($s, $l, $p);
	if ($link==false)
		error("no connection to mysql server");

	if (mysql_select_db($d) == false)
		error("no connection to database");
}

function redirect($url)
{
	if (headers_sent())
	{
		echo '<meta http-equiv="refresh" content="0;URL='.$url.'">';
	}
	else
	{
		header("Location: $url");
	}
	//exit();
}

function getimage($value, $path, $template, $base)
{
	if ($value{0} != '#')
		return $path.$value;
	else
		return $path.'templates/'.$template.'/'.$base.'.gif';
}

function getbar($pct, $width, $height, $image_bar, $image_padding)
{
	$bar = '<img src="'. $image_bar.'" width='.($pct!=0 ? ceil($pct/100*$width) : 1).' height='.$height.'>';
	if ($pct != 100)
		$bar = $bar . '<img src="'.$image_padding.'" width='.ceil((100-$pct)/100*$width).' height='.$height.'>';
	return $bar;
}

?>
