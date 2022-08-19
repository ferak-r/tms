<?php
//###fetch information
$id 	    	= @$_REQUEST['frm_id'];
$reminderid 	= @$_REQUEST['reminderid'];
$reminderindex  = @$_REQUEST['reminderindex'];
$popup 	    	= @intval($_REQUEST['popup']);
$tplModule  	= "reminder-admin.tpl";

switch($cmd){
	case 'add':
		//### insert to db
		$fields_values = array( 
							'xreminder' 		=> $_POST['frm_reminder'],
							'xusernameid' 		=> $user->id,
							'xreminderdate' 	=> $_POST['frm_reminderdate'] ? $_POST['frm_reminderdate'] : NULL,
							'xreminderhour' 	=> $_POST['frm_reminderhour'],
							'xreminderminute' 	=> $_POST['frm_reminderminute'],
							'xremindertimestamp'=> floor($_POST['frm_remindertimestamp'] / 10000)
							);
		$res = $db->autoExecute('xxreminder', $fields_values, DB_AUTOQUERY_INSERT);
		$fields_values['xreminderid'] = $db->getOne ("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=reminder-list&page=$page");					
		break;
	 case 'update':
		$fields_values = array( 
							'xreminder' 		=> $_POST['frm_reminder'],
							'xusernameid' 		=> $user->id,
							'xreminderdate' 	=> $_POST['frm_reminderdate'] ? $_POST['frm_reminderdate'] : NULL,
							'xreminderhour' 	=> $_POST['frm_reminderhour'],
							'xreminderminute' 	=> $_POST['frm_reminderminute'],
							'xremindertimestamp'=> floor($_POST['frm_remindertimestamp'] / 10000),
							'xreminderview'		=> '0'
							);
		$res = $db->autoExecute('xxreminder', $fields_values, DB_AUTOQUERY_UPDATE, "xreminderid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=reminder-admin&page=$page&frm_id=$id");
		break;
	case 'alert':		
		$sql = "SELECT *
				FROM xxreminder
				WHERE xreminderid = '$reminderid' AND xusernameid = '$user->id'";
		$reminder = $db->getRow($sql);
		$reminder['xreminder'] = addslashes( $reminder['xreminder'] );
		if($reminder && $reminder['view'] != 1){
			echo "<script>
			      	msg.reminder('$reminder[xreminder] ($reminder[xreminderdate] $reminder[xreminderhour]:$reminder[xreminderminute])', $reminderid, $reminderindex);
				  </script>";
		
			$sql = "UPDATE xxreminder
					SET xreminderview = 1
					WHERE xusernameid = '$user->id'";
			$res = $db->query($sql);		
		}
		die();
		break;
	case 'postpone':
		$sql = "SELECT xremindertimestamp
				FROM xxreminder
				WHERE xreminderid='$reminderid' AND xusernameid='$user->id'";
		$timestamp = $db->getOne($sql);
		$fields_values = array( 
							'xreminderdate' 	=> $_GET['newdate'],
							'xreminderhour' 	=> $_GET['newhour'],
							'xreminderminute' 	=> $_GET['newminute'],
							'xremindertimestamp'=> $_GET['newtimestamp'],
							'xreminderview'		=> '0'
							);
		$res = $db->autoExecute('xxreminder', $fields_values, DB_AUTOQUERY_UPDATE, "xreminderid='$reminderid' AND xusernameid='$user->id'");

		echo "<script>
				reminder[$reminderindex]['time'] = $_GET[newtimestamp];
				reminder[$reminderindex]['view'] = 0;
			  </script>";

		die();
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxreminder
				WHERE xreminderid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=reminder-list");
		break;
	default:
		if($id){
			$sql = "SELECT *
					FROM xxreminder
					WHERE xreminderid = '$id'";
			$list = $db->getRow($sql);
		}else{
			$list['xreminderdate'] = date("Y-m-d");
		}
		for($i=1;$i<=24;$i++){
			$hour[$i] = sprintf("%02d", $i);
		}
		for($i=0;$i<=59;$i++){
			$minute[$i] = sprintf("%02d", $i);
		}
		$smarty->assign('hour', $hour);
		$smarty->assign('minute', $minute);
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