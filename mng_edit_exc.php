<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
@extract($_REQUEST);

require ("./connect.inc.php");
require ("./sess.inc.php");

if (!IsLoggedManager())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}
db_Connect();

$id = (IsSet($id) && is_numeric($id)) ? (int)$id : 0;
$mng = (IsSet($mng) && is_numeric($mng)) ? (int)$mng : 0;

if($id > 0)
{
	$result=MySQL_Query("UPDATE ".TBL_USER." SET `chief_id`='$mng' WHERE `id` = '$id'")
		or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
	if ($result == FALSE)
		die ("Nepoda�ilo se zm�nit p�ihl�ku �lena.");
}
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
	window.opener.focus();
	window.close();
//-->
</SCRIPT>
