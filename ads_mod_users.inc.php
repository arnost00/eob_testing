<?php /* adminova stranka - editace clenu oddilu */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('Skryt� �len� a zamyk�n� ��t�');
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

function confirm_lock(name) {
	return confirm('Opravdu chcete zamknout ��et �lena odd�lu ? \n Jm�no �lena : "'+name+'" \n �len nebude m�t mo�nost se p�ihl�sit do syst�mu!');
}

function confirm_unlock(name) {
	return confirm('Opravdu chcete odemknout ��et �lena odd�lu ? \n Jm�no �lena : "'+name+'"');
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
$data_tbl->set_header_col_with_help($col++,'Reg.�.',ALIGN_CENTER,"Registra�n� ��slo");
$data_tbl->set_header_col_with_help($col++,'��et',ALIGN_CENTER,"Informace o existenci ��tu");
$data_tbl->set_header_col_with_help($col++,'Skryt',ALIGN_CENTER,"Informace zda je u�ivatel skryt�");
$data_tbl->set_header_col_with_help($col++,'Zam�en',ALIGN_CENTER,"Informace o zamknut� ��ty u�ivateli");
$data_tbl->set_header_col($col++,'Mo�nosti',ALIGN_CENTER);

echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_header_row()."\n";

$i=1;
while ($zaznam=MySQL_Fetch_Array($vysledek))
{
	$row = array();
	$row[] = $i++;
	$row[] = $zaznam['prijmeni'];
	$row[] = $zaznam['jmeno'];
	$row[] = RegNumToStr($zaznam['reg']);
	$action = '';
	if($zaznam['hidden'] == 0)
	{
		$hidd = 'Ne';
		$action = '<A HREF="./user_hide_exc.php?id='.$zaznam['id'].'" onclick="return confirm_hide(\''.$zaznam['jmeno'].' '.$zaznam['prijmeni'].'\')">Skr�t</A>';
	}
	else
	{
		$hidd = '<span class="WarningText">Ano</span>';
		$action = '<A HREF="./user_hide_exc.php?id='.$zaznam['id'].'" onclick="return confirm_show(\''.$zaznam['jmeno'].' '.$zaznam['prijmeni'].'\')">Zviditelnit</A>';
	}
	
	$val=GetUserAccountId_Users($zaznam['id']);
	$acc = '<span class="DisableText">Ne</span>';
	$acc_r = 'Ne';
	
	if ($val)
	{
		$vysl2=MySQL_Query("SELECT * FROM ".TBL_ACCOUNT." WHERE id = '$val'");
		$zaznam2=MySQL_Fetch_Array($vysl2);
		if ($zaznam2 != FALSE)
		{
			$acc = 'Ano';
			if ($zaznam2['locked'] != 0) 
			{
				$acc_r = '<span class="WarningText">Ano</span>';
				if ($zaznam['hidden'] == 0) 
					$action .= '&nbsp;/&nbsp;<A HREF="./user_lock_exc.php?id='.$zaznam['id'].'" onclick="return confirm_unlock(\''.$zaznam['jmeno'].' '.$zaznam['prijmeni'].'\')">Odemknout</A>';
			}
			else
			{
				$action .= '&nbsp;/&nbsp;<A HREF="./user_lock_exc.php?id='.$zaznam['id'].'" onclick="return confirm_lock(\''.$zaznam['jmeno'].' '.$zaznam['prijmeni'].'\')">Zamknout</A>';
			}
		}
	}
	if ( $usr->user_id == $zaznam['id'])
	{
		$action = '-';
	}
	
	$row[] = $acc;
	$row[] = $hidd;
	$row[] = $acc_r;
	$row[] = $action;
	
	
	echo $data_tbl->get_new_row_arr($row)."\n";
}
echo $data_tbl->get_footer()."\n";

?>
<br>
Upozorn�n�: �lenu je skryt�m z�rov�n i odebr�na mo�nost p�ihl�sit se do syst�mu (zam�en ��et).<br>
<BR>
</CENTER>