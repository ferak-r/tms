<?php
//### fetch variable
$prefix		= $section."/".$module;
$sortby		= @$_COOKIE[$prefix."_sortby"];
$sortorder	= @$_COOKIE[$prefix."_order"];
$filter = '';

//### rowset columns
$col[] = array('{xmain}', '20%', 'name', 'main');
$col[] = array('<span dir="ltr">{xsql}</span>', '50%');
$col[] = array('<span dir="ltr">{xgroupby}</span>', '5%', 'groupby');
$col[] = array('<span dir="ltr">{xgroup}</span>', '5%', 'grouppermission');
$col[] = array('<span dir="ltr">{xfunction}</span>', '20%', 'function');


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

$res = $report->reportList(1, 0);
$numrow  = $res['numrow'];
$maxpage = $res['maxpage'];
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $reportconfig['maxrow'];

//### fetch list
$list = $report->reportList(0, 0, $sort, $sortorder, $page);

//### row set
$rowset->reset($list, 'xmainid', $prefix, $sortby, $sortorder, "sortASC", "sortDESC", array('delete'), true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$smarty->assign('dataset', $rowset->renderDataset());

$tplModule = "list.tpl";
//### smarty
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
trace($smarty->_tpl_vars);
?>