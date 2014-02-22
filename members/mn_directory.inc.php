<?php /* trenerova stranka - editace clenu oddilu */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('�lensk� z�kladna');
?>
<CENTER>

<script language="JavaScript">
<!--
function confirm_delete(name) {
	return confirm('Opravdu chcete smazat �lena odd�lu ? \n Jm�no �lena : "'+name+'" \n �len bude nen�vratn� smaz�n !!');
}

-->
</script>

<?
include "./common_user.inc.php";
include('./csort.inc.php');

$sc = new column_sort_db();
$sc->add_column('sort_name','');
$sc->add_column('reg','');
$sc->set_url('index.php?id=500&subid=1',true);
$sub_query = $sc->get_sql_string();

$query = "SELECT id,prijmeni,jmeno,reg,hidden,lic,lic_mtbo,lic_lob,entry_locked FROM ".TBL_USER.$sub_query;
@$vysledek=MySQL_Query($query);

if (IsSet($result) && is_numeric($result) && $result != 0)
{
	require('./const_strings.inc.php');
	$res_text = GetResultString($result);
	Print_Action_Result($res_text);
}

$data_tbl = new html_table_mc();
$col = 0;
$data_tbl->set_header_col($col++,'Po�.�.',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'P��jmen�',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Jm�no',ALIGN_LEFT);
$data_tbl->set_header_col_with_help($col++,'Reg.�.',ALIGN_CENTER,"Registra�n� ��slo");
$data_tbl->set_header_col_with_help($col++,'P�ihl.',ALIGN_CENTER,"Mo�nost p�ihla�ov�n� se �lena na z�vody");
$data_tbl->set_header_col_with_help($col++,'L.OB',ALIGN_CENTER,"Licence pro OB");
$data_tbl->set_header_col_with_help($col++,'L.MTBO',ALIGN_CENTER,"Licence pro MTBO");
$data_tbl->set_header_col_with_help($col++,'L.LOB',ALIGN_CENTER,"Licence pro LOB");
$data_tbl->set_header_col_with_help($col++,'��et',ALIGN_CENTER,"Stav a existence ��tu");
$data_tbl->set_header_col($col++,'Mo�nosti',ALIGN_CENTER);

echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
//echo $data_tbl->get_header_row()."\n";

$data_tbl->set_sort_col(1,$sc->get_col_content(0));
$data_tbl->set_sort_col(3,$sc->get_col_content(1));
//echo $data_tbl->get_sort_row()."\n";
echo $data_tbl->get_header_row_with_sort()."\n";

$i=1;
while ($zaznam=MySQL_Fetch_Array($vysledek))
{
	if (!$zaznam['hidden'])
	{
		$row = array();
		$row[] = $i++;
		$row[] = $zaznam['prijmeni'];
		$row[] = $zaznam['jmeno'];
		$row[] = RegNumToStr($zaznam['reg']);
		if ($zaznam['entry_locked'] != 0)
			$row[] = '<span class="WarningText">Ne</span>';
		else
			$row[] = '';
		$row[] = ($zaznam['lic'] != 'C' || $zaznam['lic'] != '-') ? '<B>'.$zaznam['lic'].'</B>' : $zaznam['lic'];
		$row[] = ($zaznam['lic_mtbo'] != 'C' || $zaznam['lic_mtbo'] != '-') ? '<B>'.$zaznam['lic_mtbo'].'</B>' : $zaznam['lic_mtbo'];
		$row[] = ($zaznam['lic_lob'] != 'C' || $zaznam['lic_lob'] != '-') ? '<B>'.$zaznam['lic_lob'].'</B>' : $zaznam['lic_lob'];
		$val=GetUserAccountId_Users($zaznam['id']);
		$acc = '';
		if ($val)
		{
			$vysl2=MySQL_Query("SELECT locked FROM ".TBL_ACCOUNT." WHERE id = '$val' LIMIT 1");
			$zaznam2=MySQL_Fetch_Array($vysl2);
			if ($zaznam2 != FALSE)
			{
				if ($zaznam2['locked'] != 0) 
					$acc = '<span class="WarningText">L</span> ';
				$acc .= 'Ano';
			}
			else
				$acc = '-';
		}
		else
			$acc = '-';
		$row[] = $acc;
		$row[] = '<A HREF="./user_edit.php?id='.$zaznam['id'].'&cb=500">Edit</A>&nbsp;/&nbsp;<A HREF="./user_login_edit.php?id='.$zaznam["id"].'&cb=500">��et</A>&nbsp;/&nbsp;<A HREF="./user_del_exc.php?id='.$zaznam["id"]."\" onclick=\"return confirm_delete('".$zaznam["jmeno"].' '.$zaznam["prijmeni"]."')\" class=\"Erase\">Smazat</A>";
		echo $data_tbl->get_new_row_arr($row)."\n";
	}
}

echo $data_tbl->get_footer()."\n";

echo '<BR><BR>';
echo '(�erven� <span class="WarningText">L</span> zna�� �e ��et je zablokov�n spr�vcem. Tj. nejde se na n�j p�ihl�sit.)<BR>';
echo '<BR><hr><BR>';

include "./user_new.inc.php";
?>
<BR>
</CENTER>