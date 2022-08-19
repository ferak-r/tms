<?php
//###fetch information
$id 	   = @$_REQUEST['frm_id'];
$carrierid = @$_REQUEST['carrierid'];
$step 	   = @$_REQUEST['step'];
$popup 	   = @intval($_REQUEST['popup']);
$object	   = @$_REQUEST['object'];
$tplModule = "admin.tpl";

switch($cmd){
	case 'add':
		//### insert to db
		if(@$_POST['frm_carrier']){
			$res = $db->autoExecute('xxcarrier', array('xcarrier' => $_POST['frm_carrier'], 'xcarriertype' => 'Person'), DB_AUTOQUERY_INSERT);
			$carrierid = $db->getOne("SELECT @@IDENTITY");			
		}else{
			$carrierid   = @$_POST['frm_carrierid'];
		}
		$fields_values = array(
							'xcarrierid' 			=> $carrierid,
							'xequipment'			=> @$_POST['frm_equipment'],
							'xequipmentcat' 		=> @$_POST['frm_equipmentcat'],
							'xequipmentno' 			=> @$_POST['frm_equipmentno'],
							'xchassisno' 			=> @$_POST['frm_chassisno'],
							'xequipmenttypeid' 		=> @$_POST['frm_equipmenttypeid'],
							'xequipmentquantityid' 	=> @$_POST['frm_equipmentquantityid'],
							'xcertificate' 			=> @$_POST['frm_certificate'],
							'xequipmentdes' 		=> @$_POST['frm_equipmentdes']
							);
		$res = $db->autoExecute('xxequipment', $fields_values, DB_AUTOQUERY_INSERT);
		$fields_values['xequipmentid'] = $db->getOne ("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}
		if(!$popup){
			redirect("index.php?section=admin&module=equipment-list&page=$page");
		}else{
			$equipmentcat = $db->fetchEnum('xxequipment', 'xequipmentcat');
			$fields_values['xequipmentcat'] = $equipmentcat[$fields_values['xequipmentcat']];
			$fields_values['xequipment'] = $fields_values['xequipmentcat'] . '(' . ($fields_values['xequipmentcat'] == 'VSL' ? $fields_values['xequipment'] : $fields_values['xequipmentno']) . ')';
			$smarty->assign_by_ref('popup', $popup);
			$smarty->assign('object', $object);
			$smarty->assign_by_ref('newequipment', $fields_values);
			$smarty->display($tplModule);
			die();
		}
		break;
	 case 'update':
		//### insert to db
		if(@$_POST['frm_carrier']){
			$sql = "SELECT xcarrierid
					FROM xxequipment
					NATURAL LEFT JOIN xxcarrier
					WHERE xequipmentid = '$id' AND xcarriertype = 'Person'";
			$carrierid = $db->getOne($sql);
			if($carrierid){
				$res = $db->autoExecute('xxcarrier', array('xcarrier' => $_POST['frm_carrier'], 'xcarriertype' => 'Person'), DB_AUTOQUERY_UPDATE, "xcarrierid = '$carrierid'");
			}else{
				$res = $db->autoExecute('xxcarrier', array('xcarrier' => $_POST['frm_carrier'], 'xcarriertype' => 'Person'), DB_AUTOQUERY_INSERT);
				$carrierid = $db->getOne ("SELECT @@IDENTITY");
			}
		}else{
			$carrierid = @$_POST['frm_carrierid'];
		}
		
		$fields_values = array( 
							'xcarrierid' 			=> $carrierid,
							'xequipment'			=> $_POST['frm_equipment'],
							'xequipmentcat' 		=> $_POST['frm_equipmentcat'],
							'xequipmentno' 			=> $_POST['frm_equipmentno'],
							'xchassisno' 			=> $_POST['frm_chassisno'],
							'xequipmenttypeid' 		=> $_POST['frm_equipmenttypeid'],
							'xequipmentquantityid' 	=> $_POST['frm_equipmentquantityid'],
							'xcertificate' 			=> $_POST['frm_certificate'],
							'xequipmentdes' 		=> $_POST['frm_equipmentdes']
							);
		$res = $db->autoExecute('xxequipment', $fields_values, DB_AUTOQUERY_UPDATE, "xequipmentid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=equipment-admin&carrierid=$carrierid&page=$page&frm_id=$id&popup=$popup");
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		
		$sql = "DELETE
				FROM xxcarrier
				WHERE xcarrierid IN 
					(SELECT xcarrierid 
					 FROM (SELECT xcarrierid, xcarriertype FROM xxcarrier) AS xxtemp
					 NATURAL LEFT JOIN xxequipment
					 WHERE xequipmentid IN ($id) AND xcarriertype = 'Person'
					)";
		$res = $db->query($sql);

		$sql = "DELETE
				FROM xxequipment
				WHERE xequipmentid IN ($id)";
		$res = $db->query($sql);

		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect('index.php?section=admin&module=equipment-list');
		break;
	default:
		$equipmentcat = $db->fetchEnum('xxequipment', 'xequipmentcat');
		$equipmentquantity = $db->getList('xxequipmentquantity', '', '', 'xequipmentquantity');
		$equipmenttype	   = $db->getList('xxequipmenttype', '', '', 'xequipmenttype');
		$carrier		   = $db->getList('xxcarrier', 'xcarrier', 'WHERE xcarriertype="Company"', 'xcarrier');

		$sql = "SELECT *, xequipmentcat+0 AS xequipmentcat
				FROM xxequipment
				NATURAL LEFT JOIN xxcarrier
				WHERE xequipmentid = '$id'";
		$list = $db->getRow($sql);
		if($list){
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
		}elseif($carrierid){
			$default['frm_carriertype'] = 'Company';
			$default['frm_carrierid']   = $carrierid;
		}
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=equipment-admin&page=$page&cmd=$cmd&popup=$popup&carrierid=$carrierid&object=$object");
		$form->addElement('select', 'frm_equipmentcat', T_('Category'), $equipmentcat, 'dir="ltr" onchange="equipmentChanged(this)"');
		
		if(@$default['frm_carriertype'] == 'Company'){
			$owner[] =& HTML_QuickForm::createElement('select', 'frm_carrierid', NULL, $carrier, "dir='ltr'");
			$owner[] =& HTML_QuickForm::createElement('text', 'frm_carrier', NULL, "dir='ltr' style='display: none'");
			$owner[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'A Person', 'onclick="form1.frm_carrierid.disabled=false; form1.frm_carrier.disabled=false; if(form1.frm_carrierid.style.display == \'none\'){ this.innerHTML = \'A Person\'; form1.frm_carrierid.style.display = \'inline\';form1.frm_carrier.disabled=\'disabled\'; form1.frm_carrier.style.display=\'none\';}else{ this.innerHTML = \'A Company\'; form1.frm_carrierid.disabled=\'disabled\'; form1.frm_carrierid.style.display = \'none\'; form1.frm_carrier.style.display=\'inline\'; }"');				
			$form->addGroup($owner, NULL, T_('Owner'));
		}else{
			$owner[] =& HTML_QuickForm::createElement('select', 'frm_carrierid', NULL, $carrier, "dir='ltr' style='display: none'");
			$owner[] =& HTML_QuickForm::createElement('text', 'frm_carrier', NULL, "dir='ltr'");
			$owner[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'A Company', 'onclick="form1.frm_carrierid.disabled=false; form1.frm_carrier.disabled=false; if(form1.frm_carrierid.style.display == \'none\'){ this.innerHTML = \'A Person\'; form1.frm_carrierid.style.display = \'inline\'; form1.frm_carrier.disabled=\'disabled\'; form1.frm_carrier.style.display=\'none\';}else{ this.innerHTML = \'A Company\'; form1.frm_carrierid.disabled=\'disabled\'; form1.frm_carrierid.style.display = \'none\'; form1.frm_carrier.style.display=\'inline\'; }"');				
			$form->addGroup($owner, NULL, T_('Owner'));
		}
		
		$form->addElement('text', 'frm_equipment', T_('Name'), "dir='ltr'");
		$form->addElement('text', 'frm_equipmentno', T_('Truck/Voyage No'), "dir='ltr'");
		$form->addElement('text', 'frm_vsltype', T_('Type'), "dir='ltr'");
		$form->addElement('select', 'frm_equipmenttypeid', T_('Type'), $equipmenttype, "dir='ltr'");
		$form->addElement('select', 'frm_equipmentquantityid', T_('Quantity'), $equipmentquantity, "dir='ltr'");
		$form->addElement('text', 'frm_chassisno', T_('Chassis No'), "dir='ltr'");
		$form->addElement('text', 'frm_certificate', T_('Certificate'), "dir='ltr'");
		$form->addElement('textarea', 'frm_equipmentdes', T_('Description'), "dir='ltr'");
		
		$form->setDefaults(@$default);
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();
		$P['js'][] = "equipmentChanged()";
}

//###samarty
$smarty->assign('extModule', @$extModule);
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('list', $list);
$smarty->assign('formData', @$formData);
$smarty->assign('id', @$id);
$smarty->assign('carrierid', $carrierid);
$smarty->assign('backurl', "index.php?section=$section&module=equipment-list&page=$page");
trace($smarty->_tpl_vars);
if($popup){
	$smarty->assign('P', $P);
	$smarty->display($tplModule);
	die();
}
?>