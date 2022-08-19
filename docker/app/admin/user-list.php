<?php
//### fetch variable
$prefix		= $section."/".$module;
$sortBy		= @$_COOKIE[$prefix."_sortby"];
$sortOrder	= @$_COOKIE[$prefix."_order"];
$where 	    = $qobject->makeWhere(@$zcond);


//### sort
$sortBy = (!empty($sortBy)) ? $sortBy : 'infoid';
$sortOrder = (@$sortOrder == "asc") ? "ASC" : "DESC" ;

//### paging
$sql = "SELECT COUNT(*)
		FROM xxuser_info
		NATURAL LEFT JOIN xxuser_username
		NATURAL LEFT JOIN xxuser_groupuser
		NATURAL LEFT JOIN xxuser_group
		WHERE 1 $where
		GROUP BY xusernameid";
$maxpage = $db->getone($sql);
$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $config['page'];

$sql = "SELECT *, GROUP_CONCAT(xgroup SEPARATOR ', ')AS xgroup
		FROM xxuser_info
		NATURAL LEFT JOIN xxuser_username
		NATURAL LEFT JOIN xxuser_groupuser
		NATURAL LEFT JOIN xxuser_group
		WHERE 1 $where
		GROUP BY xusernameid
		ORDER BY x$sortBy $sortOrder";
//custom list
$list = $db->_getAll($sql." limit $page, $config[page]");

$btn = array('edit','delete');
$col[] = array('{xusername}', '15%', 'username', 'username');
$col[] = array('{xgroup}', '30%', 'group', 'group');
$col[] = array('{xname}', '20%', 'name', 'name');
$col[] = array('{xfamily}', '20%', 'family', 'family');
$col[] = array('{xtel}', '20%', 'tel', 'phone');

//### row set
$rowset->reset($list, 'xinfoid', @$prefix, $sortBy, $sortOrder, "sortASC", "sortDESC", $btn, true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$smarty->assign('dataset', $rowset->renderDataset());

$group = $user->fetchgroup();
unset($group[array_search('webcarrier', $group)]);
unset($group[array_search('customer', $group)]);
unset($group[array_search('office', $group)]);

$tplModule = "list.tpl";
//###samarty
$smarty->assign_by_ref('sortBy', $sortBy);
$smarty->assign_by_ref('sortOrder', $sortOrder);
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
$smarty->assign_by_ref('list', $list);
$smarty->assign('group', $group);
trace($smarty->_tpl_vars);
?>