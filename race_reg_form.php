<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?php
@extract($_REQUEST);

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

DrawPageTitle('Export p�ihl�ky - kontrola', false);

db_Connect();

$id_zav = (isset($id_zav) && is_numeric($id_zav)) ? (int)$id_zav : 0;
//------------------------------
$regsend = (isset($regsend) && is_numeric($regsend)) ? (int)$regsend : -1;
if($regsend >= 0 && $regsend <= 5)
{
	$regsendnow = (isset($regsendnow) && is_numeric($regsendnow)) ? (int)$regsendnow : 0;
	if($regsendnow > 0)
	{	// save new regsend...
		$result=MySQL_Query("UPDATE ".TBL_RACE." SET `send`='$regsend' WHERE `id`='$id_zav'")
				or die('Chyba p�i prov�d�n� dotazu do datab�ze.');
		if ($result == FALSE)
			die ('Nepoda�ilo se zm�nit �daje o z�vod�.');
	}
}
else	// kontrola rozsahu
	$regsend = -1;
//------------------------------

@$vysledek_z=MySQL_Query("SELECT * FROM ".TBL_RACE." WHERE id=$id_zav LIMIT 1");
$zaznam_z = MySQL_Fetch_Array($vysledek_z);

$regsend = $zaznam_z['send'];

$kat_arr = array();
function prepare_kats()
{
	global $kat_arr;
	global $zaznam_z;
	$kat_arr = explode(';',$zaznam_z['kategorie']);
}

prepare_kats();

function check_kat($kat)
{
	global $kat_arr;
	$result = in_array($kat,$kat_arr);
	
	return $result;
}

?>
<SCRIPT LANGUAGE="JavaScript">
//<!--

function submit_form(termin)
{
	document.form_exp_reg.termin.value=termin;
	document.form_exp_reg.creg.value=0;
	document.form_exp_reg.submit();
	return true;
}

function submit_form_reg()
{
	document.form_exp_reg.termin.value=0;
	document.form_exp_reg.creg.value=1;
	document.form_exp_reg.submit();
	return true;
}

//-->
</SCRIPT>
<?
DrawPageSubTitle('Vybran� z�vod');

RaceInfoTable($zaznam_z);
?>

<BR>
<FORM METHOD="GET" ACTION="race_reg_form_exc.php" name="form_exp_reg" target="_blank">
<input type="hidden" name="id_zav" value="<? echo($id_zav); ?>">
Zp�sob v�pisu:<input type="radio" name="ff" value="0" id="radio_ff0" checked="checked"><label for="radio_ff0">Export p�ihl�ky</label>&nbsp;&nbsp;
<input type="radio" name="ff" value="1" id="radio_ff1"><label for="radio_ff1">N�hled na p�ihl�ku</label>
<input type="hidden" name="termin" value="0">
<input type="hidden" name="creg" value="0">
<br><br>
Form�t p�ihl�ky:<input type="radio" name="ver" value="0" id="radio_ver0"><label for="radio_ver0">do r.2004</label>&nbsp;&nbsp;
<input type="radio" name="ver" value="1" id="radio_ver1" checked="checked"><label for="radio_ver1">od r.2005</label>
<br><br>
<? if($zaznam_z['prihlasky'] > 1)
{ ?>
<BUTTON onclick="submit_form(0);  return false;">Prove� - v�echny term�ny</BUTTON>
<br>
<?
	for($ii=1; $ii<=$zaznam_z['prihlasky']; $ii++)
	{
		echo"<BUTTON onclick=\"submit_form(".$ii."); return false;\">Prove� - ".$ii.". term�n</BUTTON>&nbsp;";
	}
?>
<br>
<? } else { ?>
<BUTTON onclick="submit_form(0); return false;">Prove� akci</BUTTON>
<? } ?>
<BUTTON onclick="submit_form_reg(); return false;">V�pis pro centr�ln� registraci</BUTTON>
</FORM>
<BUTTON onclick="javascript:close_popup();">Zav�i</BUTTON>
<?//------------------------------?>
<br><br>
<FORM METHOD="POST" ACTION="race_reg_form.php?id_zav=<? echo($id_zav); ?>">
<input type="hidden" name="regsendnow" value="1">
Stav odesl�n� p�ihl�ky&nbsp;&nbsp;<select name="regsend" size="1">
	<option value="0"<? if($regsend ==0) echo(' selected="selected"'); ?>>nen� odesl�na</option>
<?
	if($zaznam_z['prihlasky'] > 1)
	{
		for($ii=1; $ii<=$zaznam_z['prihlasky']; $ii++)
		{
			echo'<option value="'.$ii.'"'.(($regsend == $ii) ? ' selected="selected" ' : '').'>je odesl�na pro '.$ii.'. term�n</option>';
		}
	}
	else
	{
?>
	<option value="1"<? if($regsend ==1) echo(' selected="selected"'); ?>>je odesl�na</option>
<?
	}
?>
</select>
<INPUT TYPE="submit" value='Nastav stav odesl�n� p�ihl�ky'>
</FORM>
<?//------------------------------?>
<BR><BR><hr><BR>

<?
DrawPageSubTitle('P�ihl�en� z�vodn�ci');

$data_tbl = new html_table_mc();
$col = 0;
$data_tbl->set_header_col($col++,'Po�.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Jm�no',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'P��jmen�',ALIGN_LEFT);
$data_tbl->set_header_col_with_help($col++,'Reg.',ALIGN_CENTER,"Registra�n� ��slo");
$data_tbl->set_header_col($col++,'SI �ip',ALIGN_RIGHT);
$data_tbl->set_header_col($col++,'Kategorie',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Kontrola',ALIGN_CENTER);
if($zaznam_z['prihlasky'] > 1)
{
	$data_tbl->set_header_col($col++,'Term�n',ALIGN_CENTER);
}
$data_tbl->set_header_col($col++,'Pozn�mka',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Pozn�mka (intern�)',ALIGN_CENTER);

echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_header_row()."\n";

$query = 'SELECT u.jmeno, u.prijmeni, u.reg, u.si_chip, z.kat, z.pozn, z.pozn_in, z.termin, z.si_chip as t_si_chip FROM '.TBL_ZAVXUS.' as z, '.TBL_USER.' as u WHERE z.id_user = u.id AND z.id_zavod='.$id_zav.' AND u.hidden = 0 ORDER BY z.termin ASC, z.id ASC';

@$vysledek=MySQL_Query($query);

$i=0;
$err_cnt = 0;
$old_term = 1;

while ($zaznam=MySQL_Fetch_Array($vysledek))
{
	$i++;

	$row = array();
	$row[] = $i;
	$row[] = $zaznam['jmeno'];
	$row[] = $zaznam['prijmeni'];
	$row[] = $g_shortcut.RegNumToStr($zaznam['reg']);
	if ($zaznam['si_chip'] == 0)
		$row[] = (($zaznam['t_si_chip'] != 0) ? '<span class="TemporaryChip">'.SINumToStr($zaznam['t_si_chip']).'</span>' : '');
	else
		$row[] = (($zaznam['t_si_chip'] != 0) ? '<span class="TemporaryChip">'.SINumToStr($zaznam['t_si_chip']).'</span>' : SINumToStr($zaznam['si_chip']));
	$row[] = '<B>'.$zaznam['kat'].'</B>';
	if (check_kat($zaznam['kat']))
		$kres = '<span class="TextCheckOk">OK';
	else
	{
		$kres = '<span class="TextCheckBad">Chyba*';
		$err_cnt++;
	}
	$kres .= '</span>';
	$row[] = $kres;
	if($zaznam_z['prihlasky'] > 1)
		$row[] = $zaznam['termin'];
	$row[] = $zaznam['pozn'];
	$row[] = $zaznam['pozn_in'];

	if($zaznam_z['prihlasky'] > 1 && $old_term != $zaznam['termin'])
	{
		$old_term = $zaznam['termin'];
		echo $data_tbl->get_break_row()."\n";
	}

	echo $data_tbl->get_new_row_arr($row)."\n";
}
echo $data_tbl->get_footer()."\n";

if($err_cnt > 0)
{
?>
<span class="TextCheckBad">* Kategorie v p�ihl�ce z�vodn�ka nen� definovan� jako platn� kategorie pro tento z�vod.</span><br>
<?
	echo('Celkov� po�et chyb v p�ihl�ce je '.$err_cnt.'.<br>');
	// spusteni opravy vysledku ...
}

if(strlen($zaznam_z['poznamka']) > 0)
{
?>
<p><b>Dopl�uj�c� informace o z�vod� (intern�)</b> :<br>
<?
	echo('&nbsp;&nbsp;&nbsp;'.$zaznam_z['poznamka'].'</p>');
}

?>
<BR>

</body>
</html>
