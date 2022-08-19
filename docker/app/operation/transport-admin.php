<?php
//###fetch information
$step = @$_REQUEST['step'];
$transportid = @$_REQUEST['transportid'];
$cargoid = @$_REQUEST['cargoid'];
$containerid = @$_REQUEST['containerid'];
$carry = @$_REQUEST['carrytype'];
$id = @$_REQUEST['frm_id'];
$popup = @intval($_REQUEST['popup']);
$archive = @$_GET['archive'];
$tplModule = "admin.tpl";

switch($step){
	case 'transport':
		include "transport-admin/transport.inc.php";
		break;
	case 'document':
		include "transport-admin/document.inc.php";
		break;
	case 'documentcomment':
		include "transport-admin/documentcomment.inc.php";
		break;
	case 'cargo':
		include "transport-admin/cargo.inc.php";
		break;
	case 'containercargo':
		include "transport-admin/containercargo.inc.php";
		break;
	case 'finished':
		include "transport-admin/finished.inc.php";
		break;	
}

if($popup && $tplModule == 'admin.tpl'){
	$smarty->assign('hideback', 1);
}

//###samarty
$smarty->assign('extModule', @$extModule);
$smarty->assign('transportid', $transportid);
$smarty->assign('cargoid', $cargoid);
$smarty->assign('containerid', $containerid);
$smarty->assign('carrytype', $carry);
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('step', $step);
$smarty->assign_by_ref('list', $list);
$smarty->assign_by_ref('default', @$default);
$smarty->assign('id', $id);
$smarty->assign('formData', @$formData);
trace($smarty->_tpl_vars);
//$smarty->debugging = true;
if($popup){
	$smarty->display($tplModule);
	die();
}
?>