<?php
//###fetch information
$id = @$_REQUEST['frm_id'];
$popup = @intval($_REQUEST['popup']);
$tplModule = 'container-status-all.tpl';

$where = $qobject->makeWhere(@$zcond);

switch($cmd){
	 case 'update':
	 	$container = $_POST['frm_transportcontainerid'];
	 	foreach($container as $key=>$val){
			$fields_values = array( 
								'xshippingstartdate'  => @$_POST["frm_shippingstartdate{$val}"] ? $_POST["frm_shippingstartdate{$val}"] : NULL,
								'xshippingfreetime'   => @$_POST["frm_shippingfreetime{$val}"] ? $_POST["frm_shippingfreetime{$val}"] : NULL,
								'xshippingrejectdate' => @$_POST["frm_shippingreturndate{$val}"] ? $_POST["frm_shippingreturndate{$val}"] : NULL,
								'xcustomerstartdate'  => @$_POST["frm_customerstartdate{$val}"] ? $_POST["frm_customerstartdate{$val}"] : NULL,
								'xcustomerfreetime'   => @$_POST["frm_customerfreetime{$val}"] ? $_POST["frm_customerfreetime{$val}"] : NULL,
								'xcustomerrejectdate' => @$_POST["frm_customerreturndate{$val}"] ? $_POST["frm_customerreturndate{$val}"] : NULL,
								//'xreacheddate'		  => !empty($_POST["frm_reached{$val}"]) ? ($_POST["frm_reacheddate{$val}"] ? $_POST["frm_reacheddate{$val}"] : NULL) : NULL,
								'xshippingreached'    => !empty($_POST["frm_shippingreached{$val}"]),
								'xcustomerreached'    => !empty($_POST["frm_customerreached{$val}"]),
								);
			$res = $db->autoExecute('xxtransportcontainer', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportcontainerid='{$val}'");					
		}
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=container-status-all&page=$page&frm_id=$id&popup=$popup&query=$_GET[query]");
		break;
	default:
		if(@$_GET['reached'] == 'false'){
			$where .= " AND (xcustomerreached=0 OR xshippingreached=0)";
		}

		$pagingsql = "SELECT COUNT(*)
					  FROM xxtransportcontainer
					  LEFT JOIN zzcontainer USING ( xcontainerid )
					  LEFT JOIN xxtransport ON ( xxtransport.xtransportid = xxtransportcontainer.xtransportid )
					  WHERE xcarrytype='Container' AND xown='COC' AND  xxtransport.xtransportid IS NOT NULL $where";
		//### paging
		$maxpage = $db->getone($pagingsql);
		$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
		$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
		$page = ($curpage - 1) * $config['page'];

		
		$sql = "SELECT *, CONCAT('<a href=\'javascript:void(0)\' onclick=\"showDetail(\'operation\', \'transportcontainer\',', xtransportcontainerid, ', this);\">', xcontainernumber, '</a>', ' / <a href=\'javascript:void(0)\' onclick=\"showDetail(\'operation\', \'transport\',', xxtransport.xtransportid, ', this);\">', xtransportcode, '</a>') AS xprojectcontainer,
					 IF(xcustomerreached, IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime), xcustomerrejectdate) = 0, 'Without any lateness', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),xcustomerrejectdate)>0,CONCAT(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),xcustomerrejectdate), ' Days Earlear'), CONCAT(ABS(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),xcustomerrejectdate)), ' Days Late'))), IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime), NOW()) = 0, 'Must Return Today', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW())>0,CONCAT(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW()), ' Days Left'), CONCAT(ABS(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW())), ' Days Late')))) AS xcustomerstatus,
					 IF(xcustomerreached = 1, '#CAF9DA', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW()) = 0, '#F9CACA', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW())>0, '#F9F4CA', '#DEDEDE'))) AS xcustomercolor,
					 IF(xcustomerreached = 1, '4', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW()) = 0, '1', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime), NOW())>0, '3', '2'))) AS xcustomerorder,
					 IF(xshippingreached, IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime), xshippingrejectdate) = 0, 'Without any lateness', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),xshippingrejectdate)>0,CONCAT(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),xshippingrejectdate), ' Days Earlear'), CONCAT(ABS(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),xshippingrejectdate)), ' Days Late'))), IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW()) = 0, 'Must Return Today', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW())>0,CONCAT(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW()), ' Days Left'), CONCAT(ABS(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW())), ' Days Late')))) AS xshippingstatus,
					 IF(xshippingreached = 1, '#CAF9DA', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW()) = 0, '#F9CACA', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW())>0, '#F9F4CA', '#DEDEDE'))) AS xshippingcolor,
					 IF(xshippingreached = 1, '4', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW()) = 0, '1', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime), NOW())>0, '3', '2'))) AS xshippingorder								 
				FROM xxtransportcontainer
				LEFT JOIN zzcontainer USING ( xcontainerid )
				LEFT JOIN xxtransport ON ( xxtransport.xtransportid = xxtransportcontainer.xtransportid )
				WHERE xcarrytype='Container' AND xown='COC' AND xxtransport.xtransportid IS NOT NULL $where
				ORDER BY xcustomerorder, xshippingorder";
		$container = $db->getAll($sql." limit $page, $config[page]");
		
}

//###samarty
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('containerlist', $container);
$smarty->assign_by_ref('id', $id);
$smarty->assign('formData', @$formData);
$smarty->assign('currentdate', date('Y-m-d'));
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>