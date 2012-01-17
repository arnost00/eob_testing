<?php if (!defined('__HIDE_TEST__')) exit; /* zamezeni samostatneho vykonani */ ?>
<?

define ('CS_EMPTY_ITEM','1001');
define ('CS_MIN_LEN_LOGIN','1002');
define ('CS_LOGIN_EXIST','1003');
define ('CS_LOGIN_UPDATED','1004');
define ('CS_BAD_CUR_PASS','1005');
define ('CS_NODIFF_PASS','1006');
define ('CS_MIN_LEN_PASS','1007');
define ('CS_DIFF_NEWPASS','1008');
define ('CS_PASS_UPDATED','1009');
define ('CS_ACC_UPDATED','1010');
define ('CS_ACC_CREATED','1011');
define ('CS_USER_PASS_UPDATED','1012');
define ('CS_ADM_PASS_REQ','1013');
define ('CS_ADM_NOT_FOUND','1014');
define ('CS_USER_LOCK_ACC','1015');
define ('CS_ADM_PASS_WRONG','1016');
/*
define ('CS_','1017');
*/
define ('CS_UNKNOWN_ERROR','9999');

function GetResultString($code)
{

	switch($code)
	{
		case CS_EMPTY_ITEM:
			$result = 'Mus� n�co zadat!'; break;
		case CS_MIN_LEN_LOGIN:
			$result = 'Minim�ln� d�lka p�ihla�ovac� jm�na je 4 znaky !'; break;
		case CS_LOGIN_EXIST:
			$result = 'Toto p�ihla�ovac� jm�no ji� existuje.'; break;
		case CS_LOGIN_UPDATED:
			$result = 'Podpis a p�ihla�ovac� jm�no byly aktualizov�ny.'; break;
		case CS_BAD_CUR_PASS:
			$result = '�patn� zadan� sou�asn� heslo !'; break;
		case CS_NODIFF_PASS:
			$result = 'Nov� i star� heslo nem��e b�t stejn� !'; break;
		case CS_MIN_LEN_PASS:
			$result = 'Minim�ln� d�lka hesla jsou 4 znaky !'; break;
		case CS_DIFF_NEWPASS:
			$result = 'Nov� heslo i kontroln� heslo musej� b�t stejn� !'; break;
		case CS_PASS_UPDATED:
			$result = 'Heslo bylo zm�n�no.'; break;
		case CS_ACC_UPDATED:
			$result = 'Byl upraven ��et �lena.'; break;
		case CS_ACC_CREATED:
			$result = 'Byl zalo�en nov� ��et.'; break;
		case CS_USER_PASS_UPDATED:
			$result = 'Bylo zm�n�no heslo �lena.'; break;
		case CS_ADM_PASS_REQ:
			$result = 'Mus� zadat heslo admina!'; break;
		case CS_ADM_NOT_FOUND:
			$result = 'Nepoda�ilo se naj�t admina !!!'; break;
		case CS_USER_LOCK_ACC:
			$result = 'Byl zam�en/odem�en ��et �lena.'; break;
		case CS_ADM_PASS_WRONG:
			$result = 'Mus� zadat spr�vn� heslo admina!'; break;
/*
		case :
			$result = ''; break;
*/
		case CS_UNKNOWN_ERROR:
			$result = 'Nezn�m� chyba.'; break;
		default :
			$result = '';
	}
	return $result;
}

?>