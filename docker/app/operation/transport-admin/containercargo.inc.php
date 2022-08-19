<?php
switch($cmd){
	case 'add':
		//### insert to db
		$fields_values = array( 
							'xtransportcontainerid' => @$containerid ? $containerid : NULL,
							'xcommodity'			=> $_POST['frm_commodity'],
							'xcargokind'			=> $_POST['frm_cargokind'],
							'xcargosize'			=> $_POST['frm_cargosize'],
							'xcargodanger'			=> $_POST['frm_cargodanger'],
							'ximo'					=> intval($_POST['frm_imo']),
							'xcargoweight'			=> intval($_POST['frm_cargoweight']),
							'xcargovolume'			=> intval($_POST['frm_cargovolume']),
							'xcargodescription'		=> $_POST['frm_cargodescription'],
							'xpackagetypeid'		=> $_POST['frm_packagetypeid'],
							'xpackagenumber'		=> intval($_POST['frm_packagenumber']),
							'xcargodimension'		=> $_POST['frm_cargodimension']
							);
		$res = $db->autoExecute('xxtransportcargo', $fields_values, DB_AUTOQUERY_INSERT);
		$fields_values['xtransportcargoid'] = $db->getOne ("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=transport-admin&page=$page&step=$step&transportid=$transportid&containerid=$containerid&popup=$popup&loadformvalues=$_GET[loadformvalues]&refreshparent=cargo");
		break;
	case 'update':
		$fields_values = array( 
							'xcommodity'			=> $_POST['frm_commodity'],
							'xcargokind'			=> $_POST['frm_cargokind'],
							'xcargosize'			=> $_POST['frm_cargosize'],
							'xcargodanger'			=> $_POST['frm_cargodanger'],
							'ximo'					=> $_POST['frm_imo'],
							'xcargoweight'			=> $_POST['frm_cargoweight'],
							'xcargovolume'			=> $_POST['frm_cargovolume'],
							'xcargodescription'		=> $_POST['frm_cargodescription'],
							'xpackagetypeid'		=> $_POST['frm_packagetypeid'],
							'xpackagenumber'		=> intval($_POST['frm_packagenumber']),
							'xcargodimension'		=> $_POST['frm_cargodimension']
							);
		$res = $db->autoExecute('xxtransportcargo', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportcargoid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=transport-admin&page=$page&frm_id=$id&step=$step&transportid=$transportid&containerid=$containerid&popup=$popup&loadformvalues=$_GET[loadformvalues]&refreshparent=cargo");
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxtransportcargo
				WHERE xtransportcargoid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=transport-admin&step=containercargo&transportid=$transportid&containerid=$containerid&popup=$popup");
		break;
	default:	
		$tplModule = "transport-container-cargo.tpl";
		$smarty->assign('cargokind', $db->fetchEnum('xxtransportcargo', 'xcargokind'));
		$smarty->assign('cargosize', $db->fetchEnum('xxtransportcargo', 'xcargosize'));
		$smarty->assign('cargodanger', $db->fetchEnum('xxtransportcargo', 'xcargodanger'));
		$smarty->assign('packagetype', $db->getList('xxpackagetype', '', '', 'xpackagetype'));
		if($id){
			$sql = "SELECT *, xcargosize+0 AS xcargosize, xcargokind+0 AS xcargokind, xcargodanger+0 AS xcargodanger
					FROM xxtransportcargo
					WHERE xtransportcargoid = '$id'";
			$default = $db->getRow($sql);
		}
		$sql = "SELECT *, xcargosize+0 AS xcargosize, xcargokind+0 AS xcargokind, xcargodanger+0 AS xcargodanger
				FROM xxtransportcargo
				NATURAL LEFT JOIN xxpackagetype
				WHERE xtransportcontainerid = '$containerid'";
		$cargolist = $db->getAll($sql);
		$smarty->assign_by_ref('cargolist', $cargolist);
		$smarty->assign('backurl', "index.php?section=$section&module=transport-admin&step=cargo&frm_id=$containerid&transportid=$transportid&popup=$popup&carrytype=Container&refreshparent=cargo");
}
?>