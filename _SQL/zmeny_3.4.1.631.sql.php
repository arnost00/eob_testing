<?

//#############################################################################
//	vychozi verze
//#############################################################################

$version_upd = '3.4.1.631';

//#############################################################################

require_once ('prepare.inc.php');

//#############################################################################
//	SQL dotazy pro zmenu db. na novejsi verzi
//#############################################################################

# *** pridani sloupcu pro dopravu
$sql[1] = 'ALTER TABLE `'.TBL_ZAVXUS.'` ADD `sedadel` TINYINT( 1 ) NULL DEFAULT NULL AFTER `transport`';

//#############################################################################

require_once ('action.inc.php');
?>