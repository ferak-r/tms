<?php
//### fetch variable
$target = @($_GET['frm_target']=='frm_cc')? 'frm_cc': 'frm_to';

switch($cmd){
	case 'add':
		$receiver = @implode(',',$_POST['frm_receiver']);
		$group = (!empty($_POST['frm_group']))? '['.implode('],[', $_POST['frm_group']).']' : '';
		$result = (!empty($receiver) and !empty($group))? $receiver.','.$group : $receiver.$group;
		die("
		<script language='javascript' type='text/javascript'>
			window.opener.document.getElementById('".$target."').value = '".$result."';
			window.close();
		</script>
		");
		break;
	default:
			$userlist[] = array('label' => T_('All Admins'),
								'member' => 'admin');
			$userlist[] = array('label' => T_('Admin List'),
								'member' => $user->fetchGroupMember('admin',1));

			$userlist[] = array('label' => T_('All Customers'),
								'member' => 'customer');
			$userlist[] = array('label' => T_('Customer List'),
								'member' => $user->fetchGroupMember('customer',1));

			$userlist[] = array('label' => T_('All Carriers'),
								'member' => 'carrier');
			$userlist[] = array('label' => T_('Carrier List'),
								'member' => $user->fetchGroupMember('carrier',1));

			$userlist[] = array('label' => T_('All Operations'),
								'member' => 'operation');
			$userlist[] = array('label' => T_('Operation List'),
								'member' => $user->fetchGroupMember('operation',1));

			$userlist[] = array('label' => T_('All Documents'),
								'member' => 'document');
			$userlist[] = array('label' => T_('Document List'),
								'member' => $user->fetchGroupMember('document',1));
								
			$userlist[] = array('label' => T_('All Offices'),
								'member' => 'office');
			$userlist[] = array('label' => T_('Office List'),
								'member' => $user->fetchGroupMember('office',1));

			$userlist[] = array('label' => T_('All Account&Customs'),
								'member' => 'account&customs');
			$userlist[] = array('label' => T_('Account&Customs List'),
								'member' => $user->fetchGroupMember('account&customs',1));


		$formData = $mail->findReceiver($userlist, "index.php?section=$section&module=$module&cmd=add&frm_target=$target");
}
$tplModule = "admin.tpl";
//### samrty
$smarty->assign('formData', @$formData);
$smarty->assign('popup', @$popup);
$smarty->display($tplModule);
die();
trace($smarty->_tpl_vars, 'global');
?>