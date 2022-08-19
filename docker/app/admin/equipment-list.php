<?php
//### fetch variable
$prefix		= $section."/".$module;
$sortBy		= @$_COOKIE[$prefix."_sortby"];
$sortOrder	= @$_COOKIE[$prefix."_order"];
$where 	    = $qobject->makeWhere(@$zcond);

//### sort
$sortBy = (!empty($sortBy)) ? $sortBy : 'carrier';
$sortOrder = (@$sortOrder == "asc") ? "ASC" : "DESC" ;

//### paging
$sql = "SELECT COUNT(*)
		FROM xxequipment
		NATURAL LEFT JOIN xxcarrier
		WHERE 1 $where";
$maxpage = $db->getone($sql);
$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $config['page'];

$sql = "SELECT *, IF(xequipmentcat='VSL', xequipment, xequipmentno)AS xequipment,
		IF(xcarriertype='Company', CONCAT('<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'equipment\',', xequipmentid, ', this);\">', xcarrier, '</a>'), xcarrier) AS xowner
		FROM xxequipment
		NATURAL LEFT JOIN xxequipmenttype
		NATURAL LEFT JOIN xxcarrier
		WHERE xequipmentcat!='Rail' $where
		ORDER BY x$sortBy $sortOrder";
//custom list
$list = $db->_getAll($sql." limit $page, $config[page]");

$btn = array('edit','delete');
$col[] = array('{xequipment}', '35%', 'equipmentnameno', 'equipment');
$col[] = array('{xowner}', '35%', 'owner', 'owner');
$col[] = array('{xequipmentcat}', '35%', 'equipmentcat', 'equipmentcat');
$col[] = array('{xequipmenttype}', '35%', 'equipmenttype', 'equipmenttype');
//### row set
$rowset->reset($list, 'xequipmentid', @$prefix, $sortBy, $sortOrder, "sortASC", "sortDESC", $btn, true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$smarty->assign('dataset', $rowset->renderDataset());

$equipmentcat = $db->fetchEnum('xxequipment', 'xequipmentcat');

$tplModule = "list.tpl";
//###samarty
$smarty->assign_by_ref('sortBy', $sortBy);
$smarty->assign_by_ref('sortOrder', $sortOrder);
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
$smarty->assign_by_ref('list', $list);
$smarty->assign_by_ref('equipmentcat', $equipmentcat);
trace($smarty->_tpl_vars);
?>