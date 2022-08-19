<?php
//###fetch information
$id = @$_REQUEST['frm_id'];
$transportid = @$_REQUEST['transportid'];
$popup = @intval($_REQUEST['popup']);
$tplModule = "customs-admin.tpl";

switch($cmd){
	case 'update':
		$receiptdate = @$_POST['frm_receiptdate'] ? $_POST['frm_receiptdate'] : NULL;
		//### insert to db
		$sql = "REPLACE INTO xxcustoms
				SET xtransportid 	= '$transportid',
				    xtlno        	= '$_POST[frm_tlno]',
					xtldate        	= '$_POST[frm_tldate]',
					xcotazhno       = '$_POST[frm_cotazhno]',
					xdeclarationno  = '$_POST[frm_declarationno]',
					xdeclarationdate= '$_POST[frm_declarationdate]',
					xbondtypeid	    = '$_POST[frm_bondtypeid]',
					xreceipt	    = '$_POST[frm_receipt]',
					xreceiptdate    = '$receiptdate',
					xinsuranceno    = '$_POST[frm_insuranceno]'";		
		$res = $db->query($sql);
		$customsid = $db->getOne ("SELECT @@IDENTITY");
		
		$field_values = array(
			'xorigincityid' 	 => $_POST['frm_origincityid'], 
			'xdestinationcityid' => $_POST['frm_destinationcityid'],
			'xviaportid'         =>	$_POST['frm_viaportid']);
		$res = $db->autoExecute('xxtransport', $field_values, DB_AUTOQUERY_UPDATE, "xtransportid='$transportid'");

		//update extra weight
		$sql = "SELECT xloadingcontainerid, xtransportcontainerid, xextraweight
				FROM xxequipment
				NATURAL LEFT JOIN xxloading
				NATURAL LEFT JOIN xxtransportpath
				NATURAL LEFT JOIN xxloadingcontainer
				NATURAL LEFT JOIN xxtransportcontainer
				WHERE xtransportid = '$transportid'";
		$res = $db->getAll($sql);
		foreach($res as $key=>$val){
			$extraweight = @$_POST['frm_extraweight'.$val['xloadingcontainerid']];
			if($extraweight != $val['xextraweight']){
				$sql = "UPDATE xxloadingcontainer
						SET xextraweight = '$extraweight'
						WHERE xtransportcontainerid = '$val[xtransportcontainerid]'";
				$res = $db->query($sql);								
			}
		}	
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}else{
			if(!empty($_FILES["frm_tlimage1"]["tmp_name"])){
				@move_uploaded_file($_FILES["frm_tlimage1"]["tmp_name"] ,$config['upload']['tl1'].$transportid);
			}
			if(!empty($_FILES["frm_tlimage2"]["tmp_name"])){
				@move_uploaded_file($_FILES["frm_tlimage2"]["tmp_name"] ,$config['upload']['tl2'].$transportid);
			}
			if(!empty($_FILES["frm_tlimage3"]["tmp_name"])){
				@move_uploaded_file($_FILES["frm_tlimage3"]["tmp_name"] ,$config['upload']['tl3'].$transportid);
			}
			if(!empty($_FILES["frm_tlimage4"]["tmp_name"])){
				@move_uploaded_file($_FILES["frm_tlimage4"]["tmp_name"] ,$config['upload']['tl4'].$transportid);
			}
			if(!empty($_FILES["frm_declarationimage"]["tmp_name"])){
				@move_uploaded_file($_FILES["frm_declarationimage"]["tmp_name"] ,$config['upload']['declaration'].$transportid);
			}		
		}
		if(!$popup){
			redirect("index.php?section=account&module=customs-admin&page=$page&popup=$popup&id=$customsid&transportid=$transportid");
		}else{
			$smarty->assign_by_ref('popup', $popup);
			$smarty->display($tplModule);
			redirect("index.php?section=account&module=customs-admin&page=$page&popup=$popup&id=$customsid&transportid=$transportid");
			die();
		}
		break;
	case 'del_img':
		$dir = @$_GET['declaration'] ? 'declaration' : (@$_GET['img'] ? 'tl'.$_GET['img'] : '');
		@unlink($config['upload'][$dir].$transportid);
		redirect("index.php?section=$section&module=customs-admin&page=$page&frm_id=$id&transportid=$transportid&popup=$popup");

		break;
	default:		
		$bondtype= $db->getList('xxbondtype');
		$city 	 = $db->getList('xxcity');
		$port 	 = $db->getList('xxport');
		$receipt = $db->fetchEnum('xxcustoms', 'xreceipt');
		$sql = "SELECT *
				FROM xxcustoms
				WHERE xtransportid = '$transportid'";
		$default = $db->getRow($sql);
		$sql = "SELECT xorigincityid, xdestinationcityid, xviaportid, xcustomsfinished
				FROM xxtransport
				WHERE xtransportid = '$transportid'";
		if($default){
			$default += $db->getRow($sql);
		}else{
			$default = $db->getRow($sql);
		}
		if(@file_exists($config['upload']['tl1'].$transportid)){
			$default['tl1']	= 1;
		}
		if(@file_exists($config['upload']['tl2'].$transportid)){
			$default['tl2']	= 1;
		}
		if(@file_exists($config['upload']['tl3'].$transportid)){
			$default['tl3']	= 1;
		}
		if(@file_exists($config['upload']['tl4'].$transportid)){
			$default['tl4']	= 1;
		}
		if(@file_exists($config['upload']['declaration'].$transportid)){
			$default['declaration_img'] = 1;
		}		
		//loading list
		$sql = "SELECT *, CONCAT(xequipmentcat, ' ( ', IFNULL(xequipmentno, xequipment), ' )') AS xequipment
				FROM xxequipment
				NATURAL LEFT JOIN xxloading
				NATURAL LEFT JOIN xxtransportpath
				NATURAL LEFT JOIN (
					SELECT xcityid AS xfromcityid, xcity AS xfromcity
					FROM xxcity) AS xxfromcity
				NATURAL LEFT JOIN (
					SELECT xcityid AS xtocityid, xcity AS xtocity
					FROM xxcity) AS xxtocity
				WHERE xtransportid = '$transportid'
				ORDER BY xloadingid";
		$list = $db->getAll($sql);				 
				 
		$sql = "( SELECT xloadingid, xcontainernumber, xloadingcontainerid, xcarrytype,CONCAT( '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'container\',', xcontainerid, ', this);\">', xcontainernumber, '</a>', ' ( ', GROUP_CONCAT( CONCAT( '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'operation\', \'transportcargo\',', xtransportcargoid, ', this);\">', xcommodity, '</a>' ) SEPARATOR ', ' ) , ' )' ) AS xcommodity, SUM(xcargoweight) AS xweight, xextraweight, NULL AS xcargoweight
				  FROM xxequipment
				  NATURAL LEFT JOIN xxloading
				  NATURAL LEFT JOIN xxtransportpath
				  NATURAL LEFT JOIN xxloadingcontainer
				  NATURAL LEFT JOIN xxtransportcontainer
				  NATURAL LEFT JOIN xxtransportcargo
				  LEFT JOIN zzcontainer USING ( xcontainerid )
				  WHERE xcarrytype = 'Container' AND xtransportid = '$transportid'
				  GROUP BY xloadingcontainerid)
				 UNION
				( SELECT xloadingid, xcontainernumber, xloadingcontainerid, xcarrytype, GROUP_CONCAT( CONCAT( '<a href=\"javascript:void(0)\" onclick=\"showDetail(\'operation\', \'transportcargo\',', xtransportcargoid, ', this);\">', xcommodity, '</a>' ) SEPARATOR ', ' ) AS xcommodity, xweight, xextraweight, xcargoweight
				  FROM xxequipment
				  NATURAL LEFT JOIN xxloading
				  NATURAL LEFT JOIN xxtransportpath
				  NATURAL LEFT JOIN xxloadingcontainer
				  NATURAL LEFT JOIN xxtransportcontainer
				  NATURAL LEFT JOIN xxtransportcargo
				  LEFT JOIN zzcontainer USING ( xcontainerid )
				  WHERE xcarrytype = 'Bulk' AND xtransportid = '$transportid'
				  GROUP BY xloadingid)
				 ORDER BY xloadingid";
				 
		$res = $db->getAll($sql);
		$cnt = 0;
		foreach($list as $key=>$val){
			while($val['xloadingid'] == @$res[$cnt]['xloadingid']){
				$list[$key]['load'][] = $res[$cnt];
				$cnt++;
			}
		}
		$sql = "SELECT xtransportcode
				FROM xxtransport
				WHERE xtransportid = '$transportid'";
		$transportcode = $db->getOne($sql);
		
		$smarty->assign_by_ref('bondtype', $bondtype);
		$smarty->assign_by_ref('city', $city);
		$smarty->assign_by_ref('port', $port);
		$smarty->assign('receipt', $receipt);
		$smarty->assign('default', $default);
		$smarty->assign('transportcode', $transportcode);
}


//###samarty
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('list', $list);
$smarty->assign_by_ref('user', $user);
$smarty->assign('transportid', $transportid);
$smarty->assign('formData', @$formData);
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>