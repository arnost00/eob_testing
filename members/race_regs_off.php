<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
@extract($_REQUEST);

require("./cfg/_colors.php");
require ("./connect.inc.php");
require ("./sess.inc.php");
require ("./common.inc.php");

if (!IsLoggedRegistrator())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}

require ("./ctable.inc.php");
include ("./header.inc.php"); // header obsahuje uvod html a konci <BODY>
include ("./common_race.inc.php");
include ("./common_user.inc.php");
include ('./url.inc.php');
DrawPageTitle('Hromadn� odhl�ka ze z�vodu');

$gr_id = (IsSet($gr_id) && is_numeric($gr_id)) ? (int)$gr_id : 0;
$id = (IsSet($id) && is_numeric($id)) ? (int)$id : 0;

db_Connect();

@$vysledek_z=MySQL_Query("SELECT * FROM ".TBL_RACE." WHERE id=$id");
$zaznam_z = MySQL_Fetch_Array($vysledek_z);

?>
<H3>Vybran� z�vod</H3>

<?
RaceInfoTable($zaznam_z);
?>
<BR>
<H3>Odhl�ky</H3>

<p>
Odhl�en� �lena - se provede vymaz�n�m kategorie (pr�zn� textov� pole) pro p��slu�n�ho �lena.<BR>
Zm�na kategorie - se provede zm�nou textov�ho pole s kategori� pro p��slu�n�ho �lena.<BR>
<span class="WarningText">Do sloupc�, kter� nechcete m�nit nezasahujte !!</span>
</p>

<SCRIPT LANGUAGE="JavaScript">
//<!--
var focused_row = -1;

function select_row(row)
{
	focused_row = row;
}

function zmen_kat(kat)
{
	if (focused_row != -1)
	{
		kat_name = 'kateg[' + focused_row +']';
		document.form1.elements[kat_name].value = kat;
	}
	return false;
}

//-->
</SCRIPT>
<?
$termin = raceterms::GetCurr4RegTerm($zaznam_z);

if($termin == 0 && !IsLoggedAdmin() && !IsLoggedRegistrator())
{
	echo('Nelze prov�d�t p�ihl�ky, nejsp� u� vypr�ely v�echny term�ny p�ihl�ek, je po z�vod�, �i nen� aktivn� ��dn� term�n pro p�ihl�en�.');
}
else
{
?>
<FORM METHOD=POST ACTION="./race_regs_off_exc.php?gr_id=<?echo $gr_id;?>&id=<?echo $id;?>" name="form1">
<?

$query = 'SELECT '.TBL_USER.'.id, prijmeni, jmeno, reg, datum, kat, pozn, pozn_in, termin FROM '.TBL_USER.' LEFT JOIN '.TBL_ZAVXUS.' ON '.TBL_USER.'.id = '.TBL_ZAVXUS.'.id_user AND '.TBL_ZAVXUS.'.id_zavod='.$id.' WHERE '.TBL_USER.'.hidden = 0';

@$vysledek=MySQL_Query($query);

$data_tbl = new html_table_mc();
$col = 0;
$data_tbl->set_header_col($col++,'Po�.�.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Reg.�.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'P��jmen�',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Jm�no',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Kategorie',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'T.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Pozn�mka',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Pozn�mka(intern�)',ALIGN_CENTER);

echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_header_row()."\n";

$i=1;
while ($zaznam=MySQL_Fetch_Array($vysledek))
{
	if ($zaznam['kat'] != NULL && $zaznam['termin'] < $termin)
	{	// jiz prihlasen
		$u=$zaznam['id'];
		$row = array();
		$row[] = $i++;
		$row[] = RegNumToStr($zaznam['reg']);
		$row[] = $zaznam['prijmeni'];
		$row[] = $zaznam['jmeno'];
		$row[] = $zaznam['termin'].'/'.$termin.'<INPUT TYPE="text" NAME="kateg['.$u.']" SIZE=5 value="'.$zaznam['kat'].'" onfocus="javascript:select_row('.$u.');">';
		$row[] = '<INPUT TYPE="text" NAME="term['.$u.']" SIZE=1 value="'.$zaznam['termin'].'" onfocus="javascript:select_row('.$u.');">';
		$row[] = '<INPUT TYPE="text" NAME="pozn['.$u.']" SIZE=25 value="'.$zaznam['pozn'].'" onfocus="javascript:select_row('.$u.');">';
		$row[] = '<INPUT TYPE="text" NAME="pozn2['.$u.']" SIZE=25 value="'.$zaznam['pozn_in'].'" onfocus="javascript:select_row('.$u.');">';
		if ($zaznam['id'] == $usr->user_id) 
			$data_tbl->set_next_row_highlighted();
		echo $data_tbl->get_new_row_arr($row)."\n";
	}
}
echo $data_tbl->get_footer()."\n";
?>
Mo�nosti (kategorie)<BR>
<?
	echo "<button onclick=\"javascript:zmen_kat('');return false;\">Vypr�zdnit</button>&nbsp;";
	$kategorie=explode(';',$zaznam_z['kategorie']);
	for ($i=0; $i<count($kategorie)-1; $i++)
	{
		echo "<button onclick=\"javascript:zmen_kat('".$kategorie[$i]."');return false;\">".$kategorie[$i]."</button>";
	}
?>
<BR>
Vyberte z�vodn�ka klepnut�m do pol��ka kategorie u z�vodn�ka a n�sledn� vlo�te vybranou kategorii pomoc� tla��tka s n�zvem kategorie.<BR>
<BR>
<INPUT TYPE="submit" value='Prove� zm�ny'>
</FORM>
<?
}
?>
<BR>
<BUTTON onclick="javascript:close_popup();">Zp�t</BUTTON>
</BODY>
</HTML>
