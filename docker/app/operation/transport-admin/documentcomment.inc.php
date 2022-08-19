<?php
$commenttype = @$_GET['type'];
switch($cmd){
	case 'add':
		
		//### insert to db
		$fields_values = array( 
							'xtransportcomment'	=> $_POST['frm_transportcomment'],
							'xtransportid'		=> $transportid,
							'xcommenttype'		=> $commenttype
							);
		$res = $db->autoExecute('xxtransportcomment', $fields_values, DB_AUTOQUERY_INSERT);
		$fields_values['xtransportcommentid'] = $db->getOne ("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=transport-admin&page=$page&step=$step&transportid=$transportid&popup=$popup&type=$commenttype");
		break;
	 case 'update':
		$fields_values = array( 
							'xtransportcomment'	=> $_POST['frm_transportcomment'],
							'xtransportid'				=> $transportid
							);
		$res = $db->autoExecute('xxtransportcomment', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportcommentid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=transport-admin&page=$page&step=$step&transportid=$transportid&popup=$popup&type=$commenttype");
		break;
	case 'delete':
		$sql = "DELETE
				FROM xxtransportcomment
				WHERE xtransportcommentid = '$id'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=transport-admin&step=$step&transportid=$transportid&popup=$popup&type=$commenttype");
		break;				
	default:
		if($id){
			$sql = "SELECT *
					FROM xxtransportcomment
					WHERE xtransportcommentid = '$id'";
			$default = $db->getRow($sql);
		}
		$sql = "SELECT * 
				FROM xxtransportcomment
				WHERE xtransportid = '$transportid' AND xcommenttype='$commenttype'";
		$commentlist = $db->getAll($sql);
		$smarty->assign_by_ref('commentlist', $commentlist);
		$tplModule = "transport-document-comment.tpl";
}
?>
