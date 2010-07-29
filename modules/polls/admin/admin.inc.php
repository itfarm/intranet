<?php

$path="../";
@include_once("../config.inc.php");
@include_once("../includes/nabopoll.inc.php");

$nabopoll_version = "1.2";

function openadmin()
{
	global $nabopoll_version;	header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1	header("Pragma: no-cache");                                   // HTTP/1.0
	echo "<html>\n<head>\n";	echo "<link rel=\"stylesheet\" href=\"admin.css\" type=\"text/css\">\n";	echo "<title>nabopoll ".$nabopoll_version."</title>\n";	echo "<script language=\"JavaScript\">\n";	echo "<!--\n";	echo "// Nannette Thacker http://www.shiningstar.net\n";	echo "function confirmSubmit()\n";	echo "{\n";	echo "	var agree=confirm(\"Are you sure you wish to continue?\");\n";	echo "	if (agree) return true;\n";	echo "	else return false;\n";	echo "}\n";	echo "// -->\n";	echo "</script>\n";	echo "</head>\n<body>\n";	echo "<table align=\"center\"><tr height=100><td align=\"center\">\n";	echo "<a href=\"config_edit.php\">config</a> | <a href=\"template_edit.php\">templates</a> | <a href=\"survey_edit.php\">survey edit</a>\n";	echo "</td></tr><tr><td align=\"center\">\n";	echo "<font size=\"-1\">\n";
}

function closeadmin()
{
	echo '</td></tr></table>';
	echo '</font>';
	echo '</body>';
	echo '</html>';
}

function error($error_msg)
{
	openadmin();
	echo $error_msg;
	closeadmin();
}

function formtemplates($tmpl)
{
	echo '<select name="template" class="txtfld">';

	$path = "../templates";
	$folder = opendir($path);
	while ($file = readdir($folder))
		if ($file != "." && $file != ".." && is_dir($path.'/'.$file) && $file != "cvs" && $file != "CVS")
			echo '<option value="'.$file.'"'. ($file==$tmpl ? ' selected' : ''). '>'.$file.'</option>';
	echo '</select>';
	closedir($folder);
}

function formsinglevote($sv)
{
	echo '<select name="single_vote" class="txtfld">';
	echo '<option value=0'. ($sv==0 ? ' selected' : '').'>No Check</option>';
	echo '<option value=1'. ($sv==1 ? ' selected' : '').'>Test IP</option>';
	echo '<option value=2'. ($sv==2 ? ' selected' : '').'>Cookies</option>';
	echo '</select>';
}

//
// split_sql_file will split an uploaded sql file into single sql statements.
// Note: expects trim() to have already been run on $sql.
//
function split_sql_file($sql, $delimiter)
{
	// Split up our string into "possible" SQL statements.
	$tokens = explode($delimiter, $sql);

	// try to save mem.
	$sql = "";
	$output = array();

	// we don't actually care about the matches preg gives us.
	$matches = array();

	// this is faster than calling count($oktens) every time thru the loop.
	$token_count = count($tokens);
	for ($i = 0; $i < $token_count; $i++)
	{
		// Don't wanna add an empty string as the last thing in the array.
		if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
		{
			// This is the total number of single quotes in the token.
			$total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
			// Counts single quotes that are preceded by an odd number of backslashes,
			// which means they're escaped quotes.
			$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

			$unescaped_quotes = $total_quotes - $escaped_quotes;

			// If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
			if (($unescaped_quotes % 2) == 0)
			{
				// It's a complete sql statement.
				$output[] = $tokens[$i];
				// save memory.
				$tokens[$i] = "";
			}
			else
			{
				// incomplete sql statement. keep adding tokens until we have a complete one.
				// $temp will hold what we have so far.
				$temp = $tokens[$i] . $delimiter;
				// save memory..
				$tokens[$i] = "";

				// Do we have a complete statement yet?
				$complete_stmt = false;

				for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
				{
					// This is the total number of single quotes in the token.
					$total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
					// Counts single quotes that are preceded by an odd number of backslashes,
					// which means they are escaped quotes.
					$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

					$unescaped_quotes = $total_quotes - $escaped_quotes;

					if (($unescaped_quotes % 2) == 1)
					{
						// odd number of unescaped quotes. In combination with the previous incomplete
						// statement(s), we now have a complete statement. (2 odds always make an even)
						$output[] = $temp . $tokens[$j];

						// save memory.
						$tokens[$j] = "";
						$temp = "";

						// exit the loop.
						$complete_stmt = true;
						// make sure the outer loop continues at the right point.
						$i = $j;
					}
					else
					{
						// even number of unescaped quotes. We still do not have a complete statement.
						// (1 odd and 1 even always make an odd)
						$temp .= $tokens[$j] . $delimiter;
						// save memory.
						$tokens[$j] = "";
					}

				} // for..
			} // else
		}
	}

	return $output;
}

//
// remove_remarks will strip the sql comment lines out of an uploaded sql file
//
function remove_remarks($sql)
{
	$lines = explode("\n", $sql);

	// try to keep mem. use down
	$sql = "";

	$linecount = count($lines);
	$output = "";

	for ($i = 0; $i < $linecount; $i++)
	{
		if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
		{
			if ($lines[$i][0] != "#")
			{
				$output .= $lines[$i] . "\n";
			}
			else
			{
				$output .= "\n";
			}
			// Trading a bit of speed for lower mem. use here.
			$lines[$i] = "";
		}
	}

	return $output;

}

function runsqlscript($dbms_schema)
{
	$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema));
	$sql_query = remove_remarks($sql_query);
	$sql_query = split_sql_file($sql_query, ";");
	$sql_count = count($sql_query);

	$ok = true;
	echo '<p>';

	for($i = 0; $i < $sql_count; $i++)
	{
		$result = mysql_query($sql_query[$i]);
		if ($result == false)
		{
			echo $sql_query[$i].'...<font color="red"><b>KO</b></font><br>';
			$ok = false;
			break;
		}
	}
	echo '</p>';
	return $ok;
}

function write1pixelgif($color, $filename)
{
	if ($color{0} == '#')
	{
		copy ('../images/1x1.gif', $filename);
		$file = fopen($filename, 'r+b');
		fseek($file, 13);

		$r = substr($color, 1, 2);
		$red = base_convert($r{0},16,10) * 16 + base_convert($r{1},16,10);
		fwrite($file, chr($red), 1);

		$g = substr($color, 3, 2);
		$green = base_convert($g{0},16,10) * 16 + base_convert($g{1},16,10);
		fwrite($file, chr($green), 1);

		$b = substr($color, 5, 2);
		$blue = base_convert($b{0},16,10) * 16 + base_convert($b{1},16,10);
		fwrite($file, chr($blue), 1);

		fclose($file);
	}
}

function getuniqueid()
{
	while (true)
	{
		$uid = ceil(mysql_result(mysql_query("select rand()*1e9 as uid from nabopoll_version"), 0, "uid"));
		$res = mysql_query("select 1 from nabopoll_surveys where uid=$uid");
		if ($res == TRUE && mysql_num_rows($res) == 0)
			break;
	}
	return $uid;
}

?>
