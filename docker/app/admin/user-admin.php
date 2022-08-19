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
								'xname' 		=> $_POST['frm_name'],
								'xfamily'  		=> $_POST['frm_family'],
								'xgender'   	=> $_POST['frm_gender'],
								'xmarital'		=> $_POST['frm_marital'],
								'xcompany'  	=> $_POST['frm_company'],
								'xpost'  		=> $_POST['frm_post'],
								'xaddress' 		=> $_POST['frm_address'],
								'xcity'  		=> $_POST['frm_city'],
								'xtel'  		=> $_POST['frm_tel'],
								'xfax'  		=> $_POST['frm_fax'],
								'xcountryid'  	=> $_POST['frm_countryid'],
								'xemail'  		=> $_POST['frm_email'],
								'xweb'			=> $_POST['frm_web'],
								'xuserdes' 		=> $_POST['frm_userdes']
								);
			$res = $db->autoExecute('xxuser_info', $fields_values, DB_AUTOQUERY_INSERT);
			$fields_values['xinfoid'] = $db->getOne ("SELECT @@IDENTITY");
			if (DB::isError($res)) {
				msg($msg['Error'], 'error', 'Error');
			}else{		
				unset($username['xrepassword']);
				$username['xusernameid'] = 'inf'.$fields_values['xinfoid'];
				$username['xuserstatus'] = 'Active';
				$res = $db->autoExecute('xxuser_username', $username, DB_AUTOQUERY_INSERT);
				$userid = $db->getOne("SELECT @@IDENTITY");
		
				if(!empty($_POST['frm_group'])){
					$groupid = array_map('intval', $_POST['frm_group']);
					//add to groupuser
					foreach($groupid as $key => $val){
						$user->joinGroup('inf'.$userid, $val, 'add');
					}
				}
			}
		}
		if(!$popup){
			redirect("index.php?section=admin&module=user-list&page=$page");
		}else{
			$smarty->assign_by_ref('popup', $popup);
			$smarty->assign('object', $object);
			$smarty->assign_by_ref('newcustomer', $fields_values);
			$smarty->display($tplModule);
			die();
		}
		break;
	 case 'update':
			$fields_values = array( 
								'xname' 		=> $_POST['frm_name'],
								'xfamily'  		=> $_POST['frm_family'],
								'xgender'   	=> $_POST['frm_gender'],
								'xmarital'		=> $_POST['frm_marital'],
								'xcompany'  	=> $_POST['frm_company'],
								'xpost'  		=> $_POST['frm_post'],
								'xaddress' 		=> $_POST['frm_address'],
								'xcity'  		=> $_POST['frm_city'],
								'xtel'  		=> $_POST['frm_tel'],
								'xfax'  		=> $_POST['frm_fax'],
								'xcountryid'  	=> $_POST['frm_countryid'],
								'xemail'  		=> $_POST['frm_email'],
								'xweb'			=> $_POST['frm_web'],
								'xuserdes' 		=> $_POST['frm_userdes']
								);
		$res = $db->autoExecute('xxuser_info', $fields_values, DB_AUTOQUERY_UPDATE, "xinfoid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		} else {
			$sql = "DELETE FROM xxuser_groupuser WHERE xusernameid IN ('inf$id')";
			$res = $db->query($sql);
			$groupid = array_map('intval', $_POST['frm_group']);
			//add to groupuser
			foreach($groupid as $key => $val){
				$user->joinGroup("inf$id", $val, 'add');
			}
		}
		redirect("index.php?section=$section&module=user-admin&page=$page&frm_id=$id");
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxuser_info
				WHERE xinfoid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		} else {
			$sql = "DELETE
					FROM xxuser_groupuser
					WHERE xusernameid IN ('inf$id')";
			$res = $db->query($sql);
			$sql = "DELETE
					FROM xxuser_username
					WHERE xusernameid IN ('inf$id')";
			$res = $db->query($sql);
		}
		redirect('index.php?section=admin&module=user-list');
		break;
	default:
		$sql = "SELECT *, xgender+0 AS xgender, xcountryid+0 AS xcountryid, xmarital+0 AS xmarital
				FROM xxuser_info
				NATURAL LEFT JOIN xxuser_username
				WHERE xinfoid = '$id'";
		$list = $db->getRow($sql);
		$default['frm_group'] = array_keys($user->groupInfo("inf$id"));
		$default['frm_countryid'] = 115; //iran
		if($list){
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
		}
		$group = $user->fetchgroup();
		unset($group[array_search('webcarrier', $group)]);
		unset($group[array_search('customer', $group)]);
		unset($group[array_search('office', $group)]);
		
		$gender = $db->fetchEnum('xxuser_info', 'xgender');
		$marital = $db->fetchEnum('xxuser_info', 'xmarital');
		$country = $db->getList('xxcountry');
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=user-admin&page=$page&cmd=$cmd&popup=$popup");
				if(!$id){
					$form->addElement('text', 'frm_username', T_('Username'), "dir='ltr'");
					$form->addElement('password', 'frm_password', T_('Password'), "dir='ltr'");
					$form->addElement('password', 'frm_repassword', T_('Confirm Password'), "dir='ltr'");
				}else{
					$form->addElement('static', NULL, T_('Username'), $default['frm_username'], "dir='ltr'");
					$form->addElement('link', NULL, NULL, "javascript:void(0);", "Change Password", "onclick='openNewWindow(\"index.php?section=admin&module=user-changepass&frm_usernameid=inf$id\", 500, 300);'");
				}
		$form->addElement('select', 'frm_group', T_('Group'), $group, "multiple='multiple' dir='ltr'");
		$form->addElement('text', 'frm_name', T_('Name'), "dir='ltr'");
		$form->addElement('text', 'frm_family', T_('Family'), "dir='ltr'");
		$form->addElement('select', 'frm_gender', T_('Gender'), $gender, "dir='ltr'");
		$form->addElement('select', 'frm_marital', T_('Marital Status'), $marital, "dir='ltr'");
		$form->addElement('text', 'frm_company', T_('Company'), "dir='ltr'");
		$form->addElement('text', 'frm_post', T_('Position'), "dir='ltr'");
		$form->addElement('select', 'frm_countryid', T_('Country'), $country, "dir='ltr'");
		$form->addElement('text', 'frm_city', T_('City'), "dir='ltr'");
		$form->addElement('text', 'frm_tel', T_('Phone Number'), "dir='ltr'");
		$form->addElement('text', 'frm_fax', T_('Fax Number'), "dir='ltr'");
		$form->addElement('textarea', 'frm_address', T_('Address'), "dir='ltr'");
		$form->addElement('text', 'frm_email', T_('Email'), "dir='ltr'");
		$form->addElement('text', 'frm_web', T_('Website'), "dir='ltr'");
		$form->addElement('textarea', 'frm_userdes', T_('Remarks'), "dir='ltr'");
		
		

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
$smarty->assign('backurl', "index.php?section=$section&module=user-list&page=$page");
$smarty->assign('formData', @$formData);
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>