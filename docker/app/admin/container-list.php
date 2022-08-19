<?php
//### fetch variable
$prefix		= $section."/".$module;
$sortBy		= @$_COOKIE[$prefix."_sortby"];
$sortOrder	= @$_COOKIE[$prefix."_order"];
$where 	    = $qobject->makeWhere(@$zcond);
$companycontainer = @intval($_GET['companycontainer']);

$where .= "AND xcompanycontainer = '$companycontainer'";
if($companycontainer){
	$msg['title1']['container-list'] = "Company Container List";
}


//### sort
$sortBy = (!empty($sortBy)) ? $sortBy : 'containerid';
$sortOrder = (@$sortOrder == "asc") ? "ASC" : "DESC" ;

//### paging
$sql = "SELECT COUNT(*)
		FROM zzcontainer
		WHERE 1 $where";
$maxpage = $db->getone($sql);
$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $config['page'];

$sql = "SELECT *, IF(xcarriertype = 'Company', CONCAT('<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'carrier\',', xcarrierid, ', this);\">', xcarrier, '</a>'), xcarrier) AS xcarrier
		FROM zzcontainer
		WHERE 1 $where
		ORDER BY x$sortBy $sortOrder";
//container list
$list = $db->getAll($sql." limit $page, $config[page]");

$btn = array('edit','delete');
$col[] = array('{xcontainernumber}', '30%', 'containernumber', 'containernumber');
if(!$companycontainer){
	$col[] = array('{xown}', '30%', 'type', 'own');
	$col[] = array('{xcarrier}', '30%', 'owner', 'carrier');
}
$col[] = array('{xcontainertype}', '30%', 'containertype', 'containertype');
$col[] = array('{xcontainersize}', '30%', 'containersize', 'containersize');

//### row set
$rowset->reset($list, 'xcontainerid', @$prefix, $sortBy, $sortOrder, "sortASC", "sortDESC", $btn, true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$smarty->assign('dataset', $rowset->renderDataset());

$containertype = $db->getList('xxcontainertype');
$containersize = $db->getList('xxcontainersize');
$own		   = $db->fetchEnum('xxcontainer', 'xown');

$tplModule = "list.tpl";
//###samarty
$smarty->assign_by_ref('sortBy', $sortBy);
$smarty->assign_by_ref('sortOrder', $sortOrder);
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
$smarty->assign_by_ref('list', $list);
$smarty->assign('containertype', $containertype);
$smarty->assign('containersize', $containersize);
$smarty->assign('containersize', $containersize);
$smarty->assign('own', $own);

trace($smarty->_tpl_vars);
?>