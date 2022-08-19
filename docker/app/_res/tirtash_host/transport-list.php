<?php
//### fetch variable
$step = @$_REQUEST['step'];
$transportid= @$_REQUEST['transportid'];
$prefix		= $section."/".$module."/".$step;
$sortBy		= @$_COOKIE[$prefix."_sortby"];
$sortOrder	= @$_COOKIE[$prefix."_order"];
$query		= @$db->escapeSimple($_REQUEST['query']);
$archive	= @$_GET['archive'];

$where = $qobject->makeWhere(@$zcond);
//### sort order
$sortOrder = (@$sortOrder == "asc") ? "ASC" : "DESC" ;

switch($step){
	case 'transport':
		if($archive){
			$where .= " AND xarchive = 1";
			$msg['title1']['transport-list'] = "Project Archive";
		}else{
			$where .= " AND xarchive = 0";
		}
		
		if(!@$user->group['admin']){
			if(@$user->group['document']){
				$where .= " AND ( xdocumentationfinished=0 OR xcargodocumentfinished=0 )";
			}
			if(@$user->group['operation']){
				$where .= " AND xoperationfinished=0";
			}
			if(@$user->group['account&customs']){
				$where .= " AND ( xaccountingfinished=0 OR xcustomsfinished=0 )";
			}
			if(@$user->group['carrier']){
				$where .= " AND xtransportdocumentfinished=0";
			}
		}
		
		//### sort by
		$sortBy = (!empty($sortBy)) ? $sortBy : 'transportid';
		//### paging
		$pagingsql = "SELECT COUNT(*)
					  FROM xxtransport
					  NATURAL LEFT JOIN xxcustoms
					  NATURAL LEFT JOIN (
						SELECT xtransportid, GROUP_CONCAT(xcontainernumber) AS xcontainerno
						FROM xxtransportcontainer
						NATURAL LEFT JOIN zzcontainer
						GROUP BY xtransportid
					  ) AS xxcontainerno
					  WHERE 1 $where";
//@tid=xtransportid,
		$sql = "SELECT xtransportid, GROUP_CONCAT( CONCAT( CAST( xcounter AS CHAR ), '- ', xload ) SEPARATOR '<br>' ) AS xload, xtransportcode, xlaststatus, xdocumentcomment,
				CONCAT( IFNULL( xfromcity, '' ) , '/<br>', IFNULL( xtocity, '' ) ) AS xfromto, xtransporttype, xetaarrivalport, xataarrivalport, xetaexitport, xatdexitport, xrlz, xcustoms, IF( INSTR( xtransportmethod, ',' ), CONCAT( 'Multimodal:', '<br>', xtransportmethod ) , xtransportmethod ) AS xtransportmethod, xcontainerno, xstatuscolor
				FROM xxtransport
				NATURAL LEFT JOIN (
					SELECT xload, IF(IFNULL(@tid,0)=xtransportid, @cnt:=@cnt+1, @cnt:=1) AS xcounter, @tid:=xtransportid, xtransportid
					FROM xxtransportpath
					NATURAL LEFT JOIN xxloading
					NATURAL LEFT JOIN xxequipment
					NATURAL LEFT JOIN (
						SELECT xloadingid, CONCAT( '<a href=\"javascript:void(0)\" onclick=\"showDetail(\'carrier\', \'loading-equipment\',', xloadingid, ', this);\">', IFNULL( xequipmentno, xequipment ), '</a> ( ', xfrom, ' to ', xto, ' ): ', GROUP_CONCAT( CONCAT( IF( xcarrytype = 'Container', CONCAT( '<a href=\"javascript:void(0)\" onclick=\"showDetail(\'operation\', \'transportcontainer\',', xtransportcontainerid, ', this);\">', xcontainernumber, '</a>' ), 'Bulk' ), ' ( ', xcommodity, ' )' ) SEPARATOR ', ') ) AS xload
						FROM xxloading
						NATURAL LEFT JOIN xxtransportpath
						NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfrom
						NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxto
						NATURAL LEFT JOIN xxequipment
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
						GROUP BY xloadingid) AS xxload
					) AS xxtemp
					NATURAL LEFT JOIN (
						SELECT xtransportid, GROUP_CONCAT( xdocumentcomment SEPARATOR '<br>' ) AS xdocumentcomment
						FROM (
						  ( SELECT xtransportid, CONCAT( '<small><span style=\'color: #000033\'>* Transport Document Comments:</span><br>', GROUP_CONCAT(xtransportcomment SEPARATOR '<br>' ), '</small>' ) AS xdocumentcomment
							FROM xxtransportcomment
							WHERE xcommenttype='Transportdoc'
							GROUP BY xtransportid )
						  UNION
						  ( SELECT xtransportid, CONCAT( '<small><span style=\'color: #000033\'>* Cargo Document Comments:</span><br>', GROUP_CONCAT(xtransportcomment SEPARATOR '<br>' ), '</small>' ) AS xdocumentcomment
							FROM xxtransportcomment
							WHERE xcommenttype='Cargodoc'
							GROUP BY xtransportid )
						 ) AS xxcomment
						 GROUP BY xtransportid
					) AS xxgroupcomment
				NATURAL LEFT JOIN (
					SELECT xtransportid, GROUP_CONCAT(xcontainernumber) AS xcontainerno
					FROM xxtransportcontainer
					NATURAL LEFT JOIN zzcontainer
					GROUP BY xtransportid
				) AS xxcontainerno
				NATURAL LEFT JOIN (
					SELECT xtransportid, CONCAT(IFNULL( GROUP_CONCAT(CONCAT('<div class=\'colorbox\' style=\'width:20px; height: 20px; margin-bottom: 1px; border: 1px solid #666; background-color:', xcolornumber, '\' title=\'', xstatus, '\'></div>') SEPARATOR ''), ''), CONCAT('<a href=\'javascript:openNewWindow(\"index.php?section=operation&module=status-admin&popup=1&id=', xtransportid, '\", 400, 200)\'><small style=\'white-space: nowrap\'>Set Status</small></a>')) AS xstatuscolor
					FROM xxtransport
					NATURAL LEFT JOIN xxtransportstatuscolor 
					NATURAL LEFT JOIN xxstatuscolor
					NATURAL LEFT JOIN xxcolor
					GROUP BY xtransportid
				) AS xxstatuscolor

				NATURAL LEFT JOIN (
					SELECT xcityid AS xfromcityid, xcity AS xfromcity
					FROM xxcity) AS xxfromcity
				NATURAL LEFT JOIN (
					SELECT xcityid AS xtocityid, xcity AS xtocity
					FROM xxcity) AS xxtocity
				NATURAL LEFT JOIN xxcustoms
				WHERE 1 $where
				GROUP BY xtransportid
				ORDER BY x$sortBy $sortOrder";		
		$btn = array('edit','delete');
		$col[] = array('<center>{xstatuscolor}</center>', '5%', 'status', '');
		$col[] = array('<a href="javascript:void(0)" onclick="showDetail(\'operation\', \'transport\', \'{xtransportid}\', this);">{xtransportcode}</a>', '5%', 'projectnumber', 'transportcode');
		$col[] = array('{xfromto}', '5%', 'fromto', 'fromto');
		$col[] = array('{xtransportmethod}', '5%', 'transportmethod', 'transportmethod');
		$col[] = array('<div style="font-size: 10px">
							ETA <small>(Arrival Port)</small>: {xetaarrivalport} <br>
							ARV Notice: {xataarrivalport}<br>
							ETA <small>(Exit Port)</small>: {xetaexitport} <br>
							ATD <small>(Exit Port)</small>: {xatdexitport}<br>
							RLZ: {xrlz}<br>
							Customs: {xcustoms}<br>
						</div>', '16%', 'dates', '');
		$col[] = array('{xload}', '40%', 'loading', '');
		$col[] = array('{xdocumentcomment}', '15%', 'documentcomment', '');
		$col[] = array('{xlaststatus}', '15%', 'laststatus', '');
		
		$transporttype 	 = $db->fetchEnum('xxtransport', 'xtransporttype');
		$transportmethod = $db->fetchSet('xxtransport', 'xtransportmethod');
		$customer = $db->getList('xxcustomer', 'concat(xname, " ", xfamily)', '', 'xname');
		$office = $db->getList('xxoffice', 'xoffice', '', 'xoffice');
		$carrier = $db->getList('xxcarrier', 'xcarrier', '', 'xcarrier');
		$port = $db->getList('xxport', '', '', 'xport');
		$city = $db->getList('xxcity', '', '', 'xcity');
		
		//get different sections status
		$sql2 = "SELECT xtransportid
				FROM xxtransport
				NATURAL LEFT JOIN (
					SELECT xtransportid, COUNT(*) AS xcontainercount
		 			FROM xxtransportcontainer
		 			WHERE xcarrytype='Container' AND xreached!='Yes'
		 			GROUP BY xtransportid
				) AS xxtemp
				WHERE xcontainercount IS NULL";
		$res = $db->getCol($sql2);
		foreach($res as $val){
			$finished['container']["tr$val"] = 1;
		}
		
		$parts = array("cargodocument", "transportdocument", "accounting", "customs", "operation", "documentation");
		foreach($parts as $val){
			$sql2 = "SELECT xtransportid
					 FROM xxtransport
					 WHERE x{$val}finished = '1'";
			$res = $db->getCol($sql2);
			foreach($res as $val2){
				$finished[$val]["tr$val2"] = 1;
			}			
		}
		
		$smarty->assign('transporttype', $transporttype);
		$smarty->assign('transportmethod', $transportmethod);
		$smarty->assign_by_ref('customer', $customer);
		$smarty->assign_by_ref('office', $office);
		$smarty->assign_by_ref('carrier', $carrier);
		$smarty->assign_by_ref('port', $port);
		$smarty->assign_by_ref('city', $city);
		$smarty->assign_by_ref('finished', $finished);
	
		$rowsetfield = 'xtransportid';
		break;
	case 'document':
		$sql = "SELECT xtransportcode FROM xxtransport WHERE xtransportid = '$transportid'";
		$code = $db->getOne($sql);
		$msg['title2']['transport-list'] = "Documents for transport: $code";
		//### sort by
		$sortBy = (!empty($sortBy)) ? $sortBy : 'date';
		//### paging
		$pagingsql = "SELECT COUNT(*)
					  FROM xxtransportdocument
					  WHERE xtransportid = '$transportid' AND xoldtransportdocumentid IS NULL $where";
		$sql = "SELECT *
				FROM xxtransportdocument
				NATURAL LEFT JOIN xxdocument
				WHERE xtransportid = '$transportid' AND xoldtransportdocumentid IS NULL $where
				ORDER BY x$sortBy $sortOrder";

		$btn = array('edit','delete');
		$col[] = array('{xdocument}', '80%', 'document', 'document');
		$col[] = array('{xdocumentdate}', '20%', 'date', 'date');
		
		$rowsetfield = 'xtransportdocumentid';
		break;
}

$user->manageAction('add', 'admin', 'importdb', 'import');

//### paging
$maxpage = $db->getone($pagingsql);
$maxpage = empty($maxpage) ? 1 : ceil($maxpage/$config['page']);
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $config['page'];

//get list
$db->query($sql." limit $page, $config[page]");
$list = $db->getAll($sql." limit $page, $config[page]");

//### row set
$rowset->reset($list, $rowsetfield, @$prefix, $sortBy, $sortOrder, "sortASC", "sortDESC", $btn, true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$smarty->assign('dataset', $rowset->renderDataset());

$tplModule = "list.tpl";
//###samarty
$smarty->assign_by_ref('sortBy', $sortBy);
$smarty->assign_by_ref('sortOrder', $sortOrder);
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
$smarty->assign_by_ref('list', $list);
//$smarty->debugging = true;
trace($smarty->_tpl_vars);
?>