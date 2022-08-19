<?php
//###fetch information
$id		   = @$_REQUEST['frm_id'];
$carrierid = @$_REQUEST['carrierid'];
$object    = @$_REQUEST['object'];
$step 	   = @$_REQUEST['step'];
$popup 	   = @intval($_REQUEST['popup']);
$tplModule = "admin.tpl";

$step = $step ? $step : 'carrier';

switch($step){
	case 'carrier':
		$extModule[] = 'carrier-equipment-ext.tpl';
		//select all carrier equipment
		if($id){
			$sql = "SELECT *
					FROM xxequipment
					WHERE xcarrierid = '$id'";
			$equipmentlist = $db->getAll($sql);
			$smarty->assign_by_ref('equipmentlist', $equipmentlist);
		}
		$smarty->assign('backurl', "index.php?section=$section&module=carrier-list&page=$page");
		switch($cmd){
			case 'add':
				$username = array(
							'xusername'			=> $_POST['frm_username'],
							'xpassword'			=> sha1($_POST['frm_password']),
							'xrepassword'		=> sha1($_POST['frm_repassword'])
							);
				if($user->checkUsername($username)){
					//### insert to db
					$fields_values = array( 
										'xcarrier' 			=> $_POST['frm_carrier'],
										'xcarriertype'		=> 'Company',
										'xphone' 			=> $_POST['frm_phone'],
										'xfax' 				=> $_POST['frm_fax'],
										'xmanager' 			=> $_POST['frm_manager'],
										'xmanagerphone' 	=> $_POST['frm_managerphone'],
										'xresponsible' 		=> $_POST['frm_responsible'],
										'xresponsiblephone' => $_POST['frm_responsiblephone'],
										'xaddress' 			=> $_POST['frm_address']
										);
					$res = $db->autoExecute('xxcarrier', $fields_values, DB_AUTOQUERY_INSERT);
					$id = $fields_values['xcarrierid'] = $db->getOne ("SELECT @@IDENTITY");
					
					if (DB::isError($res)) {
						msg($msg['Error'], 'error', 'Error');
					}else{
						unset($username['xrepassword']);
						$username['xusernameid'] = 'cri'.$fields_values['xcarrierid'];
						$username['xuserstatus'] = 'Active';
						$res = $db->autoExecute('xxuser_username', $username, DB_AUTOQUERY_INSERT);
						$userid = $db->getOne("SELECT @@IDENTITY");
						$user->joinGroup('cri'.$userid, key($user->fetchGroup('carrier')), 'add');
					}	
				}
				if(!$popup){
					if(isset($_GET['newequipment'])){
						redirect("index.php?section=admin&module=carrier-admin&page=$page&step=carrier&frm_id=$id&popupwin=equipment");
					}else{
						redirect("index.php?section=admin&module=carrier-admin&page=$page");
					}
				}else{
					$smarty->assign_by_ref('popup', $popup);
					$smarty->assign('object', $object);
					$smarty->assign_by_ref('newcarrier', $fields_values);
					$smarty->display($tplModule);
					die();
				}

				break;
			 case 'update':
				$fields_values = array( 
									'xcarrier' 			=> $_POST['frm_carrier'],
									'xcarriertype'		=> 'Company',
									'xphone' 			=> $_POST['frm_phone'],
									'xfax' 				=> $_POST['frm_fax'],
									'xmanager' 			=> $_POST['frm_manager'],
									'xmanagerphone' 		=> $_POST['frm_managerphone'],
									'xresponsible' 		=> $_POST['frm_responsible'],
									'xresponsiblephone' 	=> $_POST['frm_responsiblephone'],
									'xaddress' 			=> $_POST['frm_address']
									);
				
				$res = $db->autoExecute('xxcarrier', $fields_values, DB_AUTOQUERY_UPDATE, "xcarrierid='$id'");
				if(PEAR::isError($res)){
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				}
				redirect("index.php?section=$section&module=carrier-admin&page=$page&frm_id=$id");
				break;
			case 'delete':
				$id = is_array($id) ? implode(',', $id) : $id;
				$sql = "DELETE
						FROM xxcarrier
						WHERE xcarrierid IN ($id)";
				$res = $db->query($sql);
				if(PEAR::isError($res)){
					//delete related equipment
					$sql = "DELETE
							FROM xxequipment
							WHERE xcarrierid IN ($id)";
					$res = $db->query($sql);
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				}
				redirect('index.php?section=admin&module=carrier-list');
				break;
			default:
				$sql = "SELECT * 
						FROM xxcarrier
						NATURAL LEFT JOIN xxuser_username
						WHERE xcarrierid = '$id'";
				$list = $db->getRow($sql);

				if($list){
					foreach($list as $key => $val){
						$default['frm_'.substr($key, 1, strlen($key))] = $val;
					}
				}
				$cmd = empty($id)? "add" : "update&frm_id=$id";
				$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=carrier-admin&page=$page&cmd=$cmd&popup=$popup&object=$object");
				if(!$id){
					$form->addElement('text', 'frm_username', T_('Username'), "dir='ltr'");
					$form->addElement('password', 'frm_password', T_('Password'), "dir='ltr'");
					$form->addElement('password', 'frm_repassword', T_('Confirm Password'), "dir='ltr'");
				}else{
					$form->addElement('static', NULL, T_('Username'), $default['frm_username'], "dir='ltr'");
					$form->addElement('link', NULL, NULL, "javascript:void(0);", "Change Password", "onclick='openNewWindow(\"index.php?section=admin&module=user-changepass&frm_usernameid=cri$id\", 500, 300);'");
				}
				$form->addElement('text', 'frm_carrier', T_('Company Name'), "dir='ltr'");
				$form->addElement('text', 'frm_phone', T_('Phone Number'), "dir='ltr'");
				$form->addElement('text', 'frm_fax', T_('Fax Number'), "dir='ltr'");
				$form->addElement('text', 'frm_address', T_('Address'), "dir='ltr'");
				$form->addElement('text', 'frm_manager', T_('Company Manager'), "dir='ltr'");
				$form->addElement('text', 'frm_managerphone', T_('Manager Phone Number'), "dir='ltr'");
				$form->addElement('text', 'frm_responsible', T_('Responsible'), "dir='ltr'");
				$form->addElement('text', 'frm_responsiblephone', T_('Responsible Phone Number'), "dir='ltr'");
				$form->setDefaults(@$default);
				$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
				$form->accept($renderer);
				$formData = $renderer->toArray();							
		}
		break;
	case 'equipment':
		switch($cmd){
			case 'add':
				//### insert to db
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
				$res = $db->autoExecute('xxequipment', $fields_values, DB_AUTOQUERY_INSERT);
				$fields_values['xequipmentid'] = $db->getOne ("SELECT @@IDENTITY");
				if (DB::isError($res)) {
					msg($msg['Error'], 'error', 'Error');
				}
				redirect("index.php?section=admin&module=carrier-admin&step=equipment&carrierid=$carrierid&page=$page&popup=$popup&refreshparent=equipment");
				break;
			 case 'update':
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
				redirect("index.php?section=$section&module=carrier-admin&step=equipment&carrierid=$carrierid&page=$page&frm_id=$id&popup=$popup&refreshparent=equipment");
				break;
			case 'delete':
				$id = is_array($id) ? implode(',', $id) : $id;
				$sql = "DELETE
						FROM xxequipment
						WHERE xequipmentid IN ($id)";
				$res = $db->query($sql);
				if(PEAR::isError($res)){
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				}
				redirect('index.php?section=admin&module=carrier-list');
				break;
			case 'equipmentoutput':
				$sql = "SELECT *
						FROM xxequipment
						WHERE xcarrierid = '$carrierid'";
				$equipmentlist = $db->getAll($sql);
				$smarty->assign('id', $carrierid);
				$smarty->assign_by_ref('equipmentlist', $equipmentlist);
				$smarty->display('carrier-equipment-ext.tpl');
				die();
				break;
			default:
				$equipmentcat      = $db->fetchEnum('xxequipment', 'xequipmentcat');
				$equipmentquantity = $db->getList('xxequipmentquantity', '', '', 'xequipmentquantity');
				$equipmenttype	   = $db->getList('xxequipmenttype', '', '', 'xequipmenttype');
				$sql = "SELECT *, xequipmentcat+0 AS xequipmentcat
						FROM xxequipment
						WHERE xequipmentid = '$id'";
				$list = $db->getRow($sql);
				if($list){
					foreach($list as $key => $val){
						$default['frm_'.substr($key, 1, strlen($key))] = $val;
					}
				}
				$cmd = empty($id)? "add" : "update&frm_id=$id";
				$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=carrier-admin&step=equipment&page=$page&cmd=$cmd&popup=$popup&carrierid=$carrierid");
				$form->addElement('select', 'frm_equipmentcat', T_('Category'), $equipmentcat, 'dir="ltr" onchange="form1.frm_equipment.disabled=\'disabled\';form1.frm_chassisno.disabled=false;form1.frm_certificate.disabled=false;form1.frm_equipmentno.disabled=false; if(this.value == 2 || this.value == 3){form1.frm_chassisno.disabled=\'disabled\';form1.frm_certificate.disabled=\'disabled\';} if(this.value == 3){form1.frm_equipment.disabled=false; form1.frm_equipmentno.disabled=\'disabled\';}"');
				
				if(@$default['frm_equipmentcat'] == '3'){
					$form->addElement('text', 'frm_equipment', T_('Name'), "dir='ltr'");
					$form->addElement('text', 'frm_equipmentno', T_('Equipment No'), "dir='ltr' disabled='disabled'");
				}else{
					$form->addElement('text', 'frm_equipment', T_('Name'), "dir='ltr' disabled='disabled'");
					$form->addElement('text', 'frm_equipmentno', T_('Equipment No'), "dir='ltr'");
				}

				$form->addElement('select', 'frm_equipmenttypeid', T_('Type'), $equipmenttype, "dir='ltr'");
				$form->addElement('select', 'frm_equipmentquantityid', T_('Quantity'), $equipmentquantity, "dir='ltr'");

				if(!@$default['frm_equipmentcat'] || $default['frm_equipmentcat'] == 1){
					$form->addElement('text', 'frm_chassisno', T_('Chassis No'), "dir='ltr'");
					$form->addElement('text', 'frm_certificate', T_('Certificate'), "dir='ltr'");
				}else{
					$form->addElement('text', 'frm_chassisno', T_('Chassis No'), "dir='ltr' disabled='disabled'");
					$form->addElement('text', 'frm_certificate', T_('Certificate'), "dir='ltr' disabled='disabled'");
				}

				$form->addElement('textarea', 'frm_equipmentdes', T_('Description'), "dir='ltr'");
				
				$form->setDefaults(@$default);
				$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
				$form->accept($renderer);
				$formData = $renderer->toArray();							
		}
		break;
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
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>