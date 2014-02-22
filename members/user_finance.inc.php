<?php /* finance -  show exact user finance */
 /* zamezeni samostatneho vykonani */ ?>

<?
@$vysledek_historie=MySQL_Query("select fin.id fin_id, rc.nazev zavod_nazev, rc.cancelled zavod_cancelled, from_unixtime(rc.datum,'%Y-%c-%e') zavod_datum, fin.amount amount, fin.note note, us.sort_name name, fin.date `date` from ".TBL_FINANCE." fin 
		inner join ".TBL_USER." us on fin.id_users_editor = us.id
		left join ".TBL_RACE." rc on fin.id_zavod = rc.id
		where fin.id_users_user = ".$user_id." and fin.storno is null  order by fin.date asc, fin.id asc");

//vytazeni jmena uzivatele
@$vysledek_user_name=MySQL_Query("select us.sort_name name from ".TBL_USER." us where us.id = ".$user_id);
$zaznam_user_name=MySQL_Fetch_Array($vysledek_user_name);

DrawPageSubTitle('Historie ��tu pro �lena: '.$zaznam_user_name['name']);

include_once ("./common_race.inc.php");
include_once ('./url.inc.php');


$data_tbl = new html_table_mc();
$col = 0;
$data_tbl->set_header_col($col++,'Datum transakce',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Z�vod',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'Datum z�vodu',ALIGN_CENTER);
$data_tbl->set_header_col($col++,'��stka',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Pozn�mka',ALIGN_LEFT);
$data_tbl->set_header_col($col++,'Zapsal',ALIGN_LEFT);
if ($g_enable_finances_claim)
	$data_tbl->set_header_col($col++,'Reklamace',ALIGN_LEFT);
isset($finance_readonly)?"":IsLoggedFinance()?$data_tbl->set_header_col($col++,'Mo�nosti',ALIGN_LEFT):"";


echo $data_tbl->get_css()."\n";
echo $data_tbl->get_header()."\n";
echo $data_tbl->get_header_row()."\n";

$sum_amount = 0;
$i = 0;
while ($zaznam=MySQL_Fetch_Array($vysledek_historie))
{
	$row = array();
	$datum = SQLDate2String($zaznam['date']);
	$row[] = $datum;
	$row[] = ($zaznam['zavod_nazev'] == null) ? '-':GetFormatedTextDel($zaznam['zavod_nazev'], $zaznam['zavod_cancelled']);
	$row[] = ($zaznam['zavod_nazev'] == null) ? '-':formatDate($zaznam['zavod_datum']);
	$row[] = $zaznam['amount'];
	$row[] = $zaznam['note'];
	$row[] = $zaznam['name'];
//priprava pro pouziti ajaxu a jquery
// 	$row[] = "<div class=\"div-claim\" claim=\"".$zaznam['fin_id']."\" id=\"claim-".$zaznam['fin_id']."\">Probl�m?</div>";
	if ($g_enable_finances_claim)
		$row[] = '<A HREF="javascript:open_win(\'./claim.php?payment_id='.$zaznam['fin_id'].'\',\'\')">Probl�m?</A>';
	isset($finance_readonly)?"":IsLoggedFinance()?$row[]=" <a href=\"?change=change&trn_id=".$zaznam['fin_id']."\">Zm�nit</a>&nbsp;/&nbsp;<a href=\"?storno=storno&trn_id=".$zaznam['fin_id']."\">Storno</a>":"";
	
	$sum_amount += $zaznam['amount'];
	
	echo $data_tbl->get_new_row_arr($row)."\n";
	$i++;
}
if ($i > 0)
	echo $data_tbl->get_break_row()."\n";

$row = array();
$row[] = '';
$row[] = "Kone�n� z�statek";
$row[] = '';
$sum_amount<0?$class="red":$class="";
$row[] = "<span class='amount$class'>".$sum_amount."</span>";
echo $data_tbl->get_new_row_arr($row)."\n";
echo $data_tbl->get_footer()."\n";


//------------ formular pro prevod financi mezi cleny
$return_url = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; 
// $return_url = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
$return_url = parse_url($return_url, PHP_URL_QUERY);
include 'user_finance_transfer_form.inc.php';


//priprava pro pouziti ajaxu a jquery
// <div style="display: none;" id="dialog-modal">
// <form action="http://localhost/members/index.php?id=200&subid=10">
// <fieldset>
// <label for="dialog-text" id="label-dialog-text"></label>
// <textarea rows="3" id="dialog-text"></textarea>
// <button type="submit">Ode�li</button>
// </fieldset>
// </form>
// </div>

//   <style>
//     textarea#dialog-text { width:95%; padding: 10px; }
//     fieldset { padding:0; border:0; margin-top:10px; }
//   </style>

// <script>
// $(".div-claim").click(function () {
// 	var id = $(this).prop("id");
// 	$("#label-dialog-text").prop("innerHTML",id);
//     $("#dialog-modal").dialog({
//         width: 500,
//         height: 220,
//         modal: true,
//         autoOpen: false,
//         title: "Zadej reklamaci"
//     });
// 	$("#dialog-modal").dialog("open");
// });
// </script>
?>
