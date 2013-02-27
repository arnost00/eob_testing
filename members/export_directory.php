<? define("__HIDE_TEST__", "_KeAr_PHP_WEB_"); ?>
<?php
@extract($_REQUEST);

require('./cfg/_colors.php');
require ('./connect.inc.php');
require ('./sess.inc.php');

if (!IsLoggedRegistrator() && !IsLoggedManager())
{
	header('location: '.$g_baseadr.'error.php?code=21');
	exit;
}

include ('./header.inc.php'); // header obsahuje uvod html a konci <BODY>
include ('./common.inc.php');

DrawPageTitle('Export adres��e',false);
?>
Do�asn�: <a href="export_directory_exc.php?oris=1">Export pro ORIS (Import �len� klubu)</a><br>

<h3 class="LinksTitle">Parametry exportu :</h3>
<form method="post" action="export_directory_exc.php">
Odd�lova� mezi sloupci :<br>
<input type="radio" name="par1" value="1" checked id="id_p1a"><label for="id_p1a">St�edn�k</label><br>
<input type="radio" name="par1" value="2" id="id_p1b"><label for="id_p1b">Tabel�tor</label><br>
<br>
Sloupce uzav��t do uvozovek :<br>
<input type="radio" name="par2" value="1" checked id="id_p2a"><label for="id_p2a">Ano</label><br>
<input type="radio" name="par2" value="0" id="id_p2b"><label for="id_p2b">Ne</label><br>
<br>
Vlo�it apostrof p�ed numerick� sloupce :<br>
<input type="radio" name="par3" value="1" checked id="id_p3a"><label for="id_p3a">Ano</label><br>
<input type="radio" name="par3" value="0" id="id_p3b"><label for="id_p3b">Ne</label><br>
<br>
<input type="submit" value="Exportovat">&nbsp;&nbsp;<button onclick="javascript:close_popup();">Zav��t</button>
</form>
</body>
</html>