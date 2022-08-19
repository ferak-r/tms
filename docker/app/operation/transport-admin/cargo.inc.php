<?php
$carrytype = @$_GET['carrytype'] ? $_GET['carrytype'] : 'Bulk';
switch($carrytype){
	case 'Bulk':
		switch($cmd){
			case 'add':
				if(!$containerid){
					$fields_values = array( 
										'xtransportid' => $transportid,
										'xcarrytype'   => $_POST['frm_carrytype']
									);
					$res = $db->autoExecute('xxtransportcontainer', $fields_values, DB_AUTOQUERY_INSERT);
					$containerid = $db->getOne("SELECT @@IDENTITY");
				}
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
				redirect("index.php?section=$section&module=transport-admin&page=$page&step=$step&transportid=$transportid&popup=$popup&loadformvalues=$_GET[loadformvalues]&refreshparent=cargo");
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
				$res = $db->autoExecute('xxtransportcargo', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportcontainerid='$id'");
				if(PEAR::isError($res)){
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				}
				redirect("index.php?section=$section&module=transport-admin&page=$page&frm_id=$id&step=$step&transportid=$transportid&popup=$popup&loadformvalues=$_GET[loadformvalues]&refreshparent=cargo");
				break;
			default:
				$carryingtype  = $db->fetchEnum('xxtransportcontainer', 'xcarrytype');
				$cargokind 	   = $db->fetchEnum('xxtransportcargo', 'xcargokind');
				$cargosize 	   = $db->fetchEnum('xxtransportcargo', 'xcargosize');
				$cargodanger   = $db->fetchEnum('xxtransportcargo', 'xcargodanger');
				$packagetype   = $db->getList('xxpackagetype', '', '', 'xpackagetype');						
				if($id){
					$sql = "SELECT *, xcarrytype+0 AS xcarrytype, xcargokind+0 AS xcargokind, xcargosize+0 AS xcargosize, xcargodanger+0 AS xcargodanger
							FROM xxtransportcargo
							NATURAL LEFT JOIN xxtransportcontainer
							WHERE xtransportcontainerid = '$id'";
					$list = $db->getRow($sql);
				}
				if(@$list){
					foreach($list as $key => $val){
						$default['frm_'.substr($key, 1, strlen($key))] = $val;
					}
				}
				
				$cmd = empty($id)? "add" : "update&frm_id=$id";
				$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=transport-admin&page=$page&step=cargo&cmd=$cmd&transportid=$transportid&containerid=$containerid&popup=$popup&carrytype=$carry");
				$form->addElement('select', 'frm_carrytype', T_('Carrying Type'), $carryingtype, 'dir="ltr" onchange="var href=document.location.href; document.location.href=(href.indexOf(\'carrytype\')!=\'-1\'?href.substr(0, href.indexOf(\'carrytype\'))+href.substr(href.indexOf(\'carrytype\')+15, href.length):href)+\'&carrytype=Container\'"' );
				$default['frm_carrytype'] = array_search(@$carry, $carryingtype);
				$form->addElement('select', 'frm_packagetypeid', T_('Packing Type'), $packagetype, "dir='ltr'");
				$form->addElement('text', 'frm_packagenumber', T_('Number of Packages'), "dir='ltr'");
				$form->addElement('text', 'frm_commodity', T_('Commodity'), "dir='ltr'");
				$form->addElement('select', 'frm_cargokind', T_('Kind'), $cargokind, "dir='ltr'");
				$form->addElement('select', 'frm_cargosize', T_('Size'), $cargosize, "dir='ltr'");
				$form->addElement('select', 'frm_cargodanger', T_('Danger Level'), $cargodanger, "dir='ltr'");
				$form->addElement('text', 'frm_imo', T_('IMO'), "dir='ltr'");
				
				
				$weight[] =& HTML_QuickForm::createElement('text', 'frm_cargoweight', NULL, "dir='ltr'");
				$weight[] =& HTML_QuickForm::createElement('static', NULL, NULL, 'Kg');
				$form->addGroup($weight, NULL, T_('Cargo Weight'));						

				$volume[] =& HTML_QuickForm::createElement('text', 'frm_cargovolume', NULL, "dir='ltr'");
				$volume[] =& HTML_QuickForm::createElement('static', NULL, NULL, 'M<sup>3</sup>');
				$form->addGroup($volume, NULL, T_('Cargo Volume'));						
	
				$form->addElement('text', 'frm_cargodimension', T_('Dimension (L*W*H)'), "dir='ltr'");
				
				$form->addElement('textarea', 'frm_cargodescription', T_('Description'), "dir='ltr'");
				$form->setDefaults(@$default);
				$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
				$form->accept($renderer);
				$formData = $renderer->toArray();	
		}
		break;
	case 'Container':
		switch($cmd){
			case 'add':
				//### insert to db
				if(!$_POST['frm_containerid']){
					if(@$_POST['frm_carrier']){
						$res = $db->autoExecute('xxcarrier', array('xcarrier' => $_POST['frm_carrier'], 'xcarriertype' => 'Person'), DB_AUTOQUERY_INSERT);
						$carrierid = $db->getOne("SELECT @@IDENTITY");			
					}else{
						$carrierid   = @$_POST['frm_carrierid'];
					}

					$fields_values = array( 
										'xcarrierid' 		=> $_POST['frm_own'] == 2 ? $carrierid : NULL,
										'xcontainernumber' 	=> $_POST['frm_containernumber'],
										'xcontainertypeid' 	=> $_POST['frm_containertypeid'],
										'xcontainersizeid' 	=> $_POST['frm_containersizeid'],
										'xown'				=> $_POST['frm_own']);
					$res = $db->autoExecute('xxcontainer', $fields_values, DB_AUTOQUERY_INSERT);
					$containerid = $db->getOne ("SELECT @@IDENTITY");				
				}else{
					$containerid = $_POST['frm_containerid'];
				}
				$fields_values = array( 
									'xtransportid'		  => $transportid,
									'xcontainerid'		  => $containerid,
									'xcarrytype'		  => $_POST['frm_carrytype'],
									'xshippingstartdate'  => $_POST['frm_shippingstartdate'] ? $_POST['frm_shippingstartdate'] : NULL,
									'xshippingfreetime'   => $_POST['frm_shippingfreetime'],
									'xcustomerstartdate'  => $_POST['frm_customerstartdate'] ? $_POST['frm_customerstartdate'] : NULL,
									'xcustomerfreetime'   => $_POST['frm_customerfreetime']
								 );
				$res = $db->autoExecute('xxtransportcontainer', $fields_values, DB_AUTOQUERY_INSERT);
				$fields_values['xtransportcontainerid'] = $db->getOne ("SELECT @@IDENTITY");
				if (DB::isError($res)) {
					msg($msg['Error'], 'error', 'Error');
				}
				if(@isset($_GET['addcontainercargo'])){
					redirect("index.php?section=$section&module=transport-admin&page=$page&step=containercargo&containerid=$fields_values[xtransportcontainerid]&transportid=$transportid&popup=$popup&loadformvalues=$_GET[loadformvalues]&refreshparent=cargo");
				}else{
					redirect("index.php?section=$section&module=transport-admin&page=$page&step=$step&transportid=$transportid&carrytype=$carry&popup=$popup&loadformvalues=$_GET[loadformvalues]&refreshparent=cargo");
				}
				break;
			 case 'update':
				if(!$_POST['frm_containerid']){
					if(@$_POST['frm_carrier']){
						$res = $db->autoExecute('xxcarrier', array('xcarrier' => $_POST['frm_carrier'], 'xcarriertype' => 'Person'), DB_AUTOQUERY_INSERT);
						$carrierid = $db->getOne("SELECT @@IDENTITY");			
					}else{
						$carrierid   = @$_POST['frm_carrierid'];
					}

					$fields_values = array( 
										'xcarrierid' 		=> $_POST['frm_own'] == 2 ? $carrierid : NULL,
										'xcontainernumber' 	=> $_POST['frm_containernumber'],
										'xcontainertypeid' 	=> $_POST['frm_containertypeid'],
										'xcontainersizeid' 	=> $_POST['frm_containersizeid'],
										'xown'				=> $_POST['frm_own']);
					$res = $db->autoExecute('xxcontainer', $fields_values, DB_AUTOQUERY_INSERT);
					$containerid = $db->getOne ("SELECT @@IDENTITY");				
				}else{
					$containerid = $_POST['frm_containerid'];
				}
				$fields_values = array( 
									'xtransportid'		  => $transportid,
									'xcontainerid'		  => $containerid,
									'xcarrytype'		  => $_POST['frm_carrytype'],
									'xshippingstartdate'  => $_POST['frm_shippingstartdate'] ? $_POST['frm_shippingstartdate'] : NULL,
									'xshippingfreetime'   => $_POST['frm_shippingfreetime'],
									'xcustomerstartdate'  => $_POST['frm_customerstartdate'] ? $_POST['frm_customerstartdate'] : NULL,
									'xcustomerfreetime'   => $_POST['frm_customerfreetime']
								 );
				$res = $db->autoExecute('xxtransportcontainer', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportcontainerid='$id'");
				if(PEAR::isError($res)){
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				}
				if(@isset($_GET['addcontainercargo'])){
					redirect("index.php?section=$section&module=transport-admin&page=$page&step=containercargo&containerid=$id&transportid=$transportid&popup=$popup&loadformvalues=$_GET[loadformvalues]&refreshparent=cargo");
				}else{
					redirect("index.php?section=$section&module=transport-admin&page=$page&frm_id=$id&step=$step&transportid=$transportid&carrytype=$carry&popup=$popup&loadformvalues=$_GET[loadformvalues]&refreshparent=cargo");
				}
				break;
			case 'delete':
				$id = is_array($id) ? implode(',', $id) : $id;
				$sql = "DELETE
						FROM xxtransportcontainer
						WHERE xtransportcontainerid IN ($id)";
				$res = $db->query($sql);
				if(PEAR::isError($res)){
					msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
				} else {
					$sql = "DELETE
							FROM xxtransportcargo
							WHERE xtransportcontainerid IN ($id)";
					$res = $db->query($sql);
				}
				redirect("index.php?section=$section&module=transport-admin&step=transport&frm_id=$transportid&popup=$popup&refreshparent=cargo");
				break;
			default:
				$tplModule 	   = 'transport-container.tpl';
				$carryingtype  = $db->fetchEnum('xxtransportcontainer', 'xcarrytype');
				$own 		   = $db->fetchEnum('xxcontainer', 'xown'); 
				$containertype = $db->getList('xxcontainertype');
				$containersize = $db->getList('xxcontainersize');
				$carrier	   = $db->getList('xxcarrier', 'xcarrier', 'WHERE xcarriertype="Company"', 'xcarrier');
				
				//get container list
				$sql = "SELECT *
						FROM xxcontainer
						NATURAL LEFT JOIN xxcontainersize
						NATURAL LEFT JOIN xxcarrier
						ORDER BY xcarrierid DESC";
				$res = $db->getAll($sql);
				foreach($res as $key=>$val){
					$container[$val['xcontainerid']] = ($val['xown'] == 'COC' ?  "$val[xcarrier]" : ( $val['xcompanycontainer'] ? "$config[sitename]" : "SOC" )) . ": $val[xcontainernumber] ($val[xcontainersize])";
				}
				asort($container);
				if($id){
					$sql = "SELECT *, xcarrytype+0 AS xcarytype, xown+0 AS xown
							FROM xxtransportcontainer
							NATURAL LEFT JOIN xxcontainer
							WHERE xtransportcontainerid = '$id'";
					$default = $db->getRow($sql);
				}
				$default['xcarrytype'] = array_search('Container', $carryingtype);
				$smarty->assign('carryingtype', $carryingtype);
				$smarty->assign('container', @$container);
				$smarty->assign('own', $own);
				$smarty->assign('containertype', $containertype);
				$smarty->assign('containersize', $containersize);
				$smarty->assign('carrier', $carrier);
				$smarty->assign('showsavebtn', 1);
		}
		break;
}
?>