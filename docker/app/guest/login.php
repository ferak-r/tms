<?php
$username = @$db->escapeSimple($_POST['username_frm']);
$password = @$db->escapeSimple($_POST['password_frm']);
switch(@$_REQUEST['logincmd']){
	case 'logout':
		if(!$user->logout()){
			msg($msg['Error'], 'error', 'خطا');
		}
		redirect("index.php?section=guest&module=login");
		break;
	case 'login':
		if(!$user->login($username, $password)){
			//$user->logout();
			msg($msg['login']['error'], 'error', 'Error');
		}else{
			if($section=='guest' and $module=='login'){
				redirect('index.php?section=operation&module=transport-list&step=transport');
			}else{
				redirect($href);
			}
		}
}
$tplModule = 'login.tpl';
//### smarty
$smarty->assign('logedin', $user->logedin);
trace($smarty->_tpl_vars, 'global');
?>