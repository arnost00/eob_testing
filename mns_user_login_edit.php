<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
require ("./connect.inc.php");
require ("./sess.inc.php");
if (!IsLoggedSmallManager())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}
include ("./common_user.inc.php");
include ("./common.inc.php");

db_Connect();
@$vysledek=MySQL_Query("SELECT jmeno,prijmeni,datum,hidden FROM ".TBL_USER." WHERE id = '$id' LIMIT 1");
@$zaznam=MySQL_Fetch_Array($vysledek);
if (!$zaznam)
{	// error not exist
	header("location: ".$g_baseadr."error.php?code=201");
	exit;
}
include "./header.inc.php"; // header obsahuje uvod html a konci <BODY>
<?
DrawPageTitle('�lensk� z�kladna - Editace u�ivatelsk�ch ��t�', false);
?>
?>
<TABLE width="100%" cellpadding="0" cellspacing="0" border="0">
<TR>
<TD width="2%"></TD>
<TD width="90%" ALIGN=left>
<CENTER>
<?
	$id_acc = GetUserAccountId_Users($id);
	$vysledek2=MySQL_Query("SELECT login,podpis,policy_news,policy_regs,policy_mng,locked FROM ".TBL_ACCOUNT." WHERE id = '$id_acc' LIMIT 1");
	$zaznam2=MySQL_Fetch_Array($vysledek2);
?>
<BR><hr><BR>
<H3>Z�kladn� �daje o vybran�m �lenovi</H3>
<TABLE width="90%">
<TR>
	<TD width="45%" align="right">P��jmen�</TD>
	<TD width="5"></TD>
	<TD class="DataValue"><?echo $zaznam["prijmeni"]?></TD>
</TR>
<TR>
	<TD width="45%" align="right">Jm�no</TD>
	<TD width="5"></TD>
	<TD class="DataValue"><?echo $zaznam["jmeno"]?></TD>
</TR>
<TR>
	<TD width="45%" align="right">Datum narozen�</TD>
	<TD width="5"></TD>
	<TD class="DataValue"><?echo Date2String($zaznam["datum"])?></TD>
</TR>
<TR>
	<TD width="45%" align="right">P�ihla�ovac� jm�no</TD>
	<TD width="5"></TD>
	<TD class="DataValue"><?echo $zaznam2["login"]?></TD>
</TR>
<? if ($zaznam["hidden"] != 0) { ?>
<TR>
	<TD width="45%" align="right">Tento u�ivatel je</TD>
	<TD width="5"></TD>
	<TD class="DataValue"><span class="WarningText">skryt� u�ivatel</span></TD>
</TR>
<? } ?>
</TABLE>
<BR><hr>
<H3>Zm�na hesla</H3>

<FORM METHOD=POST ACTION="./user_login_edit_exc.php?type=3&id=<?echo $id;?>">
<TABLE width="90%">
<TR>
	<TD width="45%" align="right">Nov� heslo:</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="password" NAME="nheslo" VALUE="" SIZE="20"></TD>
</TR>
<TR>
	<TD width="45%" align="right">Nov� heslo (ov��en�):</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="password" NAME="nheslo2" VALUE="" SIZE="20"></TD>
</TR>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD colspan="3" align="center"><INPUT TYPE="submit" VALUE="Zm�nit heslo"></TD>
</TR>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD colspan="3"><b>Heslo : </b>Hesla zad�vejte bez diakritiky, mohou b�t i ��slice, minim�ln� 4 znaky dlouh�. A nejl�pe takov� co ka�d�ho nenapadnou jako prvn�. Hesla typu "12345", "brno" nebo va�e p�ezd�vka budou bez varov�n� zm�n�ny! Nedoporu�uji ani pou��v�n� jmen d�t�, rodi�� p��padn� dom�c�ch mazl��k� v p�vodn� podob�. Pou�ijte alespo� zdrobn�linu nebo dom�c� variantu, p��padn� dopl�te jm�no n�jak�m ��slem (krom� registra�n�ho nebo roku narozen�).<BR></TD>
</TR>
</TABLE>
</FORM>
<BR><hr><BR>
<A HREF="index.php?id=600&subid=1">Zp�t na seznam �len�</A><BR>
<BR><hr><BR>
</CENTER>
</TD>
<TD width="2%"></TD>
</TR>
<TR><TD COLSPAN=4 ALIGN=CENTER>
<!-- Footer Begin -->
<?include "./footer.inc.php"?>
<!-- Footer End -->
</TD></TR>
</TABLE>

</BODY>
</HTML>