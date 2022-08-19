<?PHP
if(($_SERVER['REMOTE_ADDR']=='91.184.80.102' or substr($_SERVER['REMOTE_ADDR'], 0, 8)=='172.18.3') and strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox')) {
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	$testuser = true;
} else {
	//error_reporting(0);
	//ini_set('display_errors', false);
	$testuser = false;
}
ini_set('mbstring.internal_encoding','UTF-8');
ini_set('mbstring.http_input','UTF-8');
ini_set('mbstring.http_output','UTF-8');

require_once("language/en.inc.php");

require_once("DB.php");
require_once("DB/mysqli.php");
require_once("Smarty.class.php");
require_once("HTML/QuickForm.php");
require_once("HTML/QuickForm/Renderer/ArraySmarty.php");

require_once("function.inc.php");
require_once("site.class.php");
require_once("site.conf.php");
require_once("module/xdb/xdb.module.php");
require_once("module/session/session.module.php");
require_once("module/xsmarty/xsmarty.module.php");
require_once("module/user/user.module.php");
require_once("module/mail/mail.module.php");
require_once("module/report/report.module.php");
require_once("module/query/query.module.php");

foreach($qobject->q as $key => $val) {  // pass the query values to smarty
	$smarty->assign($key, $val);
}

//###  variables
$root_dir = @$_SERVER["DOCUMENT_ROOT"]; 

$php_self 		= $_SERVER['PHP_SELF'];
$query_string 	= $_SERVER['QUERY_STRING'];
$href 			= $php_self.(empty($query_string) ? '' : '?'.$query_string);

$page 	 	= @!empty($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$cmd	 	= empty($_REQUEST['cmd']) ? '': $_REQUEST['cmd'];
$query	 	= @$_REQUEST['query'];
$popup	 	= @$_REQUEST['popup'];
$section 	= empty($_REQUEST['section'])? 'guest' : $_REQUEST['section'];
$module  	= empty($_REQUEST['module']) ? '' : $_REQUEST['module'];
$step    	= empty($_REQUEST['step']) ? '' : $_REQUEST['step'];
$carrytype  = empty($_REQUEST['carrytype']) ? '' : $_REQUEST['carrytype'];
?>