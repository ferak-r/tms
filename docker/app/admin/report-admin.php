<?php
$reportid = @intval($_REQUEST['frm_id']);

switch($cmd){
	case 'delete': //delete favor
		$report->deleteFavor($reportid);
		die();				
		break;
	case 'result':
		$res = $report->createQuery(@$_POST['reportid'], @$_POST['showfield'], @$_POST['wherefield'], @$_POST['operator'], @$_POST['value'], @$_POST['value_min'], @$_POST['value_max'], @$_POST['type'], @$_POST['orderby'], @$_POST['sortorder'], @$_POST['limit'], @$_POST['maxrow'], @$_POST['favor'], @$_POST['groupfavor']);
		$smarty->assign('maxrow', @$res['maxrow']);
		$smarty->assign('showfield',@ $res['showfield']);
		$smarty->assign('list', @$res['result']);
		$smarty->display('report-result.tpl');
		die();
		break;	
	case 'favorresult':
		$res = $report->favorResult($reportid);		
		$smarty->assign('showfield', $res['showfield']);
		$smarty->assign('list', @$res['result']);
		$smarty->display('report-result.tpl');
		die();
		break;
	default: // reportdefault for admin
		$formData = $report->reportFormdata("index.php?section=$section&module=$module&cmd=result", $reportid);
}

$tplModule = "admin.tpl";
$smarty->assign_by_ref('page', $page);
$smarty->assign('backurl', "index.php?section=$section&module=report-list&page=$page");
$smarty->assign('formData', @$formData);
trace($smarty->_tpl_vars, 'global');
?>