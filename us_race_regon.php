<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?php
@extract($_REQUEST);

require('./cfg/_colors.php');
require('./connect.inc.php');
require('./sess.inc.php');

if (!IsLogged())
{
	header('location: '.$g_baseadr.'error.php?code=21');
	exit;
}
require('./ctable.inc.php');
include('./header.inc.php'); // header obsahuje uvod html a konci <BODY>
include('./common.inc.php');
include('./common_race.inc.php');
include('./url.inc.php');

db_Connect();


$id_zav = (IsSet($id_zav) && is_numeric($id_zav)) ? (int)$id_zav : 0;
$id_us = (IsSet($id_us) && is_numeric($id_us)) ? (int)$id_us : 0;

DrawPageTitle('P�ihl�ka na z�vod');

@$vysledek=MySQL_Query("SELECT * FROM ".TBL_ZAVXUS." WHERE id_zavod=$id_zav ORDER BY id");

@$vysledek_z=MySQL_Query("SELECT * FROM ".TBL_RACE." WHERE id=$id_zav");
$zaznam_z = MySQL_Fetch_Array($vysledek_z);

@$vysledek_rg=MySQL_Query("SELECT * FROM ".TBL_ZAVXUS." WHERE id_zavod=$id_zav and id_user=$id_us");
$zaznam_rg=MySQL_Fetch_Array($vysledek_rg);

@$vysledek_u=MySQL_Query("SELECT * FROM ".TBL_USER." WHERE id=$id_us");
$zaznam_u = MySQL_Fetch_Array($vysledek_u);

$new = ($zaznam_rg && $zaznam_rg['kat'] != '') ? 0 : 1;

?>

<SCRIPT LANGUAGE="JavaScript">
<!--
function zmen_kat(kateg)
{
	document.form1.kat.value=kateg;
}

function check_reg(vstup)
{
	if (vstup.kat.value == "")
	{
		alert("Mus� zadat kategorii pro p�ihl�en� do z�vodu.");
		return false;
	}
	else
		return true;
}

function submit_off()
{
	if (confirm('Opravdu se chcete odhl�sit?'))
	{
		window.location = 'us_race_regoff_exc.php?id_zav=<? echo($id_zav) ?>&id_us=<? echo($id_us) ?>';
	}
	return false;
}
//-->
</SCRIPT>

<?
DrawPageSubTitle('Vybran� z�vod');

if (!$new)
{
	$add_r[0] ='Kategorie';
	$add_r[1] ='<B>'.$zaznam_rg['kat'].'</B>';
	RaceInfoTable($zaznam_z,$add_r,true,false,true);
}
else
	RaceInfoTable($zaznam_z,'',true,false,true);
?>
<BR>
<BUTTON onclick="javascript:close_popup();">Zp�t</BUTTON>
<BR><BR>
<hr><BR>

<?
if ($zaznam_u['entry_locked'] != 0)
{
	echo('<span class="WarningText">M�te zamknutou mo�nost se p�ihla�ovat.</span>'."<br>\n");

	if ($zaznam_rg['kat'] != '')
	{
		echo('<BR><BR>Vybran� kategorie:&nbsp;'.$zaznam_rg['kat']);
		if ($zaznam_z["transport"]==1)
		{
			echo "<BR><BR>";
			$trans=$zaznam_rg["transport"]?"Ano":"Ne";
			echo 'Chci vyu��t spole�nou dopravu:&nbsp;'.$trans;
		}
		echo "<BR><BR>";
		echo 'Pozn�mka:&nbsp;'.$zaznam_rg['pozn'].'&nbsp;(do&nbsp;p�ihl�ky)';
		echo "<BR><BR>";
		echo 'Pozn�mka:&nbsp;'.$zaznam_rg['pozn_in'].'&nbsp;(intern�)';
		echo "<BR><BR>";
	}
}
else
{	// zacatek - povoleno prihlasovani
?>
<FORM METHOD=POST ACTION="us_race_regon_exc.php" name="form1" onsubmit="return check_reg(this);">

Do kter� kategorie chcete p�ihl�sit:&nbsp;
<?
echo'<br>';
$kategorie=explode(';',$zaznam_z['kategorie']);
for ($i=0; $i<count($kategorie)-1; $i++)
{
	echo "<button onclick=\"javascript:zmen_kat('".$kategorie[$i]."');return false;\">".$kategorie[$i]."</button>";
}

echo('<BR><BR>Vybran� kategorie:&nbsp;');
echo('<INPUT TYPE="text" NAME="kat" size=4 value="'.$zaznam_rg['kat'].'">');
echo("<BR>\n");

if ($zaznam_z["transport"]==1)
{
	echo "<BR><BR>";
	$trans=$zaznam_rg["transport"]?"CHECKED":"";
	echo 'Chci vyu��t spole�nou dopravu&nbsp;<input type="checkbox" name="transport" id="transport" '.$trans.'>';
}

?>
<BR><BR>
Pozn�mka&nbsp;<INPUT TYPE="text" name="pozn" size="50" maxlength="250" value="<?echo $zaznam_rg['pozn']?>">&nbsp;(do&nbsp;p�ihl�ky)
<BR><BR>
Pozn�mka&nbsp;<INPUT TYPE="text" name="pozn2" size="50" maxlength="250" value="<?echo $zaznam_rg['pozn_in']?>">&nbsp;(intern�)
<BR><BR>

<INPUT TYPE="hidden" name="id_us" value="<?echo $id_us?>">
<INPUT TYPE="hidden" name="id_zav" value="<?echo $id_zav?>">
<INPUT TYPE="hidden" name="novy" value="<?echo $new?>">
<INPUT TYPE="hidden" name="id_z" value="<?echo $zaznam_rg['id']?>">

<?
if ($new)
{
?>
<INPUT TYPE="submit" value="P�ihl�sit na z�vod">
<?
}
else
{
?>
<INPUT TYPE="submit" value="Zm�nit �daje">
&nbsp;&nbsp;&nbsp;&nbsp;<BUTTON onclick="return submit_off();">Odhl�sit za z�vodu</BUTTON>
<?
}
?>
</FORM>
<?
} // konec - povoleno prihlasovani

if(strlen($zaznam_z['poznamka']) > 0)
{
?>
<p><b>Dopl�uj�c� informace o z�vod� (intern�)</b> :<br>
<?
	echo('&nbsp;&nbsp;&nbsp;'.$zaznam_z['poznamka'].'</p>');
}
?>

<BR><hr><BR>
<?
DrawPageSubTitle('P�ihl�en� z�vodn�ci');

$data_tbl = new html_table_mc();
$col = 0;
$data_tbl->set_header_col($col++,'Po�.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Jm�no',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'P��jmen�',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Kategorie',ALIGN_CENTER);
if($zaznam_z['prihlasky'] > 1)
	$data_tbl->set_header_col($col++,'Term�n',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Pozn.',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Pozn.(i)',ALIGN_LEFT);

echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_header_row()."\n";

$i=0;
$trans=0;
while ($zaznam=MySQL_Fetch_Array($vysledek))
{
	@$vysledek1=MySQL_Query("SELECT * FROM ".TBL_USER." WHERE id=$zaznam[id_user] LIMIT 1");
	$zaznam1=MySQL_Fetch_Array($vysledek1);
	$i++;

	$zaznam["transport"]?$trans++:"";
	
	$row = array();
	$row[] = $i.'<!-- '.$zaznam['id'].' -->';
	$row[] = $zaznam1['jmeno'];
	$row[] = $zaznam1['prijmeni'];
	$row[] = '<B>'.$zaznam['kat'].'</B>';
	if($zaznam_z['prihlasky'] > 1)
		$row[] = $zaznam['termin'];
	$row[] = $zaznam['pozn'];
	$row[] = $zaznam['pozn_in'];
	echo $data_tbl->get_new_row_arr($row)."\n";
}
echo $data_tbl->get_footer()."\n";

echo $zaznam_z["transport"]?"<BR>Po�et p�ihl�en�ch na dopravu: $trans":"";
?>

<BR>

</body>
</html>