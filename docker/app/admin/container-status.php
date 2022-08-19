<?php
//###fetch information
$id = @$_REQUEST['frm_id'];
$popup = @intval($_REQUEST['popup']);
$tplModule = 'container-status.tpl';

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
								'xtruckstartdate'  	  => @$_POST["frm_truckstartdate{$val}"] ? $_POST["frm_truckstartdate{$val}"] : NULL,
								'xtruckfreetime'      => @$_POST["frm_truckfreetime{$val}"] ? $_POST["frm_truckfreetime{$val}"] : NULL,
								'xtruckrejectdate'    => @$_POST["frm_truckreturndate{$val}"] ? $_POST["frm_truckreturndate{$val}"] : NULL,
								'xshippingreached'    => !empty($_POST["frm_shippingreached{$val}"]),
								'xcustomerreached'    => !empty($_POST["frm_customerreached{$val}"]),
								'xtruckreached'    	  => !empty($_POST["frm_truckreached{$val}"])
								);
			$res = $db->autoExecute('xxtransportcontainer', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportcontainerid='{$val}'");					
		}
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=container-status&page=$page&frm_id=$id&popup=$popup");
		break;
	default:	
		$sql = "SELECT *, CONCAT('<a href=\'javascript:void(0)\' onclick=\"showDetail(\'operation\', \'transportcontainer\',', xtransportcontainerid, ', this);\">', xcontainernumber, '</a>') AS xprojectcontainer,
					 IF(xcustomerreached, IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime), xcustomerrejectdate) = 0, 'Without any lateness', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),xcustomerrejectdate)>0,CONCAT(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),xcustomerrejectdate), ' Days Earlear'), CONCAT(ABS(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),xcustomerrejectdate)), ' Days Late'))), IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime), NOW()) = 0, 'Must Return Today', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW())>0,CONCAT(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW()), ' Days Left'), CONCAT(ABS(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW())), ' Days Late')))) AS xcustomerstatus,
					 IF(xcustomerreached = 1, '#CAF9DA', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW()) = 0, '#F9CACA', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW())>0, '#F9F4CA', '#DEDEDE'))) AS xcustomercolor,
					 IF(xcustomerreached = 1, '4', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime),NOW()) = 0, '1', IF(DATEDIFF(ADDDATE(xcustomerstartdate, xcustomerfreetime), NOW())>0, '3', '2'))) AS xcustomerorder,
					 IF(xshippingreached, IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime), xshippingrejectdate) = 0, 'Without any lateness', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),xshippingrejectdate)>0,CONCAT(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),xshippingrejectdate), ' Days Earlear'), CONCAT(ABS(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),xshippingrejectdate)), ' Days Late'))), IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW()) = 0, 'Must Return Today', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW())>0,CONCAT(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW()), ' Days Left'), CONCAT(ABS(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW())), ' Days Late')))) AS xshippingstatus,
					 IF(xshippingreached = 1, '#CAF9DA', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW()) = 0, '#F9CACA', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW())>0, '#F9F4CA', '#DEDEDE'))) AS xshippingcolor,
					 IF(xshippingreached = 1, '4', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime),NOW()) = 0, '1', IF(DATEDIFF(ADDDATE(xshippingstartdate, xshippingfreetime), NOW())>0, '3', '2'))) AS xshippingorder,
					 IF(xtruckreached, IF(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime), xtruckrejectdate) = 0, 'Without any lateness', IF(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),xtruckrejectdate)>0,CONCAT(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),xtruckrejectdate), ' Days Earlear'), CONCAT(ABS(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),xtruckrejectdate)), ' Days Late'))), IF(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),NOW()) = 0, 'Must Return Today', IF(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),NOW())>0,CONCAT(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),NOW()), ' Days Left'), CONCAT(ABS(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),NOW())), ' Days Late')))) AS xtruckstatus,
					 IF(xtruckreached = 1, '#CAF9DA', IF(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),NOW()) = 0, '#F9CACA', IF(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),NOW())>0, '#F9F4CA', '#DEDEDE'))) AS xtruckcolor,
					 IF(xtruckreached = 1, '4', IF(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime),NOW()) = 0, '1', IF(DATEDIFF(ADDDATE(xtruckstartdate, xtruckfreetime), NOW())>0, '3', '2'))) AS xtruckorder								 
				FROM xxtransportcontainer
				LEFT JOIN zzcontainer USING ( xcontainerid )
				LEFT JOIN xxtransport ON ( xxtransport.xtransportid = xxtransportcontainer.xtransportid )
				WHERE xcarrytype='Container' AND xxtransport.xtransportid = '$id'
				ORDER BY xcustomerorder, xshippingorder";
		$container = $db->getAll($sql);
		
}

//###samarty
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