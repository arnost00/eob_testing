<?php /* adresar clenu oddilu */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('Adres�� �len� odd�lu',false);
?>
<TABLE width="95%" border="0">
<TR>
<TD align="right">
<? if ( IsLoggedManager() || IsLoggedRegistrator()) { ?>
<a href="javascript:open_win_ex('./export_directory.php','',600,600);">Export adres��e</a>
<? } ?>
</TD></TR>
</TABLE>
<br>
<? if ( IsLogged() ) { ?>
<script language="javascript">
<!-- 
	/*	"width=500,height=400"	*/

	javascript:set_default_size(500,540);
//-->
</script>
<? } ?>

<CENTER>
<?
include ("./common_user.inc.php");

$columns = 'id, prijmeni,jmeno,email,hidden,reg';
@$vysledek=MySQL_Query("SELECT ".$columns." FROM ".TBL_USER." ORDER BY sort_name ASC")
	or die("Chyba p�i prov�d�n� dotazu do datab�ze.");


$data_tbl = new html_table_mc();
$col = 0;

$data_tbl->set_header_col($col++,'P��jmen�'.((IsLogged())? AddPointerImg():''),ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Jm�no',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Reg.�.',ALIGN_LEFT);
if (IsLogged())
	$data_tbl->set_header_col($col++,'Email',ALIGN_LEFT);
else if ($g_mail_in_public_directory)
	$data_tbl->set_header_col($col++,'Email *',ALIGN_LEFT);
echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_header_row()."\n";

while ($zaznam=MySQL_Fetch_Array($vysledek))
{
	if ($zaznam["hidden"] == 0)
	{
		$row = array();
		if ( IsLogged() )
		{
			$row[] = "<A href=\"javascript:open_win('./view_address.php?id=".$zaznam["id"]."','')\" class=\"adr_name\">".$zaznam["prijmeni"]."</A>";
		}
		else
			$row[] = $zaznam["prijmeni"];
		$row[] = $zaznam["jmeno"];
		$row[] = $g_shortcut.RegNumToStr($zaznam["reg"]);

		if (IsLogged())
			$row[] = GetEmailHTML(ParseEmails($zaznam["email"]));
		else if($g_mail_in_public_directory)
			$row[] = GetEmailSecuredHTML(ParseEmails($zaznam["email"]));
		echo $data_tbl->get_new_row_arr($row)."\n";
	}
}

echo $data_tbl->get_footer()."\n";
if (!IsLogged() && $g_mail_in_public_directory)
{
	$n = rand(0,1);
	$char_at = ($n) ? '&#64;' : '&#x40;';
?>
* E-mailov� adresy se zobrazuj� v upraven� podob�.<br>
E-mailov� adresy v neupraven� podob� se zobrazuj� po p�ihl�en� se do syst�mu.<br>
Jin� mo�nost jak z�skat spr�vnou e-mailovou adresu je nahrazen�m textu "(zavin��)" znakem "<? echo($char_at);?>" a "(te�ka)" znakem ".".<br>
<?
}
?><BR>
</CENTER>