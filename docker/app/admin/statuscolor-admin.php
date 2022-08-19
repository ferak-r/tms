<?php
//###fetch information
$id = @$_REQUEST['frm_id'];
$popup = @intval($_REQUEST['popup']);
$object = @$_REQUEST['object'];
$tplModule = "admin.tpl";

switch($cmd){
	case 'add':
		//### insert to db
		$fields_values = array( 
							'xcolorid' 	=> $_POST['frm_colorid'],
							'xstatus'  	=> $_POST['frm_status']
							);
		$res = $db->autoExecute('xxstatuscolor', $fields_values, DB_AUTOQUERY_INSERT);
		$fields_values['xcolorstatusid'] = $db->getOne ("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=admin&module=statuscolor-list&page=$page");
		break;
	 case 'update':
		$fields_values = array( 
							'xcolorid' 	=> $_POST['frm_colorid'],
							'xstatus'  	=> $_POST['frm_status']
							);
		$res = $db->autoExecute('xxstatuscolor', $fields_values, DB_AUTOQUERY_UPDATE, "xstatuscolorid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=statuscolor-admin&page=$page&frm_id=$id");
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxstatuscolor
				WHERE xstatuscolorid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect('index.php?section=admin&module=statuscolor-list');
		break;
	default:
		$sql = "SELECT *
				FROM xxstatuscolor
				WHERE xstatuscolorid='$id'";
		$list = $db->getRow($sql);
		if($list){
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
		}
		$color = $db->getList('xxcolor');
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=statuscolor-admin&page=$page&cmd=$cmd&popup=$popup&object=$object");
		$form->addElement('text', 'frm_status', T_('Status'), "dir='ltr'");
		$form->addElement('select', 'frm_colorid', T_('Color'), $color, "dir='ltr'");
		$form->setDefaults(@$default);
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();							
}


//###samarty
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('list', $list);
$smarty->assign('backurl', "index.php?section=$section&module=statuscolor-list&page=$page");
$smarty->assign('formData', @$formData);
trace($smarty->_tpl_vars);
?>