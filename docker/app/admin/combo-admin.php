<?PHP

$tplModule = "combo-admin.tpl";

$table    = "xx".$_REQUEST['table'];
$fldid 	  = "x" .$_REQUEST['table']."id";
$fname    = "x" .$_REQUEST['table'];
$oldid = @intval($_REQUEST['frm_oldid']);
$id    = @intval($_REQUEST['frm_id']);
$name 	 = @addslashes(fa_normalize(($_REQUEST['frm_name'])));

$res = null;

switch($cmd){
	case 'add':
			$sql = "INSERT INTO `$table` (`$fldid`, `$fname`)
					VALUES ('$id', '$name')";
			$res = $db->query($sql);
			break;
	case 'update':
			$sql = "UPDATE `$table` SET `$fldid`='$id', `$fname`='$name'
					WHERE `$fldid`='$oldid'";
			$res = $db->query($sql);
			echo "<pre>", print_r($res, 1), "</pre>";
			break;
	case 'delete':
			$sql = "DELETE FROM `$table`
					WHERE `$fldid`='$id'
					LIMIT 1";
			$db->query($sql);
			break;
	case 'combooutput':
			$sql = "INSERT INTO `$table` (`$fname`)
					VALUES ('$name')";
			$res = $db->query($sql);
			$sql = "SELECT `$fldid` AS xid, `$fname` AS xname
					FROM `$table`
					ORDER BY `$fldid` ASC";
			$list =& $db->getAll($sql);
			if(@$_GET['width']){
				$smarty->assign('combowidth', $_GET['width']);
			}
			$smarty->assign_by_ref('list', $list);
			$smarty->display('combo-output.tpl');
			break;
	default:
			$sql = "SELECT `$fldid` AS xid, `$fname` AS xname
					FROM `$table`
					ORDER BY `$fldid` ASC";
			$list =& $db->_getAll($sql);
			$smarty->assign_by_ref('list', $list);
			$smarty->display($tplModule);
			break;
}
if(PEAR::isError($db) or PEAR::isError($res)) {
	echo "<script>alert('Process faild. This code is used.');</script>";
}
$testuser = false;		
die();
?>