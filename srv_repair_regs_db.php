<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?php /* adminova stranka - oprava tabulky usxzav */
require ("./connect.inc.php");
require ("./sess.inc.php");

if (IsLoggedAdmin())
{
	db_Connect();

	include "./common.inc.php";
	$races = Array();
	$users = Array();

	$vysledekR=MySQL_Query("SELECT id FROM ".TBL_RACE);
	while ($zaznamR=MySQL_Fetch_Array($vysledekR))
	{
		$races[] = $zaznamR['id'];
	}

	$vysledekU=MySQL_Query("SELECT id FROM ".TBL_USER);
	while ($zaznamU=MySQL_Fetch_Array($vysledekU))
	{
		$users[] = $zaznamU['id'];
	}

	$i = 0;
	$j = 0;
	$vysledek=MySQL_Query("SELECT id,id_zavod,id_user FROM ".TBL_ZAVXUS);
	$cnt = mysql_num_rows($vysledek);
	while ($zaznam=MySQL_Fetch_Array($vysledek))
	{
		if(in_array($zaznam['id_zavod'],$races) && in_array($zaznam['id_user'],$users))
		{
			$i++;
		}
		else
		{
			$result=MySQL_Query("DELETE FROM ".TBL_ZAVXUS." WHERE id='".$zaznam['id']."'")
			or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
			if ($result != FALSE)
				$j++;
		}
	}
	echo "<HTML><BODY><b>V�sledek opravy tabluky registaci v db :</b><BR>V po��dku / Celkem : ".$i."/".$cnt."<br>Smaz�no / Ke smaz�n� : ".$j."/".($cnt-$i)."<br><A href=\"".$g_baseadr."index.php?id=300&subid=1\">N�vrat na str�nky</A></BODY></HTML>";
}
else
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}
?>