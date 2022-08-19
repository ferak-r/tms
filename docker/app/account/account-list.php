<?php
//### fetch variable
$transportid= @$_REQUEST['transportid'];
$sortBy		= @$_COOKIE[$prefix."_sortby"];
$sortOrder	= @$_COOKIE[$prefix."_order"];

//### sort order
$sortOrder = (@$sortOrder == "asc") ? "ASC" : "DESC" ;

//### sort by
$sortBy = (!empty($sortBy)) ? $sortBy : 'accountingid';

/*if(!$user->group['admin'] || !$user->group['account&customs']){
	if($user->group['operation']){
		$where = " AND (xgroup = 'operation' OR xgroup = 'carrier')";
	}elseif($user->group['carrier']){
		$where = " AND xgroup = 'carrier'";
	}
}*/

//### paging
$pagingsql = "SELECT COUNT(*)
			  FROM xxaccounting
			  NATURAL LEFT JOIN xxuser_groupuser
			  NATURAL LEFT JOIN xxuser_group
			  WHERE xtransportid = '$transportid'";

$sql = "SELECT *, IF(xpay = 'Yes', 'Paid', 'Not Paid')As xstatus, IF(xaccounttype = 5, xchequetotal, xamount) AS xamount,
			COALESCE(CONCAT('<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'partyaccount\',\'', xpartyaccountid, '\', this);\">', xpartyaccount, '</a>'), xpartyaccountetc) AS xpartyaccount
		FROM xxaccounting
		NATURAL LEFT JOIN zzidentity
		WHERE xtransportid = '$transportid'
		ORDER BY x$sortBy $sortOrder";
		
$btn = array('edit','delete');
$col[] = array('{xpartyaccount}', '20%', 'partyaccount', 'partyaccount');
$col[] = array('{xaccounttype}', '30%', 'accounttype', 'accounttype');
$col[] = array('{xamount}', '40%', 'amount', 'amount');
$col[] = array('{xfor}', '40%', 'for', 'for');
$col[] = array('{xstatus}', '10%', 'status', 'status');
$rowsetfield = 'xaccountingid';

//### paging
$maxpage = $db->getone($pagingsql);
$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $config['page'];

//custom list
$list = $db->getAll($sql." limit $page, $config[page]");

//### row set
$rowset->reset($list, $rowsetfield, @$prefix, $sortBy, $sortOrder, "sortASC", "sortDESC", $btn, true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$smarty->assign('dataset', $rowset->renderDataset());

//get accountings status
$sql = "SELECT xaccountingfinished FROM xxtransport WHERE xtransportid = '$transportid'";
$accountingfinished = $db->getOne($sql);

//get received money - paid money
$sql = "SELECT IFNULL( xreceived, 0 ) - IFNULL( xpaid, 0 )
		FROM xxtransport
		NATURAL LEFT JOIN (
			SELECT xtransportid, sum( xamount ) AS xreceived
			FROM xxaccounting
			WHERE xpay = 'Yes' AND xaccounttype != 'Pay'
			GROUP BY xtransportid ) AS xxreceived
		NATURAL LEFT JOIN (
			SELECT xtransportid, sum( xamount ) AS xpaid
			FROM xxaccounting
			WHERE xpay = 'Yes' AND xaccounttype = 'Pay'
			GROUP BY xtransportid ) AS xxpaid
		WHERE xtransportid = '$transportid'";
$amount = $db->getOne($sql);

$tplModule = "list.tpl";
//###samarty
$smarty->assign_by_ref('sortBy', $sortBy);
$smarty->assign_by_ref('sortOrder', $sortOrder);
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
$smarty->assign_by_ref('list', $list);
$smarty->assign('transportid', $transportid);
$smarty->assign('accountingfinished', $accountingfinished);
$smarty->assign('amount', $amount);
$smarty->assign('hideSearchButton', 1);
trace($smarty->_tpl_vars);
?>