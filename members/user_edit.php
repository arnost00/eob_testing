<?php /* adminova stranka - editace clena */
define("__HIDE_TEST__", "_KeAr_PHP_WEB_");

@extract($_REQUEST);

require ("connect.inc.php");
require ("sess.inc.php");
require ("ctable.inc.php");
if (!IsLoggedSmallAdmin() && !IsLoggedManager())
{
	header("location: ".$g_baseadr."error.php?code=21");
	exit;
}
db_Connect();
$id = (isset($id) && is_numeric($id)) ? (int)$id : 0;

// id je z tabulky "users"
@$vysledek=MySQL_Query("SELECT * FROM ".TBL_USER." WHERE id = '$id' LIMIT 1");
@$zaznam=MySQL_Fetch_Array($vysledek);
$update=$id;
include ("./header.inc.php"); // header obsahuje uvod html a konci <BODY>
include ("./common.inc.php");
include ("./common_user.inc.php");

DrawPageTitle('�lensk� z�kladna - Editace u�ivatele');
?>
<TABLE width="100%" cellpadding="0" cellspacing="0" border="0">
<TR>
<TD width="2%"></TD>
<TD width="90%" ALIGN=left>
<CENTER>
<BR><hr><BR>
<? include ("user_new.inc.php"); ?>
<BR><hr><BR>
<?
	if (!IsSet($cb)) $cb = 0;
	$cb = (int)$cb;
	if ($cb == 0)
	{
		if (IsLoggedSmallAdmin())
			$cb = 700;
		else if (IsLoggedManager())
			$cb = 700;
		else
			$cb = 600;
	}
	echo('<A HREF="index.php?id='.$cb.'&subid=1">Zp�t na seznam �len�</A><BR>');
?>
<BR><hr><BR>
</CENTER>
</TD>
<TD width="2%"></TD>
</TR>
<TR><TD COLSPAN=4 ALIGN=CENTER>
<!-- Footer Begin -->
<?include ("footer.inc.php");?>
<!-- Footer End -->
</TD></TR>
</TABLE>

</BODY>
</HTML>