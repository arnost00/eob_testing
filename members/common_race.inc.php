<?php if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?

$g_zebricek [0]['id'] = 0x0001;
$g_zebricek [0]['nm'] = 'Celost�tn�';
$g_zebricek [1]['id'] = 0x0002;
$g_zebricek [1]['nm'] = 'Morava';
$g_zebricek [2]['id'] = 0x0004;
$g_zebricek [2]['nm'] = '�echy';
$g_zebricek [3]['id'] = 0x0008;
$g_zebricek [3]['nm'] = 'Oblastn�';
$g_zebricek [4]['id'] = 0x0010;
$g_zebricek [4]['nm'] = 'Mistrovstv�';
$g_zebricek [5]['id'] = 0x0020;
$g_zebricek [5]['nm'] = '�tafety';
$g_zebricek [6]['id'] = 0x0080;
$g_zebricek [6]['nm'] = 'Ve�ejn�';

$g_zebricek_cnt = 7;

$g_racetype [0]['id'] = 0x0001;
$g_racetype [0]['nm'] = 'OB';
$g_racetype [0]['enum'] = 'ob';
$g_racetype [0]['img'] = 'fot';
$g_racetype [1]['id'] = 0x0002;
$g_racetype [1]['nm'] = 'MTBO';
$g_racetype [1]['enum'] = 'mtbo';
$g_racetype [1]['img'] = 'mbo';
$g_racetype [2]['id'] = 0x0004;
$g_racetype [2]['nm'] = 'LOB';
$g_racetype [2]['enum'] = 'lob';
$g_racetype [2]['img'] = 'ski';
$g_racetype [3]['id'] = 0x0008;
$g_racetype [3]['nm'] = 'O-Trail';
$g_racetype [3]['enum'] = 'trail';
$g_racetype [3]['img'] = 'trl';
$g_racetype [4]['id'] = 0x0010;
$g_racetype [4]['nm'] = 'Jin�';
$g_racetype [4]['enum'] = 'jine';
$g_racetype [4]['img'] = 'mcs';

$g_racetype_cnt = 5;

$g_modify_flag [0]['id'] = 0x0001;
$g_modify_flag [0]['nm'] = 'Term�n p�ihl�ek';
$g_modify_flag [1]['id'] = 0x0002;
$g_modify_flag [1]['nm'] = 'Z�vod p�id�n';
$g_modify_flag [2]['id'] = 0x0004;
$g_modify_flag [2]['nm'] = 'Termin z�vodu';

$g_modify_flag_cnt = 3;

function GetRaceTypeName($value)
{
	global $g_racetype_cnt;
	global $g_racetype;

	for($ii=0; $ii<$g_racetype_cnt; $ii++)
	{
		if($value == $g_racetype [$ii]['enum'])
			return $g_racetype [$ii]['nm'];
	}
	return '-';
}

function GetRaceTypeNameSpec($value)
{
	global $g_racetype_cnt;
	global $g_racetype;

	$result = '';
	for($ii=0; $ii<$g_racetype_cnt; $ii++)
	{
		if(($value & $g_racetype [$ii]['id']) != 0)
			$result .= $g_racetype [$ii]['nm'].', ';
	}
	if(strlen($result) > 0)
		return substr($result,0,strlen($result)-2);
	else
		return '-';
}

function GetRaceTypeImg(&$value)
{
	global $g_racetype_cnt;
	global $g_racetype;

	for($ii=0; $ii<$g_racetype_cnt; $ii++)
	{
		if($value == $g_racetype [$ii]['enum'])
		{
			return '<img src="imgs/'.$g_racetype [$ii]['img'].'16.gif" width="16" height="16" alt='.$g_racetype [$ii]['nm'].'>';
		}
	}
	return '?';
}

function GetZebricekName2($value)
{
	global $g_zebricek_cnt;
	global $g_zebricek;

	$result = '';
	for($ii=0; $ii<$g_zebricek_cnt; $ii++)
	{
		if(($value & $g_zebricek [$ii]['id']) != 0)
			$result .= $g_zebricek [$ii]['nm'].', ';
	}
	if(strlen($result) > 0)
		return substr($result,0,strlen($result)-2);
	else
		return '-';
}

function CreateZebricekNumber(&$zebricek)
{
	global $g_zebricek_cnt;
	global $g_zebricek;

	$result = 0;
	for($ii=0; $ii<$g_zebricek_cnt; $ii++)
	{
		if(isset($zebricek[$ii]) && $zebricek[$ii] == 1)
			$result += $g_zebricek [$ii]['id'];
	}
	return $result;
}

function CreateRaceTypeNumber(&$racetype)
{
	global $g_racetype_cnt;
	global $g_racetype;

	$result = 0;
	for($ii=0; $ii<$g_racetype_cnt; $ii++)
	{
		if(isset($racetype[$ii]) && $racetype[$ii] == 1)
			$result += $g_racetype [$ii]['id'];
	}
	return $result;
}

function CreateModifyFlag(&$mflags)
{
	global $g_modify_flag_cnt;
	global $g_modify_flag;

	$result = 0;
	for($ii=0; $ii<$g_modify_flag_cnt; $ii++)
	{
		if(isset($mflags[$ii]) && $mflags[$ii] == 1)
			$result += $g_modify_flag [$ii]['id'];
	}
	return $result;
}

function GetModifyFlagDesc(&$mflags)
{
	global $g_modify_flag_cnt;
	global $g_modify_flag;

	$result = '';
	for($ii=0; $ii<$g_modify_flag_cnt; $ii++)
	{
		if(($mflags & $g_modify_flag[$ii]['id']) != 0)
			$result .= (($result != '')?', ':'').$g_modify_flag [$ii]['nm'];
	}
	return $result;
}

function GetLicence($licF,$licM,$licL,$type)
{
	switch($type)	// 2 - MTBO, 1 - LOB, 0 - OB
	{
		case 2:
			return $licM;
			break;
		case 1:
			return $licL;
			break;
		case 0:
		default:
			return $licF;
	}
}

$g_kategorie ['oblz'] = 'D10N;D12;D14;D16;D18;D21C;D21D;D35;D45;D55;H10N;H12;H14;H16;H18;H21C;H21D;H35;H45;H55;HDR;';
$g_kategorie ['oblz_vetsi'] = 'D10N;D12C;D14C;D16C;D18C;D21C;D21D;D35C;D45C;D55C;H10N;H12C;H14C;H16C;H18C;H21C;H21D;H35C;H45C;H55C;HDR;';
$g_kategorie ['becka'] = 'D12B;D14B;D16B;D18B;D20B;D21B;D21C;D35B;D40B;D45B;D50B;D55B;D60B;D65B;H12B;H14B;H16B;H18B;H20B;H21B;H21C;H35B;H40B;H45B;H50B;H55B;H60B;H65B;H70B;H75B;';
$g_kategorie ['acka'] = 'D16A;D18A;D20A;D21A;D21E;H16A;H18A;H20A;H21A;H21E;';
$g_kategorie ['stafety'] = 'D14;D18;D21;D105;D140;H14;H18;H21;H105;H140;H165;dorost;dosp�l�;HD175;HD235;';
$g_kategorie ['MTBO'] = 'H21E;D21E;H21A;H21B;H21C;D21;H14;H17;H20;D14;D17;D20;H40;D40;';

require('./common_race2.inc.php');

function RaceInfoTable(&$zaznam,$add_row = '',$show_curr_term = false, $full_width=false, $expandable=false)
//	$show_curr_term = 0 - nic, 1 - us,mng,smn, 2 - rg,ad
{
	global $g_enable_race_boss;

	if ($expandable)
	{
?>
<script language="JavaScript">
function RIT_SH(divId1, divId2)
{
	if(document.getElementById(divId1).style.display == 'none')
		document.getElementById(divId1).style.display='block';
	else
		document.getElementById(divId1).style.display = 'none';

	if(document.getElementById(divId2).style.display == 'none')
		document.getElementById(divId2).style.display='block';
	else
		document.getElementById(divId2).style.display = 'none';
}
</script>
<div id="RIT_min" style="display: block" >
<?
		$data_tbl = new html_table_nfo;
		if($full_width)
			$data_tbl->table_width = 100;
		echo $data_tbl->get_css()."\n";
		echo $data_tbl->get_header()."\n";
		$odkaz = '<a onclick ="javascript:RIT_SH(\'RIT_min\',\'RIT_normal\')" href="javascript:;" ><code>[+]</code></a>'; //Zobrazit v�ce
		if($zaznam['vicedenni'])
			echo $data_tbl->get_new_row_extend('Datum',Date2StringFT($zaznam['datum'],$zaznam['datum2']),$odkaz);
		else
			echo $data_tbl->get_new_row_extend('Datum',Date2String($zaznam['datum']),$odkaz);
		echo $data_tbl->get_new_row('Jm�no',$zaznam['nazev']);
		echo $data_tbl->get_footer()."\n";
		echo ('</div><div id="RIT_normal" style="display: none">');
		$odkaz2 = '<a onclick ="javascript:RIT_SH(\'RIT_normal\',\'RIT_min\')" href="javascript:;" ><code>[-]</code></a>'; // Skr�t podrobnosti
	}
	else
		$odkaz2 = '';
	$data_tbl = new html_table_nfo;
	if($full_width)
		$data_tbl->table_width = 100;
	echo $data_tbl->get_css()."\n";
	echo $data_tbl->get_header()."\n";
	if($g_enable_race_boss)
	{
		$vedouci = '-';
		if($zaznam['vedouci'] != 0)
		{
			@$vysledekU=MySQL_Query("SELECT jmeno,prijmeni FROM ".TBL_USER." WHERE id = '".$zaznam['vedouci']."' LIMIT 1");
			@$zaznamU=MySQL_Fetch_Array($vysledekU);
			if($zaznamU != FALSE)
				$vedouci = $zaznamU['jmeno'].' '.$zaznamU['prijmeni'];
		}
	}
	$datum = ($zaznam['vicedenni']) ? Date2StringFT($zaznam['datum'],$zaznam['datum2']) : Date2String($zaznam['datum']);
	if($odkaz2)
		echo $data_tbl->get_new_row_extend('Datum',$datum,$odkaz2);
	else
		echo $data_tbl->get_new_row('Datum',$datum);
	echo $data_tbl->get_new_row('Jm�no',$zaznam['nazev']);
	echo $data_tbl->get_new_row('M�sto',$zaznam['misto']);
	echo $data_tbl->get_new_row('Po��daj�c� odd�l',$zaznam['oddil']);
	echo $data_tbl->get_new_row('Typ',GetRaceTypeName($zaznam['typ']));
	echo $data_tbl->get_new_row('�eb���ek',GetZebricekName2($zaznam['zebricek']));
	echo $data_tbl->get_new_row('Ranking',($zaznam['ranking'] == 1) ? 'Ano' : 'Ne');
	echo $data_tbl->get_new_row('WWW str�nky',GetRaceLinkHTML($zaznam['odkaz'],false));
	if($zaznam['vicedenni'])
	{
		echo $data_tbl->get_new_row('Po�et etap',$zaznam['etap']);
	}
	if($zaznam['prihlasky'] > 1)
	{
		echo $data_tbl->get_new_row('Term�n� p�ihl�ek',$zaznam['prihlasky']);
		if($show_curr_term)
		{
			$prihlasky_curr = raceterms::GetActiveRegDateArr($zaznam);
			$tp = ($prihlasky_curr[0] != 0) ? Date2String($prihlasky_curr[0]).' - term�m �.'.$prihlasky_curr[1] : 'nen�';
			echo $data_tbl->get_new_row('Aktivn� term�n',$tp);
		}
		echo $data_tbl->get_new_row('Term�ny p�ihl�ek',raceterms::ListRegDates($zaznam));
	}
	else
		echo $data_tbl->get_new_row('Term�n p�ihl�ek',Date2String($zaznam['prihlasky1']));
	if(IsLoggedRegistrator())
	{
		if($zaznam['send'] > 0)
		{
			if($zaznam['prihlasky'] > 1)
				$send = $zaznam['send'].'.term�n';
			else
				$send = 'Ano';
		}
		else
			$send = 'Ne';

		echo $data_tbl->get_new_row('P�ihl�ka odesl�na',$send);
	}
	if($g_enable_race_boss)
		echo $data_tbl->get_new_row('Vedouc�',$vedouci);
	if(is_array($add_row))
		echo $data_tbl->get_new_row($add_row[0],$add_row[1]);
	echo $data_tbl->get_footer()."\n";
	if ($expandable)
	{
		echo ('</div>');
	}
}

function form_filter_racelist($page,&$filterA,&$filterB,&$filterC)
{
	global $g_zebricek_cnt;
	global $g_zebricek;

	$urlA = "'./".$page.'&fB='.$filterB.'&fC='.$filterC.'&fA=\'';
	$urlB = "'./".$page.'&fA='.$filterA.'&fC='.$filterC.'&fB=\'';
	$urlC = "'./".$page.'&fA='.$filterA.'&fB='.$filterB.'&fC=\'';
	$filter_arr_niceA = array(0=>'v�echny',1=>'jen OB',2=>'jen MTBO',3=>'jen LOB',4=>'jen neza�azen�');
	$filter_arr_sqlA = array(1=>'ob',2=>'mtbo',3=>'lob',4=>'jine');
	if($filterA > 0 && $filterA < 5)
		$result = ' WHERE `typ`=\''.$filter_arr_sqlA[$filterA]."'";
	else
		$result = '';
	if($filterB > 0 && $filterB <= $g_zebricek_cnt)
	{
		if($result == '')
			$result = ' WHERE (';
		else
			$result .= ' AND (';
		$code = $g_zebricek[$filterB-1]['id'];
		$result .= '`zebricek` & \''.$code."')";
	}
	if($filterC == 0)
	{
		if($result == '')
			$result = ' WHERE (';
		else
			$result .= ' AND (';
		$result .= '`datum` >= \''.GetCurrentDate()."')";
	}
?>
<table><tr><td>
<form>
Typ zobrazen�ch z�vod�&nbsp;
<?
	echo('<select name="fA" onchange="javascript:window.open('.$urlA.'+this.options[this.selectedIndex].value,\'_top\')">'."\n");
	for($ii=0; $ii<count($filter_arr_niceA); $ii++)
	{
		echo('<option value="'.$ii.'"'.(($filterA == $ii)? ' selected' : '').'>'.$filter_arr_niceA[$ii].'</option>'."\n");
	}
?>
</select>
</form>
</td><td>&nbsp;&nbsp;</td><td>
<form>
Za�azen� zobrazen�ch z�vod�&nbsp;
<?
	echo('<select name="fB" onchange="javascript:window.open('.$urlB.'+this.options[this.selectedIndex].value,\'_top\')">'."\n");
	echo('<option value="0"'.(($filterB == 0)? ' selected' : '').'>v�echny</option>'."\n");
	for($ii=0; $ii<$g_zebricek_cnt; $ii++)
	{
		echo('<option value="'.($ii+1).'"'.(($filterB == $ii+1)? ' selected' : '').'>'.$g_zebricek[$ii]['nm'].'</option>'."\n");
	}
?>
</select>
</form>
</td><td>&nbsp;&nbsp;</td><td valign="top">
<INPUT TYPE="checkbox" NAME="fC" onClick="javascript:window.open(<? echo($urlC);?>+Number(this.checked),'_top')" id="fC" value="1"<? if ($filterC != 0) echo(' checked');?>><label for="fC">Zobrazit star� z�vody</label>

</td></tr>
</table>
<?
	return $result;
}

function show_link_to_actual_race(&$num_rows)
{
	if($num_rows > GC_MIN_RACES_2_SHOW_LINK)
		echo('<a href="#actual_races">Jdi na aktu�ln� z�vody</a><br>');
}

?>