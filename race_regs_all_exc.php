<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
@extract($_REQUEST);

require ("./connect.inc.php");
require ("./sess.inc.php");

if (!IsLoggedRegistrator() && !IsLoggedManager()&& !IsLoggedSmallManager())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}

require ("./common.inc.php");
require ("./common_race.inc.php");

$gr_id = (IsSet($gr_id) && is_numeric($gr_id)) ? $gr_id : 0;
db_Connect();

@$vysledek=MySQL_Query("SELECT id_user FROM ".TBL_ZAVXUS." WHERE $id=id_zavod");

while ($zaznam=MySQL_Fetch_Array($vysledek))
{
	$zaz_db[]=$zaznam["id_user"];
}

@$vysledekZ=MySQL_Query("SELECT id,hidden FROM ".TBL_USER);

@$vysledek_z=MySQL_Query("SELECT * FROM ".TBL_RACE." WHERE id=$id");
$zaznam_z = MySQL_Fetch_Array($vysledek_z);

$is_registrator_on = false;

if($zaznam_z['vicedenni'])
{
	if(IsCalledByManager($gr_id) || IsCalledBySmallManager($gr_id))
	{
		$termin = GetActiveRaceRegTerm($zaznam_z);
	}
	else if(IsCalledByRegistrator ($gr_id) || IsCalledByAdmin ($gr_id))
	{
		$is_registrator_on = true;
		$termin_curr = GetActiveRaceRegTerm($zaznam_z);
		$termin = 0;
	}
	else
		$termin = 1;
}
else
	$termin = 1;

if($termin == 0)
	$termin = 1;

while ($zaznamZ=MySQL_Fetch_Array($vysledekZ))
{
	if ($zaznamZ["hidden"] == 0)
	{
		$user=$zaznamZ["id"];
		if (IsSet($kateg[$user]))
		{
			$kat = $kateg[$user];
			$poz = $pozn[$user];
			$poz2 = $pozn2[$user];
			if($is_registrator_on)
			{
				$termin = ($term[$user] > 0 && $term[$user] <= $termin_curr) ? $term[$user] : $termin_curr;
				if($termin == 0)
					$termin = 1;
			}
			if (IsSet($zaz_db) && count($zaz_db) > 0 && in_array($user,$zaz_db))
			{
				if ($kat == "")
				{	// del
	//				echo "DEL";
					$result=MySQL_Query("DELETE FROM ".TBL_ZAVXUS." WHERE id_zavod = '$id' AND id_user = '$user'")
						or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
					if ($result == FALSE)
						die ("Nepoda�ilo se zm�nit p�ihl�ku �lena.");
				}
				else
				{	// update
	//				echo "UPD";
					$result=MySQL_Query("UPDATE ".TBL_ZAVXUS." SET kat='$kat', pozn='$poz', pozn_in='$poz2', termin='$termin' WHERE id_zavod = '$id' AND id_user = '$user'")
						or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
					if ($result == FALSE)
						die ("Nepoda�ilo se zm�nit p�ihl�ku �lena.");
				}
			}
			else
			{
				if ($kat != "")
				{	// new
	//				echo "NEW";
					$result=MySQL_Query("INSERT INTO ".TBL_ZAVXUS." (id_user, id_zavod, kat, pozn, pozn_in,termin) VALUES ('$user','$id','$kat', '$poz','$poz2','$termin')")
						or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
					if ($result == FALSE)
						die ("Nepoda�ilo se zm�nit p�ihl�ku �lena.");
				}
			}
	//		echo " -".$kat." u clena ".$user." a s pozn.: '".$poz."'<BR>";
		}
	}
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	window.opener.focus();
	window.close();
//-->
</SCRIPT>
