<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?php
require("./cfg/_colors.php");
require ("./connect.inc.php");
require ("./sess.inc.php");

if (!IsLoggedRegistrator())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}
require ("./ctable.inc.php");
include ("./header.inc.php"); // header obsahuje uvod html a konci <BODY>
include ("./common.inc.php");
include ("./common_race.inc.php");
include ("./common_user.inc.php");
include ('./url.inc.php');

DrawPageTitle('P�i�azen� SI �ip� pro z�vod', false);

db_Connect();

$id_zav = (isset($id_zav) && is_numeric($id_zav)) ? (int)$id_zav : 0;

$query = 'SELECT u.*, z.kat, z.pozn, z.pozn_in, z.si_chip as t_si_chip FROM '.TBL_ZAVXUS.' as z, '.TBL_USER.' as u WHERE z.id_user = u.id AND z.id_zavod='.$id_zav.' AND u.si_chip = 0 AND u.hidden = 0 ORDER BY z.id ASC';

@$vysledek=MySQL_Query($query);

@$vysledek_z=MySQL_Query("SELECT * FROM ".TBL_RACE." WHERE id=$id_zav LIMIT 1");
$zaznam_z = MySQL_Fetch_Array($vysledek_z);

?>
<H3>Vybran� z�vod</H3>

<?
RaceInfoTable($zaznam_z);
?>

<BR><BR><hr><BR>
<H3>P�ihl�en� z�vodn�ci bez trval�ch SI �ip�</H3>
<?
if (mysql_num_rows($vysledek) > 0)
{
?>
<FORM METHOD="POST" ACTION="race_reg_chip_exc.php?id_zav=<? echo($id_zav); ?>">

<?
	$data_tbl = new html_table_mc();
	$col = 0;
	$data_tbl->set_header_col($col++,'Po�.',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'Jm�no',ALIGN_LEFT);
	$data_tbl->set_header_col($col++,'P��jmen�',ALIGN_LEFT);
	$data_tbl->set_header_col($col++,'Reg.',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'SI �ip',ALIGN_RIGHT);
	$data_tbl->set_header_col($col++,'Kategorie',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'Pozn�mka',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'Pozn�mka (intern�)',ALIGN_CENTER);

	echo $data_tbl->get_css()."\n";
	echo $data_tbl->get_header()."\n";
	echo $data_tbl->get_header_row()."\n";

	$i=0;
	while ($zaznam=MySQL_Fetch_Array($vysledek))
	{
		$i++;

		$row = array();
		$row[] = $i.'<!-- '.$zaznam['id'].' -->';
		$row[] = $zaznam['jmeno'];
		$row[] = $zaznam['prijmeni'];
		$row[] = $g_shortcut.RegNumToStr($zaznam['reg']);
		$row[] = '<input type="text" name="chip['.$zaznam['id'].']" SIZE=9 MAXLENGTH=9 value="'.$zaznam['t_si_chip'].'">';
		$row[] = '<B>'.$zaznam['kat'].'</B>';
		$row[] = $zaznam['pozn'];
		$row[] = $zaznam['pozn_in'];

		echo $data_tbl->get_new_row_arr($row)."\n";
	}
	echo $data_tbl->get_footer()."\n";
?>
<br>
<INPUT TYPE="submit" value='Zapsat �ipy pro z�vod'>
</FORM>
<?
}
else
{
	echo('Nejsou p�ihl�en� ��dn� z�vodn�ci bez vlastn�ch �ip�.<br>');
}
?>
<BR>
<BUTTON onclick="javascript:close_popup();">Zav�i</BUTTON>

</body>
</html>
