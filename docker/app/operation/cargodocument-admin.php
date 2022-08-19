<?php
//###fetch information
$id 		 = @intval($_REQUEST['frm_id']);
$transportid = @intval($_REQUEST['transportid']);
$popup 		 = @intval($_REQUEST['popup']);
$tplModule   = 'cargo-document.tpl';

switch($cmd){
	case 'add':
		//### insert to db
		$fields_values = array( 
							'xloadingid' 	   => $_POST['frm_loadingid'],
							'xdocument2id' 	   => $_POST['frm_document2id'],
							'xdocumentno'      => $_POST['frm_documentno'],
							'xdocumentdate'    => $_POST['frm_documentdate'],
							'xdocumentdate2'   => $_POST['frm_documentdate2'],
							//'xfilename'		   => $_FILES['frm_documentimage']['name'],
							'xisrail'		   => @($_POST['frm_document2id']!=4) ? 0 : 1,
							//'xwgno'		 	   => @$_POST['frm_wgno'],
							//'xsmgsno'		   => @$_POST['frm_smgsno'],
							'xdocumentcomment' => @$_POST['frm_documentcomment'],
							'xdocumenttransportpathid' => @$_POST['frm_documenttransportpathid'],
							);
							//trace($fields_values, 1);		
		$res = $db->autoExecute('xxloadingdocument', $fields_values, DB_AUTOQUERY_INSERT);

		$loadingdocumentid = $db->getOne("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}else{
			mkdir($config['upload']['document2'].$loadingdocumentid);
			foreach($_FILES['frm_img']['tmp_name'] as $key=>$val){
				$imgname = $_FILES['frm_img']['name'][$key];
				if($imgname){
					$sql = "INSERT INTO xxloadingdocumentimg(xloadingdocumentid, xloadingdocumentimg)VALUES('$loadingdocumentid', '$imgname')";
					$db->query($sql);
					$imgid = $db->getOne("SELECT LAST_INSERT_ID()");
					move_uploaded_file($val, $config['upload']['document2'].$loadingdocumentid."/$imgid");
				}
			}		
		}
		redirect("index.php?section=$section&module=cargodocument-admin&transportid=$transportid&popup=$popup&page=$page&refreshparent=doc");
		break;
	 case 'update':
		$fields_values = array( 
							'xloadingid' 	   	=> $_POST['frm_loadingid'],
							'xdocument2id' 	   	=> $_POST['frm_document2id'],
							'xdocumentno'      	=> $_POST['frm_documentno'],
							'xdocumentdate'    	=> $_POST['frm_documentdate'],
							'xdocumentdate2'    => $_POST['frm_documentdate2'],
							'xisrail'			=> @($_POST['frm_document2id']!=4) ? 0 : 1,
							//'xwgno'		 		=> @$_POST['frm_wgno'],
							//'xsmgsno'			=> @$_POST['frm_smgsno'],
							'xdocumentcomment' 	=> @$_POST['frm_documentcomment'],
							'xdocumenttransportpathid' => @$_POST['frm_documenttransportpathid'],
							);
							
/*		if(!empty($_FILES["frm_documentimage"]["tmp_name"])){
			$fields_values['xfilename'] = $_FILES["frm_documentimage"]["name"];
		}*/
		$res = $db->autoExecute('xxloadingdocument', $fields_values, DB_AUTOQUERY_UPDATE, "xloadingdocumentid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		} else {
			if(!is_dir($config['upload']['document2'].$id)){
				mkdir($config['upload']['document2'].$id);
			}
			foreach($_FILES['frm_img']['tmp_name'] as $key=>$val){
				$imgname = $_FILES['frm_img']['name'][$key];
				if($imgname){
					$sql = "INSERT INTO xxloadingdocumentimg(xloadingdocumentid, xloadingdocumentimg)VALUES('$id', '$imgname')";
					$db->query($sql);
					$imgid = $db->getOne("SELECT LAST_INSERT_ID()");
					move_uploaded_file($val, $config['upload']['document2'].$id."/$imgid");
				}
			}		
		}
		redirect("index.php?section=$section&module=cargodocument-admin&frm_id=$id&transportid=$transportid&page=$page&popup=$popup&refreshparent=doc");
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxloadingdocument
				WHERE xloadingdocumentid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		if($popup){
			redirect("index.php?section=$section&module=cargodocument-admin&transportid=$transportid&popup=$popup&refreshparent=doc");
		}else{
			redirect("index.php?section=$section&module=operation-admin&frm_id=$transportid&refreshparent=doc");
		}
		break;
	case 'del_img':
		$folder = @$_GET['folder'];
		@unlink($config['upload']['document2']."$folder/$id");
		$sql = "DELETE FROM xxloadingdocumentimg WHERE xloadingdocumentimgid='$id'";
		$db->query($sql);
		redirect("index.php?section=$section&module=cargodocument-admin&frm_id=$folder&transportid=$transportid&popup=$popup");
		break;
	case 'docoutput':
		$sql = "SELECT *, CONCAT(xfrom, '/', xto)AS xpath,
				CONCAT(xdocument2, '(', xdocumentno, ')') AS xdocument2,
				CONCAT(xcarrier, '(', xequipmentcat, ':', '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'equipment\',', xequipmentid, ', this);\">', IF(xequipmentcat = 'VSL', xequipment, xequipmentno), '</a>', ')')AS xcarrier
				FROM xxloadingdocument
				LEFT JOIN xxdocument2 USING(xdocument2id)
				LEFT JOIN xxloading USING(xloadingid)
				LEFT JOIN xxtransportpath ON(xxloading.xtransportpathid = xxtransportpath.xtransportpathid OR xxloadingdocument.xdocumenttransportpathid = xxtransportpath.xtransportpathid)
				LEFT JOIN xxequipment USING(xequipmentid)
				LEFT JOIN xxcarrier USING(xcarrierid)
				NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom
				NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto
				WHERE xtransportid = '$transportid'";
		$documentlist = $db->getAll($sql);
		
		$smarty->assign('id', $transportid);
		$smarty->assign_by_ref('documentlist', $documentlist);
		$smarty->display('cargo-document-ext.tpl');
		die();
		break;	
	default:			
		$sql = "(
					SELECT c.*, '1-Truck' AS xtruck FROM xxcarrier c 
					NATURAL LEFT JOIN xxequipment
					WHERE xequipmentcat = 'Truck'
					GROUP BY xcarrierid
				) UNION (
					SELECT c.*, '2-VSL' AS xtruck FROM xxcarrier c 
					NATURAL LEFT JOIN xxequipment
					WHERE xequipmentcat = 'VSL'
					GROUP BY xcarrierid
				) UNION (
					SELECT c.*, '3-Others' AS xtruck FROM xxcarrier c 
					NATURAL LEFT JOIN xxequipment
					WHERE xequipmentcat NOT IN ('Truck', 'VSL') OR xequipmentcat IS NULL
					GROUP BY xcarrierid
				)
				ORDER BY xtruck, xcarrier";
		$carrierlist = $db->getAll($sql);
		$sql = "SELECT *, CONCAT(xequipmentcat, '(', IF(xequipmentcat='VSL', xequipment, xequipmentno), ')', '(', xfrom, ' to ', xto, ')')AS xequipment
				FROM xxloading
				NATURAL LEFT JOIN xxtransportpath
				NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom 
				NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto 
				NATURAL LEFT JOIN xxequipment
				NATURAL LEFT JOIN xxcarrier
				WHERE xtransportid = '$transportid'";
		$res = $db->getAll($sql);
		
		foreach($res as $key=>$val){
			$equipmentlist[$val['xequipmentid']] = $val['xequipment'];
		}
		$documents = $db->getList('xxdocument2');
		
		$sql = "SELECT *, CONCAT(xfrom, '/', xto)AS xpath,
				CONCAT(xdocument2, '(', xdocumentno, ')') AS xdocument2,
		  		CONCAT(xcarrier, '(', xequipmentcat, ':', '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'equipment\',', xequipmentid, ', this);\">', IF(xequipmentcat = 'VSL', xequipment, xequipmentno), '</a>', ')')AS xcarrier
				FROM xxloadingdocument
				LEFT JOIN xxdocument2 USING(xdocument2id)
				LEFT JOIN xxloading USING(xloadingid)
				LEFT JOIN xxtransportpath ON(xxloading.xtransportpathid = xxtransportpath.xtransportpathid OR xxloadingdocument.xdocumenttransportpathid = xxtransportpath.xtransportpathid)
				LEFT JOIN xxequipment USING(xequipmentid)
				LEFT JOIN xxcarrier USING(xcarrierid)
				NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom
				NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto
				WHERE xtransportid = '$transportid'";
		$documentlist = $db->getAll($sql);
		
		//select related comments
		$sql = "SELECT xtransportcomment FROM xxtransportcomment
				WHERE xtransportid = '$transportid' AND xcommenttype = 'Cargodoc'";
		$res = $db->getCol($sql);
		$comments = implode("<br>", $res);

		$sql = "SELECT *
				FROM xxloadingdocument
				LEFT JOIN xxdocument2 USING(xdocument2id)
				LEFT JOIN xxloading USING(xloadingid)
				LEFT JOIN xxequipment USING(xequipmentid)
				LEFT JOIN xxcarrier USING(xcarrierid)
				WHERE xloadingdocumentid = '$id'";
		$default = $db->getRow($sql);
		
		$sql = "SELECT *
				FROM xxloadingdocumentimg
				WHERE xloadingdocumentid = '$id'";
		$default['img'] = $db->getAll($sql);
		foreach($default['img'] as $key=>$val){
			$default['img'][$key]['ext'] = strtolower(end(explode('.', $default['img'][$key]['xloadingdocumentimg'])));
		}
			
		$sql = "SELECT *
				FROM xxtransportpath
				NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom
				NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto
				WHERE xtransportid = '$transportid'";
		$pathlist = $db->getAll($sql);

		$smarty->assign_by_ref('carrierlist', $carrierlist);
		$smarty->assign_by_ref('equipmentlist', $equipmentlist);
		$smarty->assign_by_ref('documentlist', $documentlist);
		$smarty->assign_by_ref('pathlist', $pathlist);
		$smarty->assign_by_ref('documents', $documents);
		$smarty->assign_by_ref('documentcomment', $comments);
}

//###samarty
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('list', $list);
$smarty->assign('id', $id);
$smarty->assign('transportid', $transportid);
$smarty->assign('formData', @$formData);
$smarty->assign('default', @$default);

if($popup){
	$smarty->display($tplModule);
	die();
}
?>