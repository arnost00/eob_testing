<?php /* adminova stranka - rozcestnik pro admina */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('Administrace str�nek odd�lu',false);
?>
<CENTER>

<A HREF="index.php?id=<? echo (_ADMIN_GROUP_ID_); ?>&subid=2" class="NaviColSm">P�ihl�ky na z�vody</A><BR>
<A HREF="index.php?id=<? echo (_ADMIN_GROUP_ID_); ?>&subid=5" class="NaviColSm">Editace z�vod�</A><BR><BR>
<A HREF="index.php?id=<? echo (_ADMIN_GROUP_ID_); ?>&subid=3" class="NaviColSm">�lensk� z�kladna odd�lu</A><BR><BR>
<A HREF="index.php?id=<? echo (_ADMIN_GROUP_ID_); ?>&subid=4" class="NaviColSm">N�hled na ��ty</A><BR>
<A HREF="index.php?id=<? echo (_ADMIN_GROUP_ID_); ?>&subid=6" class="NaviColSm">V�pis zm�n v datab�zi</A><BR>

<BR><hr>

<H2>Speci�ln� pomocn� "funkce"</H2>
<H3>! Pou��vejte jen pokud v�te co �in�te !</H3>

<A HREF="srv_repair_czech_names_db.php" class="NaviColSm">Oprava t��d�c�ch jmen u u�ivatel�</A><BR>
<A HREF="srv_repair_regs_db.php" class="NaviColSm">Oprava tabulky registrac� na z�vody.</A><BR>
<A HREF="_SQL/zmeny.sql.php" class="NaviColSm" target="_blank">�pravy datab�ze (patche,updaty)</A><BR>

<BR><hr>

<H2>Informace o syst�mu</H2>

<?

$data_tbl = new html_table_nfo;
echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";

echo $data_tbl->get_new_row('N�zev syst�mu',SYSTEM_NAME);
echo $data_tbl->get_new_row('Verze syst�mu', GetCodeVersion());
echo $data_tbl->get_new_row('Http Server',$_SERVER['SERVER_SOFTWARE']);
echo $data_tbl->get_new_row('Verze php', phpversion());
echo $data_tbl->get_new_row('Verze MySQL',mysql_get_client_info().' / '.mysql_get_server_info());

echo $data_tbl->get_footer()."\n";
?>

</CENTER>