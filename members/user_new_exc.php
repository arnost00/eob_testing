<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?php /* adminova stranka - provedeni vlozeni clena */
@extract($_REQUEST);

require ('./connect.inc.php');
require ('./sess.inc.php');
require ('./modify_log.inc.php');

if (!IsSet($fin)) $fin = 0;
if (!IsSet($rc)) $rc = '';

include "./common.inc.php";

if (!IsSet($hidden)) $hidden = 0;
$datum = String2SQLDateDMY($datum);

// --> filling of czech sort helping column
$name2 = $prijmeni." ".$jmeno;
switch ($g_czech_sort)
{
	case 1 :	// cp1250 -> iso?
		$name2 = cp2iso($name2);
		break;
	case 2 :	//	 without changes
		break;
}
// <-- end

db_Connect();

$prijmeni=correct_sql_string($prijmeni);
$jmeno=correct_sql_string($jmeno);
$datum=correct_sql_string($datum);
$adresa=correct_sql_string($adresa);
$mesto=correct_sql_string($mesto);
$psc=correct_sql_string($psc);
$domu=correct_sql_string($domu);
$zam=correct_sql_string($zam);
$mobil=correct_sql_string($mobil);
$email=correct_sql_string($email);
$reg=correct_sql_string($reg);
$si=correct_sql_string($si);
$name2=correct_sql_string($name2);
$hidden=correct_sql_string($hidden);
$poh=correct_sql_string($poh);
$lic=correct_sql_string($lic);
$lic_mtbo=correct_sql_string($lic_mtbo);
$lic_lob=correct_sql_string($lic_lob);
$fin=correct_sql_string($fin);
$rc=correct_sql_string($rc);

if (IsLoggedAdmin())
{
	if (IsSet($update))
	{
		$update = (isset($update) && is_numeric($update)) ? (int)$update : 0;

		$result=MySQL_Query("UPDATE ".TBL_USER." SET prijmeni='$prijmeni', jmeno='$jmeno', datum='$datum', adresa='$adresa', mesto='$mesto', psc='$psc', tel_domu='$domu', tel_zam='$zam', tel_mobil='$mobil', email='$email', reg='$reg', si_chip='$si' , hidden='$hidden', sort_name='$name2', poh='$poh', lic='$lic', lic_mtbo='$lic_mtbo', lic_lob='$lic_lob', fin='$fin', rc='$rc' WHERE id='$update'")
			or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
		if ($result == FALSE)
			die ("Nepoda�ilo se zm�nit �daje �lena.");
		SaveItemToModifyLog_Edit(TBL_USER,$jmeno.' '.$prijmeni.' ['.$reg.']');
	}
	else
	{
		$result=MySQL_Query("INSERT INTO ".TBL_USER." (prijmeni,jmeno,datum,adresa,mesto,psc,tel_domu,tel_zam,tel_mobil,email,reg,si_chip,hidden,sort_name,poh,lic,lic_mtbo,lic_lob,fin,rc) VALUES ('$prijmeni','$jmeno','$datum','$adresa','$mesto','$psc','$domu','$zam','$mobil','$email','$reg','$si','$hidden','$name2','$poh','$lic','$lic_mtbo','$lic_lob','$fin','$rc')")
			or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
		if ($result == FALSE)
			die ("Nepoda�ilo se vlo�it �lena.");
		SaveItemToModifyLog_Add(TBL_USER,$jmeno.' '.$prijmeni.' ['.$reg.']');
	}
	header("location: ".$g_baseadr."index.php?id=300&subid=3");
}
else if (IsLoggedManager() || IsLoggedSmallManager())
{
	$hidden = 0;	// unhidden users only

	if (IsSet($update))
	{
		$update = (isset($update) && is_numeric($update)) ? (int)$update : 0;
		
		$result=MySQL_Query("UPDATE ".TBL_USER." SET prijmeni='$prijmeni', jmeno='$jmeno', datum='$datum', adresa='$adresa', mesto='$mesto', psc='$psc', tel_domu='$domu', tel_zam='$zam', tel_mobil='$mobil', email='$email', reg='$reg', si_chip='$si' , hidden='$hidden', sort_name='$name2', poh='$poh', lic='$lic', lic_mtbo='$lic_mtbo', lic_lob='$lic_lob', fin='$fin' WHERE id='$update'")
			or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
		if ($result == FALSE)
			die ("Nepoda�ilo se zm�nit �daje �lena.");
		SaveItemToModifyLog_Edit(TBL_USER,$jmeno.' '.$prijmeni.' ['.$reg.']');
	}
	else
	{
		$result=MySQL_Query("INSERT INTO ".TBL_USER." (prijmeni,jmeno,datum,adresa,mesto,psc,tel_domu,tel_zam,tel_mobil,email,reg,si_chip,hidden,sort_name,poh,lic,lic_mtbo,lic_lob,fin) VALUES ('$prijmeni','$jmeno','$datum','$adresa','$mesto','$psc','$domu','$zam','$mobil','$email','$reg','$si','$hidden','$name2','$poh','$lic','$lic_mtbo','$lic_lob','$fin')")
			or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
		if ($result == FALSE)
			die ("Nepoda�ilo se vlo�it �lena.");
		SaveItemToModifyLog_Add(TBL_USER,$jmeno.' '.$prijmeni.' ['.$reg.']');
	}
	if (IsSet($update) && $update == $usr->user_id)
		header("location: ".$g_baseadr."index.php?id=200&subid=3");
	else if (IsLoggedSmallManager())
		header("location: ".$g_baseadr."index.php?id=600&subid=1");
	else
		header("location: ".$g_baseadr."index.php?id=500&subid=1");
}
else if (IsLoggedUser())
{
	if (IsSet($update) && $update == $usr->user_id)
	{
		$update = (isset($update) && is_numeric($update)) ? (int)$update : 0;

		$hidden = 0;	// unhidden users only

		$result=MySQL_Query("UPDATE ".TBL_USER." SET prijmeni='$prijmeni', jmeno='$jmeno', datum='$datum', adresa='$adresa', mesto='$mesto', psc='$psc', tel_domu='$domu', tel_zam='$zam', tel_mobil='$mobil', email='$email', reg='$reg', si_chip='$si' , hidden='$hidden', sort_name='$name2', poh='$poh', lic_mtbo='$lic_mtbo', lic_lob='$lic_lob', fin='$fin' WHERE id='$update'")
			or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
		if ($result == FALSE)
			die ("Nepoda�ilo se zm�nit �daje �lena.");
		SaveItemToModifyLog_Edit(TBL_USER,$jmeno.' '.$prijmeni.' ['.$reg.']');
	}
	header("location: ".$g_baseadr."index.php?id=200&subid=3");
}
else
{
	header("location:".$g_baseadr."error.php?code=21");
	exit;
}
?>