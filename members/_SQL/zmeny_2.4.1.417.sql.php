<?

//#############################################################################
//	vychozi verze
//#############################################################################

$version_upd = '2.4.1.417';

//#############################################################################

require ('prepare.inc.php');

//#############################################################################
//	SQL dotazy pro zmenu db. na novejsi verzi
//#############################################################################

# *** pridani sloupcu pro dopravu
$sql[1] = 'ALTER TABLE `'.TBL_RACE.'` ADD `cancelled` TINYINT( 1 ) NOT NULL DEFAULT \'0\'';
//#############################################################################

require ('action.inc.php');
?>
