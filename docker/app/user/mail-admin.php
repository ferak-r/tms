<?php
//### fetch variable
$userbodyid = @intval($_REQUEST['frm_id']);
$listid = @$_REQUEST['frm_listid']; //delete
$cmd = @$_REQUEST['cmd'];
$step = @$_REQUEST['step'];

switch($cmd){
	case 'download':
		$mail->downloadAttachment($userbodyid);
		break;
	case 'view':
		$sql = "SELECT xuserbodyid
				FROM xxmail_userbody
				WHERE xuserbodyid > $userbodyid AND xusernameid='$user->id' AND xdir='inbox' ORDER BY xuserbodyid ASC LIMIT 1";
		$upid = $db->getOne($sql);
		$sql = "SELECT xuserbodyid
				FROM xxmail_userbody
				WHERE xuserbodyid < $userbodyid AND xusernameid='$user->id' AND xdir='inbox' ORDER BY xuserbodyid DESC LIMIT 1";
		$downid = $db->getOne($sql);		
		$btn = array('replay' => "index.php?section=$section&module=$module&cmd=edit&step=replay&frm_id=$userbodyid",
					'forward' => "index.php?section=$section&module=$module&cmd=edit&step=forward&frm_id=$userbodyid",
					'delete'  => "index.php?section=$section&module=$module&cmd=delete&frm_id=$userbodyid",
					'nav'	  => 1,
					'up'      => ($upid ? "index.php?section=user&module=mail-admin&cmd=view&frm_id=$upid" : '#'),
					'down'    => ($downid ? "index.php?section=user&module=mail-admin&cmd=view&frm_id=$downid" : '#'),
					);
		$list = $mail->view($userbodyid);
		break;
	case 'save':
		if(!$mail->saveToDraft($_POST, @$userbodyid)){
			msg($msg['Error'], 'error', 'Alert');
		}
		redirect("index.php?section=$section&module=mail-list&cmd=draft");
		break;
	case 'send':
		switch($step){
			case 'replay':
				if(!$mail->send($_POST, 1)){
					msg($msg['Error'], 'error', 'Alert');
				}
				redirect("index.php?section=$section&module=mail-list&cmd=sent",true);
				break;
			default: //### send( compose & forward )
				if(!$mail->send($_POST)){
					msg($msg['Error'], 'error', 'Alert');
				}
				redirect("index.php?section=$section&module=mail-list&cmd=sent",true);
		}
		break;
	case 'delete':
		if(!empty($userbodyid)){
			if(!$mail->delete($userbodyid)){
				msg($msg['Error'], 'error', 'Alert');
			}
		}else{
			foreach($listid as $val){
				$mail->delete($val);
			}
		}
		redirect("index.php?section=$section&module=mail-list&cmd=inbox");			
		break;
	case 'edit':
		$btn = array('send'			=> "javascript:sendMail('$step');",//index.php?section=$section&module=$module&cmd=send".(($step=='replay')? "&step=$step" : ""),
					 'delete'		=> "index.php?section=$section&module=$module&cmd=delete&frm_id=$userbodyid",
					 'savetodraft' 	=> "javascript:saveMail('$userbodyid');",//index.php?section=$section&module=$module&cmd=save&frm_id=$userbodyid",
					 );
		switch($step){
			case 'replay':
				$list = $mail->edit($userbodyid, $step);
				break;
			case 'forward':
				// msg with attachment
				$list = $mail->edit($userbodyid, $step);
				break;
			default: //from draft
				$list = $mail->edit($userbodyid);
		}
		break;
	case 'newmail':
		$m = $mail->checkMail($user->id);
		
		foreach($m as $key => $val){
			if($mail->newmail){
				echo "<script>
						msg.display('new mail from $val[xfrom]. <a href=\'index.php?section=user&module=mail-admin&cmd=view&frm_id=$val[xuserbodyid]\'>click here</a>', 'ok', 'New Mail');
					  </script>";
			}
		}
		die();
		break;
	default: //### compose
		$btn = array('send'			=> "javascript:sendMail();",//index.php?section=$section&module=$module&cmd=send",
					 'savetodraft' 	=> "javascript:saveMail();",//index.php?section=$section&module=$module&cmd=save",
					 );
}
$formData = $mail->formdata("index.php?section=$section&module=$module", $cmd, @$list);

$tplModule = "admin.tpl";
//### samrty
$smarty->assign('btn',$btn);
$smarty->assign('btnModule', 'mail-btn.tpl');
$smarty->assign('backurl', "index.php?section=$section&module=mail-list&cmd=inbox");
$smarty->assign('formData', @$formData);
trace($smarty->_tpl_vars, 'global');
?>