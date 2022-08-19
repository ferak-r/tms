<?php
//###fetch information
$id = @$_REQUEST['frm_id'];
$transportid = @$_REQUEST['transportid'];
$popup = @intval($_REQUEST['popup']);
$tplModule = "admin.tpl";

switch($cmd){
	case 'add':
		$res = $db->autoExecute('xxidentity', array('xpartyaccountid' => $_POST['frm_partyaccountid'], 'xpartyaccountetc' => @$_POST['frm_partyaccountetc']), DB_AUTOQUERY_INSERT);
		$identityid = $db->getOne("SELECT @@identity");
		//### insert to db
		$fields_values = array( 
							'xtransportid' 		=> $transportid,
							'xidentityid'		=> $identityid,
							'xaccounttype'		=> $_POST['frm_accounttype'],
							'xaccountnumber'  	=> $_POST['frm_accountnumber'],
							'xamount'    		=> $_POST['frm_amount'],
							'xfor'  			=> $_POST['frm_for'],
							'xaccountdate'		=> $_POST['frm_accountdate'] ? $_POST['frm_accountdate'] : NULL,
							'xcomment'			=> $_POST['frm_comment'],
							'xpay' 				=> @$_POST['frm_pay'] ? 'Yes' : 'No',
							'xinvoicedate'		=> @$_POST['frm_invoicedate'],
							'xprepaid'			=> @$_POST['frm_prepaid'],
							'xcollect'			=> @$_POST['frm_collect'],
							'xescort'			=> @$_POST['frm_escort'],
							'xoverweight'		=> @$_POST['frm_overweight'],
							'xdeliverylate'		=> @$_POST['frm_deliverylate'],
							'xdeliverylateamount'=> @$_POST['frm_deliverylateamount'],
							'xagent'			=> @$_POST['frm_agent'],
							'xduzvolagh'		=> @$_POST['frm_duzvolagh'],
							'ximco'				=> @$_POST['frm_imco'],
							'xetcamount'		=> @$_POST['frm_etcamount'],
							'xprepaidamount'    => @$_POST['frm_prepaidamount'],
							'xchequenumber'		=> @$_POST['frm_chequenumber'],
							'xchequeamount'		=> @$_POST['frm_chequeamount'],
							'xchequefor'		=> @$_POST['frm_chequefor'],
							'xchequesettlement'	=> @$_POST['cheque_settlement'],
							'xchequeliquidate'	=> @$_POST['cheque_liquidate'],
							'xchequepayable'	=> @$_POST['cheque_payable'],
							'xchequetotal'		=> @$_POST['cheque_total']
							);
		if(!empty($_FILES["frm_accountingfile"]["tmp_name"])){
			$fields_values['xfilename'] = $_FILES["frm_accountingfile"]["name"];
		}
		$res = $db->autoExecute('xxaccounting', $fields_values, DB_AUTOQUERY_INSERT);

		$fields_values['xaccountingid'] = $db->getOne ("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}
		
		if($_POST['frm_accounttype'] == 5){
			$ch_container = $_POST['cheque_container'];
			$ch_size      = $_POST['cheque_size'];
			$ch_ardate    = $_POST['cheque_ardate'];
			$ch_retdate   = $_POST['cheque_retdate'];
			$ch_days      = $_POST['cheque_days'];
			$ch_detamount = $_POST['cheque_detamount'];
			foreach($ch_container as $key=>$val){
				if($val){
					$sql = "INSERT INTO xxaccountingcontainer(xaccountingid, xcontainer, xsize, xarrivaldate, xemptydate, xdays, xdetamount) 
								VALUES('$fields_values[xaccountingid]', '$val', '$ch_size[$key]', '$ch_ardate[$key]', '$ch_retdate[$key]', '$ch_days[$key]', '$ch_detamount[$key]')";
					$db->query($sql);
				}
			}
		}
				
		if(!empty($_FILES["frm_accountingfile"]["tmp_name"])){
			@move_uploaded_file($_FILES["frm_accountingfile"]["tmp_name"] ,$config['upload']['accounting'].$fields_values['xaccountingid']);
		}

		redirect("index.php?section=$section&module=account-list&page=$page&popup=$popup&transportid=$transportid");
		break;
	 case 'update':
		$sql = "SELECT xidentityid
				FROM xxcontainerlend
				WHERE xcontainerlendid = '$id'";
		$identityid = $db->getOne($sql);
		if($identityid){
			$res = $db->autoExecute('xxidentity', array('xpartyaccountid' => $_POST['frm_partyaccountid'], 'xpartyaccountetc' => $_POST['frm_partyaccountetc']), DB_AUTOQUERY_UPDATE, "xidentityid='$identityid'");
		}else{
			$res = $db->autoExecute('xxidentity', array('xpartyaccountid' => $_POST['frm_partyaccountid'], 'xpartyaccountetc' => $_POST['frm_partyaccountetc']), DB_AUTOQUERY_INSERT);
			$identityid = $db->getOne("SELECT @@identity");
		}
		$fields_values = array( 
							'xtransportid' 		=> $transportid,
							'xidentityid'		=> $identityid,
							'xaccounttype'		=> $_POST['frm_accounttype'],
							'xaccountnumber'  	=> $_POST['frm_accountnumber'],
							'xamount'    		=> $_POST['frm_amount'],
							'xfor'  			=> $_POST['frm_for'],
							'xaccountdate'		=> $_POST['frm_accountdate'] ? $_POST['frm_accountdate'] : NULL,
							'xcomment'			=> $_POST['frm_comment'],
							'xpay' 				=> @$_POST['frm_pay'] ? 'Yes' : 'No',
							'xinvoicedate'		=> @$_POST['frm_invoicedate'],
							'xprepaid'			=> @$_POST['frm_prepaid'],
							'xcollect'			=> @$_POST['frm_collect'],
							'xescort'			=> @$_POST['frm_escort'],
							'xoverweight'		=> @$_POST['frm_overweight'],
							'xdeliverylate'		=> @$_POST['frm_deliverylate'],
							'xdeliverylateamount'=> @$_POST['frm_deliverylateamount'],
							'xagent'			=> @$_POST['frm_agent'],
							'xduzvolagh'		=> @$_POST['frm_duzvolagh'],
							'ximco'				=> @$_POST['frm_imco'],
							'xetcamount'		=> @$_POST['frm_etcamount'],
							'xprepaidamount'    => @$_POST['frm_prepaidamount'],
							'xchequenumber'		=> @$_POST['frm_chequenumber'],
							'xchequeamount'		=> @$_POST['frm_chequeamount'],
							'xchequefor'		=> @$_POST['frm_chequefor'],
							'xchequesettlement'	=> @$_POST['cheque_settlement'],
							'xchequeliquidate'	=> @$_POST['cheque_liquidate'],
							'xchequepayable'	=> @$_POST['cheque_payable'],
							'xchequetotal'		=> @$_POST['cheque_total']
							);
		if(!empty($_FILES["frm_accountingfile"]["tmp_name"])){
			$fields_values['xfilename'] = $_FILES["frm_accountingfile"]["name"];
		}
		$res = $db->autoExecute('xxaccounting', $fields_values, DB_AUTOQUERY_UPDATE, "xaccountingid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		if($_POST['frm_accounttype'] == 5){
			$sql = "DELETE FROM xxaccountingcontainer WHERE xaccountingid = '$id'";
			$db->query($sql);
			$ch_container = $_POST['cheque_container'];
			$ch_size      = $_POST['cheque_size'];
			$ch_ardate    = $_POST['cheque_ardate'];
			$ch_retdate   = $_POST['cheque_retdate'];
			$ch_days      = $_POST['cheque_days'];
			$ch_detamount = $_POST['cheque_detamount'];
			foreach($ch_container as $key=>$val){
				if($val){
					$sql = "INSERT INTO xxaccountingcontainer(xaccountingid, xcontainer, xsize, xarrivaldate, xemptydate, xdays, xdetamount) 
								VALUES('$id', '$val', '$ch_size[$key]', '$ch_ardate[$key]', '$ch_retdate[$key]', '$ch_days[$key]', '$ch_detamount[$key]')";
					$db->query($sql);
				}
			}
		}

		
		if(!empty($_FILES["frm_accountingfile"]["tmp_name"])){
			@move_uploaded_file($_FILES["frm_accountingfile"]["tmp_name"] ,$config['upload']['accounting'].$id);
		}
		redirect("index.php?section=$section&module=account-admin&page=$page&frm_id=$id&transportid=$transportid&popup=$popup");
		break;
	case 'delete':
		$id = is_array($id) ? $id : array($id);
		foreach($id as $val){
			@unlink($config['upload']['invoice'].$val);
		}
		$id = implode(',', $id);
		$sql = "DELETE
				FROM xxaccounting
				WHERE xaccountingid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}
		redirect("index.php?section=$section&module=accounting-list");
		break;
	case 'deleteimg':
		@unlink($config['upload']['accounting'].$id);
		$sql = "UPDATE xxaccounting SET xfilename=NULL WHERE xaccountingid = '$id'";
		$db->query($sql);
		
		redirect("index.php?section=$section&module=account-admin&page=$page&frm_id=$id&transportid=$transportid&popup=$popup");
		break;
	default:
		$type = $db->fetchEnum('xxaccounting', 'xaccounttype');
		
		$sql = "SELECT *
			    FROM xxcarrier
			    WHERE xcarriertype='Company'
				ORDER BY xcarrier";
		$res = $db->getAll($sql);
		foreach($res as $val){
			$carrier["cri$val[xcarrierid]"] = $val['xcarrier'];
		}
		$sql = "SELECT *
				FROM xxcustomer
				ORDER BY xname";
		$res = $db->getAll($sql);
		foreach($res as $val){
			$customer["cst$val[xcustomerid]"] = "$val[xname] $val[xfamily]";
		}
		$sql = "SELECT *
				FROM xxoffice
				ORDER BY xoffice";
		$res = $db->getAll($sql);
		foreach($res as $val){
			$office["ofc$val[xofficeid]"] = $val['xoffice'];
		}
		
		$sql = "SELECT *, xaccounttype+0 AS xaccounttype
				FROM xxaccounting
				NATURAL LEFT JOIN zzidentity
				WHERE xaccountingid = '$id'";
		$list = $db->getRow($sql);
		if($list){
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
			$default['frm_pay'] = $default['frm_pay'] == 'Yes' ? 1 : 0;
			$list['xtotalamount'] = $default['frm_duzvolagh'] + $default['frm_escort'] + $default['frm_overweight'] + $default['frm_imco'] + $default['frm_etcamount'];
			$list['xremain'] = $list['xtotalamount'] - $default['frm_agent'] - $default['frm_prepaidamount'];
			$list['xcollectamount'] = $list['xremain'] - $default['frm_deliverylateamount'];
			if($list['xaccounttype'] == 5){
				$sql = "SELECT * FROM xxaccountingcontainer WHERE xaccountingid='$id'";
				$accountingcontainer = $db->getAll($sql);
			}		
		}
		
		if($id){
			$default['frm_partyaccount'] = $default['frm_type'];
		}else{
			$default['frm_partyaccount'] = 'carrier';
			$default['frm_type']		 = 'carrier';
		}
		
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=account-admin&page=$page&cmd=$cmd&transportid=$transportid&popup=$popup", "", "enctype='multipart/form-data'");

		$partyaccount[] =& HTML_QuickForm::createElement('radio', 'frm_partyaccount', NULL, T_('Carrier'), 'carrier', 'style="width: 20px; border: 0px;" onclick="$$(\'.partyaccount\').each(function(el){el.style.display=\'none\'; el.disabled=1}); $(\'frm_carrierid\').style.display=\'inline\'; $(\'frm_carrierid\').disabled=0;"');
		$partyaccount[] =& HTML_QuickForm::createElement('radio', 'frm_partyaccount', NULL, T_('Customer'), 'customer', 'style="width: 20px; border: 0px;" onclick="$$(\'.partyaccount\').each(function(el){el.style.display=\'none\'; el.disabled=1}); $(\'frm_customerid\').style.display=\'inline\'; $(\'frm_customerid\').disabled=0"');
		$partyaccount[] =& HTML_QuickForm::createElement('radio', 'frm_partyaccount', NULL, T_('Office'), 'office', 'style="width: 20px; border: 0px;" onclick="$$(\'.partyaccount\').each(function(el){el.style.display=\'none\'; el.disabled=1}); $(\'frm_officeid\').style.display=\'inline\'; $(\'frm_officeid\').disabled=0"');
		$partyaccount[] =& HTML_QuickForm::createElement('radio', 'frm_partyaccount', NULL, T_('Etc'), 'etc', 'style="width: 20px; border: 0px;" onclick="$$(\'.partyaccount\').each(function(el){el.style.display=\'none\'; el.disabled=1}); $(\'frm_etc\').style.display=\'inline\'; $(\'frm_etc\').disabled=0"');
		
		$partyaccount[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<br>");
		
		if(@$default['frm_type'] == 'carrier'){
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $carrier, "id='frm_carrierid' class='partyaccount' dir='ltr'");
		}else{
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $carrier, "id='frm_carrierid' class='partyaccount' dir='ltr' style='display: none;' disabled='disabled'");		
		}
		if(@$default['frm_type'] == 'customer'){
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $customer, "id='frm_customerid' class='partyaccount' dir='ltr'");
		}else{
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $customer, "id='frm_customerid' class='partyaccount' dir='ltr' style='display: none;' disabled='disabled'");
		}
		if(@$default['frm_type'] == 'office'){
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $office, "id='frm_officeid' class='partyaccount' dir='ltr'");
		}else{
			$partyaccount[] =& HTML_QuickForm::createElement('select', 'frm_partyaccountid', NULL, $office, "id='frm_officeid' class='partyaccount' dir='ltr' style='display: none' disabled='disabled'");
		}
		if(@$default['frm_type'] == 'etc'){
			$partyaccount[] =& HTML_QuickForm::createElement('textarea', 'frm_partyaccountetc', NULL, "id='frm_etc' class='partyaccount' dir='ltr'");
		}else{
			$partyaccount[] =& HTML_QuickForm::createElement('textarea', 'frm_partyaccountetc', NULL, "id='frm_etc' class='partyaccount' dir='ltr' style='display: none' disabled='disabled'");
		}
		$form->addGroup($partyaccount, NULL, T_('Party Account'));
		
		$accounttype[] =& HTML_QuickForm::createElement('select','frm_accounttype', NULL, $type, "dir='ltr' onchange='if(this.options[this.selectedIndex].text==\"Invoice\")$(\"invoice_spn\").style.display=\"inline\"; else $(\"invoice_spn\").style.display=\"none\";if(this.options[this.selectedIndex].text==\"Contract\")$(\"contract_spn\").style.display=\"inline\"; else $(\"contract_spn\").style.display=\"none\";if(this.options[this.selectedIndex].text==\"Guarantee Cheque\")$(\"cheque_spn\").style.display=\"inline\"; else $(\"cheque_spn\").style.display=\"none\";'");
		
		$invoice = "<table><tr><td>Invoice Date:</td><td><input type='text' name='frm_invoicedate' id='frm_invoicedate' style='width: 80px' value='$list[xinvoicedate]'>
							 <a href='javascript:void(0)' onclick='return showCalendar(\"frm_invoicedate\", \"y-mm-dd\");'><img border='0' src='../images/calendar.png' width='16' height='16' alt=''/></td>
							<td>&nbsp;&nbsp;Invoice Image:</td><td><input type='file' name='frm_accountingfile'></td></tr></table>";


		$contract = "<table><tr><td>Duzvolagh:</td><td><input type='text' style='width:80px' name='frm_duzvolagh' id='frm_duzvolagh' value='$list[xduzvolagh]' onchange='changeSum();'>$</td>
					 <td>&nbsp;&nbsp;Escort:</td><td><input type='text' style='width:80px' name='frm_escort' id='frm_escort' value='$list[xescort]' onchange='changeSum();'>$</td></tr>
					 <tr><td>Over Weight:</td><td><input type='text' style='width:80px' name='frm_overweight' id='frm_overweight' value='$list[xoverweight]' onchange='changeSum();'>$</td>
					 <td>&nbsp;&nbsp;Imco:</td><td><input type='text' style='width:80px' name='frm_imco' id='frm_imco' value='$list[ximco]' onchange='changeSum();'>$</td></tr>
					 <tr><td>Etc:</td><td><input type='text' style='width:80px' name='frm_etcamount' id='frm_etcamount' value='$list[xetcamount]' onchange='changeSum();'>$</td>
					  <td><b>&nbsp;&nbsp;Total Amount:</b></td><td><input type='text' style='width:80px' name='frm_totalamount' id='frm_totalamount' value='$list[xtotalamount]'>$</td></tr>
					 <tr><td>Agent Pay:</td><td><input type='text' style='width:80px' name='frm_agent' id='frm_agent' value='$list[xagent]' onchange='changeSum();'>$</td>
					  <td>&nbsp;&nbsp;Prepaid:</td><td><input type='text' style='width:80px' name='frm_prepaidamount' id='frm_prepaidamount' value='$list[xprepaidamount]' onchange='changeSum();'>$</td></tr>
					 <tr><td>Prepaid Date:</td><td><input type='text' style='width:80px' name='frm_prepaid'  id='frm_prepaid' value='$list[xprepaid]'>
					   <a href='javascript:void(0)' onclick='return showCalendar(\"frm_prepaid\", \"y-mm-dd\");'><img border='0' src='../images/calendar.png' width='16' height='16' alt=''/></td>
					 <td>&nbsp;&nbsp;<b>Remain:</b></td><td><input type='text' style='width:80px' name='frm_remain' id='frm_remain' value='$list[xremain]'>$</td></tr>
					 <tr><td>Delivery Late Days:</td><td><input type='text' style='width:80px' name='frm_deliverylate' value='$list[xdeliverylate]'></td>
					 <td>&nbsp;&nbsp;Delivery Late:</td><td><input type='text' style='width:80px' name='frm_deliverylateamount' id='frm_deliverylateamount' value='$list[xdeliverylateamount]' onchange='changeSum();'>$</td></tr>
					 <tr><td>Collect Date:</td><td><input type='text' style='width:80px' name='frm_collect' id='frm_collect' value='$list[xcollect]'>
					   <a href='javascript:void(0)' onclick='return showCalendar(\"frm_collect\", \"y-mm-dd\");'><img border='0' src='../images/calendar.png' width='16' height='16' alt=''/></td>
					 <td>&nbsp;&nbsp;<b>Collect:</b></td><td><input type='text' style='width:80px' name='frm_collectamount' id='frm_collectamount' value='$list[xcollectamount]'>$</td></tr>
					 <tr><td>Contract Image:</td><td><input type='file' name='frm_accountingfile'></td></tr>
					 </table>";

		$cheque = "<table><tr><td>Number:</td><td><input type='text' name='frm_chequenumber' id='frm_chequenumber' style='width: 80px' value='$list[xchequenumber]'></td>
							<td>&nbsp;&nbsp;Amount:</td><td><input type='text' name='frm_chequeamount' id='frm_chequeamount' style='width: 80px' value='$list[xchequeamount]'>Rls</td></tr>
				   	<tr><td>For:</td><td><input type='text' name='frm_chequefor' id='frm_chequefor' style='width: 80px' value='$list[xchequefor]'></td>
						<td>&nbsp;&nbsp;Cheque Image:</td><td><input type='file' name='frm_accountingfile'></td></tr>
					<tr><td colspan='4'><b>Detention Notice</b></td></tr>
					<tr><td colspan='4'>			
						<table>
						<tr><td>Container</td><td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[0]['xcontainer']}'></td><td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[1]['xcontainer']}'></td><td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[2]['xcontainer']}'></td><td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[3]['xcontainer']}'></td><td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[4]['xcontainer']}'></td><td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[5]['xcontainer']}'></td><td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[6]['xcontainer']}'></td><td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[7]['xcontainer']}'></td>
							<td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[8]['xcontainer']}'></td><td><input type='text' style='width: 50px' name='cheque_container[]' value='{$accountingcontainer[9]['xcontainer']}'></td></tr>
						<tr><td>Size</td><td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[0]['xsize']}'></td><td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[1]['xsize']}'></td><td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[2]['xsize']}'></td><td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[3]['xsize']}'></td><td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[4]['xsize']}'></td><td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[5]['xsize']}'></td>
							<td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[6]['xsize']}'></td><td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[7]['xsize']}'></td><td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[8]['xsize']}'></td><td><input type='text' style='width: 50px' name='cheque_size[]' value='{$accountingcontainer[9]['xsize']}'></td></tr>
						<tr><td>Arrival Date</td><td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[0]['xarrivaldate']}'></td><td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[1]['xarrivaldate']}'></td><td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[2]['xarrivaldate']}'></td><td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[3]['xarrivaldate']}'></td><td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[4]['xarrivaldate']}'></td><td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[5]['xarrivaldate']}'></td>
							<td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[6]['xarrivaldate']}'></td><td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[7]['xarrivaldate']}'></td><td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[8]['xarrivaldate']}'></td><td><input type='text' style='width: 50px' name='cheque_ardate[]' value='{$accountingcontainer[9]['xarrivaldate']}'></td></tr>
						<tr><td>Empty Return Date</td><td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[0]['xemptydate']}'></td><td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[1]['xemptydate']}'></td><td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[2]['xemptydate']}'></td><td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[3]['xemptydate']}'></td><td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[4]['xemptydate']}'></td><td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[5]['xemptydate']}'></td>
							<td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[6]['xemptydate']}'></td><td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[7]['xemptydate']}'></td><td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[8]['xemptydate']}'></td><td><input type='text' style='width: 50px' name='cheque_retdate[]' value='{$accountingcontainer[9]['xemptydate']}'></td></tr>
						<tr><td>Days</td><td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[0]['xdays']}'></td><td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[1]['xdays']}'></td><td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[2]['xdays']}'></td><td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[3]['xdays']}'></td><td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[4]['xdays']}'></td><td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[5]['xdays']}'></td>
							<td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[6]['xdays']}'></td><td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[7]['xdays']}'></td><td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[8]['xdays']}'></td><td><input type='text' style='width: 50px' name='cheque_days[]' value='{$accountingcontainer[9]['xdays']}'></td></tr>
						<tr><td>Det Amount</td><td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[0]['xdetamount']}'></td><td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[1]['xdetamount']}'></td><td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[2]['xdetamount']}'></td><td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[3]['xdetamount']}'></td><td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[4]['xdetamount']}'></td><td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[5]['xdetamount']}'></td>
							<td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[6]['xdetamount']}'></td><td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[7]['xdetamount']}'></td><td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[8]['xdetamount']}'></td><td><input type='text' style='width: 50px' name='cheque_detamount[]' value='{$accountingcontainer[9]['xdetamount']}'></td></tr>
						<tr><td colspan='10'>Total: <input type='text' name='cheque_total' style='width: 80px' value='$list[xchequetotal]'>&nbsp;&nbsp;&nbsp;
							Settlement: <input type='text' name='cheque_settlement' style='width: 80px' value='$list[xchequesettlement]'>&nbsp;&nbsp;&nbsp; 
							Payable: <input type='text' name='cheque_payable' style='width: 80px' value='$list[xchequepayable]'>&nbsp;&nbsp;&nbsp;
							Liqui Date: <input type='text' name='cheque_liquidate' style='width: 80px' value='$list[xchequeliquidate]'></td></tr>
						</table>
					</td></tr>
				   </table>";		

		if(@$default['frm_accounttype'] == 3){//invoice
			$accounttype[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<span id='invoice_spn'>$invoice</span>");
		}
		else{
			$accounttype[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<span style='display: none;' id='invoice_spn'>$invoice</span>");
		}		

		if(@$default['frm_accounttype'] == 4){//contract
			$accounttype[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<span id='contract_spn'>$contract</span>");
		}else{
			$accounttype[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<span style='display: none;' id='contract_spn'>$contract</span>");
		}	

		if(@$default['frm_accounttype'] == 5){//cheque
			$accounttype[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<span id='cheque_spn'>$cheque</span>");
		}else{
			$accounttype[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<span style='display: none;' id='cheque_spn'>$cheque</span>");
		}	
					
		if($id && file_exists($config['upload']['accounting'].$id)){
			$ext = strtolower(end(explode('.', $default['frm_filename'])));
			$accounttype[] =& HTML_QuickForm::createElement('static', NULL, NULL, '<br><br>');
			if($ext != 'pdf'){
				$accounttype[] =& HTML_QuickForm::createElement('image', NULL, "showpic.php?w=100&mh=100&module=account&pic=$id", "onclick='openNewWindow(\"../global/showpic.php?mw=600&mh=400&output=html&&module=account&pic=$id\", 640, 480, \"noscroll\"); return false;' style='width: 100px;'");
			}else{
				$accounttype[] =& HTML_QuickForm::createElement('link', NULL, NULL, "download.php?module=accounting&id=$id&dir=accounting", "<img src='../images/symbol-pdf.gif' border='0px'>");
			}
			$accounttype[] =& HTML_QuickForm::createElement('link', NULL, NULL, "index.php?section=$section&module=account-admin&cmd=deleteimg&frm_id=$id&transportid=$transportid&popup=$popup", T_('Delete'));
		}
	
		$form->addGroup($accounttype, NULL, T_('Type'));		
		
		$form->addElement('text','frm_accountnumber', T_('Number'), "dir='ltr'");

		$amount[] =& HTML_QuickForm::createElement('text', 'frm_amount', NULL, "dir='ltr'");
		$amount[] =& HTML_QuickForm::createElement('static', NULL, NULL, '$');
		$form->addGroup($amount, NULL, T_('Amount'));						

		$form->addElement('text','frm_for', T_('For'), "dir='ltr'");
		$accountdate[] =& HTML_QuickForm::createElement('text', 'frm_accountdate', NULL, "id='frm_accountdate' dir='ltr'");
		$accountdate[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_accountdate\', \'y-mm-dd\');"');
		$form->addGroup($accountdate, NULL, T_('Account Date'));

		$form->addElement('textarea','frm_comment', T_('Comment'), "dir='ltr'");
		$form->addElement('checkbox','frm_pay', T_('Paid'));
		
		$form->setDefaults(@$default);
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();							
}


//###samarty
$smarty->assign_by_ref('page', $page);
$smarty->assign_by_ref('popup', $popup);
$smarty->assign_by_ref('cmd', $cmd);
$smarty->assign_by_ref('list', $list);
$smarty->assign('backurl', "index.php?section=$section&module=account-list&transportid=$transportid&page=$page&popup=$popup");
$smarty->assign('formData', @$formData);
trace($smarty->_tpl_vars);
if($popup){
	$smarty->display($tplModule);
	die();
}
?>