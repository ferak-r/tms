<?php
$reportid = @intval($_REQUEST['frm_id']);

switch($cmd){
	case 'add':
		$res = $report->add(@$_POST['main'],
							 @$_POST['sql'],
							 @$_POST['groupby'],
							 @$_POST['function'],							 
							 @$_POST['showfield'], 
							 @$_POST['showname'], 
							 @$_POST['wherefield'], 
							 @$_POST['wherename'], 
							 @$_POST['types'], 
							 @$_POST['condition'],
							 @$_POST['groupreport']);
		if(empty($res)){
			msg($msg['Error'], 'error', 'خطا');
		}else{
			msg($msg['Ok'], 'ok', 'افزودن گزارش');
		}
		redirect("index.php?section=$section&module=reportmaker-list");
		break;
	case 'delete':
		if(!$report->delete($reportid)){
			msg($msg['Error'], 'error', 'خطا');
		}else{
			msg($msg['Ok'], 'ok', 'حذف گزارش');
		}
		//redirect("index.php?section=$section&module=reportmaker-list");		
		die();
		break;	
	default: //  querydefault for  programmer
		$formData = $report->queryFormdata("index.php?section=$section&module=$module&cmd=add");
}

$tplModule = "admin.tpl";
$smarty->assign_by_ref('page', $page);
$smarty->assign('backurl', "index.php?section=$section&module=reportmaker-list&page=$page");
$smarty->assign('formData', @$formData);
trace($smarty->_tpl_vars, 'global');
?>