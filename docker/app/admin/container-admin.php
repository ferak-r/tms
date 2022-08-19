<?php
//###fetch information
$id 	   = @$_REQUEST['frm_id'];
$step 	   = @$_REQUEST['step'];
$popup 	   = @intval($_REQUEST['popup']);
$companycontainer = @intval($_GET['companycontainer']);
if($companycontainer){
	$msg['title1']['container-admin'] = "Add Company Container";
}
$tplModule = "admin.tpl";

switch($cmd){
	case 'add':
		if(@$_POST['frm_carrier']){
			$res = $db->autoExecute('xxcarrier', array('xcarrier' => $_POST['frm_carrier'], 'xcarriertype' => 'Person'), DB_AUTOQUERY_INSERT);
			$carrierid = $db->getOne("SELECT @@IDENTITY");			
		}else{
			$carrierid   = @$_POST['frm_carrierid'];
		}

		//### insert to db
		$fields_values = array( 
							'xcarrierid' 		=> $companycontainer ? NULL : ($_POST['frm_own'] == 2 ? $carrierid : NULL),
							'xcontainernumber' 	=> $_POST['frm_containernumber'],
							'xcontainertypeid' 	=> $_POST['frm_containertypeid'],
							'xcontainersizeid' 	=> $_POST['frm_containersizeid'],
							'xown'				=> $companycontainer ? NULL : $_POST['frm_own'],
							'xcompanycontainer' => $companycontainer
							);
		$res = $db->autoExecute('xxcontainer', $fields_values, DB_AUTOQUERY_INSERT);
		$fields_values['xcontainerid'] = $db->getOne ("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=admin&module=container-admin&page=$page&companycontainer=$companycontainer");					
		break;
	 case 'update':
		if(@$_POST['frm_carrier']){
			$sql = "SELECT xcarrierid
					FROM xxcontainer
					NATURAL LEFT JOIN xxcarrier
					WHERE xcontainerid = '$id' AND xcarriertype = 'Person'";
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
							'xcarrierid' 		=> $_POST['frm_own'] == 2 ? $carrierid : NULL,
							'xcontainernumber' 	=> $_POST['frm_containernumber'],
							'xcontainertypeid' 	=> $_POST['frm_containertypeid'],
							'xcontainersizeid' 	=> $_POST['frm_containersizeid'],
							'xown'				=> $_POST['frm_own'],
							'xcompanycontainer' => $companycontainer
							);
		$res = $db->autoExecute('xxcontainer', $fields_values, DB_AUTOQUERY_UPDATE, "xcontainerid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=container-admin&page=$page&frm_id=$id&companycontainer=$companycontainer");
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxcontainer
				WHERE xcontainerid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect('index.php?section=admin&module=container-list&companycontainer=$companycontainer');
		break;
	default:
		$containertype = $db->getList('xxcontainertype', '', '', 'xcontainertype');
		$containersize = $db->getList('xxcontainersize');
		$carrier	   = $db->getList('xxcarrier', 'xcarrier', 'WHERE xcarriertype="Company"', 'xcarrier');
		$own		   = $db->fetchEnum('xxcontainer', 'xown');
		$sql = "SELECT *, xown+0 AS xown 
				FROM zzcontainer
				WHERE xcontainerid = '$id'";
		$list = $db->getRow($sql);
		if($list){
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
		}
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=container-admin&page=$page&cmd=$cmd&popup=$popup&companycontainer=$companycontainer");
		$form->addElement('text', 'frm_containernumber', T_('Container Number'), "dir='ltr'");
		$form->addElement('select', 'frm_containertypeid', T_('Container Type'), $containertype, "dir='ltr'");
		$form->addElement('select', 'frm_containersizeid', T_('Container Size'), $containersize, "dir='ltr'");
		
		if(!$companycontainer){
			$form->addElement('select', 'frm_own', NULL, $own, "dir='ltr' onchange='if(this.options[selectedIndex].innerHTML == \"COC\")$(\"grp_owner\").style.display=\"inline\";else $(\"grp_owner\").style.display=\"none\";'");
			
			if(!@$default['frm_own'] || @$default['frm_own'] == 1){
				$owner[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<div id='grp_owner' style='display:none'>Owner");
			}else{
				$owner[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<div id='grp_owner'>Owner");
			}
			if(@$default['frm_carriertype'] == 'Company'){
				$owner[] =& HTML_QuickForm::createElement('select', 'frm_carrierid', NULL, $carrier, "dir='ltr'");
				$owner[] =& HTML_QuickForm::createElement('text', 'frm_carrier', NULL, "dir='ltr' style='display: none'");
				$owner[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'A Person', 'onclick="form1.frm_carrierid.disabled=false; form1.frm_carrier.disabled=false; if(form1.frm_carrierid.style.display == \'none\'){ this.innerHTML = \'A Person\'; form1.frm_carrierid.style.display = \'inline\';form1.frm_carrier.disabled=\'disabled\'; form1.frm_carrier.style.display=\'none\';}else{ this.innerHTML = \'A Company\'; form1.frm_carrierid.disabled=\'disabled\'; form1.frm_carrierid.style.display = \'none\'; form1.frm_carrier.style.display=\'inline\'; }"');				
			}else{
				$owner[] =& HTML_QuickForm::createElement('select', 'frm_carrierid', NULL, $carrier, "dir='ltr' style='display: none'");
				$owner[] =& HTML_QuickForm::createElement('text', 'frm_carrier', NULL, "dir='ltr'");
				$owner[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", 'A Company', 'onclick="form1.frm_carrierid.disabled=false; form1.frm_carrier.disabled=false; if(form1.frm_carrierid.style.display == \'none\'){ this.innerHTML = \'A Person\'; form1.frm_carrierid.style.display = \'inline\'; form1.frm_carrier.disabled=\'disabled\'; form1.frm_carrier.style.display=\'none\';}else{ this.innerHTML = \'A Company\'; form1.frm_carrierid.disabled=\'disabled\'; form1.frm_carrierid.style.display = \'none\'; form1.frm_carrier.style.display=\'inline\'; }"');				
			}
			$owner[] =& HTML_QuickForm::createElement('static', NULL, NULL, "</div>");
			$form->addGroup($owner, NULL, NULL);
		}
		
		$form->setDefaults(@$default);
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();							
}

//###samarty
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