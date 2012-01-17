<?php /* clenova stranka - editace informaci a nastaveni */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('Nastaven� osobn�ch �daj� �len� odd�lu', false);
?>
<CENTER>
<?
if (IsLogged())
{

$vysledek=MySQL_Query("SELECT login,podpis FROM ".TBL_ACCOUNT." WHERE id = '$usr->account_id' LIMIT 1");
$curr_usr=MySQL_Fetch_Array($vysledek);

if (IsSet($result) && is_numeric($result) && $result != 0)
{
	require('./const_strings.inc.php');
	$res_text = GetResultString($result);
	Print_Action_Result($res_text);
}
?>
<BR><hr><BR>
<H3>Z�kladn� �daje</H3>

<TABLE width="90%">
<TR>
	<TD width="45%" align="right">P�ihla�ovac� jm�no</TD>
	<TD width="5"></TD>
	<TD class="DataValue"><? echo $curr_usr["login"]; ?></TD>
</TR>
<TR>
	<TD width="45%" align="right">Povoleno psan� novinek</TD>
	<TD width="5"></TD>
	<TD class="DataValue"><? echo ($usr->policy_news) ? "ano": "ne"; ?></TD>
</TR>
</TABLE>

<BR><hr><BR>
<H3>Voliteln� �daje</H3>

<FORM METHOD=POST ACTION="./us_setup_exc.php?type=1&id=<?echo $usr->account_id;?>">
<TABLE width="90%">
<TR>
	<TD width="40%" align="right">Podpis</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="text" NAME="podpis" SIZE=20 VALUE="<?echo  $curr_usr["podpis"]?>"></TD>
</TR>
<TR>
	<TD width="40%" align="right">P�ihla�ovac� jm�no</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="text" NAME="login" SIZE=20 VALUE="<? echo $curr_usr["login"]; ?>"></TD>
</TR>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD colspan="3" align="center"><INPUT TYPE="submit" VALUE="Zm�nit �daje"></TD>
</TR>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD colspan="3"><B>Podpis</B> je pou�it p�i zobrazov�n� novinek jako informace kdo novinku napsal. Tak� se zobrazuje p�i p�ihl�en� v naviga�n� li�t� vlevo dole.</TD>
</TR>
<TR>
	<TD colspan="3"></TD>
</TR>
<TR>
	<TD colspan="3"><b>P�ihla�ovac� jm�no : </b>Doporu�ujeme pou�it� slova bez diakritiky a rozli�ov�n� velk�m a mal�ch p�smen (jedno kterou variantu vyberete). V p�ihla�ovac�m jm�n� mohou b�t i ��slice, krom� prvn�ho p�smene. Nedoporu�ujem t� pou��v�n� mezer v jm�nu. Volte jm�no tak, aby se zabr�nilo koliz�m mezi jm�ny u�ivatel�. Minim�ln� d�lka jsou 4 znaky.<BR></TD>
</TR>
</TABLE>
</FORM>

<BR><hr><BR>
<H3>Zm�na hesla</H3>

<FORM METHOD=POST ACTION="./us_setup_exc.php?type=2&id=<?echo $usr->account_id;?>">
<TABLE width="90%">
<TR>
	<TD width="45%" align="right">Star� heslo:</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="password" NAME="oldheslo" VALUE="" SIZE="20"></TD>
</TR>
<TR>
	<TD width="45%" align="right">Nov� heslo:</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="password" NAME="heslo" VALUE="" SIZE="20"></TD>
</TR>
<TR>
	<TD width="45%" align="right">Nov� heslo (ov��en�):</TD>
	<TD width="5"></TD>
	<TD><INPUT TYPE="password" NAME="heslo2" VALUE="" SIZE="20"></TD>
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
	<TD colspan="3"><b>Omezen� hesla : </b>Hesla zad�vejte bez diakritiky, mohou b�t i ��slice, minim�ln� 4 znaky dlouh�. A nejl�pe takov� co ka�d�ho nenapadnou jako prvn�. Hesla typu "12345", "brno" nebo va�e p�ezd�vka budou bez varov�n� zm�n�ny! Nedoporu�uji ani pou��v�n� jmen d�t�, rodi�� p��padn� dom�c�ch mazl��k� v p�vodn� podob�. Pou�ijte alespo� zdrobn�linu nebo dom�c� variantu, p��padn� dopl�te jm�no n�jak�m ��slem (krom� registra�n�ho nebo roku narozen�).</TD>
</TR>
</TABLE>
</FORM>
<BR>
<?
}
?>

</CENTER>