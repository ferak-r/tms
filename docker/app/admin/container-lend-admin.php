<?php
//###fetch information
$id 	   = @$_REQUEST['frm_id'];
$step 	   = @$_REQUEST['step'];
$popup 	   = @intval($_REQUEST['popup']);
$tplModule = "admin.tpl";

switch($cmd){
	case 'add':
		$res = $db->autoExecute('xxidentity', array('xpartyaccountid' => $_POST['frm_partyaccountid'], 'xpartyaccountetc' => $_POST['frm_partyaccountetc']), DB_AUTOQUERY_INSERT);
		$identityid = $db->getOne("SELECT @@identity");
		//### insert to db
		$fields_values = array( 
							'xidentityid'  	   => $identityid,
							'xlenddate'        => $_POST['frm_lenddate'] ? $_POST['frm_lenddate'] : NULL,
							'xfreetime'		   => $_POST['frm_freetime'],
							'xcomment' 		   => $_POST['frm_comment'],
							'xreturned' 	   => $_POST['frm_returned'] ? 'Yes' : 'No',
							'xreturndate'	   => $_POST['frm_returned'] ? $_POST['frm_returndate'] : NULL
							);
		$res = $db->autoExecute('xxcontainerlend', $fields_values, DB_AUTOQUERY_INSERT);
		$containerlendid = $db->getOne ("SELECT @@IDENTITY");

		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}else{
			$containerid = $_POST['frm_containerid'];
			foreach($containerid as $val){
				$fields_values = array( 
									'xcontainerlendid' => $containerlendid,
									'xcontainerid' 	   => $val
									);
				$res = $db->autoExecute('xxcontainerlendcontainer', $fields_values, DB_AUTOQUERY_INSERT);
			}
		}
		redirect("index.php?section=admin&module=container-lend-admin&page=$page");					
		break;
	 case 'update':
		$sql = "SELECT xidentityid
				FROM xxcontainerlend
				WHERE xcontainerlendid = '$id'";
		$identityid = $db->getOne($sql);
		if($identityid){
			$res = $db->autoExecute('xxidentity', array('xpartyaccountid' => $_POST['frm_partyaccountid'], 'xpartyaccountetc' => $_POST['frm_partyaccountetc']), DB_AUTOQUERY_UPDATE, "xidentityid='$identityid'");
		}else{
			$res = $db->autoExecute('xxidentity', array('xpartyaccountid' => $_POST['frm_partyaccountid'], 'xpartyaccountetc' => $_POST['frm_partyaccountetc']), DB_AUTOQUERY_INSERT);
			$identityid = $db->getOne("SELECT @@identity");
		}
		$res = $db->query($sql);
		$fields_values = array( 
							'xidentityid'  	   => $identityid,
							'xlenddate' 	   => $_POST['frm_lenddate'] ? $_POST['frm_lenddate'] : NULL,
							'xfreetime'		   => $_POST['frm_freetime'],
							'xcomment' 		   => $_POST['frm_comment'],
							'xreturned' 	   => $_POST['frm_returned'] ? 'Yes' : 'No',
							'xreturndate'	   => $_POST['frm_returned'] ? $_POST['frm_returndate'] : NULL
							);
		$res = $db->autoExecute('xxcontainerlend', $fields_values, DB_AUTOQUERY_UPDATE, "xcontainerlendid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		} else {
			$sql = "DELETE
					FROM xxcontainerlendcontainer
					WHERE xcontainerlendid IN ($id)";
			$res = $db->query($sql);
			$containerid = $_POST['frm_containerid'];
			foreach($containerid as $val){
				$fields_values = array( 
									'xcontainerlendid' => $id,
									'xcontainerid' 	   => $val
									);
				$res = $db->autoExecute('xxcontainerlendcontainer', $fields_values, DB_AUTOQUERY_INSERT);
			}
		}
		redirect("index.php?section=$section&module=container-lend-admin&page=$page&frm_id=$id");
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxcontainerlend
				WHERE xcontainerlendid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		} else {
			$sql = "DELETE
					FROM xxcontainerlendcontainer
					WHERE xcontainerlendid IN ($id)";
			$res = $db->query($sql);
		}
		redirect('index.php?section=admin&module=container-lend-list');
		break;
	default:
		$sql = "SELECT *
			    FROM xxcarrier
			    WHERE xcarriertype='Company'
				ORDER BY xcarrier";
		$res = $db->getAll($sql);
		foreach($res as $val){
			$carrier["cri$val[xcarrierid]"] = $val['xcarrier'];
		}
		$sql = "SELECT *
				FROM xxcustomer
				ORDER BY xname";
		$res = $db->getAll($sql);
		foreach($res as $val){
			$customer["cst$val[xcustomerid]"] = "$val[xname] $val[xfamily]";
		}
		$sql = "SELECT *
				FROM xxoffice
				ORDER BY xoffice";
		$res = $db->getAll($sql);
		foreach($res as $val){
			$office["ofc$val[xofficeid]"] = $val['xoffice'];
		}
				
		//get container list
		$sql = "SELECT *
				FROM xxcontainer
				NATURAL LEFT JOIN xxcontainersize
				WHERE xcompanycontainer=1";
		$res = $db->getAll($sql);
		foreach($res as $key=>$val){
			$container[$val['xcontainerid']] = "$val[xcontainernumber] ($val[xcontainersize])";
		}
		asort($container);
		$sql = "SELECT *
				FROM xxcontainerlend
				NATURAL LEFT JOIN zzidentity
				WHERE xcontainerlendid = '$id'";
		$list = $db->getRow($sql);
		if($list){
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
		}
		
		if($id){
			$default['frm_partyaccount'] = $default['frm_type'];
			$default['frm_returned'] = $default['frm_returned'] == 'Yes' ? 1 : 0;
			$sql = "SELECT xcontainerid
					FROM xxcontainerlendcontainer
					WHERE xcontainerlendid = '$id'";
			$default['frm_containerid'] = $db->getCol($sql);
			$default['frm_returndate'] = $default['frm_returndate'] ? $default['frm_returndate'] : date("Y-m-d");
		}else{
			$default['frm_partyaccount'] = 'carrier';
			$default['frm_type']		 = 'carrier';
			$default['frm_returndate']	 = date("Y-m-d");
		}
		
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=container-lend-admin&page=$page&cmd=$cmd&popup=$popup");
		
		
		$partyaccount[] =& HTML_QuickForm::createElement('radio', 'frm_partyaccount', NULL, T_('Carrier'), 'carrier', 'style="width: 20px; border: 0px;" onclick="$$(\'.partyaccount\').each(function(el){el.style.display=\'none\'; el.disabled=1}); $(\'frm_carrierid\').style.display=\'inline\'; $(\'frm_carrierid\').disabled=0;"');
		$partyaccount[] =& HTML_QuickForm::createElement('radio', 'frm_partyaccount', NULL, T_('Customer'), 'customer', 'style="width: 20px; border: 0px;" onclick="$$(\'.partyaccount\').each(function(el){el.style.display=\'none\'; el.disabled=1}); $(\'frm_customerid\').style.display=\'inline\'; $(\'frm_customerid\').disabled=0"');
		$partyaccount[] =& HTML_QuickForm::createElement('radio', 'frm_partyaccount', NULL, T_('Office'), 'office', 'style="width: 20px; border: 0px;" onclick="$$(\'.partyaccount\').each(function(el){el.style.display=\'none\'; el.disabled=1}); $(\'frm_officeid\').style.display=\'inline\'; $(\'frm_officeid\').disabled=0"');
		$partyaccount[] =& HTML_QuickForm::createElement('radio', 'frm_partyaccount', NULL, T_('Etc'), 'etc', 'style="width: 20px; border: 0px;" onclick="$$(\'.partyaccount\').each(function(el){el.style.display=\'none\'; el.disabled=1}); $(\'frm_etc\').style.display=\'inline\'; $(\'frm_etc\').disabled=0"');
		
		$partyaccount[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<br>");
		
		if(@$default['frm_type'] == 'carrier'){
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $carrier, "id='frm_carrierid' class='partyaccount' dir='ltr'");
		}else{
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $carrier, "id='frm_carrierid' class='partyaccount' dir='ltr' style='display: none;' disabled='disabled'");		
		}
		if(@$default['frm_type'] == 'customer'){
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $customer, "id='frm_customerid' class='partyaccount' dir='ltr'");
		}else{
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $customer, "id='frm_customerid' class='partyaccount' dir='ltr' style='display: none;' disabled='disabled'");
		}
		if(@$default['frm_type'] == 'office'){
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $office, "id='frm_officeid' class='partyaccount' dir='ltr'");
		}else{
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $office, "id='frm_officeid' class='partyaccount' dir='ltr' style='display: none' disabled='disabled'");
		}
		if(@$default['frm_type'] == 'etc'){
			$partyaccount[] =& HTML_QuickForm::createElement('textarea', 'frm_partyaccountetc', NULL, "id='frm_etc' class='partyaccount' dir='ltr'");
		}else{
			$partyaccount[] =& HTML_QuickForm::createElement('textarea', 'frm_partyaccountetc', NULL, "id='frm_etc' class='partyaccount' dir='ltr' style='display: none' disabled='disabled'");
		}
		$form->addGroup($partyaccount, NULL, T_('Party Account'));
		 
		$form->addElement('select', 'frm_containerid', T_('Container'), $container, "dir='ltr' multiple='multiple' style='height: 150px'");
		$date[] =& HTML_QuickForm::createElement('text', 'frm_lenddate', NULL, "id='frm_lenddate' dir='ltr'");
		$date[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_lenddate\', \'y-mm-dd\');"');
		$form->addGroup($date, NULL, T_('Lend Date'));		

		$form->addElement('text', 'frm_freetime', T_('Free Time'), "dir='ltr'");
		$form->addElement('textarea', 'frm_comment', T_('Comment'), "dir='ltr' style='height: 100px'");
	
		$returndate[] =& HTML_QuickForm::createElement('checkbox', 'frm_returned', T_('Returned'), NULL, "style='width: 20px' onChange='if(this.checked)$$(\".cl_returndate\").each(function(el){el.style.display=\"inline\"});else $$(\".cl_returndate\").each(function(el){el.style.display=\"none\"})'");
		if(@$default['frm_returned']){
			$returndate[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<div class='cl_returndate' style='display: inline;'>Return Date: </div>");
			$returndate[] =& HTML_QuickForm::createElement('text', 'frm_returndate', NULL, "style='display: inline' class='cl_returndate' id='frm_returndate' dir='ltr'");
			$returndate[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'class="cl_returndate" style="display: inline" onclick="return showCalendar(\'frm_returndate\', \'y-mm-dd\');"');
		}else{
			$returndate[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<div class='cl_returndate' style='display: none;'>Return Date: </div>");
			$returndate[] =& HTML_QuickForm::createElement('text', 'frm_returndate', NULL, "style='display: none' class='cl_returndate' id='frm_returndate' dir='ltr'");
			$returndate[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'class="cl_returndate" style="display: none" onclick="return showCalendar(\'frm_returndate\', \'y-mm-dd\');"');
		}
		$form->addGroup($returndate, NULL, T_('Returned'));
				
		$form->setDefaults(@$default);
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();
}

//###samarty
$smarty->assign('backurl', "index.php?section=admin&module=container-lend-list&page=$page");
$smarty->assign('extModule', @$extModule);
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('list', $list);
$smarty->assign('formData', @$formData);
$smarty->assign('id', @$id);
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>