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
$sortBy = (!empty($sortBy)) ? $sortBy : 'carrierid';
$sortOrder = (@$sortOrder == "asc") ? "ASC" : "DESC" ;

//### paging
$sql = "SELECT COUNT(*)
		FROM xxcarrier
		WHERE xcarriertype='Company' $where";
$maxpage = $db->getone($sql);
$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $config['page'];

$sql = "SELECT *
		FROM xxcarrier
		NATURAL LEFT JOIN xxuser_username
		WHERE xcarriertype='Company' $where
		ORDER BY x$sortBy $sortOrder";

//carrier list
$list = $db->getAll($sql." limit $page, $config[page]");

$btn = array('edit','delete');
$col[] = array('{xusername}', '20%', 'username', 'username');
$col[] = array('{xcarrier}', '20%', 'company', 'carrier');
$col[] = array('{xphone}', '20%', 'tel', 'phone');
$col[] = array('{xaddress}', '40%', 'address', 'address');

//### row set
$rowset->reset($list, 'xcarrierid', @$prefix, $sortBy, $sortOrder, "sortASC", "sortDESC", $btn, true);
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
trace($smarty->_tpl_vars);
?>