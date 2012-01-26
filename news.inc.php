<?php /* novinky */
if (!defined("__HIDE_TEST__")) exit; /* zamezeni samostatneho vykonani */ ?>
<?
DrawPageTitle('Novinky', false);
?>
<?
$curr_date = GetCurrentDate();

if (IsLoggedEditor())
{
	echo "<A href=\"#addnews\">P�id�n� novinky ...</A><BR>\n";
?>
<script language="JavaScript">
<!--
function confirm_delete(date) {
	return confirm('Opravdu chcete smazat tuto novinku ? \n Ze dne : "'+date+'" \n Novinka bude nen�vratn� smaz�na !!');
}
-->
</script>
<?
}
// news_sh
$news = (IsSet($news) && is_numeric($news) && $news > 0) ? 1 : 0;

$sql_query = 'SELECT '.TBL_NEWS.'.*, '.TBL_ACCOUNT.'.podpis FROM '.TBL_NEWS.' LEFT JOIN '.TBL_ACCOUNT.' ON '.TBL_NEWS.'.id_user = '.TBL_ACCOUNT.'.id ORDER BY datum DESC,id DESC';
if ($news != 1)
	$sql_query .= " LIMIT ".GC_NEWS_LIMIT;

@$vysledek=MySQL_Query($sql_query);
$cnt= ($vysledek != FALSE) ? mysql_num_rows($vysledek) : 0;
if($cnt > 0)
{
?>
<TABLE width="100%">
<?
	if ( IsLoggedAdmin() )
	{
		echo '<TR><TD></TD><TD class="LastDate">';
		echo 'Po�et';
		if ($news != 1)
			echo ' zobrazen�ch';
		echo ' novinek : '.$cnt;
		echo '</TD></TR>';
	}

	while ($zaznam=MySQL_Fetch_Array($vysledek))
	{
		$datum = Date2String($zaznam['datum']);
		echo '<TR><TD class="NewsItemDate">'.$datum.'&nbsp;&nbsp;</TD>';
		if ($zaznam['nadpis']!='') echo '<TD class="NewsItemTitle">'.$zaznam['nadpis'].' </TD></TR><TR><TD></TD>';
		$name_id = $zaznam['id_user'];

		echo '<TD class="NewsItem">'.$zaznam['text'];
		if ($name_id && $zaznam['podpis'] != '' && $name_id != $g_www_admin_id)
			echo '&nbsp;<span class="NewsAutor">[&nbsp;'.$zaznam['podpis'].'&nbsp;]</span>';
		if ( ($usr->account_id == $name_id) || IsLoggedAdmin() )
			echo '&nbsp;&nbsp;<A HREF="./news_del_exc.php?id='.$zaznam['id'].'" onclick="return confirm_delete(\''.$datum.'\')" class="NewsErase">Smazat</A>';
		echo '</TD></TR>';
	}
//	news_sh
?>
</TABLE>
<?
if ($news != 1 && $cnt == GC_NEWS_LIMIT)
	echo '<BR><BR><CENTER><A href="index.php?id=0&news=1">Zobrazit v�echny novinky</A></CENTER><BR>'."\n";
} // aspon jeden zaznam
else
{
	echo "Seznam novinek je pr�zdn�.<BR>";
}
//	news_sh

if (IsLoggedEditor ())
	{
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
function change_font(object)
{
	if (object.value == "t_bold")
	{
		var start='<B>';
		var stop='</B>';
	}
	else
	{
		var start='<U>';
		var stop='</U>';
	}

	if (object.checked)
	{
		object.form.text.value=object.form.text.value+start;
		object.form.text.focus();
	}
	else
	{
		object.form.text.value=object.form.text.value+stop;
		object.form.text.focus();
	}
}

//-->
</SCRIPT>

<CENTER><BR><hr><BR></CENTER>
<FORM METHOD=POST ACTION="./news_new_exc.php" name="form_news" id="form_news">
<A name="addnews">&nbsp;</A>
<TABLE width="100%">
<TR><TD></TD><TD width="5" rowspan="11"></TD><TD align=left valign=bottom>
<H3>Formul�� pro vlo�en� novinky</H3>
</TD></TR>
<!-- temporary !!! - remove and convert to html_table_form -->
<style type="text/css">
TD.NewsEditCaption {
	width : 80px;
	vertical-align : top;
	text-align : right;
	color : <? echo $g_colors['body_text']; ?>;
	font-weight : bold;
}
</style>
<TR><TD class="NewsEditCaption">Datum</TD><TD class="DataValue">
<INPUT TYPE="text" NAME="datum" SIZE=10 VALUE="<?echo GetCurrentDateString(true);?>">&nbsp;&nbsp;(DD.MM.RRRR)
</TD></TR>
<TR><TD colspan="3" height="5"></TD></TR>
<TR><TD class="NewsEditCaption">Nadpis</TD><TD>
<INPUT TYPE="text" NAME="nadpis" size="50">
</TD></TR>
<TR><TD colspan="3" height="5"></TD></TR>
<TR><TD class="NewsEditCaption">Text</TD><TD>
<TEXTAREA name="text" cols="50" rows="10" wrap=virtual></TEXTAREA>
</TD></TR>
<TR><TD colspan="2"></TD><TD>
<INPUT TYPE="checkbox" NAME="t_bold" onClick="javascript:change_font(this);" value="t_bold">Tu�n� p�smo (<B>p��klad</B>)<BR>
<INPUT TYPE="checkbox" NAME="t_unli" onClick="javascript:change_font(this);" value="t_unli">Podtr�en� p�smo (<U>p��klad</U>)<BR>
Upozorn�n� - V�dy ukon�ujte zm�ny p�sma, jinak m��e doj�t k poru�en� form�tov�n� novinek.<BR>
</TD></TR>
<TR><TD colspan="3" height="5"></TD></TR>
<TR><TD></TD><TD align=left valign=top>
<INPUT TYPE="submit" VALUE="Odeslat">
</TD></TR>
</TABLE>
</FORM>
<?
	}
?>
<BR>