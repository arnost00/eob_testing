<?php /* financnik - seznam sverencu pro finance */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('Finance �len�',false);
?>
<CENTER>
<script language="javascript">
<!-- 
	javascript:set_default_size(600,600);
//-->
</script>
<?
include "./common_user.inc.php";
include('./csort.inc.php');

$sc = new column_sort_db();
$sc->add_column('sort_name','');
$sc->add_column('reg','');
$sc->set_url('index.php?id=800&subid=10',true);
$sub_query = $sc->get_sql_string();

$query = 'SELECT id,prijmeni,jmeno,reg,hidden,lic,lic_mtbo,lic_lob FROM '.TBL_USER.$sub_query;
@$vysledek=MySQL_Query($query);

$i=1;
if ($vysledek != FALSE && mysql_num_rows($vysledek) > 0)
{
	$data_tbl = new html_table_mc();
	$col = 0;
	$data_tbl->set_header_col($col++,'Po�.�.',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'P��jmen�',ALIGN_LEFT);
	$data_tbl->set_header_col($col++,'Jm�no',ALIGN_LEFT);
	$data_tbl->set_header_col_with_help($col++,'Reg.�.',ALIGN_CENTER,"Registra�n� ��slo");
	$data_tbl->set_header_col($col++,'Mo�nosti',ALIGN_CENTER);

	echo $data_tbl->get_css()."\n";
	echo $data_tbl->get_header()."\n";
//	echo $data_tbl->get_header_row()."\n";

	$data_tbl->set_sort_col(1,$sc->get_col_content(0));
	$data_tbl->set_sort_col(3,$sc->get_col_content(1));
//	echo $data_tbl->get_sort_row()."\n";
	echo $data_tbl->get_header_row_with_sort()."\n";
	
	while ($zaznam=MySQL_Fetch_Array($vysledek))
	{
		if (!$zaznam['hidden'])
		{
			$row = array();
			$row[] = $i++;
			$row[] = $zaznam['prijmeni'];
			$row[] = $zaznam['jmeno'];
			$row[] = RegNumToStr($zaznam['reg']);
			$row_text = '<A HREF="javascript:open_win(\'./user_finance_view.php?user_id='.$zaznam['id'].'\',\'\')">P�ehled</A>';
			$row[] = $row_text;
			echo $data_tbl->get_new_row_arr($row)."\n";
		}
	}
	echo $data_tbl->get_footer()."\n";
}
?>


<BR>
</CENTER>