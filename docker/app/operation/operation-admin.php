<?php
//###fetch information
$id = @$_REQUEST['frm_id'];
$transportid = @$_REQUEST['frm_id'];
$popup = @intval($_REQUEST['popup']);
$tplModule = "admin.tpl";
$extModule[] = 'transport-path-ext.tpl';
$extModule[] = 'cargo-document-ext.tpl';

//select title2
$sql = "SELECT xtransportcode
		FROM xxtransport
		WHERE xtransportid = '$id'";
$title2 = 'Project No: '.$db->getOne($sql);

$sql = "SELECT *
		FROM xxtransportpath
		NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom
		NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto
		WHERE xtransportid = '$id'";
$pathlist = $db->_getAll($sql);

$sql = "SELECT *, CONCAT(xfrom, '/', xto)AS xpath,
		CONCAT(xdocument2, '(', xdocumentno, ')') AS xdocument2,
		CONCAT(xcarrier, '(', xequipmentcat, ':', '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'equipment\',', xequipmentid, ', this);\">', IF(xequipmentcat = 'VSL', xequipment, xequipmentno), '</a>', ')')AS xcarrier
		FROM xxloadingdocument
		LEFT JOIN xxdocument2 USING(xdocument2id)
		LEFT JOIN xxloading USING(xloadingid)
		LEFT JOIN xxtransportpath ON(xxloading.xtransportpathid = xxtransportpath.xtransportpathid OR xxloadingdocument.xdocumenttransportpathid = xxtransportpath.xtransportpathid)
		LEFT JOIN xxequipment USING(xequipmentid)
		LEFT JOIN xxcarrier USING(xcarrierid)
		NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom
		NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto
		WHERE xtransportid = '$id'";
$documentlist = $db->getAll($sql);

switch($cmd){
	 case 'update':
		$fields_values = array( 
							'xetaarrivalport' 	=> $_POST['frm_etaarrivalport'] ? $_POST['frm_etaarrivalport'] : NULL,
							'xataarrivalport' 	=> $_POST['frm_ataarrivalport'] ? $_POST['frm_ataarrivalport'] : NULL,
							'xrlz' 				=> $_POST['frm_rlz'] ? $_POST['frm_rlz'] : NULL,
							'xcustoms' 			=> $_POST['frm_customs'] ? $_POST['frm_customs'] : NULL,
							'xloading' 			=> $_POST['frm_loading'] ? $_POST['frm_loading'] : NULL,
							'xpenalty' 			=> $_POST['frm_penalty'],
							'xatdarrivalport' 	=> $_POST['frm_atdarrivalport'] ? $_POST['frm_atdarrivalport'] : NULL,
							'xetaexitport' 		=> $_POST['frm_etaexitport'] ? $_POST['frm_etaexitport'] : NULL,
							'xatdexitport' 		=> $_POST['frm_atdexitport'] ? $_POST['frm_atdexitport'] : NULL,
							'xetadestination' 	=> $_POST['frm_etadestination'] ? $_POST['frm_etadestination'] : NULL,
							'xatddestination' 	=> $_POST['frm_atddestination'] ? $_POST['frm_atddestination'] : NULL,
							'xoperationcomment' => $_POST['frm_operationcomment'],
							'xlaststatus' 		=> $_POST['frm_laststatus']
							);
		if(!$user->group['admin']){
			if($user->group['document'] && (!$user->group['operation'] || !$user->group['carrier'])){
				unset($fields_values['xloading'], $fields_values['xpenalty'], $fields_values['xetaexitport'], $fields_values['xatdexitport']);
			}
			if(!$user->group['operation']){
				unset($fields_values['xcustoms'], $fields_values['xetadestination'], $fields_values['xatddestination']);
			}
			if(!$user->group['document']){
				unset($fields_values['xetaarrivalport'], $fields_values['xataarrivalport'], $fields_values['xdo'], $fields_values['xrlz']);
			}		
		}
		$res = $db->autoExecute('xxtransport', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=operation-admin&page=$page&frm_id=$id");
		break;
	default:
		$penalty = $db->fetchEnum('xxtransport', 'xpenalty');
		$sql = "SELECT *, xpenalty+0 AS xpenalty
				FROM xxtransport
				WHERE xtransportid = '$id'";
		$list = $db->getRow($sql);
		if($list){
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
		}
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=operation-admin&page=$page&cmd=$cmd&popup=$popup");

		$etaarrivalport[] =& HTML_QuickForm::createElement('text', 'frm_etaarrivalport', NULL, "id='frm_etaarrivalport' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etaarrivalport'] ) ? "disabled" : NULL));	
		$etaarrivalport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_etaarrivalport\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etaarrivalport'] ) ? "style='display: none'" : NULL));		
		$form->addGroup($etaarrivalport, NULL, T_('Receiving Arrival Notice'));
		
		$ataarrivalport[] =& HTML_QuickForm::createElement('text', 'frm_ataarrivalport', NULL, "id='frm_ataarrivalport' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_ataarrivalport'] ) ? "disabled" : NULL));
		$ataarrivalport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_ataarrivalport\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_ataarrivalport'] ) ? "style='display: none'" : NULL));
		$form->addGroup($ataarrivalport, NULL, T_('ATA Arrival Port/Border'));

/*		$do[] =& HTML_QuickForm::createElement('text', 'frm_do', NULL, "id='frm_do' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_do'] ) ? "disabled" : NULL));
		$do[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_do\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_do'] ) ? "style='display: none'" : NULL));
		$form->addGroup($do, NULL, T_('D/O'));*/
		$rlz[] =& HTML_QuickForm::createElement('text', 'frm_rlz', NULL, "id='frm_rlz' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_rlz'] ) ? "disabled" : NULL));
		$rlz[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_rlz\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_rlz'] ) ? "style='display: none'" : NULL));
		$form->addGroup($rlz, NULL, T_('Rlz'));

		$customs[] =& HTML_QuickForm::createElement('text', 'frm_customs', NULL, "id='frm_customs' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_customs'] ) ? "disabled" : NULL));
		$customs[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_customs\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_customs'] ) ? "style='display: none'" : NULL));
		$form->addGroup($customs, NULL, T_('Customs Clearance'));

		$loading[] =& HTML_QuickForm::createElement('text', 'frm_loading', NULL, "id='frm_loading' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_loading'] ) ? "disabled" : NULL));
		$loading[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_loading\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_loading'] ) ? "style='display: none'" : NULL));
		$form->addGroup($loading, NULL, T_('Loading'));

		$form->addElement('select', 'frm_penalty', T_('Penalty'), $penalty, "dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_penalty'] ) ? "disabled" : NULL));
		
		$atdarrivalport[] =& HTML_QuickForm::createElement('text', 'frm_atdarrivalport', NULL, "id='frm_atdarrivalport' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_atdarrivalport'] ) ? "disabled" : NULL));
		$atdarrivalport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_atdarrivalport\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_atdarrivalport'] ) ? "style='display: none'" : NULL));
		$form->addGroup($atdarrivalport, NULL, T_('ATD From Arrival Port/Border'));

		$etaexitport[] =& HTML_QuickForm::createElement('text', 'frm_etaexitport', NULL, "id='frm_etaexitport' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etaexitport'] ) ? "disabled" : NULL));
		$etaexitport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_etaexitport\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etaexitport'] ) ? "style='display: none'" : NULL));
		$form->addGroup($etaexitport, NULL, T_('ATA Exit Port/Border'));

		$atdexitport[] =& HTML_QuickForm::createElement('text', 'frm_atdexitport', NULL, "id='frm_atdexitport' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_atdexitport'] ) ? "disabled" : NULL));
		$atdexitport[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_atdexitport\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_atdexitport'] ) ? "style='display: none'" : NULL));
		$form->addGroup($atdexitport, NULL, T_('ATD From Exit Port/Border'));

		$etades[] =& HTML_QuickForm::createElement('text', 'frm_etadestination', NULL, "id='frm_etadestination' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etadestination'] ) ? "disabled" : NULL));
		$etades[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_etadestination\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_etadestination'] ) ? "style='display: none'" : NULL));
		$form->addGroup($etades, NULL, T_('ATA Final Destination'));

		$atddes[] =& HTML_QuickForm::createElement('text', 'frm_atddestination', NULL, "id='frm_atddestination' dir='ltr'".(!array_diff(array_keys($user->group), $userconfig[$module]['frm_atddestination'] ) ? "disabled" : NULL));
		$atddes[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_atddestination\', \'y-mm-dd\');"'.(!array_diff(array_keys($user->group), $userconfig[$module]['frm_atddestination'] ) ? "style='display: none'" : NULL));
		$form->addGroup($atddes, NULL, T_('ATD Final Destination'));

		$form->addElement('textarea', 'frm_operationcomment', T_('Note'), "dir='ltr' style='width: 300px; height: 100px'");
		$form->addElement('textarea', 'frm_laststatus', T_('Last Status'), "dir='ltr' style='width: 300px; height: 100px'");

		if(@$user->group['admin'] || @$user->group['operation']){
			if($default['frm_operationfinished'] == 1){
				$value = "Operations Closed";
				$class = "btn-finished";
			}else{
				$value = "Operations Not Closed";
				$class = "btn-notfinished";
			}
			
			$form->addElement("static", NULL, NULL, "<span  id='finished_div' style='margin: 4px; width: 16px;'></span><input type='button' id='operation_finished' value='$value' class='$class' onclick='new ajax(\"index.php?section=operation&module=transport-admin&step=finished&cmd=operation&transportid={$transportid}\", {update: \"finished_div\", evalScripts: true}).request();' />");
		}
		$form->setDefaults(@$default);
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();							
}


//###samarty
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('id', $id);
$smarty->assign_by_ref('list', $list);
$smarty->assign_by_ref('pathlist', @$pathlist);
$smarty->assign_by_ref('documentlist', @$documentlist);
$smarty->assign('extModule', $extModule);
$smarty->assign('backurl', "index.php?section=$section&module=transport-list&step=transport&page=$page");
$smarty->assign('formData', @$formData);
$smarty->assign('default', @$default);
$smarty->assign('transportid', $transportid);
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>