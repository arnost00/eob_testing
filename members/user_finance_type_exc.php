<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
@extract($_REQUEST);

require ("./connect.inc.php");
require ("./sess.inc.php");
include ("./common.inc.php");

if (!IsLoggedFinance())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}

db_Connect();

$user_id = (isset($user_id) && is_numeric($user_id)) ? (int)$user_id : 0;
$type = (isset($type)&& is_numeric($type)) ? (int)$type : 0;

$result=MySQL_Query("UPDATE ".TBL_USER." SET finance_type='$type' WHERE id='$user_id'")
	or die("Chyba p�i prov�d�n� dotazu do datab�ze.");
if ($result == FALSE)
	die ("Nepoda�ilo se zm�nit �daje o z�vod�.");

header('location: '.$g_baseadr.'?id=800&subid=1');

?>

