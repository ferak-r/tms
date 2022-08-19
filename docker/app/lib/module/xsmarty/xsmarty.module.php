<?PHP
require_once('xsmarty.conf.php');
require_once('xsmarty.class.php');

$smarty = new mySmarty();
$smarty->caching = false;
//$smarty->force_compile = true;
$rowset = new SMARTY_DATASET();
?>