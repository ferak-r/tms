<?php
//###fetch information
$id = @intval($_REQUEST['id']);
$popup = @intval($_REQUEST['popup']);
$tplModule = "status-admin.tpl";

//select title2
$sql = "SELECT xtransportcode
		FROM xxtransport
		WHERE xtransportid = '$id'";
$transportcode = $db->getOne($sql);

switch($cmd){
	 case 'update':
		$sql = "DELETE FROM xxtransportstatuscolor WHERE xtransportid='$id'";
		$db->query($sql);
		$statuscolorid = $_POST['frm_statuscolorid'];
		foreach($statuscolorid as $val){
			$sql = "INSERT INTO xxtransportstatuscolor(xtransportid, xstatuscolorid) VALUES($id, $val)";
			$db->query($sql);
		}
		die("<script>window.opener.window.location.reload(); window.close();</script>");		
		break;
	default:
		$sql = "SELECT *
				FROM xxstatuscolor
				NATURAL LEFT JOIN xxcolor";
		$color = $db->getAll($sql);
		
		$sql = "SELECT *
				FROM xxtransportstatuscolor
				WHERE xtransportid='$id'";
		$res = $db->getAll($sql);
		foreach($res as $key=>$val){
			$default[$val['xstatuscolorid']] = 1;
		}
}


//###samarty
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('id', $id);
$smarty->assign_by_ref('list', $list);
$smarty->assign('transportcode', $transportcode);
$smarty->assign('default', @$default);
$smarty->assign('color', $color);
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>