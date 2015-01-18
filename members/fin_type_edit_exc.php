<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?php /* finance - editace (pridavani) typu prispevku */
@extract($_REQUEST);

require ('connect.inc.php');
require ('sess.inc.php');
require ('common.inc.php');
require("./cfg/_globals.php");

if (IsLoggedFinance())
{
	db_Connect();

	if ($nazev == '')
	{
		header('location: '.$g_baseadr.'error.php?code=62');
		exit;
	}
	else
	{
		if (strlen($popis) > 255)
			$popis = substr($popis,0,255);
		
		$nazev=correct_sql_string($nazev);
		$popis=correct_sql_string($popis);
		
		if (IsSet($update))
		{
			$update = (isset($update) && is_numeric($update)) ? (int)$update : 0;

			$result=MySQL_Query("UPDATE ".TBL_FINANCE_TYPES." SET nazev='$nazev', popis='$popis' WHERE id='$update'")
				or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
			if ($result == FALSE)
				die ("Nepoda�ilo se zm�nit typ p��sp�vku.");
		}
		else
		{
			$result = MySQL_Query("INSERT INTO ".TBL_FINANCE_TYPES." (nazev,popis) VALUES ('$nazev','$popis')")
				or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
			if ($result == FALSE)
				die ("Nepoda�ilo se vlo�it typ p��sp�vku.");
		}
	}
	header('location: '.$g_baseadr.'index.php?id=800&subid=4');
}
else
{
	header('location: '.$g_baseadr.'error.php?code=21');
	exit;
}
?>