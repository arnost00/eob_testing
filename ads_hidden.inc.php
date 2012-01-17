<?php /* adminova stranka - editace clenu oddilu */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('Skryt� �len�',false);
?>
<CENTER>

<script language="JavaScript">
<!--
function confirm_hide(name) {
	return confirm('Opravdu chcete skr�t �lena odd�lu ? \n Jm�no �lena : "'+name+'"\n�len nebude viditeln� v p�ihl�k�ch!');
}

function confirm_show(name) {
	return confirm('Opravdu chcete zviditelnit �lena odd�lu ? \n Jm�no �lena : "'+name+'"');
}

-->
</script>

<?
include "./common_user.inc.php";

@$vysledek=MySQL_Query("SELECT id,prijmeni,jmeno,reg,hidden FROM ".TBL_USER." ORDER BY sort_name ASC");

$data_tbl = new html_table_mc();
$col = 0;
$data_tbl->set_header_col($col++,'Po�.�.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'P��jmen�',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Jm�no',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Reg.�.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Skryt',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Mo�nosti',ALIGN_CENTER);

echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_header_row()."\n";

$i=1;
while ($zaznam=MySQL_Fetch_Array($vysledek))
{
//	if ($zaznam['hidden'] == 0) 
	$row = array();
	$row[] = $i++;
	$row[] = $zaznam['prijmeni'];
	$row[] = $zaznam['jmeno'];
	$row[] = RegNumToStr($zaznam['reg']);
	$val=GetUserAccountId_Users($zaznam['id']);
	if($zaznam['hidden'] == 0)
	{
		$hidd = 'Ne';
		$action = '<A HREF="./user_hide_exc.php?id='.$zaznam['id'].'" onclick="return confirm_hide(\''.$zaznam['jmeno'].' '.$zaznam['prijmeni'].'\')">Skr�t</A>';
	}
	else
	{
		$hidd = 'Ano';
		$action = '<A HREF="./user_hide_exc.php?id='.$zaznam['id'].'" onclick="return confirm_show(\''.$zaznam['jmeno'].' '.$zaznam['prijmeni'].'\')">Zviditelnit</A>';
	}
	$row[] = $hidd;
	$row[] = $action;
	echo $data_tbl->get_new_row_arr($row)."\n";
}
echo $data_tbl->get_footer()."\n";

?>
Upozorn�n�: �len skryt�m neztrat� mo�nost p�ihl�sit se do syst�mu.<br>
<BR>
</CENTER>