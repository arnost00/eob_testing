<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
@extract($_REQUEST);

require("./cfg/_cfg.php");
require ("./sess.inc.php");
require ("./common.inc.php");

include "./header.inc.php"; // header obsahuje uvod html a konci <BODY>
DrawPageTitle('Chybov� stav :');
?>
<TABLE width="80%" cellpadding="0" cellspacing="0" border="0">
<TR><TD width="20px" ROWSPAN="4">&nbsp;</TD><TD ALIGN=CENTER>
<H4>
<?
if (IsSet($code) && $code != 0)
{
	$errors_list = array ( // preddefinovany seznam chybovych hlasek
		11 => 'Nepoda�ilo se nav�zat spojen� s datab�z�.',
		12 => 'Chyba p�i komunikaci s datab�z�.',
		21 => 'Do t�to oblasti nem�te p��stupov� pr�va, kontaktujte spr�vce str�nek.',
		31 => 'Nem�te p��stupov� pr�va pro psan� a maz�n� novinek, kontaktujte spr�vce str�nek.',
		32 => 'Je pot�eba zadat n�jak� �daje pro vytvo�en� novinky.',
		42 => 'Je pot�eba zadat n�jak� �daje pro vytvo�en� z�vodu.',
		52 => 'Je pot�eba zadat n�jak� �daje pro zm�nu upozor�ov�n� na email.',
		62 => 'Je pot�eba zadat n�jak� �daje pro vytvo�en� typu odd�lov�ho p��sp�vku.',
		101 => 'Neexistuj�c� u�ivatel. Zadejte spr�vn� u�ivatelsk� jm�no.',
		102 => '�patn� zadan� heslo! Zkuste zadat heslo znovu.',
		103 => 'U�et je zablokov�n! Pokud nev�te d�vod, kontaktujte spr�vce str�nek.',
		201 => 'Nebyl nalezen po�adovan� z�znam.',
		202 => 'Nelze smazat sebe sama.',
		9999 => 'Nezn�m� chyba.'
	);
	$text = $errors_list[$code];
	if (strlen($text) == 0)
		$text = $errors_list[9999];
	echo $text;
	//--> log file
	{
		$ipa = getenv ('REMOTE_ADDR');
		$www = getenv ('HTTP_USER_AGENT');
		$cd = getdate();
		$scd = $cd["mday"].".".$cd["mon"].".".$cd["year"]." - ".$cd["hours"].":".$cd["minutes"].".".$cd["seconds"];
		$hr = (IsSet($HTTP_REFERER)) ? $HTTP_REFERER : '?';
		$str = $ipa."\t".$scd."\terr:".$code."\t".$www."\t".gethostbyaddr($ipa)."\tREF[".$hr."]\r\n";
		LogToFile(dirname(__FILE__) . '/logs/.errors.txt',$str);
	}
	//<-- log file
}
else
	header("location: ".$g_baseadr);
?>
</H4>
<?
 $reff = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
 if ($reff != '')
 {
	echo('<BR><A href="'.$reff.'">Zp�t</A>');
 }
?>
<BR><A href="<? echo $g_baseadr?>">Zp�t na �vodn� str�nku</A><BR><BR><BR>
<hr><BR>
</TD></TR>
<TR><TD ALIGN=CENTER>
<?include "./footer.inc.php"?>
</TD></TR>
</TABLE>

<? 	if (!$g_is_release)
{	// pri debug zobrazit
echo '<HR>';
echo '<B>Debug Informations ::</B>'."<BR>\n";
echo '<U>Current User</U>'."<BR>\n";
echo 'Func: Admin : '.IsLoggedAdmin().', Reg : '.IsLoggedRegistrator().', Mng : '.IsLoggedManager().', SmallMng : '.IsLoggedSmallManager().', Editor : '.IsLoggedEditor().', User : '.IsLogged()."<BR>\n";
echo 'Vars: Admin : '.$usr->policy_admin.', Reg : '.$usr->policy_reg.', Mng : '.$usr->policy_mng.', Editor : '.$usr->policy_news.', User : '.$usr->logged."<BR>\n";
echo 'Logged : '.$usr->logged.', UserID : '.$usr->user_id.', AccountID : '.$usr->account_id.', CrossID : '.$usr->cross_id."<BR>\n";
echo '<U>System & Browser</U>'."<BR>\n";
echo 'PHP Session ID = '._CURR_SESS_ID_."<BR>\n";
echo 'WWW Browser = ['.(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '')."]<BR>\n";
echo 'URL opened = ['.$_SERVER['PHP_SELF']."]<BR>\n";
echo 'Referer URL  = ['.(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '')."]<BR>\n";
echo 'header = ["Last-Modified: '. gmdate("D, d M Y H:i:s") .' GMT"]'."<BR>\n";
echo '<HR>';
} ?>

</BODY>
</HTML>