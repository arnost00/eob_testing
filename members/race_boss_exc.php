<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
require ("./connect.inc.php");
require ("./sess.inc.php");
include ("./common.inc.php");
include ("./common_race.inc.php");

if (!IsLoggedRegistrator())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}

db_Connect();

$boss = (IsSet($boss) && is_numeric($boss)) ? (int)$boss : 0;
$id = (IsSet($id) && is_numeric($if)) ? (int)$id : 0;

if($id > 0)
{
	$result=MySQL_Query("UPDATE ".TBL_RACE." SET `vedouci`='$boss' WHERE `id`='$id'")
		or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
	if ($result == FALSE)
		die ("Nepoda�ilo se zm�nit �daje o z�vod�.");
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	window.opener.focus();
	window.close();
//-->
</SCRIPT>
