<?php
//### fetch variable
$prefix		= $section."/".$module;
$sortBy		= @$_COOKIE[$prefix."_sortby"];
$sortOrder	= @$_COOKIE[$prefix."_order"];
$where 	    = $qobject->makeWhere(@$zcond);

//### sort
$sortBy = (!empty($sortBy)) ? $sortBy : 'xcontainerlendid';
$sortOrder = (@$sortOrder == "asc") ? "ASC" : "DESC" ;

//### paging
$sql = "SELECT COUNT(*)
		FROM xxcontainerlend
		NATURAL LEFT JOIN (
			SELECT xcontainerlendid, GROUP_CONCAT(xcontainernumber) AS xcontainerno
			FROM xxcontainerlendcontainer
			NATURAL LEFT JOIN xxcontainer
			GROUP BY xcontainerlendid) AS xxtemp
		WHERE 1 $where";
$maxpage = $db->_getone($sql);
$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $config['page'];

$sql = "SELECT *, GROUP_CONCAT(CONCAT('<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'container\',', xcontainerid, ', this);\">', xcontainernumber, '</a>') SEPARATOR ', ')AS xcontainer,
			COALESCE(CONCAT('<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'partyaccount\',\'', xpartyaccountid, '\', this);\">', xpartyaccount, '</a>'), xpartyaccountetc) AS xpartyaccount,
			IF(xreturned = 'Yes', CONCAT('Yes <br>', xreturndate), 'No') AS xreturned
		FROM xxcontainerlend
		NATURAL LEFT JOIN (
			SELECT xcontainerlendid, GROUP_CONCAT(xcontainernumber) AS xcontainerno
			FROM xxcontainerlendcontainer
			NATURAL LEFT JOIN xxcontainer
			GROUP BY xcontainerlendid ) AS xxtemp
		NATURAL LEFT JOIN xxcontainerlendcontainer
		NATURAL LEFT JOIN xxcontainer
		LEFT JOIN (zzidentity) USING(xidentityid)
		WHERE 1 $where
		GROUP BY xcontainerlendid
		ORDER BY $sortBy $sortOrder";
//container list
$list = $db->_getAll($sql." limit $page, $config[page]");

$btn = array('edit','delete');
$col[] = array('{xcontainer}', '30%', 'container', 'container');
$col[] = array('{xpartyaccount}', '20%', 'partyaccount', 'partyaccount');
$col[] = array('{xlenddate}', '20%', 'lenddate', 'lenddate');
$col[] = array('{xfreetime}', '20%', 'freetime', 'freetime');
$col[] = array('{xreturned}', '20%', 'returned', 'returned');

//### row set
$rowset->reset($list, 'xcontainerlendid', @$prefix, $sortBy, $sortOrder, "sortASC", "sortDESC", $btn, true);
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