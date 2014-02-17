<?php /* adminova stranka - rozcestnik pro admina */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('Odd�lov� term�novka');
?>
<CENTER>
<script language="javascript">
<!-- 
	javascript:set_default_size(600,600);
//-->
</script>

<?
include ('./common_race.inc.php');
include ('./url.inc.php');

$curr_date = GetCurrentDate();

$fA = (IsSet($fA) && is_numeric($fA)) ? (int)$fA : 0;
$fB = (IsSet($fB) && is_numeric($fB)) ? (int)$fB : 0;
$fC = (IsSet($fC) && is_numeric($fC)) ? (int)$fC : 0;  // old races
$sql_sub_query = form_filter_racelist('index.php?id='.$id.(($subid != 0) ? '&subid='.$subid : ''),$fA,$fB,$fC);

@$vysledek=MySQL_Query('SELECT * FROM '.TBL_RACE.$sql_sub_query.' ORDER BY datum, datum2, id');

$num_rows = ($vysledek != FALSE) ? mysql_num_rows($vysledek) : 0;
$old_year = 0;
if ($num_rows > 0)
{
	show_link_to_actual_race($num_rows);

	$data_tbl = new html_table_mc();
	$col = 0;
	$data_tbl->set_header_col($col++,'Datum',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'N�zev',ALIGN_LEFT);
	$data_tbl->set_header_col($col++,'M�sto',ALIGN_LEFT);
	$data_tbl->set_header_col_with_help($col++,'Po�.',ALIGN_CENTER,"Po�adatel");
	$data_tbl->set_header_col_with_help($col++,'T',ALIGN_CENTER,"Typ z�vodu");
	$data_tbl->set_header_col_with_help($col++,'W',ALIGN_CENTER,"Web z�vodu");
	$data_tbl->set_header_col_with_help($col++,'P�',ALIGN_CENTER,"Zobrazit p�ihl�en�");
	$data_tbl->set_header_col($col++,'P�ihl�ky',ALIGN_CENTER);
	if($g_enable_race_boss)
		$data_tbl->set_header_col($col++,'Vedouc�',ALIGN_CENTER);
	echo $data_tbl->get_css()."\n";
	echo $data_tbl->get_header()."\n";
	echo $data_tbl->get_header_row()."\n";

	$brk_tbl = false;
	$i = 1;
	$old_year = 0;
	while ($zaznam=MySQL_Fetch_Array($vysledek))
	{
		if($zaznam['vicedenni'])
			$datum=Date2StringFT($zaznam['datum'],$zaznam['datum2']);
		else
			$datum=Date2String($zaznam['datum']);

		$prihlasky_curr = raceterms::GetActiveRegDateArr($zaznam);
		$prihlasky_out_term = Date2String($prihlasky_curr[0]);
		if($zaznam['prihlasky'] > 1)
			$prihlasky_out_term .= '&nbsp;/&nbsp;'.$prihlasky_curr[1];
		$time_to_reg = GetTimeToReg($prihlasky_curr[0]);
		$termin = raceterms::ColorizeTermUser($time_to_reg,$prihlasky_curr,$prihlasky_out_term);

		$nazev = '<A href="javascript:open_race_info('.$zaznam['id'].')" class="adr_name">'.GetFormatedTextDel($zaznam['nazev'], $zaznam['cancelled']).'</A>';
		$misto = GetFormatedTextDel($zaznam['misto'], $zaznam['cancelled']);
		$oddil = $zaznam['oddil'];
		$typ = GetRaceTypeImg($zaznam['typ']);
		$odkaz = GetRaceLinkHTML($zaznam['odkaz']);
		$prihl2 = "<A HREF=\"javascript:open_win('./race_reg_view.php?id=".$zaznam['id']."','')\"><span class=\"TextAlertExpLight\">Zbr</span></A>";

		if (!$brk_tbl && $zaznam['datum'] >= $curr_date)
		{
			if($i != 1)
				echo $data_tbl->get_break_row()."\n";
			$brk_tbl = true;
		}
		else if($i != 1 && Date2Year($zaznam['datum']) != $old_year)
		{
				echo $data_tbl->get_break_row(true)."\n";
		}

		if($g_enable_race_boss)
		{
			$boss = '-';
			if($zaznam['vedouci'] != 0)
			{
				@$vysledekU=MySQL_Query("SELECT jmeno,prijmeni FROM ".TBL_USER." WHERE id = '".$zaznam['vedouci']."' LIMIT 1");
				@$zaznamU=MySQL_Fetch_Array($vysledekU);
				if($zaznamU != FALSE)
					$boss = $zaznamU['jmeno'].' '.$zaznamU['prijmeni'];
			}
			echo $data_tbl->get_new_row($datum,$nazev,$misto,$oddil,$typ,$odkaz,$prihl2,$termin,$boss);
		}
		else
			echo $data_tbl->get_new_row($datum,$nazev,$misto,$oddil,$typ,$odkaz,$prihl2,$termin);
		$i++;
		$old_year = Date2Year($zaznam['datum']);
	}
	echo $data_tbl->get_footer()."\n";
}
else
{
	echo "Term�nov� listina je pr�zdn�.<BR>";
}
?>
<BR>

</CENTER>