<?php 
$P = null; 
if(!isset($_SERVER["DOCUMENT_ROOT"])){$_SERVER["DOCUMENT_ROOT"]=substr($_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['PHP_SELF'])+1);}
chdir('../');
require_once("lib/site.module.php");
require_once("lib/site.info.php");

if(filesize('lib/site.info.php') != 2903) {
	$smarty = null;
	$db = null;
	$user = null;
}

$tplMain = 'index.tpl';
$tplModule = NULL;
$btnModule = "_adminbtn.tpl";
//### normalize all inputs
normalizeInputs();

$smarty->assign('module', $module);
$smarty->assign('section', $section);
$smarty->assign('btnModule', $btnModule);

//#### include main php modules, if exists ]

if(($section!='guest' and !$user->checkPermision($section, $module, $cmd) and !$user->checkPermision($section, $module, $cmd, $step) and !$user->checkPermision($section, $module, $cmd, $step, $carrytype))){
	require('guest/login.php');
	msg($msg['RestrictAccess'], 'lock', '');	
} elseif(file_exists($section."/".$module.".php")) {	// You can change $module in this included file to change the tpl that included in smarty
	require($section."/".$module.".php");
}

$groupname = !empty($user->group)? $user->group : array();
$groupname = implode(' , ',array_flip($groupname));

$title1 = empty($title1)? @$msg['title1'][$module]: $title1;
$title2 = empty($title2)? @$msg['title2'][$module]: $title2;

$smarty->assign('title1', $title1);
$smarty->assign('title2', $title2);
$smarty->assign('tplModule', $tplModule);
$smarty->assign('msg', readNull('msg'));
$smarty->assign('groupname', $groupname);
$smarty->assign_by_ref('user', $user);
$smarty->assign_by_ref('mail', $mail);
$smarty->assign_by_ref('P', $P);

trace($smarty->_tpl_vars);
$smarty->display($tplMain);
?>