<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?
@extract($_REQUEST);

require ("./connect.inc.php");
require ("./sess.inc.php");
if (!IsLoggedAdmin() && !IsLoggedManager())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}
include ("./common_user.inc.php");
include ("./common.inc.php");

db_Connect();
$id = (isset($id) && is_numeric($id)) ? (int)$id : 0;

@$vysledek=MySQL_Query("SELECT jmeno,prijmeni,datum,hidden FROM ".TBL_USER." WHERE id = '$id' LIMIT 1");
@$zaznam=MySQL_Fetch_Array($vysledek);
if (!$zaznam)
{	// error not exist
	header("location: ".$g_baseadr."error.php?code=201");
	exit;
}
include "./header.inc.php"; // header obsahuje uvod html a konci <BODY>
DrawPageTitle('�lensk� z�kladna - Administrace u�ivatelsk�ch ��t�');

?>
<TABLE width="100%" cellpadding="0" cellspacing="0" border="0">
<TR>
<TD width="2%"></TD>
<TD width="90%" ALIGN=left>
<CENTER>
<?
	$id_acc = GetUserAccountId_Users($id);
	$vysledek2=MySQL_Query("SELECT login,podpis,policy_news,policy_regs,policy_mng,policy_adm,policy_fin,locked FROM ".TBL_ACCOUNT." WHERE id = '$id_acc' LIMIT 1");
	$zaznam2=MySQL_Fetch_Array($vysledek2);
?>
<BR><hr><BR>
<? DrawPageSubTitle('Z�kladn� �daje o vybran�m �lenovi'); ?>
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
	<TD class="DataValue"><?echo SQLDate2String($zaznam["datum"])?></TD>
</TR>
<? if ($zaznam["hidden"] != 0) { ?>
<TR>
	<TD width="45%" align="right">Tento u�ivatel je</TD>
	<TD width="5"></TD>
	<TD class="DataValue"><span class="WarningText">skryt� u�ivatel</span></TD>
</TR>
<? } ?>
</TABLE>
<BR><hr><BR>
<?
	if($zaznam2 != FALSE)
		DrawPageSubTitle('Editace ��tu vybran�ho �lena odd�lu');
	else
		DrawPageSubTitle('Zalo�en� nov�ho ��tu vybran�mu �lenu odd�lu');
?>
<FORM METHOD=POST ACTION="./user_login_edit_exc.php?type=<? echo ($zaznam2 != FALSE) ? "1" : "2"; echo "&id=".$id;?>">
<TABLE width="90%">
<TR>
	<TD width="30%" align="right">P�ihla�ovac� jm�no</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="text" NAME="login" SIZE=20 VALUE="<? echo $zaznam2["login"]; ?>"></TD>
</TR>
<TR>
	<TD width="30%" align="right">Podpis u�ivatele</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="text" NAME="podpis" SIZE=20 VALUE="<?echo  $zaznam2["podpis"]?>"></TD>
</TR>
<TR>
	<TD width="30%" align="right"></TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="checkbox" NAME="news" SIZE=15 VALUE="1" <? if ($zaznam2["policy_news"]) echo "checked" ?> >Povoleno psan� novinek</TD>
</TR>
<TR>
	<TD width="30%" align="right"></TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="checkbox" NAME="mng" SIZE=15 VALUE="<? echo (!IsLoggedAdmin() && $zaznam2["policy_mng"] == _MNG_BIG_INT_VALUE_) ? '2' : '1'; ?>" <? if ($zaznam2["policy_mng"] == _MNG_SMALL_INT_VALUE_) echo "checked"; if (!IsLoggedAdmin() && $zaznam2["policy_mng"] == _MNG_BIG_INT_VALUE_) echo "disabled"; ?> >U�ivatel je mal�m trenen�rem (m��e m�nit �daje a p�ihl�ky vybran�ch �len�)</TD>
</TR>
<? if (IsLoggedAdmin())
{ ?>
<TR>
	<TD width="30%" align="right"></TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="checkbox" NAME="mng2" SIZE=15 VALUE="1" <? if ($zaznam2["policy_mng"] == _MNG_BIG_INT_VALUE_) echo "checked" ?> >U�ivatel je trenen�rem (m��e m�nit �daje a p�ihl�ky �len�)</TD>
</TR>
<TR>
	<TD width="30%" align="right"></TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="checkbox" NAME="regs" SIZE=15 VALUE="1" <? if ($zaznam2["policy_regs"]) echo "checked" ?> >U�ivatel je p�ihla�ovatelem (m��e editovat p�ihl�ky �len� - prov�d� export)</TD>
</TR>
<? if ($g_enable_finances)
{ ?>
<TR>
	<TD width="30%" align="right"></TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="checkbox" NAME="fin" SIZE=15 VALUE="1" <? if ($zaznam2["policy_fin"]) echo "checked" ?> >U�ivatel je finan�n�kem</TD>
</TR>
<? } ?>
<TR>
	<TD width="30%" align="right"></TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="checkbox" NAME="adm" SIZE=15 VALUE="1" <? if ($zaznam2["policy_adm"]) echo "checked" ?> >U�ivatel je spr�vcem</TD>
</TR>
<? if ($zaznam2["locked"] != 0) { ?>
<TR>
	<TD width="45%" align="right">Tento u�ivatel m�</TD>
	<TD width="5"></TD>
	<TD class="DataValue"><span class="WarningText">uzam�en� ��et</span></TD>
</TR>
<? } ?>

<?
}
?>
<?
if($zaznam2 == FALSE)
{ // novy ucet
?>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD width="30%" align="right">Nov� heslo:</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="password" NAME="nheslo" VALUE="" SIZE="20"></TD>
</TR>
<TR>
	<TD width="30%" align="right">Nov� heslo (ov��en�):</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="password" NAME="nheslo2" VALUE="" SIZE="20"></TD>
</TR>
<?
}
?>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD colspan="3" align="center"><INPUT TYPE="submit" VALUE="<? echo ($zaznam2 != FALSE) ? "Prov�st zm�ny" : "Zalo�it ��et"; ?>"></TD>
</TR>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD colspan="3"><b>P�ihla�ovac� jm�no : </b>Doporu�ujeme pou�it� slova bez diakritiky a rozli�ov�n� velk�m a mal�ch p�smen (jedno kterou variantu vyberete). V p�ihla�ovac�m jm�n� mohou b�t i ��slice, krom� prvn�ho p�smene. Nedoporu�ujem t� pou��v�n� mezer v jm�nu. Volte jm�no tak, aby se zabr�nilo koliz�m mezi jm�ny u�ivatel�.<BR></TD>
</TR>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD colspan="3"><B>Podpis</B> je pou�it p�i zobrazov�n� novinek jako informace kdo novinku napsal. Tak� se zobrazuje p�i p�ihl�en� v naviga�n� li�t� vlevo dole.<BR></TD>
</TR>
<?
if($zaznam2 != FALSE)
{ // zmena uctu
?>
</TABLE>
</FORM>

<BR><hr><BR>
<? DrawPageSubTitle('Zm�na hesla'); ?>

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
<?
}
?>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD colspan="3"><b>Heslo : </b>Hesla zad�vejte bez diakritiky, mohou b�t i ��slice, minim�ln� 4 znaky dlouh�. A nejl�pe takov� co ka�d�ho nenapadnou jako prvn�. Hesla typu "12345", "brno" nebo va�e p�ezd�vka budou bez varov�n� zm�n�ny! Nedoporu�uji ani pou��v�n� jmen d�t�, rodi�� p��padn� dom�c�ch mazl��k� v p�vodn� podob�. Pou�ijte alespo� zdrobn�linu nebo dom�c� variantu, p��padn� dopl�te jm�no n�jak�m ��slem (krom� registra�n�ho nebo roku narozen�).<BR></TD>
</TR>
</TABLE>
</FORM>
<BR><hr><BR>
<? if (IsLoggedManager()) { ?>
<A HREF="index.php?id=500&subid=1">Zp�t na seznam �len�</A><BR>
<? } else { ?>
<A HREF="index.php?id=300&subid=3">Zp�t na seznam �len�</A><BR>
<? } ?>
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