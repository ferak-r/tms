<?php
//###fetch information
$id = @$_REQUEST['frm_id'];
$popup = @intval($_REQUEST['popup']);
$object = @$_REQUEST['object'];
$tplModule = "admin.tpl";

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
								'xoffice' 	=> $_POST['frm_office'],
								'xphone'  	=> $_POST['frm_phone'],
								'xaddress'  => $_POST['frm_address'],
								'xfax'  	=> $_POST['frm_fax'],
								'xemail'    => $_POST['frm_email'],
								'xwebsite'  => $_POST['frm_website']
								);
			$res = $db->autoExecute('xxoffice', $fields_values, DB_AUTOQUERY_INSERT);
			$fields_values['xofficeid'] = $db->getOne ("SELECT @@IDENTITY");
			if (DB::isError($res)) {
				msg($msg['Error'], 'error', 'Error');
			}else{
				unset($username['xrepassword']);
				$username['xusernameid'] = 'ofc'.$fields_values['xofficeid'];
				$username['xuserstatus'] = 'Active';
				$res = $db->autoExecute('xxuser_username', $username, DB_AUTOQUERY_INSERT);
				$userid = $db->getOne("SELECT @@IDENTITY");
				$user->joinGroup('ofc'.$userid, key($user->fetchGroup('office')), 'add');
			}
		}
		if(!$popup){
			redirect("index.php?section=admin&module=office-list&page=$page");
		}else{
			$smarty->assign('object', $object);
			$smarty->assign('newoffice', $fields_values);
			$smarty->assign_by_ref('popup', $popup);
			$smarty->display($tplModule);
			die();
		}
		break;
	 case 'update':
		$fields_values = array( 
							'xoffice' 	=> $_POST['frm_office'],
							'xphone'  	=> $_POST['frm_phone'],
							'xaddress'  => $_POST['frm_address'],
							'xfax'  	=> $_POST['frm_fax'],
							'xemail'    => $_POST['frm_email'],
							'xwebsite'  => $_POST['frm_website']
							);
		$res = $db->autoExecute('xxoffice', $fields_values, DB_AUTOQUERY_UPDATE, "xofficeid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=office-admin&page=$page&frm_id=$id");
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxoffice
				WHERE xofficeid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect('index.php?section=admin&module=office-list');
		break;
	default:
		$sql = "SELECT *
				FROM xxoffice
				NATURAL LEFT JOIN xxuser_username
				WHERE xofficeid='$id'";
		$list = $db->getRow($sql);
		if($list){
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
		}
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=office-admin&page=$page&cmd=$cmd&popup=$popup&object=$object");
		if(!$id){
			$form->addElement('text', 'frm_username', T_('Username'), "dir='ltr'");
			$form->addElement('password', 'frm_password', T_('Password'), "dir='ltr'");
			$form->addElement('password', 'frm_repassword', T_('Confirm Password'), "dir='ltr'");
		}else{
			$form->addElement('static', NULL, T_('Username'), @$default['frm_username'], "dir='ltr'");
			$form->addElement('link', NULL, NULL, "javascript:void(0);", "Change Password", "onclick='openNewWindow(\"index.php?section=admin&module=user-changepass&frm_usernameid=ofc$id\", 500, 300);'");
		}
		$form->addElement('text','frm_office',$msg['filed']['name'], "dir='ltr'");
		$form->addElement('text','frm_phone',$msg['filed']['tel'], "dir='ltr'");
		$form->addElement('textarea','frm_address',$msg['filed']['address'], "dir='ltr'");
		$form->addElement('text','frm_fax',$msg['filed']['fax'], "dir='ltr'");
		$form->addElement('text','frm_email',$msg['filed']['email'], "dir='ltr'");
		$form->addElement('text','frm_website',$msg['filed']['web'], "dir='ltr'");
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
$smarty->assign('backurl', "index.php?section=$section&module=office-list&page=$page");
$smarty->assign('formData', @$formData);
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>