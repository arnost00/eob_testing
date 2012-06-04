<?php /* zavody - zobrazeni zavodu */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('P�ehled z�vod� pro finance');
?>
<CENTER>
<?
include ("./common_race.inc.php");
include ('./url.inc.php');

$fA = (IsSet($fA) && is_numeric($fA)) ? (int)$fA : 0;
$fB = (IsSet($fB) && is_numeric($fB)) ? (int)$fB : 0;
$fC = (IsSet($fC) && is_numeric($fC)) ? (int)$fC : 0;  // old races
$sql_sub_query = form_filter_racelist('index.php?id='.$id.(($subid != 0) ? '&subid='.$subid : ''),$fA,$fB,$fC);

@$vysledek=MySQL_Query("SELECT id,datum,datum2,prihlasky,prihlasky1,prihlasky2,prihlasky3,prihlasky4,prihlasky5, nazev,oddil,ranking,typ,vicedenni,odkaz,misto FROM ".TBL_RACE.$sql_sub_query.' ORDER BY datum, datum2, id');

?>

<script language="javascript">
<!-- 
	javascript:set_default_size(800,600);
//-->
</script>

<?
$num_rows = mysql_num_rows($vysledek);
if ($num_rows > 0)
{
	show_link_to_actual_race($num_rows);

	$data_tbl = new html_table_mc();
	$col = 0;
	$data_tbl->set_header_col($col++,'Datum',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'N�zev'.AddPointerImg(),ALIGN_LEFT);
	$data_tbl->set_header_col($col++,'M�sto',ALIGN_LEFT);
	$data_tbl->set_header_col($col++,'Po�.',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'T',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'W',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'Mo�nosti',ALIGN_CENTER);
	$data_tbl->set_header_col($col++,'P�ihl�ky',ALIGN_CENTER);

	echo $data_tbl->get_css()."\n";
	echo $data_tbl->get_header()."\n";
	echo $data_tbl->get_header_row()."\n";

	$i = 1;
	$brk_tbl = false;
	$old_year = 0;
	while ($zaznam=MySQL_Fetch_Array($vysledek))
	{
		$race_is_old = (GetTimeToRace($zaznam['datum']) == -1);

		$prefix = ($zaznam['datum'] < GetCurrentDate()) ? '<span class="TextAlertExp">' : '';
		$suffix = ($zaznam['datum'] < GetCurrentDate()) ? '</span>' : '';
		$row = array();
		//----------------------------
		if($zaznam['vicedenni'])
			$datum=Date2StringFT($zaznam['datum'],$zaznam['datum2']);
		else
			$datum=Date2String($zaznam['datum']);

		$prihlasky_curr = raceterms::GetActiveRegDateArr($zaznam);
		$prihlasky=Date2String($prihlasky_curr[0]);
		if($zaznam['prihlasky'] > 1)
			$prihlasky .= '&nbsp;/&nbsp;'.$prihlasky_curr[1];
		$time_to_reg = GetTimeToReg($prihlasky_curr[0]);
		$prihlasky_out = raceterms::ColorizeTermUser($time_to_reg,$prihlasky_curr,$prihlasky);
		$prihl_finish = (($time_to_reg == -1 && $prihlasky_curr[0] != 0) || $race_is_old);
		//----------------------------
		$row[] = $prefix.$datum.$suffix;
		$row[] = "<A href=\"javascript:open_race_info(".$zaznam['id'].")\" class=\"adr_name\">".$prefix.$zaznam['nazev'].$suffix."</A>";
		$row[] = $prefix.$zaznam['misto'].$suffix;
		$row[] = $prefix.$zaznam['oddil'].$suffix;
		$row[] = "<A HREF=\"javascript:open_win('./race_reg_view.php?id=".$zaznam['id']."','')\">".GetRaceTypeImg($zaznam['typ']).'</A>';
		$row[] = GetRaceLinkHTML($zaznam['odkaz']);
/*		
		if (!$prihl_finish)
		{
			$row[] = "<A HREF=\"javascript:open_win('./race_regs_1.php?gr_id="._MANAGER_GROUP_ID_."&id=".$zaznam['id']."','')\">P�-1</A>&nbsp;/&nbsp;<A HREF=\"javascript:open_win('./race_regs_all.php?gr_id="._MANAGER_GROUP_ID_."&id=".$zaznam['id']."','')\">P�-V</A>&nbsp;/&nbsp;<A HREF=\"javascript:open_win('./race_reg_view.php?gr_id="._MANAGER_GROUP_ID_."&id=".$zaznam['id']."','')\"><span class=\"TextAlertExp\">Zbr</span></A>";
		}
		else
		{
			$row[] = "<A HREF=\"javascript:open_win('./race_reg_view.php?gr_id="._MANAGER_GROUP_ID_."&id=".$zaznam['id']."','')\"><span class=\"TextAlertExp\">Zobrazit</span></A>";
		}
*/		
		$row[] = '?';
		$row[] = $prihlasky_out;

		if (!$brk_tbl && $zaznam['datum'] >= GetCurrentDate())
		{
			if($i != 1)
				echo $data_tbl->get_break_row()."\n";
			$brk_tbl = true;
		}
		else if($i != 1 && Date2Year($zaznam['datum']) != $old_year)
		{
				echo $data_tbl->get_break_row(true)."\n";
		}

		echo $data_tbl->get_new_row_arr($row)."\n";
		$i++;
		$old_year = Date2Year($zaznam['datum']);
	}
	echo $data_tbl->get_footer()."\n";
}
?>
<p>
??<BR>
</p>
</CENTER>
