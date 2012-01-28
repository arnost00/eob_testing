<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?php
@extract($_REQUEST);

require('./cfg/_colors.php');
require ('./connect.inc.php');
require ('./sess.inc.php');

if (!IsLoggedManager())
{
	header('location: '.$g_baseadr.'error.php?code=21');
	exit;
}
require ('./ctable.inc.php');
include ('./header.inc.php'); // header obsahuje uvod html a konci <BODY>
include ('./common.inc.php');
include ('./common_user.inc.php');

$id = (IsSet($id) && is_numeric($id)) ? (int)$id : 0;

DrawPageTitle('Editace p�i�azen� tren�ra �lenu',false);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function check_mng(vstup)
{
	if (vstup.mng.value < 0)
	{
		alert("Mus� zadat tren�ra pro �lena.");
		return false;
	}
	else
		return true;
}

//-->
</SCRIPT>
<?
db_Connect();

@$vysledek=MySQL_Query("SELECT * FROM ".TBL_USER." WHERE id = $id LIMIT 1");
@$zaznam=MySQL_Fetch_Array($vysledek);

$data_tbl = new html_table_nfo;
echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_new_row('Jm�no',$zaznam['jmeno'].' '.$zaznam['prijmeni']);
echo $data_tbl->get_new_row('Registra�n� ��slo',$g_shortcut.RegNumToStr($zaznam['reg']));
echo $data_tbl->get_new_row('��slo SI �ipu',SINumToStr($zaznam['si_chip']));
echo $data_tbl->get_new_row('Datum narozen�', SQLDate2String($zaznam['datum']));
echo $data_tbl->get_new_row('Licence OB', $zaznam['lic']);
echo $data_tbl->get_new_row('Licence MTBO', $zaznam['lic_mtbo']);
echo $data_tbl->get_new_row('Licence LOB', $zaznam['lic_lob']);
echo $data_tbl->get_footer()."\n";

echo '<H3 class="LinksTitle">Tren�r pro �lena</H2>'."\n";

echo '<FORM METHOD=POST ACTION="./mng_edit_exc.php?id='.$id.'" onsubmit="return check_mng(this);"> ';

?>
<TABLE>
<TR><TD>
<SELECT name="mng" size=10>
<?
	echo '<OPTION value="0'.(($zaznam['chief_id'] == 0) ? '" selected ':'"').'>-- bez mal�ho tren�ra --';

$query = 'SELECT u.id,u.prijmeni,u.jmeno, u.hidden FROM '.TBL_USER.' as u, '.TBL_ACCOUNT.', '.TBL_USXUS.' WHERE '.TBL_ACCOUNT.'.id = '.TBL_USXUS.'.id_accounts AND '.TBL_USXUS.'.id_users = u.id AND '.TBL_ACCOUNT.'.policy_mng = '._MNG_SMALL_INT_VALUE_;

@$vysl=MySQL_Query($query);

while ($zazn=MySQL_Fetch_Array($vysl))
{
	if(!$zazn['hidden'])
	{
		echo '<OPTION value="'.$zazn['id'].(($zazn['id'] == $zaznam['chief_id']) ? '" selected ':'"').'>'.$zazn['jmeno'].' '.$zazn['prijmeni'];
	}
}
?>
</SELECT>
</TD><TD width="10"></TD><TD valign="top">
<INPUT TYPE="submit" value='Prove� zm�ny'>
<BR><BR>
</FORM>
<BUTTON onclick="javascript:close_popup();">Zp�t</BUTTON>
</TD></TR></TABLE>

</body>
</html>