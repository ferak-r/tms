<?php
//### fetch variable
$prefix		= $section."/".$module;
$sortBy		= @$_COOKIE[$prefix."_sortby"];
$sortOrder	= @$_COOKIE[$prefix."_order"];
$where 	    = $qobject->makeWhere(@$zcond);

$query		= @$db->escapeSimple($_REQUEST['query']);
if(!empty($query)){
	$query = base64_decode($query);
	parse_str($query);
}

//### sort
$sortBy = (!empty($sortBy)) ? $sortBy : 'statuscolorid';
$sortOrder = (@$sortOrder == "asc") ? "ASC" : "DESC" ;

//### paging
$sql = "SELECT COUNT(*)
		FROM xxstatuscolor
		NATURAL LEFT JOIN xxcolor
		WHERE 1 $where";
$maxpage = $db->getone($sql);
$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $config['page'];

$sql = "SELECT *
		FROM xxstatuscolor
		NATURAL LEFT JOIN xxcolor
		WHERE 1 $where
		ORDER BY x$sortBy $sortOrder";

//carrier list
$list = $db->getAll($sql." limit $page, $config[page]");

$btn = array('edit','delete');
$col[] = array('{xcolor}', '20%', 'color', 'color');
$col[] = array('{xstatus}', '80%', 'status', 'status');

//### row set
$rowset->reset($list, 'xstatuscolorid', @$prefix, $sortBy, $sortOrder, "sortASC", "sortDESC", $btn, true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$smarty->assign('dataset', $rowset->renderDataset());

$tplModule = "list.tpl";
//###samarty
$smarty->assign_by_ref('sortBy', $sortBy);
$smarty->assign_by_ref('sortOrder', $sortOrder);
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
$smarty->assign_by_ref('list', $list);
$smarty->assign('hideSearchButton', 1);
trace($smarty->_tpl_vars);
?>