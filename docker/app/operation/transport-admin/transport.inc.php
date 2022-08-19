<?php
$extModule[] = 'transport-cargo-ext.tpl';
$extModule[] = 'transport-document-ext.tpl';
if($id){
	//select documents related to this transportation
	$sql = "SELECT xxtd1.xtransportdocumentid, xxtd1.xdocumentnumber AS xdocumentnumber, xxtd2.xdocumentnumber AS xolddocumentnumber, xdocument, xxtd1.xdocumentdate
			FROM xxtransportdocument AS xxtd1
			LEFT JOIN (
				SELECT * 
				FROM xxtransportdocument
			) AS xxtd2 ON ( xxtd1.xtransportdocumentid = xxtd2.xoldtransportdocumentid ) 
			LEFT JOIN xxdocument ON ( xxtd1.xdocumentid = xxdocument.xdocumentid )
			WHERE xxtd1.xtransportid = '$id'
			ORDER BY xxtd1.xdocumentid, xxtd1.xdocumentdate";
	$documentlist = $db->getAll($sql);
	$smarty->assign_by_ref('documentlist', $documentlist);
	
	//select cargoes related to this transportation
	$sql = "SELECT xtransportcontainerid, GROUP_CONCAT(xcommodity SEPARATOR ', ')AS xcommodity, xcarrytype, xcontainernumber, xtransportcargoid
			FROM xxtransportcontainer
			NATURAL LEFT JOIN xxtransportcargo
			NATURAL LEFT JOIN zzcontainer
			WHERE xtransportid = '$id'
			GROUP BY xtransportcontainerid";
			 
	$cargolist = $db->_getAll($sql);
	$smarty->assign_by_ref('cargolist', $cargolist);
}
$msg['title2']['transport-admin'] = 'Transport Specifications';
if($cmd == 'add' or $cmd == 'update'){
	//### insert to db
	$fields_values = array( 
						'xtransportcode' 	=> $_POST['frm_transportcode'],
						'xfromcityid'		=> $_POST['frm_fromcityid'],
						'xtocityid'	 		=> $_POST['frm_tocityid'],
						'xorigincityid'		=> $_POST['frm_origincityid'],
						'xdestinationcityid'=> $_POST['frm_destinationcityid'],
						'xetadestination'	=> $_POST['frm_etadestination'] ? $_POST['frm_etadestination'] : NULL,
						'xviaportid'		=> $_POST['frm_viaportid'],
						'xcarrierid'		=> $_POST['frm_carrierid'],
						'xarrivalportid'	=> $_POST['frm_arrivalportid'],
						'xetaarrivalport'	=> $_POST['frm_etaarrivalport'] ? $_POST['frm_etaarrivalport'] : NULL,
						'xtransporttype'	=> $_POST['frm_transporttype'],
						'xtransportmethod'	=> implode(',', $_POST['frm_transportmethod']),
						'xsenderofficeid'	=> $_POST['frm_senderofficeid'],
						'xreceiverofficeid'	=> $_POST['frm_receiverofficeid'],
						'xshipperid'		=> $_POST['frm_shipperid'],
						'xconsigneeid'		=> $_POST['frm_consigneeid'],
						'xetl'				=> $_POST['frm_etl'] ? $_POST['frm_etl'] : NULL,
						'xqt'				=> $_POST['frm_qt'],
						'xbaseprice'		=> $_POST['frm_baseprice'],
						'xep'				=> $_POST['frm_ep'],
						'xtransportcomment'	=> $_POST['frm_transportcomment'],
						'xarchive'			=> intval($_POST['frm_archive']),
						'xstartdate'		=> $_POST['frm_startdate'],
						'xenddate'			=> $_POST['frm_enddate']
						);
	if(!$user->group['admin']){
		if(!$user->group['document']){//operation
			unset($fields_values['xtransportcode'], $fields_values['xfromcityid'], $fields_values['xarrivalportid'],
				  $fields_values['xetaarrivalport'], $fields_values['xorigincityid'], $fields_values['xshipperid'],
				  $fields_values['xconsigneeid'], $fields_values['xsenderofficeid'], $fields_values['xreceiverofficeid']);
		}

		if(!$user->group['operation']){//document
			unset($fields_values['xetl'], $fields_values['xetadestination']);
		}
	}
}
switch($cmd){
	case 'add':
		$res = $db->autoExecute('xxtransport', $fields_values, DB_AUTOQUERY_INSERT);
		$fields_values['xtransportid'] = $db->getOne ("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}else{
			$statuscolorid = $_POST['frm_statuscolorid'];
			foreach($statuscolorid as $val){
				$sql = "INSERT INTO xxtransportstatuscolor(xtransportid, xstatuscolorid) VALUES($fields_values[xtransportid], $val)";
				$db->query($sql);
			}
		}
		if(isset($_GET['newdoc'])){
			redirect("index.php?section=$section&module=transport-admin&page=$page&step=transport&frm_id=$fields_values[xtransportid]&popupwin=document");
		}elseif(isset($_GET['newcargo'])){
			redirect("index.php?section=$section&module=transport-admin&page=$page&step=transport&frm_id=$fields_values[xtransportid]&popupwin=cargo");					
		}else{
			redirect("index.php?section=$section&module=transport-list&page=$page&step=transport");
		}
		break;
	 case 'update':				
		$res = $db->autoExecute('xxtransport', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportid='$id'");

		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}else{
			$sql = "DELETE FROM xxtransportstatuscolor WHERE xtransportid='$id'";
			$db->query($sql);
			$statuscolorid = $_POST['frm_statuscolorid'];
			foreach($statuscolorid as $val){
				$sql = "INSERT INTO xxtransportstatuscolor(xtransportid, xstatuscolorid) VALUES($id, $val)";
				$db->query($sql);
			}

		}
		
		if(isset($_GET['newdoc'])){
			redirect("index.php?section=$section&module=transport-admin&page=$page&step=transport&frm_id=$id&popupwin=document&archive=$archive");
		}elseif(isset($_GET['newcargo'])){
			redirect("index.php?section=$section&module=transport-admin&page=$page&step=transport&frm_id=$id&popupwin=cargo&archive=$archive");					
		}else{
			redirect("index.php?section=$section&module=transport-admin&page=$page&step=transport&frm_id=$id&archive=$archive");
		}
		
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxtransport
				WHERE xtransportid IN ($id)";
		$res = $db->query($sql);		
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		} else {
			//delete related records
			$sql = "DELETE
					FROM xxtransportdocument
					WHERE xtransportid IN ($id)";
			$res = $db->query($sql);
			$sql = "DELETE
					FROM xxtransportcomment
					WHERE xtransportid IN ($id)";
			$res = $db->query($sql);
			$sql = "DELETE
					FROM xxtransportcontainer
					WHERE xtransportcargoid IN (SELECT xtransportcargoid FROM xxtransportcargo WHERE xtransportid IN ($id))";
			$res = $db->query($sql);
			$sql = "DELETE
					FROM xxtransportcargo
					WHERE xtransportid IN ($id)";
			$res = $db->query($sql);
		}
		redirect("index.php?section=$section&module=transport-list&step=$step&archive=$archive");
		break;
	default:
		$transporttype 	 = $db->fetchEnum('xxtransport', 'xtransporttype');
		$transportmethod = $db->fetchSet('xxtransport', 'xtransportmethod');
		$customer = $db->getList('xxcustomer', 'concat(IFNULL(xname, " "), " ", IFNULL(xfamily, " "))', '', 'xname');
		$office = $db->getList('xxoffice', 'xoffice', '', 'xoffice');
		$carrier = $db->getList('xxcarrier', 'xcarrier', '', 'xcarrier');
		$port = $db->getList('xxport', '', '', 'xport');
		$city = $db->getList('xxcity', '', '', 'xcity');

		$sql = "SELECT *
				FROM xxstatuscolor
				NATURAL LEFT JOIN xxcolor";
		$color = $db->getAll($sql);
	
		if($id){
			$sql = "SELECT *, xtransporttype+0 AS xtransporttype, GROUP_CONCAT(CONCAT(',', xstatuscolorid, ',')) AS xstatuscolorid
					FROM xxtransport
					NATURAL LEFT JOIN xxtransportstatuscolor
					WHERE xtransportid = '$id'
					GROUP BY xtransportid";
			$list = $db->getRow($sql);
			
			if($list){
				foreach($list as $key => $val){
					$default['frm_'.substr($key, 1, strlen($key))] = $val;
				}
			}
		}
	
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=transport-admin&page=$page&step=transport&cmd=$cmd&popup=$popup&archive=$archive");	

		$form->addElement('text', 'frm_transportcode', T_('Project No'), "dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_transportcode'] ) ? "disabled" : NULL));
		
		$from[] =& HTML_QuickForm::createElement('static', NULL, NULL, '<span id="frm_fromcityid_span">');
		$from[] =& HTML_QuickForm::createElement('select', 'frm_fromcityid', NULL, $city, "class='cl_city' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_fromcityid'] ) ? "disabled" : NULL));
		$from[] =& HTML_QuickForm::createElement('static', NULL, NULL, '</span>');
		$from[] =& HTML_QuickForm::createElement('text', 'frm_fromcity_new', NULL, "id='frm_fromcityid_new' dir='ltr' style='display: none'");
		$from[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New City', 'id="frm_fromcityid_ok" onclick="swapLinkDisplay(form1.frm_fromcityid, \'city\', 1)"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_fromcityid'] ) ? "style='display: none'" : NULL));
		$from[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img src=\'../images/icons/16x16/delete.png\' border=\'0px\'">', 'id="frm_fromcityid_cancle" style="display: none" onclick="swapLinkDisplay(form1.frm_fromcityid, \'city\', 0)"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_fromcityid'] ) ? "style='display: none'" : NULL));
		$form->addGroup($from, NULL, T_('From'));
		
		$to[] =& HTML_QuickForm::createElement('static', NULL, NULL, '<span id="frm_tocityid_span">');
		$to[] =& HTML_QuickForm::createElement('select', 'frm_tocityid', NULL, $city, "class='cl_city' dir='ltr'");
		$to[] =& HTML_QuickForm::createElement('static', NULL, NULL, '</span>');
		$to[] =& HTML_QuickForm::createElement('text', 'frm_tocity_new', NULL, "id='frm_tocityid_new' dir='ltr' style='display: none'");
		$to[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New City', 'id="frm_tocityid_ok" onclick="swapLinkDisplay(form1.frm_tocityid, \'city\', 1)"');				
		$to[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img src=\'../images/icons/16x16/delete.png\' border=\'0px\'>', 'id="frm_tocityid_cancle" style="display: none" onclick="swapLinkDisplay(form1.frm_tocityid, \'city\', 0)"');
		$form->addGroup($to, NULL, T_('To'));
		
		$via[] =& HTML_QuickForm::createElement('static', NULL, NULL, '<span id="frm_viaportid_span">');
		$via[] =& HTML_QuickForm::createElement('select', 'frm_viaportid', NULL, $port, "class='cl_port' dir='ltr'");
		$via[] =& HTML_QuickForm::createElement('static', NULL, NULL, '</span>');
		$via[] =& HTML_QuickForm::createElement('text', 'frm_viaport_new', NULL, "id='frm_viaportid_new' dir='ltr' style='display: none'");
		$via[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New Port', 'id="frm_viaportid_ok" onclick="swapLinkDisplay(form1.frm_viaportid, \'port\', 1)"');				
		$via[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img src=\'../images/icons/16x16/delete.png\' border=\'0px\'>', 'id="frm_viaportid_cancle" style="display: none" onclick="swapLinkDisplay(form1.frm_viaportid, \'port\', 0)"');
		$form->addGroup($via, NULL, T_('Exit Border'));
		
		$cr[] =& HTML_QuickForm::createElement('select', 'frm_carrierid', NULL, $carrier, "id='frm_carrierid' dir='ltr'");
		$cr[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New Carrier', 'onclick="javascript:openNewWindow(\'index.php?section=admin&module=carrier-admin&popup=1&object=frm_carrierid\')"');
		$form->addGroup($cr, NULL, T_('Shipping Line/Carrier'));
	
	
		$form->addElement('select', 'frm_transporttype', T_('Transport Type'), $transporttype, 'dir="ltr" onchange="form1.frm_arrivalportid.disabled=false;form1.frm_etaarrivalport.disabled=false;document.getElementById(\'frm_etaarrivalport_cal\').style.visibility=\'visible\';form1.frm_etl.disabled=false;document.getElementById(\'frm_etl_cal\').style.visibility=\'visible\'; document.getElementById(\'frm_arrivalportid_ok\').style.visibility=\'visible\';if(this.value == 3){form1.frm_arrivalportid.disabled=\'disabled\';form1.frm_etaarrivalport.disabled=\'disabled\';document.getElementById(\'frm_etaarrivalport_cal\').style.visibility=\'hidden\'; document.getElementById(\'frm_arrivalportid_ok\').style.visibility=\'hidden\';}else if(this.value == 1){form1.frm_etl.disabled=\'disabled\';document.getElementById(\'frm_etl_cal\').style.visibility=\'hidden\';}}"');
		
		if(@$default['frm_transporttype'] == 3){ //export
			$arrivalport[] =& HTML_QuickForm::createElement('static', NULL, NULL, '<span id="frm_arrivalportid_span">');
			$arrivalport[] =& HTML_QuickForm::createElement('select', 'frm_arrivalportid', NULL, $port, "class='cl_port' disabled='disabled' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_arrivalportid'] ) ? "disabled" : NULL));
			$arrivalport[] =& HTML_QuickForm::createElement('static', NULL, NULL, '</span>');
			$arrivalport[] =& HTML_QuickForm::createElement('text', 'frm_arrivalport_new', NULL, "id='frm_arrivalportid_new' dir='ltr' style='display: none'");
			$arrivalport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New Port', 'id="frm_arrivalportid_ok" onclick="swapLinkDisplay(form1.frm_arrivalportid, \'port\', 1)"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_arrivalportid'] ) ? "style='display: none'" : NULL));				
			$arrivalport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img src=\'../images/icons/16x16/delete.png\' border=\'0px\'">', 'id="frm_arrivalportid_cancle" style="display: none" onclick="swapLinkDisplay(form1.frm_arrivalportid, \'port\', 0)"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_arrivalportid'] ) ? "style='display: none'" : NULL));
			$form->addGroup($arrivalport, NULL, T_('Arrival Port/Border'));
			
			$etaarrivalport[] =& HTML_QuickForm::createElement('text', 'frm_etaarrivalport', NULL, "id='frm_etaarrivalport' dir='ltr' disabled='disabled'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etaarrivalport'] ) ? "disabled" : NULL));
			$etaarrivalport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'id="frm_etaarrivalport_cal" onclick="return showCalendar(\'frm_etaarrivalport\', \'y-mm-dd\');" style="visibility:hidden"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etaarrivalport'] ) ? "style='display: none'" : NULL));
			$form->addGroup($etaarrivalport, NULL, T_('ETA Arrival Port/Border'));		
		}else{
			$arrivalport[] =& HTML_QuickForm::createElement('static', NULL, NULL, '<span id="frm_arrivalportid_span">');
			$arrivalport[] =& HTML_QuickForm::createElement('select', 'frm_arrivalportid', T_('Arrival Port/Border'), $port, "class='cl_port' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_arrivalportid'] ) ? "disabled" : NULL));
			$arrivalport[] =& HTML_QuickForm::createElement('static', NULL, NULL, '</span>');
			$arrivalport[] =& HTML_QuickForm::createElement('text', 'frm_arrivalport_new', NULL, "id='frm_arrivalportid_new' dir='ltr' style='display: none'");
			$arrivalport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New Port', 'id="frm_arrivalportid_ok" onclick="swapLinkDisplay(form1.frm_arrivalportid, \'port\', 1)"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_arrivalportid'] ) ? "style='display: none'" : NULL));
			$arrivalport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img src=\'../images/icons/16x16/delete.png\' border=\'0px\'">', 'id="frm_arrivalportid_cancle" style="display: none" onclick="swapLinkDisplay(form1.frm_arrivalportid, \'port\', 0)"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_arrivalportid'] ) ? "style='display: none'" : NULL));
			$form->addGroup($arrivalport, NULL, T_('Arrival Port/Border'));

			$etaarrivalport[] =& HTML_QuickForm::createElement('text', 'frm_etaarrivalport', NULL, "id='frm_etaarrivalport' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etaarrivalport'] ) ? "disabled" : NULL));
			$etaarrivalport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'id=\'frm_etaarrivalport_cal\' onclick="return showCalendar(\'frm_etaarrivalport\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etaarrivalport'] ) ? "style='display: none'" : NULL));
			$form->addGroup($etaarrivalport, NULL, T_('Receiving Arrival Notice'));	
		}
		if(!$id || $default['frm_transporttype'] == 1){ //transit
			$etl[] =& HTML_QuickForm::createElement('text', 'frm_etl', NULL, "id='frm_etl' dir='ltr' disabled='disable'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etl'] ) ? "disabled" : NULL));
			$etl[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'id=\'frm_etl_cal\' onclick="return showCalendar(\'frm_etl\', \'y-mm-dd\');" style="visibility: hidden"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etl'] ) ? "style='display: none'" : NULL));
			$form->addGroup($etl, NULL, T_('ETL'));
		}else{
			$etl[] =& HTML_QuickForm::createElement('text', 'frm_etl', NULL, "id='frm_etl' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etl'] ) ? "disabled" : NULL));
			$etl[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'id=\'frm_etl_cal\' onclick="return showCalendar(\'frm_etl\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etl'] ) ? "style='display: none'" : NULL));
			$form->addGroup($etl, NULL, T_('ETL'));
		}
		
		$origin[] =& HTML_QuickForm::createElement('static', NULL, NULL, '<span id="frm_origincityid_span">');	
		$origin[] =& HTML_QuickForm::createElement('select', 'frm_origincityid', NULL, $city, "class='cl_city' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_origincityid'] ) ? "disabled" : NULL));
		$origin[] =& HTML_QuickForm::createElement('static', NULL, NULL, '</span>');
		$origin[] =& HTML_QuickForm::createElement('text', 'frm_origincity_new', NULL, "id='frm_origincityid_new' dir='ltr' style='display: none'");
		$origin[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New City', 'id="frm_origincityid_ok" onclick="swapLinkDisplay(form1.frm_origincityid, \'city\', 1)"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_origincityid'] ) ? "style='display: none'" : NULL));							
		$origin[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img src=\'../images/icons/16x16/delete.png\' border=\'0px\'">', 'id="frm_origincityid_cancle" style="display: none" onclick="swapLinkDisplay(form1.frm_origincityid, \'city\', 0)"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_origincityid'] ) ? "style='display: none'" : NULL));
		$form->addGroup($origin, NULL, T_('Origin'));

		$des[] =& HTML_QuickForm::createElement('static', NULL, NULL, '<span id="frm_destinationcityid_span">');	
		$des[] =& HTML_QuickForm::createElement('select', 'frm_destinationcityid', NULL, $city, "class='cl_city' dir='ltr'");
		$des[] =& HTML_QuickForm::createElement('static', NULL, NULL, '</span>');
		$des[] =& HTML_QuickForm::createElement('text', 'frm_destinationcity_new', NULL, "id='frm_destinationcityid_new' dir='ltr' style='display: none'");
		$des[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New City', 'id="frm_destinationcityid_ok" onclick="swapLinkDisplay(form1.frm_destinationcityid, \'city\', 1)"');
		$des[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img src=\'../images/icons/16x16/delete.png\' border=\'0px\'">', 'id="frm_destinationcityid_cancle" style="display: none" onclick="swapLinkDisplay(form1.frm_destinationcityid, \'city\', 0)"');
		$form->addGroup($des, NULL, T_('Destination'));
		
		$etades[] =& HTML_QuickForm::createElement('text', 'frm_etadestination', NULL, "id='frm_etadestination' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etadestination'] ) ? "disabled" : NULL));
		$etades[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_etadestination\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etadestination'] ) ? "style='display: none'" : NULL));
		$form->addGroup($etades, NULL, T_('ATA Destination'));	
		$form->addElement('select', 'frm_transportmethod', T_('Kind of Transport'), $transportmethod, "multiple dir='ltr'");
		
		$shipper[] =& HTML_QuickForm::createElement('select', 'frm_shipperid', NULL, $customer, "id='frm_shipperid' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_shipperid'] ) ? "disabled" : NULL));
		$shipper[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New Shipper', 'onclick="javascript:openNewWindow(\'index.php?section=admin&module=customer-admin&popup=1&object=frm_shipperid\')"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_shipperid'] ) ? "style='display: none'" : NULL));
		$form->addGroup($shipper, NULL, T_('Shipper'));
		
		$consignee[] =& HTML_QuickForm::createElement('select', 'frm_consigneeid', NULL, $customer, "id='frm_consigneeid' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_consigneeid'] ) ? "disabled" : NULL));
		$consignee[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New Consignee', 'onclick="javascript:openNewWindow(\'index.php?section=admin&module=customer-admin&popup=1&object=frm_consigneeid\')"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_consigneeid'] ) ? "style='display: none'" : NULL));
		$form->addGroup($consignee, NULL, T_('Consignee'));
		
		$sender[] =& HTML_QuickForm::createElement('select', 'frm_senderofficeid', NULL, $office, "id='frm_senderofficeid' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_senderofficeid'] ) ? "disabled" : NULL));
		$sender[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New Office', 'onclick="javascript:openNewWindow(\'index.php?section=admin&module=office-admin&popup=1&object=frm_senderofficeid\')"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_senderofficeid'] ) ? "style='display: none'" : NULL));
		$form->addGroup($sender, NULL, T_('Sender Office'));
					
		$receiver[] =& HTML_QuickForm::createElement('select', 'frm_receiverofficeid', NULL, $office, "id='frm_receiverofficeid' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_receiverofficeid'] ) ? "disabled" : NULL));
		$receiver[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'New Office', 'onclick="javascript:openNewWindow(\'index.php?section=admin&module=office-admin&popup=1&object=frm_receiverofficeid\')"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_receiverofficeid'] ) ? "style='display: none'" : NULL));
		$form->addGroup($receiver, NULL, T_('Receiver Office'));			

		$qt[] =& HTML_QuickForm::createElement('text', 'frm_qt');
		$qt[] =& HTML_QuickForm::createElement('static', NULL, NULL, '&nbsp;&nbsp;Base Price:');
		$qt[] =& HTML_QuickForm::createElement('text', 'frm_baseprice', NULL, 'style="width: 120px"');
		$form->addGroup($qt, NULL, T_('QT.'));			
		
		$form->addElement('text', 'frm_ep', T_('EP.'), "dir='ltr'");
		$form->addElement('textarea', 'frm_transportcomment', T_('Comment'), "dir='ltr' style='width: 300px; height: 100px'");
		
		$startdate[] =& HTML_QuickForm::createElement('text', 'frm_startdate', NULL, "id='frm_startdate' dir='ltr'");
		$startdate[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_startdate\', \'y-mm-dd\');"');
		$form->addGroup($startdate, NULL, T_("Project's Start Date"));	


		$enddate[] =& HTML_QuickForm::createElement('text', 'frm_enddate', NULL, "id='frm_enddate' dir='ltr'");
		$enddate[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_enddate\', \'y-mm-dd\');"');
		$form->addGroup($enddate, NULL, T_("Project's End Date"));	
		
		
		$colorbar[] =& HTML_QuickForm::createElement("static", NULL, NULL, "<table><tr>");
		foreach($color as $key=>$val){
			$colorbar[] =& HTML_QuickForm::createElement("static", NULL, NULL, 
				"<td style='background-color: $val[xcolornumber];' title='$val[xstatus]'>
				<input type='checkbox' style='width: 20px' name='frm_statuscolorid[]' value='$val[xstatuscolorid]'".
				(strpos($default['frm_statuscolorid'], ",$val[xstatuscolorid],") !== false ? "checked=checked" : "" )."></td>");
		}
		$colorbar[] =& HTML_QuickForm::createElement("static", NULL, NULL, "</tr></table>");
		$form->addGroup($colorbar, NULL, T_('Status'));
		
		if(@$user->group['admin'] || @$user->group['document']){
			if(@$default['frm_documentationfinished'] == 1){
				$value = "Documentation Closed";
				$class = "btn-finished";
			}else{
				$value = "Documentation Not Closed";
				$class = "btn-notfinished";
			}
			
			$form->addElement("static", NULL, NULL, "<span  id='finished_div' style='margin: 4px; width: 16px;'></span><input type='button' id='documentation_finished' value='$value' class='$class' onclick='new ajax(\"index.php?section=operation&module=transport-admin&step=finished&cmd=documentation&transportid={$id}\", {update: \"finished_div\", evalScripts: true}).request();' />");
		}



		$form->addElement('checkbox', 'frm_archive', T_('Archive'), NULL, "style='width:20px'");
		$form->setDefaults(@$default);
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();		
		
		$smarty->assign('backurl', "index.php?section=$section&module=transport-list&step=$step&page=$page&archive=$archive");
}
?>