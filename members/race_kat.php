<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
require ("./connect.inc.php");
require ("./sess.inc.php");
require("./cfg/_colors.php");

require ("./ctable.inc.php");
include ("./common.inc.php");
include ("./common_race.inc.php");
include ('./url.inc.php');

if (!IsLoggedRegistrator())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}

include ("./header.inc.php"); // header obsahuje uvod html a konci <BODY>
DrawPageTitle('Editace kategori� v z�vodu', false);

db_Connect();

@$vysledek=MySQL_Query("SELECT * FROM ".TBL_RACE." where id=$id LIMIT 1");
$zaznam=MySQL_Fetch_Array($vysledek);
$kat_nf ='';
?>
<H3>Vybran� z�vod</H3>
<?
RaceInfoTable($zaznam);
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
function zmen_kat_n($str)
{
	
	document.form2.kat_n.value+=$str;
}

function zmen_kat_null()
{
	document.form2.kat_n.value="";
}

//-->
</SCRIPT>

<FORM METHOD=POST ACTION="./race_kat_exc.php?id=<?echo $id?>" name="form2">

<br><br><INPUT TYPE="submit" VALUE="Odeslat zm�ny kategori�">
<H3>Kategorie v z�vod�</H3>

<?include "./race_kateg.inc.php"?>

<BR>

Nestandartni kategorie&nbsp;&nbsp;

<button onclick="javascript:zmen_kat_null(); return false;">Vypr�zdni</button><BR>

<TEXTAREA name="kat_n" cols="90" rows="3"><?echo $kat_nf;?></TEXTAREA><BR>

<span class="WarningText">Zadavej jako text bez uvozovek, kazdou kategorii ukonci strednikem, vse bez mezer</span>

<BR><BR>P�edefinovan� kategorie :
<button onclick="javascript:zmen_kat_n('<? echo $g_kategorie ['oblz']?>'); return false;">Obl�</button>&nbsp;
<button onclick="javascript:zmen_kat_n('<? echo $g_kategorie ['oblz_vetsi']?>'); return false;">Obl� v�t��</button>&nbsp;
<button onclick="javascript:zmen_kat_n('<? echo $g_kategorie ['becka']?>'); return false;">�eb.B.</button>&nbsp;
<button onclick="javascript:zmen_kat_n('<? echo $g_kategorie ['acka']?>'); return false;">�eb.A.</button>&nbsp;
<button onclick="javascript:zmen_kat_n('<? echo $g_kategorie ['stafety']?>'); return false;">�tafety</button>
<button onclick="javascript:zmen_kat_n('<? echo $g_kategorie ['MTBO']?>'); return false;">MTBO</button>
<BR>
<BR>
<span class="kategory_small_list">
Obl� = (<? echo $g_kategorie ['oblz']; ?>)
<BR>
Obl� v�t�� = (<? echo $g_kategorie ['oblz_vetsi']; ?>)
<BR>
�eb.B. = (<? echo $g_kategorie ['becka']; ?>)
<BR>
�eb.A. = (<? echo $g_kategorie ['acka']; ?>)
<BR>
�tafety = (<? echo $g_kategorie ['stafety']; ?>)
<BR>
MTBO = (<? echo $g_kategorie ['MTBO']; ?>)
</span>
<BR>

</FORM>

<BUTTON onclick="javascript:close_popup();">Zp�t</BUTTON>

<br><br>Aktu�ln� kategorie:<br>
<span class="kategory_small_list"><? echo $zaznam['kategorie'];?></span><br>

</BODY>
</HTML>