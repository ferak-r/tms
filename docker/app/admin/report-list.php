<?php
//### fetch variable
$prefix		= $section."/".$module;
$sortby		= @$_COOKIE[$prefix."_sortby"];
$sortorder	= @$_COOKIE[$prefix."_order"];
$filter = '';

//### sort
$sortorder = (@$sortorder == "asc") ? "ASC" : "DESC";
$sort = '';
if(!empty($sortby) and preg_match('/^[-a-z0-9_]+$/i', $sortby) and is_int(array_search($sortby, $field))){
	$sort = "x$sortby";
}

//### rowset columns
switch($cmd){
	case 'favor':
		$btn = array('view','delete');
		$function = 'favorList';
		$col[] = array('{xfavor}', '100%', 'name', 'favor');					 	
		break;
	default:
		$btn = array('edit');
		$function = 'reportList';
		$col[] = array('{xmain}', '100%', 'name', 'main');
}

foreach($col as $val){
	if(!empty($val[3]))
		$field[] = $val[3];
}
//### sort
$sortorder = (@$sortorder == "asc") ? "ASC" : "DESC";
$sort = '';
if(!empty($sortby) and preg_match('/^[-a-z0-9_]+$/i', $sortby) and is_int(array_search($sortby, $field))){
	$sort = "x$sortby";
}

$res = $report->$function(1, 1);
$numrow  = $res['numrow'];
$maxpage = $res['maxpage'];
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $reportconfig['maxrow'];

//### fetch list
$list = $report->$function(0, 1, $sort, $sortorder, $page);

//### row set
$rowset->reset($list, 'xreportid', $prefix, $sortby, $sortorder, "sortASC", "sortDESC", $btn, true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$rowset->hidenew = true;
$smarty->assign('dataset', $rowset->renderDataset());

$tplModule = "list.tpl";
//### smarty
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
trace($smarty->_tpl_vars);
?>