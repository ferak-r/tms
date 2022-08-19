<?php
switch($cmd){
	case 'add':
		//### insert to db
		$fields_values = array( 
							'xdocumentid'	 			=> $_POST['frm_documentid'],
							'xtransportid'  			=> $transportid,
							'xdocumentnumber'			=> $_POST['frm_documentnumber'],
							'xdocumentdate'				=> $_POST['frm_documentdate'],
							'xoldtransportdocumentid'	=> @$_POST['frm_correction'] ? $_POST['frm_oldtransportdocumentid'] : NULL
							);
		$res = $db->autoExecute('xxtransportdocument', $fields_values, DB_AUTOQUERY_INSERT);
		$fields_values['xtransportdocumentid'] = $db->getOne ("SELECT @@IDENTITY");
		if (DB::isError($res)) {
			msg($msg['Error'], 'error', 'Error');
		}else{
			//add comment
			if(@$_POST['frm_transportdocumentcommnet']){
				$sql = "INSERT INTO xxtransportcomment(xtransportid, xtransportcomment, xcommenttype)
							VALUES('$transportid', '$_POST[frm_transportdocumentcommnet]', 'transportdoc')";
				$res = $db->query($sql);
			}
			//get files
			$filenum = @$_POST['frm_filenum'];
			mkdir($config['upload']['document'].$fields_values['xtransportdocumentid']);
			for($i=1; $i<=$filenum; $i++){
				if(!empty($_FILES["frm_file$i"]["tmp_name"])){
					$sql = "INSERT INTO xxtransportdocumentfile(xtransportdocumentid, xfilename) VALUES($fields_values[xtransportdocumentid], '".$_FILES["frm_file$i"]["name"]."')";
					$db->query($sql);
					$fileid = $db->getOne("SELECT LAST_INSERT_ID()");
					@move_uploaded_file($_FILES["frm_file$i"]["tmp_name"] ,$config['upload']['document'].$fields_values['xtransportdocumentid']."/$fileid");
				}
			}
		}
		redirect("index.php?section=$section&module=transport-admin&page=$page&step=$step&transportid=$transportid&popup=$popup&refreshparent=doc");
		break;
	 case 'update':
		$fields_values = array( 
							'xdocumentid'	 			=> $_POST['frm_documentid'],
							'xtransportid'  			=> $transportid,
							'xdocumentnumber'			=> $_POST['frm_documentnumber'],
							'xdocumentdate'				=> $_POST['frm_documentdate'],
							'xoldtransportdocumentid'	=> @$_POST['frm_correction'] ? $_POST['frm_oldtransportdocumentid'] : NULL
							);
		$res = $db->autoExecute('xxtransportdocument', $fields_values, DB_AUTOQUERY_UPDATE, "xtransportdocumentid='$id'");
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		} else {
			//add comment
			if(@$_POST['frm_transportdocumentcommnet']){
				$sql = "INSERT INTO xxtransportcomment(xtransportid, xtransportcomment, xcommenttype)
							VALUES('$transportid', '$_POST[frm_transportdocumentcommnet]', 'transportdoc')";
				$res = $db->query($sql);
			}
			//get files
			$filenum = @intval($_POST['frm_filenum']);
			mkdir($config['upload']['document'].$id);
			for($i=1; $i<=$filenum; $i++){
				if(!empty($_FILES["frm_file$i"]["tmp_name"])){
					$sql = "INSERT INTO xxtransportdocumentfile(xtransportdocumentid, xfilename) VALUES($id, '".$_FILES["frm_file$i"]["name"]."')";
					$db->query($sql);
					$fileid = $db->getOne("SELECT LAST_INSERT_ID()");
					@move_uploaded_file($_FILES["frm_file$i"]["tmp_name"] ,$config['upload']['document']."$id/$fileid");
				}
			}
		}
		redirect("index.php?section=$section&module=transport-admin&page=$page&frm_id=$id&step=$step&transportid=$transportid&popup=$popup&refreshparent=doc");
		break;
	case 'deleteimg':
		$img = @$_GET['img'];
		@unlink($config['upload']['document']."$id/$img");
		$sql = "DELETE FROM xxtransportdocumentfile WHERE xtransportdocumentid='$id' AND xtransportdocumentfileid='$img'";
		$db->query($sql);
		redirect("index.php?section=$section&module=transport-admin&page=$page&frm_id=$id&step=$step&transportid=$transportid&popup=$popup");
		break;
	case 'delete':
		$id = is_array($id) ? implode(',', $id) : $id;
		$sql = "DELETE
				FROM xxtransportdocument
				WHERE xtransportdocumentid IN ($id)";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			msg(__LINE__.": ".$msg['Error'], 'error', 'Error');
		}else{
			$id = explode(',', $id);
			//delete image[s]
			foreach($id as $val){
				$sql = "SELECT xtransportdocumentfileid
					   FROM xxtransportdocumentfile
					   WHERE xtransportdocumentid = '$val'";
				$fileid = $db->_getCol($sql);
				foreach($fileid as $val2){
					@unlink($config['upload']['document']."$val/$val2");
				}
				rmdir($config['upload']['document'].$val);
			}

			$sql = "DELETE
					FROM xxtransportdocumentfile
					WHERE xtransportdocumentid IN ($id)";
			$db->query($sql);		
		}
		redirect("index.php?section=$section&module=transport-admin&step=transport&frm_id=$transportid&popup=$popup&refreshparent=doc");
		break;
	case 'docoutput':
		$sql = "SELECT xxtd1.xtransportdocumentid, xxtd1.xdocumentnumber AS xdocumentnumber, xxtd2.xdocumentnumber AS xolddocumentnumber, xdocument, xxtd1.xdocumentdate
				FROM xxtransportdocument AS xxtd1
				LEFT JOIN (
					SELECT * 
					FROM xxtransportdocument
				) AS xxtd2 ON ( xxtd1.xtransportdocumentid = xxtd2.xoldtransportdocumentid ) 
				LEFT JOIN xxdocument ON ( xxtd1.xdocumentid = xxdocument.xdocumentid )
				WHERE xxtd1.xtransportid = '$transportid'
				ORDER BY xxtd1.xdocumentid, xxtd1.xdocumentdate";
		$documentlist = $db->getAll($sql);
		$smarty->assign('id', $transportid);
		$smarty->assign_by_ref('documentlist', $documentlist);
		$smarty->display('transport-document-ext.tpl');
		die();
		break;
	case 'cargooutput':
		$sql = "SELECT xtransportcontainerid, GROUP_CONCAT(xcommodity SEPARATOR ', ')AS xcommodity, xcarrytype, xcontainernumber, xtransportcargoid
				FROM xxtransportcontainer
				NATURAL LEFT JOIN xxtransportcargo
				NATURAL LEFT JOIN zzcontainer
				WHERE xtransportid = '$transportid'
				GROUP BY xtransportcontainerid";
		$cargolist = $db->getAll($sql);
		$smarty->assign('id', $transportid);
		$smarty->assign_by_ref('cargolist', $cargolist);
		$smarty->display('transport-cargo-ext.tpl');
		die();
		break;
	default:
		$document = $db->getList('xxdocument', '', '', 'xdocument');
		$sql = "SELECT *
				FROM xxtransportdocument
				WHERE xtransportdocumentid = '$id'";
		$list = $db->getRow($sql);
		
		//select all documents for this transport for correction
		$sql = "SELECT xtransportdocumentid, xdocumentnumber, xdocument
						 FROM xxtransportdocument
						 NATURAL LEFT JOIN xxdocument
						 WHERE xtransportid = '$transportid' AND xtransportdocumentid != '$id'";
		$res = $db->getAll($sql);
		foreach($res as $key => $val){
			$documenttypenumber[$val['xtransportdocumentid']] = $val['xdocument']." / ".$val['xdocumentnumber'];
		}
		
		//select comments related to this transport
		$sql = "SELECT xtransportcomment FROM xxtransportcomment
				WHERE xtransportid = '$transportid' AND xcommenttype = 'Transportdoc'";
		$res = $db->getCol($sql);
		$comments = implode("<br>", $res);
		
		if($list){
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
		}
		$cmd = empty($id)? "add" : "update&frm_id=$id";
		$form = new HTML_QuickForm('form1', 'POST', "index.php?section=$section&module=transport-admin&page=$page&step=document&cmd=$cmd&transportid=$transportid&popup=$popup");
		$form->addElement('select', 'frm_documentid', T_('Document'), $document, "dir='ltr'");
		$form->addElement('text', 'frm_documentnumber', T_('Document No'), "dir='ltr'");
		
		$grp[] =& HTML_QuickForm::createElement('text', 'frm_documentdate', NULL, "id='frm_documentdate' dir='ltr'");
		$grp[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0);", '<img border="0" src="../images/calendar.png" width="16" height="16" alt="" />', 'onclick="return showCalendar(\'frm_documentdate\', \'y-mm-dd\');"');
		$form->addGroup($grp, NULL, T_('Date'));

		// image
		if($id){
			$sql = "SELECT *
					FROM xxtransportdocumentfile
					WHERE xtransportdocumentid = '$id'";
			$file = $db->getAll($sql);
			foreach($file as $val){
				if(file_exists($config['upload']['document']."$id/$val[xtransportdocumentfileid]")){
					$ext = strtolower(end(explode('.', $val['xfilename'])));
					$img[] =& HTML_QuickForm::createElement('static');
					if($ext != 'pdf'){
						$img[] =& HTML_QuickForm::createElement('image', NULL, "showpic.php?w=59&mh=63&module=transport&folder=$id&pic=$val[xtransportdocumentfileid]", "onclick='openNewWindow(\"../global/showpic.php?mw=600&mh=400&output=html&&module=transport&folder=$id&pic=$val[xtransportdocumentfileid]\", 640, 480, \"noscroll\"); return false;' style='width: 59px;'");
					}else{
						$img[] =& HTML_QuickForm::createElement('link', NULL, NULL, "download.php?module=transportdocument&id=$val[xtransportdocumentfileid]&dir=document&folder=$id", "<img src='../images/symbol-pdf.gif' border='0px'>");
					}
					$img[] =& HTML_QuickForm::createElement('link', NULL, NULL, "index.php?section=$section&module=transport-admin&cmd=deleteimg&frm_id=$id&img=$val[xtransportdocumentfileid]&step=document&transportid=$transportid&popup=$popup", T_('Delete'));
				}
			}
		}
		$img[] =& HTML_QuickForm::createElement('static', NULL, NULL, '<div id="frm_filebox" style="clear: both">');
		$img[] =& HTML_QuickForm::createElement('file', 'frm_file1', T_('Image'), 'dir="ltr"');
		$img[] =& HTML_QuickForm::createElement('static', NULL, NULL, '</div>');
		$img[] =& HTML_QuickForm::createElement('link', NULL, NULL, "javascript:void(0)", T_('More'), "onclick='newFileInput();'");
		$form->addGroup($img, NULL, T_('Image'), array('<div style="float:left; text-direction:rtl; text-align:center; margin-right: 40px;">', "<br />", "</div>"));

		$form->addElement('hidden', 'frm_filenum', 1, 'id="frm_filenum"');	

		$comment[] =& HTML_QuickForm::createElement('static', NULL, NULL, $comments."<br>");
		$comment[] =& HTML_QuickForm::createElement('textarea', "frm_transportdocumentcommnet", NULL, "dir='ltr'");
		$form->addGroup($comment, NULL, T_('Comment'));
		
		if(@$default['frm_oldtransportdocumentid']){
			$form->addElement('checkbox', 'frm_correction', T_('Correction'), NULL, 'checked; onclick="if(this.checked)frm_oldtransportdocumentid.style.display=\'inline\';else frm_oldtransportdocumentid.style.display=\'none\';"');
			$form->addElement('select', 'frm_oldtransportdocumentid', '', @$documenttypenumber, 'dir="ltr" style="display:inline"');
		}else{
			$form->addElement('checkbox', 'frm_correction', T_('Correction'), NULL, 'onclick="if(this.checked)frm_oldtransportdocumentid.style.display=\'inline\';else frm_oldtransportdocumentid.style.display=\'none\';"');
			$form->addElement('select', 'frm_oldtransportdocumentid', '', @$documenttypenumber, 'dir="ltr" style="display:none"');
		}
		$form->setDefaults(@$default);
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();		
}
?>
