<?php

class MAIL {

	public $newmail;
	public $unread;
	
	public function __construct()
	{
		global $user;
		if(empty($_SESSION['mailinstall'])){
			$this->install();
			$_SESSION['mailinstall'] = 1;
		}
		if($user->id){
			$this->checkMail($user->id);
		}
	}
	
	public function __destruct()
	{}
	
	public function uninstall()
	{
		global $db, $mailconfig;
		
		//### drop tables
		$sql = "DROP TABLE IF EXISTS `xxmail_body`";
		$res = $db->query($sql);
		$sql = "DROP TABLE IF EXISTS `xxmail_userbody`";
		$res = $db->query($sql);
		$sql = "DROP TABLE IF EXISTS `xxmail_zzuser`";
		$res = $db->query($sql);
	}
	
	private function install()
	{
		global $mailconfig, $db;
		//###create table if NOT EXIST
		
		//table mail_body
		$sql = "CREATE TABLE IF NOT EXISTS `xxmail_body` (
				`xbodyid` int(11) NOT NULL auto_increment,
				`xfrom` varchar(20) default NULL,
				`xto` text collate utf8_persian_ci,
				`xcc` text collate utf8_persian_ci,
				`xsubject` varchar(255) collate utf8_persian_ci default NULL,
				`xbody` text collate utf8_persian_ci,
				`xtime` timestamp NULL default CURRENT_TIMESTAMP,
				`xpriority` enum('normal','low','high') collate utf8_persian_ci default 'normal',
				`xattachment` varchar(256) collate utf8_persian_ci default NULL,				
				PRIMARY KEY (`xbodyid`),
				KEY 		(`xfrom`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);
		
		//table mail_userbody
		$sql = "CREATE TABLE IF NOT EXISTS `xxmail_userbody` (
				`xuserbodyid` int(11) NOT NULL auto_increment,
				`xusernameid` varchar(20) default NULL,
				`xbodyid` int(11) default NULL,
				`xtype` enum('to','cc','from') collate utf8_persian_ci NOT NULL default 'to',
				`xsession` varchar(32) collate utf8_persian_ci default NULL COMMENT 'for follow replay random number',
				`xuserbodystatus` enum('read','unread') collate utf8_persian_ci NOT NULL default 'unread' COMMENT 'read,unread',
				`xnotifydate` timestamp NULL default NULL,
				`xdir` enum('inbox','sent','draft') collate utf8_persian_ci NOT NULL default 'inbox',
				PRIMARY KEY (`xuserbodyid`),
				KEY 		(`xusernameid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);
		
		//view mail_zzuser
		$sql = "SHOW TABLES LIKE 'xxmail_zzuser'";
		$res = $db->query($sql);
		
		if($db->affectedRows()==0){
			$sql = "CREATE VIEW `xxmail_zzuser` AS {$mailconfig['zzuser']}";
			$res = $db->query($sql);
		}
	}
	
	public function view($userbodyid)
	{
		global $db, $user;
		
		//### update msg table
		$sql = "UPDATE xxmail_userbody
				SET xuserbodystatus='read' ,xnotifydate=NOW()
				WHERE xuserbodyid='$userbodyid' AND xusernameid='$user->id' AND xuserbodystatus='unread'";
		$res = $db->query($sql);
		
		$sql = "SELECT * , xpriority+0 as xpriority, xxmail_zzuser.xusername as xfrom
				, SUBSTRING(xto,2,(LENGTH(xto)-2)) as xto, SUBSTRING(xcc,2,(LENGTH(xcc)-2)) as xcc
				FROM xxmail_userbody
				LEFT JOIN(xxmail_body)
				USING(xbodyid)
				LEFT JOIN(xxmail_zzuser)
				ON(xxmail_zzuser.xusernameid=xxmail_body.xfrom)
				WHERE xuserbodyid='$userbodyid' AND xxmail_userbody.xusernameid='$user->id'";
		$list = $db->getRow($sql);
		return($list);
	}
	
	public function delete($userbodyid)
	{
		global $db,$user,$mailconfig;
		
		//### fetch email info
		$sql = "SELECT xbodyid
				FROM xxmail_userbody
				LEFT JOIN (xxmail_body)
				USING (xbodyid)
				WHERE xbodyid =(
								SELECT xbodyid
								FROM xxmail_userbody
								LEFT JOIN (xxmail_body)
								USING (xbodyid)
								WHERE xuserbodyid='$userbodyid'
								)";
		$list = $db->query($sql);
		$numrows = $list->numRows();
		if ($numrows <= 1){
			$sql = "DELETE xxmail_body.*, xxmail_userbody.*
					FROM xxmail_userbody
					LEFT JOIN xxmail_body
					Using(xbodyid)
					WHERE xuserbodyid = '$userbodyid' AND xusernameid='$user->id'";
			$res = $db->query($sql);
			$row = $list->fetchRow();
			unlink($mailconfig['upload']['attachment'].$row['xbodyid']);
		}else{
			$sql = "DELETE FROM xxmail_userbody
					WHERE xuserbodyid = '$userbodyid' AND xusernameid='$user->id'
					limit 1";
			$res = $db->query($sql);
		}
		if(PEAR::isError($res)){
			return 0;
		}else{
			return 1;
		}
	}
	
	private function bodyInfo($userbodyid, $checkusernameid=1)
	{
		global $db,$user;
		$sql = "SELECT xbodyid, xattachment
				FROM xxmail_userbody
				LEFT JOIN(xxmail_body)
				USING(xbodyid)
				WHERE xuserbodyid='$userbodyid'";
		if(!empty($checkusernameid)){
			$sql .= "AND xusernameid='$user->id'";
		}
		$list = $db->getRow($sql, array(), DB_FETCHMODE_ORDERED); 
		return($list);		
	}
	
	public function downloadAttachment($userbodyid)
	{
		global $mailconfig;
		list($bodyid, $attachment) = $this->bodyInfo($userbodyid);
		header("Content-type: filetype({$mailconfig['upload']['attachment']}.$bodyid)); Content-Disposition: attachment; charset=utf-8"); //for download file
		$mime_type = (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT']) and preg_match('@Safari/([0-9]*)@', $_SERVER['HTTP_USER_AGENT'])) ?
					'application/octet-stream' : 'text/x-sql';
		header("Content-type: ".$mime_type);
		header("Content-Disposition: attachment; filename=$attachment; charset=utf-8");
		echo file_get_contents($mailconfig['upload']['attachment'].$bodyid);
		die();	
	}
	
	public function formdata($link='', $type, $list=array())
	{
		global $msg, $mailconfig, $section, $module, $db;
		$default = array();
		if(!empty($list)) {
			foreach($list as $key => $val){
				$default['frm_'.substr($key, 1, strlen($key))] = $val;
			}
		}
		$priority = $db->fetchEnum('xxmail_body', 'xpriority');
		$priority = translate($priority, $msg['mail']);
		
		$form = new HTML_QuickForm('form1', 'POST', @$link);
		if($type=='view'){
			$form->addElement('text','frm_from',$msg['mail']['from'], "class='text-input' dir='ltr'");
		}
		$grp = array();
		$grp[] =& HTML_QuickForm::createElement('text','frm_to',NULL, "id='frm_to' class='text-input' dir='ltr'");
		$grp[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<a href=javascript:openNewWindow('index.php?section=$section&module=mail-receiver&frm_target=frm_to');>".$msg['mail']['to']."</a>");
		$form->addGroup($grp, NULL, $msg['mail']['to']);
		$grp = array();
		$grp[] =& HTML_QuickForm::createElement('text','frm_cc',NULL, "id='frm_cc' class='text-input' dir='ltr'");
		$grp[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<a href=javascript:openNewWindow('index.php?section=$section&module=mail-receiver&frm_target=frm_cc');>".$msg['mail']['to2']."</a>");
		$form->addGroup($grp, NULL, $msg['mail']['cc']);
		$form->addElement('text','frm_subject',$msg['mail']['subject'], "class='text-input'");
		$form->addElement('textarea','frm_body',$msg['mail']['body'], "class='textarea-input' rows='7' style='width:500px'");	
		$form->addElement('select','frm_priority',$msg['mail']['priority'], $priority, "class='select-input'");

		if(file_exists($mailconfig['upload']['attachment'].$list['xbodyid']) and !is_dir($mailconfig['upload']['attachment'].$list['xbodyid'])){
			if($type!='view'){
				$img[] =& HTML_QuickForm::createElement('checkbox', 'frm_deleteattachment', NULL, $msg['mail']['deleteattachment'],'class="checkbox-input"');
				$img[] =& HTML_QuickForm::createElement('file', 'frm_file', NULL, 'class="file-input"');
			}			
			$img[] =& HTML_QuickForm::createElement('static', NULL, NULL, "<a href='index.php?section=$section&module=$module&cmd=download&frm_id=$list[xuserbodyid]'><img border='0' src='../images/icons/48x48/mail-attach.png' align='absmiddle' />$list[xattachment]</a>");
		}else{		
			$img[] =& HTML_QuickForm::createElement('file', 'frm_file', NULL, 'class="file-input"');
		}
		$form->addGroup($img, NULL, $msg['mail']['attachment'], array('<br /><br />', '<br />', '<br />'));
		
		$form->addElement('hidden','cmd');
		$form->addElement('hidden','frm_id', $list['xuserbodyid']);
		$form->addElement('hidden','frm_dir', $list['xdir']);
		$form->addElement('hidden','type');		
		$form->setDefaults($default);
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();

		return($formData);						
	}
	
	public function findReceiver($userlist, $link)
	{
		// userlist = array(0 => array( 'label' => 'name1...'
		//								'member'=> array(username1, username2)),
		// 					1 => array( 'label' => 'name2...'
		//								'member'=> array(username1, username2)),
		//					2 => array( 'label' => 'name3...'
		//								'member'=> array(username1, username2)),
		//					OR
		//					3 => array( 'label' => 'name4...'
		//								'member'=> 'admin', /*group name*/
		//					...
		//					)
		global $user;
		
		$form = new HTML_QuickForm('form1', 'POST', @$link);
		
		foreach($userlist as $key => $val){
			if(!is_array($val['member'])){//------------------------------------------------------
				$form->addElement('static' ,NULL ,NULL ,"<label><input type='checkbox' name='frm_group[]' value='$val[member]' class='checkbox-input' style='width:20px;' /> $val[label]</label>");
			}else{
				$html = "<label> $val[label] ";
				$html .= "<select name='frm_receiver[]' multiple='multiple' class='select-input' dir='ltr'>";
				foreach($val['member'] as $k => $v){
					$html .= "<option value='$v'>$v</option>"; 
				}
				$html .= "</select>";
				$html .= "</label>";
				$form->addElement('static' ,NULL ,NULL ,$html);			
			}
		}
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();

		return($formData);		
	}
	
	public function saveToDraft($list, $userbodyid='')
	{
		global $db, $user, $mailconfig;
		$flag = 1;
		$db->autoCommit(false);
		
		$list['frm_to'] = trim($list['frm_to']);				
		$list['frm_to'] = explode(',', $list['frm_to']);
		$list['frm_cc'] = trim($list['frm_cc']);		
		$list['frm_cc'] = explode(',', $list['frm_cc']);
		
		list($bodyid, $attachment) = $this->bodyInfo(@$userbodyid);

		$fields_values = array();
		if(!empty($list['frm_deleteattachment'])){
			$fields_values['xattachment'] = '';
		}else{
			$fields_values['xattachment'] = !empty($_FILES["frm_file"]["name"])? $_FILES["frm_file"]["name"] : $attachment;
		}
			
		if(!empty($userbodyid) and $list['frm_dir']=='draft'){
			$fields_values = $fields_values + array( 
								'xto'			=> @!empty($list['frm_to']) ? ",".implode(",", $list['frm_to'])."," : "",
								'xcc'			=> @!empty($list['frm_cc']) ? ",".implode(",", $list['frm_cc'])."," : "",
								'xsubject'		=> @fa_normalize($list['frm_subject'], true),
								'xbody'			=> @fa_normalize($list['frm_body'], true),
								'xpriority'		=> @intval($list['frm_priority']),
								);
			$res = $db->autoExecute('xxmail_body', $fields_values, DB_AUTOQUERY_UPDATE, "xbodyid='$bodyid'");
			$flag = $flag and !DB::isError($res);
		}else{
			$sourcebodyid = $bodyid;
			$fields_values = array( 
								'xfrom'			=> $user->id,
								'xto'			=> @!empty($list['frm_to']) ? ",".implode(",", $list['frm_to'])."," : "",
								'xcc'			=> @!empty($list['frm_cc']) ? ",".implode(",", $list['frm_cc'])."," : "",
								'xsubject'		=> @fa_normalize($list['frm_subject'], true),
								'xbody'			=> @fa_normalize($list['frm_body'], true),
								'xpriority'		=> @intval($list['frm_priority']),
								'xattachment'	=> !empty($_FILES["frm_file"]["name"])? $_FILES["frm_file"]["name"] : '',								
								);
			$res = $db->autoExecute('xxmail_body', $fields_values, DB_AUTOQUERY_INSERT);
			$flag = $flag and !DB::isError($res);
			$bodyid = $db->getOne("SELECT @@IDENTITY");
			
			$fields_values = array( 
								'xusernameid'	=> $user->id,
								'xbodyid'		=> $bodyid,
								'xtype'			=> 'from',
								'xdir'			=> 'draft',
								);
			$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
			$flag = $flag and !DB::isError($res);
		}
		if (!$flag){
			$db->rollBack();
			return 0;
		}
		// upload file
		if(empty($list['frm_deleteattachment'])){
			if(!empty($_FILES["frm_file"]["tmp_name"]) and !empty($bodyid)){
				@move_uploaded_file($_FILES["frm_file"]["tmp_name"] ,$mailconfig['upload']['attachment'].$bodyid);
			}elseif($attachment and !empty($bodyid)){
				copy($mailconfig['upload']['attachment'].$sourcebodyid, $mailconfig['upload']['attachment'].$bodyid);
			}
		}else{
			unlink($mailconfig['upload']['attachment'].$bodyid);
		}
		
		$db->commit();
		$db->autoCommit(true);
		return 1;
	}
	
	public function send($list, $typereplay=0)
	{
		global $db, $mailconfig, $user;
		
		$flag = 1;
		$db->autoCommit(false);

		$list['frm_to'] = trim($list['frm_to']);				
		$list['frm_to'] = explode(',', $list['frm_to']);
		$list['frm_cc'] = trim($list['frm_cc']);		
		$list['frm_cc'] = explode(',', $list['frm_cc']);

		// fetch msg info
		$sql = "SELECT xfrom, xsession, xattachment, xbodyid
				FROM xxmail_userbody 
				LEFT JOIN (xxmail_body) 
				USING (xbodyid) 
				WHERE xuserbodyid='$list[frm_id]'";
		$mailinfo = $db->getRow($sql);

		if(!empty($list['frm_deleteattachment'])){
			$fields_values['xattachment'] = '';
		}else{
			$fields_values['xattachment'] = !empty($_FILES["frm_file"]["name"])? $_FILES["frm_file"]["name"] : $mailinfo['xattachment'];
		}
		
		if($typereplay){ //### replay
			$fields_values = $fields_values + array( 
								'xfrom'			=> $user->id,
								'xto'			=> @!empty($list['frm_to']) ? ",".implode(",", $list['frm_to'])."," : "",
								'xcc'			=> @!empty($list['frm_cc']) ? ",".implode(",", $list['frm_cc'])."," : "",
								'xsubject'		=> @fa_normalize($list['frm_subject'], true),
								'xbody'			=> @fa_normalize($list['frm_body'], true),
								'xpriority'		=> @intval($list['frm_priority']),
								);
			$res = $db->autoExecute('xxmail_body', $fields_values, DB_AUTOQUERY_INSERT);
			$flag = $flag and !DB::isError($res);
			$bodyid = $db->getOne("SELECT @@IDENTITY");
			
			//from				
			$fields_values = array(
								'xusernameid'	=> $user->id,
								'xbodyid'		=> $bodyid,
								'xtype'			=> 'from',
								'xsession'		=> $mailinfo['xsession'],
								'xdir'			=> 'sent',
								);
			$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
			$flag = $flag and !DB::isError($res);				
						
			if(in_array($mailinfo['xfrom'], $list['frm_to'] , TRUE)){
				$key = array_search($mailinfo['xfrom'], $list['to']);
				unset($list['to'][$key]);
				
				//replay
				$fields_values = array( 
									'xusernameid'	=> $mailinfo['xfrom'],
									'xbodyid'		=> $bodyid,
									'xtype'			=> 'to',
									'xsession'		=> $mailinfo['xsession'],
									'xdir'			=> 'inbox',
									);
				$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
				$flag = $flag and !DB::isError($res);
			}
			
			// to
			for($i=0;$i<count($list['frm_to']);$i++){
				if(preg_match('/^\[[^\]]+\]$/',$list['frm_to'][$i])){ // send to group [groupname]
					$userlist = $user->fetchGroupMember(substr($list['frm_to'][$i],1, strlen($list['frm_to'][$i])-2));
					foreach($userlist as $userid){
						if(!empty($userid)){
							$fields_values = array( 
												'xusernameid'	=> $userid,
												'xbodyid'		=> $bodyid,
												'xtype'			=> 'to',
												'xsession'		=> random(10,1),
												'xdir'			=> 'inbox',
												);
							$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
							$flag = $flag and !DB::isError($res);
						}	
					}
				}else{ //send to a member
					$userid = $user->getuserid($list['frm_to'][$i]);
					if(!empty($userid)){
						$fields_values = array( 
											'xusernameid'	=> $userid,
											'xbodyid'		=> $bodyid,
											'xtype'			=> 'to',
											'xsession'		=> random(10,1),
											'xdir'			=> 'inbox',
											);
						$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
						$flag = $flag and !DB::isError($res);
					}	
				}
			}
			//cc
			for($i=0;$i<count($list['frm_cc']);$i++){
				if(preg_match('/^\[[^\]]+\]$/', $list['frm_cc'][$i])){ // send to group [groupname]
					$userlist = $user->fetchGroupMember(substr($list['frm_cc'][$i],1, strlen($list['frm_cc'][$i])-2));
					foreach($userlist as $userid){
						if(!empty($userid)){
							$fields_values = array( 
											'xusernameid'	=> $userid,
											'xbodyid'		=> $bodyid,
											'xtype'			=> 'cc',
											'xsession'		=> random(10,1),
											'xdir'			=> 'inbox',
												);
							$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
							$flag = $flag and !DB::isError($res);
						}	
					}
				}else{ //send to a member
					$userid = $user->getuserid($list['frm_cc'][$i]);
					if(!empty($userid)){
						$fields_values = array( 
											'xusernameid'	=> $userid,
											'xbodyid'		=> $bodyid,
											'xtype'			=> 'cc',
											'xsession'		=> random(10,1),
											'xdir'			=> 'inbox',
											);
						$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
						$flag = $flag and !DB::isError($res);
					}
				}
			}
		}else{ //###compose & forward
			$fields_values = $fields_values + array( 
								'xfrom'			=> $user->id,
								'xto'			=> @!empty($list['frm_to']) ? ",".implode(",", $list['frm_to'])."," : "",
								'xcc'			=> @!empty($list['frm_cc']) ? ",".implode(",", $list['frm_cc'])."," : "",
								'xsubject'		=> @fa_normalize($list['frm_subject'], true),
								'xbody'			=> @fa_normalize($list['frm_body'], true),
								'xpriority'		=> @intval($list['frm_priority']),
								);
			$res = $db->autoExecute('xxmail_body', $fields_values, DB_AUTOQUERY_INSERT);
			$flag = $flag and !DB::isError($res);
			$bodyid = $db->getOne("SELECT @@IDENTITY");

			$fields_values = array( 
								'xusernameid'	=> $user->id,
								'xbodyid'		=> $bodyid,
								'xtype'			=> 'from',
								'xsession'		=> random(10,1),
								'xdir'			=> 'sent',
								);
			$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
			$flag = $flag and !DB::isError($res);				

			// insert to msguser table for 'to' field
			for($i=0;$i<count($list['frm_to']);$i++){
				if(preg_match('/^\[[^\]]+\]$/', $list['frm_to'][$i])){ // send to group [groupname]
					$userlist = $user->fetchGroupMember(substr($list['frm_to'][$i],1, strlen($list['frm_to'][$i])-2));
					foreach($userlist as $userid){
						if(!empty($userid)){
							$fields_values = array( 
											'xusernameid'	=> $userid,
											'xbodyid'		=> $bodyid,
											'xtype'			=> 'to',
											'xsession'		=> random(10,1),
											'xdir'			=> 'inbox',
												);
							$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
							$flag = $flag and !DB::isError($res);
						}	
					}
				}else{ //send to a member
					$userid = $user->getuserid($list['frm_to'][$i]);
					if(!empty($userid)){
						$fields_values = array( 
											'xusernameid'	=> $userid,
											'xbodyid'		=> $bodyid,
											'xtype'			=> 'to',
											'xsession'		=> random(10,1),
											'xdir'			=> 'inbox',
											);
						$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
						$flag = $flag and !DB::isError($res);
					}
				}
			}
			// insert to msguser table for 'cc' field
			for($i=0;$i<count($list['frm_cc']);$i++){
				if(preg_match('/^\[[^\]]+\]$/', $list['frm_cc'][$i])){ // send to group [groupname]
					$userlist = $user->fetchGroupMember(substr($list['frm_cc'][$i],1, strlen($list['frm_cc'][$i])-2));
					foreach($userlist as $userid){
						if(!empty($userid)){
							$fields_values = array( 
											'xusernameid'	=> $userid,
											'xbodyid'		=> $bodyid,
											'xtype'			=> 'cc',
											'xsession'		=> random(10,1),
											'xdir'			=> 'inbox',
												);
							$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
							$flag = $flag and !DB::isError($res);
						}	
					}
				}else{ //send to a member
					$userid = $user->getuserid($list['frm_cc'][$i]);
					if(!empty($userid)){
						$fields_values = array( 
											'xusernameid'	=> $userid,
											'xbodyid'		=> $bodyid,
											'xtype'			=> 'cc',
											'xsession'		=> random(10,1),
											'xdir'			=> 'inbox',
											);
						$res = $db->autoExecute('xxmail_userbody', $fields_values, DB_AUTOQUERY_INSERT);
						$flag = $flag and !DB::isError($res);
					}
				}
			}
		}
		// upload file
		if(empty($list['frm_deleteattachment'])){
			if(!empty($_FILES["frm_file"]["tmp_name"]) and !empty($bodyid)){
				@move_uploaded_file($_FILES["frm_file"]["tmp_name"] ,$mailconfig['upload']['attachment'].$bodyid);
			}elseif($mailinfo['xattachment'] and !empty($bodyid)){
				copy($mailconfig['upload']['attachment'].$mailinfo['xbodyid'], $mailconfig['upload']['attachment'].$bodyid);
			}
		}else{
			unlink($mailconfig['upload']['attachment'].$bodyid);
		}
		if (!$flag){
			$db->rollBack();
			$db->autoCommit(true);			
			return 0;
		}
		
		$db->commit();
		$db->autoCommit(true);
		return 1;
	}
	
	// type=forward, replay, draft
	public function edit($userbodyid, $type='draft')
	{
		global $user, $db;
		$list = array();
		switch($type){
			case 'replay':
				// msg with out attachment
				$sql = "SELECT *
						, CONCAT('RE: ', xsubject) as xsubject
						, CONCAT('\\n\\n\\nOn ',xtime, ' ',xusername,' wrote:\\n', xbody) as xbody
						, xusername as xto
						, SUBSTRING(xcc,2,(LENGTH(xcc)-2)) as xcc
						, xpriority+0 as xpriority
						FROM xxmail_userbody
						LEFT JOIN(xxmail_body)
						USING(xbodyid)
						LEFT JOIN(xxmail_zzuser)
						ON(xxmail_zzuser.xusernameid=xxmail_body.xfrom)
						WHERE xuserbodyid='$userbodyid' AND xxmail_userbody.xusernameid='$user->id'";
				$list = $db->getRow($sql);
				break;
			case 'forward':
				// msg with attachment
				$sql = "SELECT *
						, CONCAT('FWD: ', xsubject) as xsubject
						, CONCAT('\\n\\n---------- Forwarded message ----------\\nFrom: ',
								 xusername, '\\nDate: ', xtime, 
								 '\\nSubject: ', xsubject, '\\n',xbody) as xbody
						, '' as xto
						, SUBSTRING(xcc,2,(LENGTH(xcc)-2)) as xcc
						, xpriority+0 as xpriority
						FROM xxmail_userbody
						LEFT JOIN(xxmail_body)
						USING(xbodyid)
						LEFT JOIN(xxmail_zzuser)
						ON(xxmail_zzuser.xusernameid=xxmail_body.xfrom)
						WHERE xuserbodyid='$userbodyid' AND xxmail_userbody.xusernameid='$user->id'";
				$list = $db->getRow($sql);			
				break;
			case 'draft': //from draft
				$sql = "SELECT * 
						, SUBSTRING(xcc,2,(LENGTH(xcc)-2)) as xcc
						, SUBSTRING(xto,2,(LENGTH(xto)-2)) as xto
						,xpriority+0 as xpriority
						FROM xxmail_userbody
						LEFT JOIN(xxmail_body)
						USING(xbodyid)
						WHERE xuserbodyid='$userbodyid' AND xusernameid='$user->id'";
				$list = $db->getRow($sql);
		}
		return($list);
	}
	
	public function inbox($paging=0, $sort='xtime', $sortorder='DESC', $page=0)
	{
		global $db, $user, $mailconfig;
		$sql = "SELECT xxmail_body.*, xusername as xfrom, xuserbodyid, SUBSTRING(xbody,1, 50) as xbody, xuserbodystatus
				FROM xxmail_userbody 
				LEFT JOIN xxmail_body 
				USING( xbodyid )
				LEFT JOIN(xxmail_zzuser) 
				ON(xxmail_body.xfrom=xxmail_zzuser.xusernameid)
				WHERE xxmail_userbody.xusernameid='$user->id' AND xdir='inbox'";
		if($paging){
			return($this->paging($sql));
		}
		$sort = empty($sort)? 'xtime': $sort;
		$sortorder = ($sortorder=='DESC')? $sortorder : 'ASC';				
		$list = $db->getAll($sql." ORDER BY $sort $sortorder LIMIT $page, $mailconfig[maxrow]");
		return($list);		
	}
	
	public function sent($paging=0, $sort='xtime', $sortorder='DESC', $page=0)
	{
		global $db, $user, $mailconfig;
		$sql = "SELECT xxmail_body.*, xuserbodyid, SUBSTRING(xbody,1, 50) as xbody, xuserbodystatus
				, SUBSTRING(xto,2,(LENGTH(xto)-2)) as xto
				FROM xxmail_userbody 
				LEFT JOIN xxmail_body 
				USING( xbodyid )
				LEFT JOIN(xxmail_zzuser) 
				ON(xxmail_body.xfrom=xxmail_zzuser.xusernameid)
				WHERE xxmail_userbody.xusernameid='$user->id' AND xdir='sent'";
		if($paging){
			return($this->paging($sql));
		}	
		$sort = empty($sort)? 'xtime': $sort;
		$sortorder = ($sortorder=='DESC')? $sortorder : 'ASC';				
		$list = $db->getAll($sql." ORDER BY $sort $sortorder LIMIT $page, $mailconfig[maxrow]");
		return($list);				
	}
	
	public function draft($paging=0, $sort='xtime', $sortorder='DESC', $page=0)
	{
		global $db, $user, $mailconfig;	
		$sortorder = ($sortorder=='DESC')? $sortorder : 'ASC';			
		$sql = "SELECT xxmail_body.*, xuserbodyid, SUBSTRING(xbody,1, 50) as xbody, xuserbodystatus
				, SUBSTRING(xto,2,(LENGTH(xto)-2)) as xto
				FROM xxmail_userbody 
				LEFT JOIN xxmail_body 
				USING( xbodyid )
				LEFT JOIN(xxmail_zzuser) 
				ON(xxmail_body.xfrom=xxmail_zzuser.xusernameid)
				WHERE xxmail_userbody.xusernameid='$user->id' AND xdir='draft'";
		if($paging){
			return($this->paging($sql));
		}				
		$sort = empty($sort)? 'xtime': $sort;
		$sortorder = ($sortorder=='DESC')? $sortorder : 'ASC';				
		$list = $db->getAll($sql." ORDER BY $sort $sortorder LIMIT $page, $mailconfig[maxrow]");
		return($list);			
	}
	
	public function paging($sql)
	{
		global $db, $mailconfig;
		$res =& $db->query($sql);
		$list['numrow']  = $res->numRows();	
		$list['maxpage'] = empty($list['numrow']) ? 1 : ceil($list['numrow']/$mailconfig['maxrow']);
		return $list;		
	}
	
	public function checkMail($userid)
	{
		global $db;
		$sql = "SELECT xsubject, xbody, xuserbodyid, xxmail_zzuser.xusername as xfrom
				FROM xxmail_userbody
				LEFT JOIN(xxmail_body)
				USING(xbodyid)
				LEFT JOIN(xxmail_zzuser)
				ON(xxmail_body.xfrom=xxmail_zzuser.xusernameid)
				WHERE xxmail_userbody.xusernameid='$userid' AND xdir='inbox' AND xuserbodystatus='unread'";
		$list = $db->getAll($sql);

		$this->newmail = count($list);
		$this->unread = $list;
		return($list);
	}
}
?>