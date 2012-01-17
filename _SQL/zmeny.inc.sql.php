<?

if (!defined('_ZMENY_INCLUDED')) {
	define('_ZMENY_INCLUDED', 1);

function _print_upd_info ()
{
	global $version_upd, $g_dbserver, $g_dbname, $g_baseadr;

	echo '<B>Aktualizace datab�ze pro verzi '.$version_upd.' a ni���</B>';
	echo "<BR>\n";
	echo "<code><BR>\n";
	echo 'DbServerName : <B>'.$g_dbserver."</B><BR>\n";
	echo 'DatabaseName : <B>'.$g_dbname."</B><BR>\n";
	echo 'Web Base URL : <B>'.$g_baseadr."</B><BR>\n";
	echo "</code><BR>\n";
	echo '<HR>';
}

function _list_sql_queries (&$qlist)
{
	global $this_file_name;

	echo '<U>SQL p��kazy</U> :';
	echo "<BR>\n";
	echo "<BR>\n";
	echo '<code>';
	foreach($qlist as $line)
	{
		echo '<B>SQL QUERY</B> = "'.$line.'"';
		echo "<BR>\n";
	}
	echo '</code>';
	echo '<HR>';
	echo '<BUTTON type="button" onclick="window.location = \'./'.$this_file_name.'?action=1\'">Prove� aktualizaci</BUTTON>';
}

function _run_sql_queries (&$qlist)
{
	$db_ok = 0;
	$db_err = 0;
	echo '<U>Prov�d�m SQL p��kazy</U> :';
	echo "<BR>\n";
	echo "<BR>\n";
	echo '<code>'."\n";
	foreach($qlist as $line)
	{
		echo '<B>SQL QUERY</B> = "'.$line.'"';
		echo "<BR>\n";

		$result=mysql_query($line);
		echo '&nbsp;\-------- ';
		if ($result == FALSE)
		{
			echo '<span class="ErrorText"><B>Chyba</B><BR>'."\n";
			echo 'Nepoda�ilo se prov�st zm�nu v datab�zi.<BR>'."\n";
			echo 'Error - '.mysql_errno().': '.mysql_error().'</span><BR>'."\n"; 
			echo '----------<BR>'."\n";
			$db_err ++;
		}
		else
		{
			echo '<B>OK</B><BR>'."\n";
			$db_ok ++;
		}

	}
	echo '</code>'."\n";
	echo '<HR>'."\n";
	echo ' Po�et �kon� prov�d�n�ch v db : <B>'.sizeof($qlist).'</B><BR>'."\n";
	echo ' Spr�vn� vykonan�ch �kon� v db : <B>'.$db_ok.'</B><BR>'."\n";
	echo ' Chybn� vykonan�ch �kon� v db : <span class="ErrorText"><B>'.$db_err.'</B></span><BR>'."\n";
}


}	// endif
?>