<?php
define('__HIDE_TEST__', '_KeAr_PHP_WEB_');

require_once('./cfg/_colors.php');
require_once('./cfg/_cfg.php');
require_once('./header.inc.php'); // header obsahuje uvod html a konci <BODY>
require_once('./calendar.inc.php');
?>



<TABLE width="100%" cellpadding="0" cellspacing="0" border="0">
<TR>
<TD width="2%"></TD>
<TD width="90%" ALIGN=left>
<CENTER>

<?
DrawPageTitle('Kalendář');

	$curr_date = GetCurrentDate();
	$curr_date_arr = Date2Arr($curr_date);
	$m1 = $curr_date_arr[1];
	$y1 = $curr_date_arr[2];
	$d1 = $curr_date_arr[0];
	$m2 = $m1;
	$y2 = $y1;
	$m2++;
	if($m2 > 12)
	{
		$m2 = 1;
		$y2++;
	}
	GetMonthCalendar($m1,$y1);
	GetMonthCalendar($m2,$y2);
?>

<BR><BUTTON onclick="javascript:close_popup();">Zavřít</BUTTON></TD></TR>
</CENTER>
</TD>
<TD width="2%"></TD>
</TR>
</TABLE>
<?
HTML_Footer();
?>