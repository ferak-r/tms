<?php
//###fetch information
$id 	   	 = @$_REQUEST['frm_id'];
$step		 = @$_REQUEST['step'];
$transportid = @$_REQUEST['transportid'];
$pathid		 = @$_REQUEST['pathid'];
$popup 	     = @intval($_REQUEST['popup']);

switch($step){
	case 'path':
		$tplModule = 'transport-path.tpl';
		switch($cmd){
			case 'add':		
				$fields_values = array( 
									'xtransportid' => $transportid,
									'xfromcityid'  => $_POST['frm_fromcityid'],
									'xtocityid'	   => $_POST['frm_tocityid']
									);
				$res 	= $db->autoExecute('xxtransportpath', $fields_values, DB_AUTOQUERY_INSERT);
				$pathid = $db->getOne ("SELECT @@IDENTITY");
				if (DB::isError($res)) {
					msg($msg['Error'], 'error', 'Error');
				}
				redirect("index.php?section=$section&module=loading-admin&step=loading&transportid=$transportid&pathid=$pathid&page=$page&popup=$popup&refreshparent=path");
				break;
			 case 'update':
				$fields_values = array( 
									'xtransportid' => $transportid,
									'xfromcityid'  => $_POST['frm_fromcityid'],
									'xtocityid'    => $_POST['frm_tocityid']
									);
				$res = $db->autoExecute('xxtransportpath', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportpathid='$id'");
				if(PEAR::isError($res)){
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				}
				redirect("index.php?section=$section&module=loading-admin&step=loading&pathid=$id&transportid=$transportid&page=$page&popup=$popup&refreshparent=path");
				break;
			case 'delete':
				$id = is_array($id) ? implode(',', $id) : $id;
				$sql = "DELETE FROM xxloadingcontainer WHERE xloadingid IN (SELECT xloadingid 
																			FROM xxloading
																			WHERE xtransportpathid IN ($id))";
				$res = $db->query($sql);
				$sql = "DELETE
						FROM xxloading
						WHERE xtransportpathid IN ($id)";
				$res = $db->query($sql);
		
				$sql = "DELETE
						FROM xxtransportpath
						WHERE xtransportpathid IN ($id)";
				$res = $db->query($sql);
			
				if(PEAR::isError($res)){
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				}
				if($popup){
					redirect("index.php?section=$section&module=loading-admin&step=path&transportid=$transportid&page=$page&popup=$popup&refreshparent=path");
				}else{
					redirect("index.php?section=operation&module=operation-admin&frm_id=$transportid&refreshparent=path");
				}
				break;
			case 'pathoutput':			
				$sql = "SELECT *
						FROM xxtransportpath
						NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom
						NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto
						WHERE xtransportid = '$transportid'";
				$pathlist = $db->getAll($sql);
				$smarty->assign('id', $transportid);
				$smarty->assign_by_ref('pathlist', $pathlist);
				$smarty->display('transport-path-ext.tpl');
				die();			
			default:
				$sql = "SELECT *
						FROM xxtransportpath
						NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom
						NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto
						WHERE xtransportid = '$transportid'";
				$pathlist = $db->getAll($sql);
				
				if($id){
					$sql = "SELECT xfromcityid, xtocityid
							FROM xxtransportpath
							WHERE xtransportpathid = '$id'";
					$default = $db->getRow($sql);
				}
				$city = $db->getList('xxcity', '', '', 'xcity');
				$smarty->assign_by_ref('city', $city);
				$smarty->assign_by_ref('pathlist', $pathlist);
				
		}
		break;
	case 'loading':
		$tplModule = 'loading.tpl';
		switch($cmd){
			case 'add':
				if($_POST['frm_container'] || $_POST['frm_bulk']){
					$fields_values = array( 
										'xtransportpathid'   => $pathid,
										'xequipmentid'		 => @$_POST['frm_equipmentid'],
										'xloadingdate'		 => $_POST['frm_loadingdate'],
										'xpenalty'			 => $_POST['frm_penalty'],
										'xcarrierstartdate'  => $_POST['frm_carrierstartdate']  ? $_POST['frm_carrierstartdate']  : NULL,
										'xcarrierfreetime'   => $_POST['frm_carrierfreetime'],
										'xatdarrivalport' 	 => $_POST['frm_atdarrivalport'] ? $_POST['frm_atdarrivalport'] : NULL,
										'xetaarrivalport' 	 => $_POST['frm_etaarrivalport'] ? $_POST['frm_etaarrivalport'] : NULL,
										'xatdexitport' 		 => $_POST['frm_atdexitport'] ? $_POST['frm_atdexitport'] : NULL,
										'xetaexitport' 		 => $_POST['frm_etaexitport'] ? $_POST['frm_etaexitport'] : NULL,
										'xatddestination' 	 => $_POST['frm_atddestination'] ? $_POST['frm_atddestination'] : NULL,
										'xetadestination' 	 => $_POST['frm_etadestination'] ? $_POST['frm_etadestination'] : NULL,
										'xlaststatus'		 => @$_POST['frm_laststatus'],
										'xisrail'		 	 => @intval($_POST['frm_israil']),
										//'xwgno'		 		 => @$_POST['frm_wgno'],
										//'xsmgsno'			 => @$_POST['frm_smgsno'],
										'xrailcodedate'		 => @$_POST['frm_railcodedate']
										);
					if(@$_POST['frm_israil']) {
						$sql = "SELECT xequipmentid 
								FROM xxequipment
								WHERE xequipmentno LIKE '$_POST[frm_wgno]'";
						$equipmentid = $db->getOne($sql);
						if($equipmentid){
							$fields_values['xequipmentid'] = $equipmentid;
						}else{
							$sql = "INSERT INTO xxequipment(xcarrierid, xequipmentcat, xequipmentno) VALUES('$_POST[frm_carrierid]', 'Rail', '$_POST[frm_wgno]')";
							$res = $db->query($sql);
							$fields_values['xequipmentid'] = $db->getOne ("SELECT @@IDENTITY");	 
						}
					}
										
										
					$res 	= $db->autoExecute('xxloading', $fields_values, DB_AUTOQUERY_INSERT);
					$loadingid = $db->getOne ("SELECT @@IDENTITY");	
			
					$container = $_POST['frm_container'];
					foreach($container as $val){
						//### insert to db
						$fields_values = array(
											'xloadingid'			=> $loadingid,
											'xtransportcontainerid'	=> $val,
											'xextraweight'			=> $_POST["frm_extraweight$val"]
											);
						$res = $db->autoExecute('xxloadingcontainer', $fields_values, DB_AUTOQUERY_INSERT);
					}
					$bulk = $_POST['frm_bulk'];
					foreach($bulk as $val){
						//### insert to db
						$fields_values = array(
											'xloadingid'			=> $loadingid,
											'xtransportcontainerid'	=> $val,
											'xweight'				=> $_POST["frm_weight$val"],
											);
						$res = $db->autoExecute('xxloadingcontainer', $fields_values, DB_AUTOQUERY_INSERT);
						$res = $db->autoExecute('xxloadingcontainer', array('xextraweight' => $_POST["frm_extraweight$val"]), DB_AUTOQUERY_UPDATE, "xtransportcontainerid = '$val'");
					}
				}
				if (DB::isError($res)) {
					msg($msg['Error'], 'error', 'Error');
				}
				redirect("index.php?section=$section&module=loading-admin&step=loading&transportid=$transportid&pathid=$pathid&page=$page&popup=$popup&refreshparent=1");
				break;
			 case 'update':
			 	if($_POST['frm_container'] || $_POST['frm_bulk']){
					$sql = "DELETE FROM xxloadingcontainer WHERE xloadingid = '$id'";
					$res = $db->query($sql);
				
					$fields_values = array( 
										'xtransportpathid'   => $pathid,
										'xequipmentid'		 => $_POST['frm_equipmentid'],
										'xloadingdate'		 => $_POST['frm_loadingdate'],
										'xpenalty'			 => $_POST['frm_penalty'],
										'xcarrierstartdate'  => $_POST['frm_carrierstartdate']  ? $_POST['frm_carrierstartdate']  : NULL,
										'xcarrierfreetime' 	 => $_POST['frm_carrierfreetime'],
										'xatdarrivalport' 	 => $_POST['frm_atdarrivalport'] ? $_POST['frm_atdarrivalport'] : NULL,
										'xetaarrivalport' 	 => $_POST['frm_etaarrivalport'] ? $_POST['frm_etaarrivalport'] : NULL,
										'xatdexitport' 		 => $_POST['frm_atdexitport'] ? $_POST['frm_atdexitport'] : NULL,
										'xetaexitport' 		 => $_POST['frm_etaexitport'] ? $_POST['frm_etaexitport'] : NULL,
										'xatddestination' 	 => $_POST['frm_atddestination'] ? $_POST['frm_atddestination'] : NULL,
										'xetadestination' 	 => $_POST['frm_etadestination'] ? $_POST['frm_etadestination'] : NULL,
										'xlaststatus'		 => @$_POST['frm_laststatus'],
										'xisrail'		 	 => @$_POST['frm_israil'],
										//'xwgno'		 		 => @$_POST['frm_wgno'],
										//'xsmgsno'			 => @$_POST['frm_smgsno'],
										'xrailcodedate'		 => @$_POST['frm_railcodedate']
										);
					if(@$_POST['frm_israil']) {
						$sql = "SELECT xequipmentid 
								FROM xxequipment
								WHERE xequipmentno LIKE '$_POST[frm_wgno]'";
						$equipmentid = $db->getOne($sql);
						if($equipmentid){
							$fields_values['xequipmentid'] = $equipmentid;
						}else{
							$sql = "INSERT INTO xxequipment(xcarrierid, xequipmentcat, xequipmentno) VALUES('$_POST[frm_carrierid]', 'Rail', '$_POST[frm_wgno]')";
							$res = $db->query($sql);
							$fields_values['xequipmentid'] = $db->getOne ("SELECT @@IDENTITY");	 
						}
					}
	
					$res = $db->autoExecute('xxloading', $fields_values, DB_AUTOQUERY_UPDATE, "xloadingid='$id'");
					$container = $_POST['frm_container'];
					if($container){
						foreach($container as $val){
							//### insert to db
							$fields_values = array(
												'xloadingid'			=> $id,
												'xtransportcontainerid' => $val,
												'xextraweight'			=> $_POST["frm_extraweight$val"]
												);
							$res = $db->autoExecute('xxloadingcontainer', $fields_values, DB_AUTOQUERY_INSERT);
						}
					}
					$bulk = $_POST['frm_bulk'];
					if($bulk){
						foreach($bulk as $val){
							//### insert to db
							$fields_values = array(
												'xloadingid'			=> $id,
												'xtransportcontainerid' => $val,
												'xweight'				=> $_POST["frm_weight$val"],
												);
							$res = $db->autoExecute('xxloadingcontainer', $fields_values, DB_AUTOQUERY_INSERT);
							$res = $db->autoExecute('xxloadingcontainer', array('xextraweight' => $_POST["frm_extraweight$val"]), DB_AUTOQUERY_UPDATE, "xtransportcontainerid = '$val'");
						}
					}
				}
				if(PEAR::isError($res)){
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				}
				redirect("index.php?section=$section&module=loading-admin&step=loading&frm_id=$id&transportid=$transportid&pathid=$pathid&page=$page&popup=$popup&refreshparent=1");
				break;
			case 'delete':
				$id = is_array($id) ? implode(',', $id) : $id;
				$sql = "DELETE FROM xxloadingcontainer WHERE xloadingid IN ($id)";
				$res = $db->query($sql);
				$sql = "DELETE
						FROM xxloading
						WHERE xloadingid IN ($id)";
				$res = $db->query($sql);
		
				if(PEAR::isError($res)){
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				}
				if($popup){
					redirect("index.php?section=$section&module=loading-admin&step=loading&transportid=$transportid&pathid=$pathid&page=$page&popup=$popup");
				}else{
					redirect("index.php?section=operation&module=operation-admin&frm_id=$transportid");
				}
				break;
			default:
				$penalty = $db->fetchEnum('xxloading', 'xpenalty');			
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
								
				if($id){
					$where = "AND (xloadingid is NULL OR xloadingid = $id)";
				}else{
					$where = "AND xloadingid is NULL";
				}
				$sql = "SELECT *, IFNULL(CONCAT( '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'container\',', xcontainerid, ', this);\">', xcontainernumber, '</a>', ' (', GROUP_CONCAT( CONCAT( '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'operation\', \'transportcargo\',', xtransportcargoid, ', this);\">', xcommodity , '</a>') SEPARATOR ', ' ) , ')'), CONCAT( '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'container\',', xcontainerid, ', this);\">', xcontainernumber, '</a>')) AS xcommodity,
						SUM(xcargoweight) AS xcargoweight
						FROM xxtransportcontainer
						NATURAL LEFT JOIN zzcontainer
						NATURAL LEFT JOIN xxtransportcargo
						NATURAL LEFT JOIN (
							SELECT xtransportcontainerid, xloadingid
							FROM xxloading
							NATURAL LEFT JOIN xxloadingcontainer
							WHERE xtransportpathid = '$pathid'
						) AS xxtemp
						NATURAL LEFT JOIN xxcontainersize
						NATURAL LEFT JOIN xxcontainertype
						WHERE xcarrytype = 'Container' AND xtransportid = '$transportid' $where
						GROUP BY xtransportcontainerid";
				$containerlist = $db->getAll($sql);
		
		
				if(!$id){
					$having = "HAVING  xunloadedcargoweight > 0";
					$where = "";
				}else{
					$having = "HAVING ( ( xloadingid IS NULL AND xunloadedcargoweight > 0 ) OR xloadingid = '$id')";
					$where = "AND xloadingid = '$id'";
				}
				
				$sql = "SELECT * , IF( xloadedweight, xcargoweight - xloadedweight, xcargoweight ) AS xunloadedcargoweight,
						CONCAT( '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'operation\', \'transportcargo\',', xtransportcargoid, ', this);\">', xcommodity, '</a>') AS xcommodity
						FROM xxtransportcontainer
						NATURAL LEFT JOIN zzcontainer
						NATURAL LEFT JOIN xxtransportcargo
						NATURAL LEFT JOIN (
							SELECT xtransportcontainerid, xloadingid, xextraweight
							FROM xxloading
							NATURAL LEFT JOIN xxloadingcontainer
							WHERE xtransportpathid = '$pathid' $where) AS xxtemp
						LEFT JOIN (				
							SELECT SUM( xweight ) AS xloadedweight, xtransportcontainerid
							FROM xxloading
							NATURAL LEFT JOIN xxloadingcontainer
							WHERE xtransportpathid = '$pathid'
							GROUP BY xtransportcontainerid) AS xxsum
						USING ( xtransportcontainerid )
						WHERE xtransportid = '$transportid' AND xcarrytype = 'Bulk' 
						GROUP BY xtransportcontainerid
						$having";
				$bulklist = $db->getAll($sql);
				foreach($bulklist as $key => $val){
					$default[$val['xtransportcontainerid']]['extraweight'] = $val['xextraweight'];
				}		
				


				$sql = "SELECT *, xxcarrier.xcarrier, CONCAT(xequipmentcat, '(', '<a href=\'javascript:void(0)\' onclick=\"showDetail(\'admin\', \'equipment\',', xequipmentid, ', this);\">', IF(xequipmentcat='VSL', xequipment, xequipmentno), '</a>', ')')AS xequipment,
						GROUP_CONCAT( CONCAT( IF( xcarrytype = 'Container', CONCAT( '<a href=\"javascript:void(0)\" onclick=\"showDetail(\'operation\', \'transportcontainer\',', xtransportcontainerid, ', this);\">', xcontainernumber, '</a>' ), 'Bulk' ), ' ( ', xcommodity, ' )' ) SEPARATOR ', ') AS xcommodity
						FROM xxloading
						NATURAL LEFT JOIN xxequipment
						NATURAL LEFT JOIN xxcarrier
						NATURAL LEFT JOIN xxloadingcontainer
						NATURAL LEFT JOIN xxtransportcontainer
						LEFT JOIN zzcontainer USING ( xcontainerid )
						NATURAL LEFT JOIN (
							( SELECT xloadingcontainerid, GROUP_CONCAT( CONCAT( '<a href=\"javascript:void(0)\" onclick=\"showDetail(\'operation\', \'transportcargo\',', xtransportcargoid, ', this);\">', xcommodity, '</a>' ) SEPARATOR ', ' ) AS xcommodity
							  FROM xxtransportcargo
							  NATURAL LEFT JOIN xxtransportcontainer
							  NATURAL LEFT JOIN xxloadingcontainer
							  WHERE xcarrytype = 'Container'
							  GROUP BY xloadingcontainerid)
							 UNION
							 ( SELECT xloadingcontainerid, GROUP_CONCAT( CONCAT( '<a href=\"javascript:void(0)\" onclick=\"showDetail(\'operation\', \'transportcargo\',', xtransportcargoid, ', this);\">', xcommodity, '<small> (', CAST( xweight AS CHAR ), ' kg )</small></a>' ) SEPARATOR ', ' ) AS xcommodity
							   FROM xxtransportcargo
							   NATURAL LEFT JOIN xxtransportcontainer
							   NATURAL LEFT JOIN xxloadingcontainer
							   WHERE xcarrytype = 'Bulk'
							   GROUP BY xloadingid)
							) AS xxcommodity
						WHERE xtransportid = '$transportid' AND xtransportpathid = '$pathid'
						GROUP BY xloadingid";	


				$loadinglist = $db->getAll($sql);
				
				$sql = "SELECT *
						FROM xxtransportpath
						NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom
						NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto
						WHERE xtransportpathid = '$pathid' AND xtransportid = '$transportid'";
				$r = $db->getRow($sql);
				$smarty->assign('from', $r['xfrom']);
				$smarty->assign('to', $r['xto']);
								
				if($id){
					$sql = "SELECT *
							FROM xxloading
							NATURAL LEFT JOIN xxloadingcontainer
							NATURAL LEFT JOIN xxequipment
							NATURAL LEFT JOIN xxcarrier
							WHERE xloadingid = '$id'";
					$res = $db->getAll($sql);
					foreach($res as $key => $val){
						$default[$val['xtransportcontainerid']]['containerid'] = $val['xtransportcontainerid'];
						$default[$val['xtransportcontainerid']]['weight'] 	   = $val['xweight'];
						$default[$val['xtransportcontainerid']]['extraweight'] = $val['xextraweight'];					
					}
					$sql = "SELECT *, xpenalty+0 AS xpenalty
							FROM xxloading
							NATURAL LEFT JOIN xxequipment
							NATURAL LEFT JOIN xxcarrier
							WHERE xloadingid = '$id'";
					$default += $db->getRow($sql);
				}else{
					$sql = "SELECT *, xpenalty+0 AS xpenalty
							FROM xxtransport
							WHERE xtransportid = '$transportid'";
					$default = $db->getRow($sql);
					unset($default['xlaststatus']);
				}
				
				$backurl = "index.php?section=carrier&module=loading-admin&step=path&transportid=$transportid&popup=$popup";
				
				$smarty->assign_by_ref('carrierlist', $carrierlist);
				$smarty->assign_by_ref('containerlist', $containerlist);
				$smarty->assign_by_ref('bulklist', $bulklist);
				$smarty->assign_by_ref('loadinglist', $loadinglist);
				$smarty->assign('penalty', $penalty);
		}
		break;
}

//###samarty
$smarty->assign('extModule', @$extModule);
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('list', $list);
$smarty->assign_by_ref('default', @$default);
$smarty->assign('backurl', @$backurl);
$smarty->assign('formData', @$formData);
$smarty->assign('id', @$id);
$smarty->assign('transportid', $transportid);
$smarty->assign('pathid', $pathid);
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>