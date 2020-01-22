<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
@extract($_REQUEST);

require_once ("./connect.inc.php");
require_once ("./sess.inc.php");
require_once ("./common.inc.php");

require_once "./race_kateg_list.inc.php";

if (!IsLoggedRegistrator())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}
$id = (IsSet($id) && is_numeric($id)) ? (int)$id : 0;

db_Connect();

$kat_arr = array();

foreach ($kategorie_vypis as $kat_key => $kat_value)
{
	foreach ($zebricek_vypis as $zeb_key => $zeb_value)
	{
		if (IsSet($H[$kat_value][$zeb_value]) && $H[$kat_value][$zeb_value])
		{
			$kat_arr[] = 'H'.$kat_key.$zeb_key;
		}
		if (IsSet($D[$kat_value][$zeb_value]) && $D[$kat_value][$zeb_value])
		{
			$kat_arr[] ='D'.$kat_key.$zeb_key;
		}
	}
	if (IsSet($H[$kat_value]['X']) && $H[$kat_value]['X'])
	{
		$kat_arr[] ='H'.$kat_key;
	}
	if (IsSet($D[$kat_value]['X']) && $D[$kat_value]['X'])
	{
		$kat_arr[] ='D'.$kat_key;
	}

}

$kat_arr_n = explode(";",$kat_n);
foreach ($kat_arr_n as $kat_n1)
{
	if (!in_array($kat_n1, $kat_arr) && $kat_n1 != '')
	{
		$kat_arr[] = $kat_n1;
	}
}


$kategorie = implode(';',$kat_arr);
$kategorie=correct_sql_string($kategorie);

$result=query_db('UPDATE '.TBL_RACE." SET `kategorie`='$kategorie' WHERE `id`='$id'")
	or die('Chyba při provádění dotazu do databáze.');
if ($result == FALSE)
	die ('Nepodařilo se změnit údaje o závodě.');

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	window.opener.location.reload();

	window.opener.focus();
	window.close();
//-->
</SCRIPT>
