<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
@extract($_REQUEST);

require_once ("./connect.inc.php");
require_once ("./sess.inc.php");
require_once ("./common.inc.php");
require_once ("./common_race.inc.php");

if (!IsLoggedRegistrator())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}

db_Connect();

$boss = (IsSet($boss) && is_numeric($boss)) ? (int)$boss : 0;
$id = (IsSet($id) && is_numeric($id)) ? (int)$id : 0;

if($id > 0)
{
	$query = "UPDATE ".TBL_RACE." SET `vedouci`='$boss' WHERE `id`='$id'";
	$result=query_db($query);
		or die("Chyba při provádění dotazu do databáze.");
	if ($result == FALSE)
		die ("Nepodařilo se změnit údaje o závodě.");
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	window.opener.focus();
	window.close();
//-->
</SCRIPT>
