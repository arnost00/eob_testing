<?php /* adminova stranka - rozcestnik pro admina */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('Administrace stránek oddílu');
?>
<CENTER>

<A HREF="index.php?id=<? echo (_ADMIN_GROUP_ID_); ?>&subid=2" class="NaviColSm">Přihlášky na závody</A><BR>
<A HREF="index.php?id=<? echo (_ADMIN_GROUP_ID_); ?>&subid=5" class="NaviColSm">Editace závodů</A><BR><BR>
<A HREF="index.php?id=<? echo (_ADMIN_GROUP_ID_); ?>&subid=4" class="NaviColSm">Náhled na účty</A><BR>
<A HREF="index.php?id=<? echo (_ADMIN_GROUP_ID_); ?>&subid=6" class="NaviColSm">Výpis změn v databázi</A><BR>

<BR><hr>

<? DrawPageSubTitle('Speciální pomocné "funkce"'); ?>
<B>! Používejte jen pokud víte co činíte !</B><BR>

<A HREF="srv_repair_regs_db.php" class="NaviColSm">Oprava tabulky registrací na závody.</A><BR>
<A HREF="_SQL/zmeny.sql.php" class="NaviColSm" target="_blank">Úpravy databáze (patche,updaty)</A><BR>

<BR><hr>

<? 
DrawPageSubTitle('Informace o systému');

$data_tbl = new html_table_nfo;
echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";

echo $data_tbl->get_new_row('Název systému',SYSTEM_NAME);
echo $data_tbl->get_new_row('Verze systému', GetCodeVersion());
echo $data_tbl->get_new_row('Http Server',$_SERVER['SERVER_SOFTWARE']);
echo $data_tbl->get_new_row('Verze php', phpversion());
echo $data_tbl->get_new_row('Verze MySQL',mysql_get_client_info().' / '.mysql_get_server_info());

echo $data_tbl->get_footer()."\n";
?>

</CENTER>