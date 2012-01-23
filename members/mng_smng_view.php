<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?php
@extract($_REQUEST);

require("./cfg/_colors.php");
require ("./connect.inc.php");
require ("./sess.inc.php");

if (!IsLoggedManager())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}
require ("./ctable.inc.php");
include ("./header.inc.php"); // header obsahuje uvod html a konci <BODY>
include ("./common.inc.php");
include ("./common_user.inc.php");

DrawPageTitle('Zobrazen� �len� p�id�len�ch mal�mu tren�ru', false);

echo '<H3>Tren�r'."</H3>\n";

db_Connect();

@$vysledek0=MySQL_Query("SELECT jmeno,prijmeni,reg FROM ".TBL_USER." WHERE id = $id LIMIT 1");
@$zaznam0=MySQL_Fetch_Array($vysledek0);

$data_tbl = new html_table_nfo;
$data_tbl->enable_row_select = false;
echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_new_row('Jm�no',$zaznam0['jmeno'].' '.$zaznam0['prijmeni']);
echo $data_tbl->get_new_row('Registra�n� ��slo',$g_shortcut.RegNumToStr($zaznam0['reg']));
echo $data_tbl->get_footer()."\n";

echo '<H3>P�i�azen� �lenov�'."</H3>\n";

$i=1;
$data_tbl = new html_table_mc();
$col = 0;
$data_tbl->set_header_col($col++,'Po�.�.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'P��jmen�',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Jm�no',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Reg.�.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Lic.OB',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Lic.MTBO',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Lic.LOB',ALIGN_CENTER);

echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_header_row()."\n";

@$vysledek=MySQL_Query('SELECT id,prijmeni,jmeno,reg,hidden,lic,lic_mtbo,lic_lob FROM '.TBL_USER.' WHERE chief_id = '.$id.' ORDER BY sort_name ASC ');

while ($zaznam=MySQL_Fetch_Array($vysledek))
{
	if (!$zaznam['hidden'])
	{
		$row = array();
		$row[] = $i++;
		$row[] = $zaznam['prijmeni'];
		$row[] = $zaznam['jmeno'];
		$row[] = RegNumToStr($zaznam['reg']);
		$row[] = ($zaznam['lic'] != 'C' || $zaznam['lic'] != '-') ? '<B>'.$zaznam['lic'].'</B>' : $zaznam['lic'];
		$row[] = ($zaznam['lic_mtbo'] != 'C' || $zaznam['lic_mtbo'] != '-') ? '<B>'.$zaznam['lic_mtbo'].'</B>' : $zaznam['lic_mtbo'];
		$row[] = ($zaznam['lic_lob'] != 'C' || $zaznam['lic_lob'] != '-') ? '<B>'.$zaznam['lic_lob'].'</B>' : $zaznam['lic_lob'];
		echo $data_tbl->get_new_row_arr($row)."\n";
	}
}
echo $data_tbl->get_footer()."\n";

//--------------------------------
/*
@$vysledek=MySQL_Query("SELECT * FROM ".TBL_USER." WHERE id = $id LIMIT 1");
@$zaznam=MySQL_Fetch_Array($vysledek);

$data_tbl = new html_table_nfo;
$data_tbl->enable_row_select = false;
echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_new_row('Jm�no',$zaznam['jmeno'].' '.$zaznam['prijmeni']);
echo $data_tbl->get_new_row('Registra�n� ��slo',$g_shortcut.RegNumToStr($zaznam['reg']));
echo $data_tbl->get_new_row('��slo SI �ipu',SINumToStr($zaznam['si_chip']));
echo $data_tbl->get_new_row('Datum narozen�', SQLDate2String($zaznam['datum']));
echo $data_tbl->get_new_row('Licence', $zaznam['lic']);
echo $data_tbl->get_footer()."\n";

echo '<H3 class="LinksTitle">Tren�r pro �lena</H2>'."\n";

*/
?>
<BR>
<BUTTON onclick="javascript:close_popup();">Zp�t</BUTTON>
</TD></TR></TABLE>

</body>
</html>