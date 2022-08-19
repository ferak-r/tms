<?php
//### fetch variable
$userid = empty($_REQUEST['frm_usernameid'])? $user->id : $_REQUEST['frm_usernameid'];
$password  = @$_POST["frm_newpassword"];
$repassword = @$_POST['frm_repassword'];
$oldpassword = @$_POST['frm_oldpassword'];

switch($cmd){
	case 'changepass': 
		if(!empty($user->group['carrier'])){
			$user->changepass($userid, $oldpassword, $password, $repassword);
		}else{
			$user->changepass($userid, $oldpassword, $password, $repassword, 1);
		}
		$resultmsg = empty($user->error)? $msg['Ok']: $user->error;
		die("
		<script language='javascript' type='text/javascript'>
			alert('$resultmsg');
			window.close();
		</script>
		");
		break;
	default:
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=user-changepass&cmd=changepass&frm_usernameid=$userid");

		if(!empty($user->group['carrier'])){
			$form->addElement('password','frm_oldpassword',$msg['filed']['password'], "class='text-input' dir='ltr'");
		}
		$form->addElement('password','frm_newpassword',$msg['filed']['newpassword'], "class='text-input' dir='ltr'");
		$form->addElement('password','frm_repassword',$msg['filed']['repassword'], "class='text-input' dir='ltr'");
		
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();							
}

//###smarty
$smarty->assign('formData', @$formData);
$smarty->assign('popup', 1);
$smarty->assign('hideback', 1);
$smarty->display('admin.tpl');
trace($smarty->_tpl_vars);
die();
?>