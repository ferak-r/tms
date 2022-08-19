<?php
//### fetch variable
$prefix		= $section."/".$module;
$sortBy		= @$_COOKIE[$prefix."_sortby"];
$sortOrder	= @$_COOKIE[$prefix."_order"];
$where 		= $qobject->makeWhere(@$zcond);

//### sort
$sortBy = (!empty($sortBy)) ? $sortBy : 'customerid';
$sortOrder = (@$sortOrder == "asc") ? "ASC" : "DESC" ;

//### paging
$sql = "SELECT COUNT(*)
		FROM xxcustomer
		WHERE 1 $where";
$maxpage = $db->getone($sql);
$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $config['page'];

$sql = "SELECT *
		FROM xxcustomer
		NATURAL LEFT JOIN xxuser_username
		WHERE 1 $where
		ORDER BY x$sortBy $sortOrder";
//custom list
$list = $db->_getAll($sql." limit $page, $config[page]");

$btn = array('edit','delete');
$col[] = array('{xusername}', '15%', 'username', 'username');
$col[] = array('{xname}', '15%', 'name', 'name');
$col[] = array('{xfamily}', '15%', 'family', 'family');
$col[] = array('{xcompany}', '15%', 'company', 'company');
$col[] = array('{xphone}', '15%', 'tel', 'phone');
$col[] = array('{xaddress}', '40%', 'address', 'address');

//### row set
$rowset->reset($list, 'xcustomerid', @$prefix, $sortBy, $sortOrder, "sortASC", "sortDESC", $btn, true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$smarty->assign('dataset', $rowset->renderDataset());

$country = $db->getList('xxcountry', '', '', 'xcountryname');

$tplModule = "list.tpl";
//###samarty
$smarty->assign_by_ref('sortBy', $sortBy);
$smarty->assign_by_ref('sortOrder', $sortOrder);
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
$smarty->assign_by_ref('list', $list);
$smarty->assign_by_ref('country', $country);

trace($smarty->_tpl_vars);
?>