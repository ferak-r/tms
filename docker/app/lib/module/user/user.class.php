<?php

class USER {
	public $id;
	static public $badpassno = 0;
	public $logedin;
	public $lastlogin;
	public $time;
	public $browser;
	public $ip;
	public $userinfo;
	public $table;
	public $error;
	
	
	//### user funtion
	public function __construct()
	{
		global $userconfig;
		if(headers_sent()){
			die("user class error");
		}
		$this->table['action'] = $userconfig['tableprefix'].'action';
		$this->table['group'] = $userconfig['tableprefix'].'group';
		$this->table['groupaction'] = $userconfig['tableprefix'].'groupaction';
		$this->table['groupuser'] = $userconfig['tableprefix'].'groupuser';
		$this->table['name'] = $userconfig['tableprefix'].'username';
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->browser = $_SERVER['HTTP_USER_AGENT'];

		$this->prepare();
	}
	
	private function prepare()
	{
		global $userconfig;
		//$this->checkCookie();
		if(!($this->id = @$_SESSION[$userconfig['user']['UserId']])){
			$this->install();
		}else{
			$this->info = $this->getInfo();
			unset($this->info['password']);
			$this->group = array_flip($this->groupInfo());
		}
	}
	
	public function __destruct()
	{}
	
	private function install()
	{
		global $userconfig, $db;
		//###create table if NOT EXIST
		
		//table name
		$sql = "CREATE TABLE IF NOT EXISTS `{$userconfig['tableprefix']}username` (
				  `{$userconfig['fieldprefix']}usernameid` varchar(20) NOT NULL,
				  `{$userconfig['fieldprefix']}username` varchar(128) collate utf8_persian_ci NOT NULL,
				  `{$userconfig['fieldprefix']}password` varchar(256) collate utf8_persian_ci NOT NULL,
				  `{$userconfig['fieldprefix']}userstatus` enum('Inactive','Active') collate utf8_persian_ci NOT NULL default 'Inactive',
				  PRIMARY KEY  (`{$userconfig['fieldprefix']}usernameid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci";
		$res = $db->query($sql);
		
		//table info
		foreach($userconfig['table'] as $tablename => $val){
			$sql = "CREATE TABLE IF NOT EXISTS `{$tablename}` (";
			foreach($val as $fieldname => $type){
				$sql .= " `{$userconfig['fieldprefix']}$fieldname`  $type,";
			}
			$keys 	 = array_keys($val);
			$primary = $keys[0];
			$key 	 = $keys[1];
			$sql .= " PRIMARY KEY  ($userconfig[fieldprefix]$primary),
					  KEY          ($userconfig[fieldprefix]$key)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
			$res = $db->query($sql);
		}
		
		//table action
		$sql = "CREATE TABLE IF NOT EXISTS `{$userconfig['tableprefix']}action` (
				  `{$userconfig['fieldprefix']}actionid` int(20) unsigned NOT NULL auto_increment,
				  `{$userconfig['fieldprefix']}f1` varchar(128) collate utf8_persian_ci default NULL,
				  `{$userconfig['fieldprefix']}f2` varchar(128) collate utf8_persian_ci default NULL,
				  `{$userconfig['fieldprefix']}f3` varchar(128) collate utf8_persian_ci default NULL,
				  `{$userconfig['fieldprefix']}f4` varchar(128) collate utf8_persian_ci default NULL,
				  `{$userconfig['fieldprefix']}f5` varchar(128) collate utf8_persian_ci default NULL,
				  `{$userconfig['fieldprefix']}f6` varchar(128) collate utf8_persian_ci default NULL,
				  PRIMARY KEY  (`{$userconfig['fieldprefix']}actionid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);
		
		//table group
		$sql = "CREATE TABLE IF NOT EXISTS `{$userconfig['tableprefix']}group` (
				  `{$userconfig['fieldprefix']}groupid` int(20) unsigned NOT NULL auto_increment,
				  `{$userconfig['fieldprefix']}group` varchar(128) collate utf8_persian_ci NOT NULL,
				  PRIMARY KEY  (`{$userconfig['fieldprefix']}groupid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);
		
		//table groupaction
		$sql = "CREATE TABLE IF NOT EXISTS `{$userconfig['tableprefix']}groupaction` (
				  `{$userconfig['fieldprefix']}groupactionid` int(20) unsigned NOT NULL auto_increment,
				  `{$userconfig['fieldprefix']}groupid` int(20) NOT NULL,
				  `{$userconfig['fieldprefix']}actionid` int(20) NOT NULL,
				  PRIMARY KEY  (`{$userconfig['fieldprefix']}groupactionid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);
		
		//table groupuser
		$sql = "CREATE TABLE IF NOT EXISTS `{$userconfig['tableprefix']}groupuser` (
				  `{$userconfig['fieldprefix']}groupuserid` int(20) unsigned NOT NULL auto_increment,
				  `{$userconfig['fieldprefix']}usernameid` varchar(20) NOT NULL,
				  `{$userconfig['fieldprefix']}groupid` int(20) unsigned NOT NULL,
				  PRIMARY KEY  (`{$userconfig['fieldprefix']}groupuserid`),
				  KEY 		   (`{$userconfig['fieldprefix']}usernameid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);
		
		$res = $db->multiQuery($userconfig['sql']);
	}
	
	public function uninstall()
	{
		global $db, $userconfig;
		
		//### drop tables
		$sql = "DROP TABLE IF EXISTS `{$userconfig['tableprefix']}username`";
		$res = $db->query($sql);
		$sql = "DROP TABLE IF EXISTS `{$userconfig['tableprefix']}action`";
		$res = $db->query($sql);
		$sql = "DROP TABLE IF EXISTS `{$userconfig['tableprefix']}group`";
		$res = $db->query($sql);
		$sql = "DROP TABLE IF EXISTS `{$userconfig['tableprefix']}groupaction`";
		$res = $db->query($sql);
		$sql = "DROP TABLE IF EXISTS `{$userconfig['tableprefix']}groupuser`";
		$res = $db->query($sql);

		foreach($userconfig['table'] as $tablename => $val){
			$sql = "DROP TABLE IF EXISTS `{$tablename}`";
			$res = $db->query($sql);
		}
	}
	
	// add user $user=array(),$status=1(فعال) status=0(غیر فعال)
	public function add($user, $infotable, $status=0)
	{
		global $db, $userconfig;
		$this->error = NULL;
		$username  = @$db->escapeSimple(strtolower(trim($user["username"])));
		$password  = @$user["password"];
		$repassword = @$user['repassword'];

		$sql = "SELECT `{$userconfig['fieldprefix']}usernameid`
				FROM `{$userconfig['tableprefix']}username`
				WHERE `{$userconfig['fieldprefix']}username`='$username'";
		$res = $db->getOne($sql);
		if($res){ //check user unigue
			//msg($msg['usernameError']['unique'], 'error', 'اخطار');
			$this->error = __LINE__.': duplication in username';
			return 0;
		}elseif(strlen($username)<$userconfig['min_username_len']){ //username lenght
			//msg($msg['usernameError']['lenght'], 'error', 'اخطار');
			$this->error = __LINE__.': username is smaller than '.$userconfig['min_username_len'];	
			return 0;					
		}elseif($password!=$repassword){ //EQUAL password and repassword
			//msg($msg['passwordError']['confirm'], 'error', 'اخطار');
			$this->error = __LINE__.': username is smaller than '.$userconfig['min_username_len'];	
			return 0;			
		}elseif(strlen($password)<$userconfig['min_pass_len']){ //password lenght
			//msg($msg['passwordError']['lenght'], 'error', 'اخطار');
			$this->error = __LINE__.': username is smaller than '.$userconfig['min_pass_len'];	
			return 0;			
		}else{//every things seen ok	
			// insert to user table
			@$fields_values = array(
					"{$userconfig['fieldprefix']}username"	=> $username,
					"{$userconfig['fieldprefix']}password"	=> sha1($password),
					"{$userconfig['fieldprefix']}userstatus"=> ($status==1)? 'Active': 'Inactive',					
							);
			$res = $db->autoExecute("{$userconfig['tableprefix']}username", $fields_values, DB_AUTOQUERY_INSERT);
			$userid = $db->getOne("SELECT @@IDENTITY");
							
			if(!empty($userid)){
				// insert to info
				unset($user['username'], $user['password'], $user['repassword']);
				$fields_values = array();
				foreach($user as $key => $val){
					$fields_values["{$userconfig['fieldprefix']}$key"] = $val;
				}
				$fields_values["{$userconfig['fieldprefix']}usernameid"] = $userid;
				$res = $db->autoExecute("{$userconfig['tableprefix']}{$infotable}", $fields_values, DB_AUTOQUERY_INSERT);							
				if(PEAR::isError($res)){
					$this->error = __LINE__.': error in add information';
					return 0;
					//msg($msg['Error'], 'error', 'اخطار');
				}else{
					return($userid);
				}
			}else{
				$this->error = __LINE__.': error in add user';
				return 0;
			}
		}
	}
	

	// add username $user=array(),$status=1(فعال) status=0(غیر فعال)
	public function checkUsername($user)
	{
		global $db, $userconfig, $msg;
		$this->error = NULL;
		$usernameid = @$user["xusernameid"];
		$username   = @$db->escapeSimple(strtolower(trim($user["xusername"])));
		$password   = @$user["xpassword"];
		$repassword = @$user['xrepassword'];

		$sql = "SELECT `{$userconfig['fieldprefix']}usernameid`
				FROM `{$userconfig['tableprefix']}username`
				WHERE `{$userconfig['fieldprefix']}username`='$username' AND `{$userconfig['fieldprefix']}userstatus`='Active'";
		$res = $db->getOne($sql);
		if($res){ //check user unigue
			msg($msg['user']['usernameError']['unique'], 'error', 'Alert');
			$this->error = __LINE__.': duplication in username';
			return 0;
		}elseif(strlen($username)<$userconfig['min_username_len']){ //username lenght
			msg($msg['user']['usernameError']['lenght'], 'error', 'Alert');
			$this->error = __LINE__.': username is smaller than '.$userconfig['min_username_len'];	
			return 0;					
		}elseif($password!=$repassword){ //EQUAL password and repassword
			msg($msg['user']['passwordError']['confirm'], 'error', 'Alert');
			$this->error = __LINE__.': username is smaller than '.$userconfig['min_username_len'];	
			return 0;			
		}elseif(strlen($password)<$userconfig['min_pass_len']){ //password lenght
			msg($msg['user']['passwordError']['lenght'], 'error', 'Alert');
			$this->error = __LINE__.': username is smaller than '.$userconfig['min_pass_len'];	
			return 0;			
		}else{//every things seen ok	
			return 1;
		}
	}

	// active user
	public function activate($userid)
	{
		global $db, $userconfig;
		$userid = @intval($userid);
		$sql = "UPDATE {$userconfig['tableprefix']}username
				SET {$userconfig['fieldprefix']}userstatus='Active'
				WHERE {$userconfig['fieldprefix']}usernameid='$userid'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			return 0;
			//msg($msg['Error'], 'error', 'اخطار');
		}else{
			return 1;
		}
	}
	
	// inactive user
	public function suspend($userid, $freeusername=0)
	{
		global $db, $userconfig;
		$userid = @intval($userid);
		$username = $this->getInfo('', 'username', $userid);
		$sql = "SELECT IFNULL(MAX(INSTR( {$userconfig['fieldprefix']}username, '$username' )),1)
				FROM {$userconfig['tableprefix']}username
				WHERE {$userconfig['fieldprefix']}username LIKE '%~$username%'";
		$number = $db->getOne($sql);
		$sql = "UPDATE {$userconfig['tableprefix']}username
				SET {$userconfig['fieldprefix']}userstatus='Inactive'";
		$sql .= !empty($freeusername) ? ", {$userconfig['fieldprefix']}username=concat(REPEAT('~', $number),{$userconfig['fieldprefix']}username)":  "";
		$sql .= " WHERE {$userconfig['fieldprefix']}usernameid='$userid'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			return 0;
			//msg($msg['Error'], 'error', 'اخطار');
		}else{
			return 1;
		}
	}
	
	public function login($username, $password, $remember=false)
	{
		global $db, $userconfig;
		
		$sql = "SELECT {$userconfig['fieldprefix']}usernameid 
				FROM {$userconfig['tableprefix']}username
				WHERE {$userconfig['fieldprefix']}password='".sha1($password)."' 
				AND {$userconfig['fieldprefix']}username='".$db->escapeSimple(strtolower(trim($username)))."'
				AND {$userconfig['fieldprefix']}userstatus='Active'";
		$this->id = $db->getOne($sql);
		if($this->id){						
			//savepass
			if(!empty($remember)){
				$this->savepass($this->id, $username, $password);
			}
			$_SESSION[$userconfig['user']['UserId']] = $this->id;
			$this->prepare();
			$this->logedin = 1;
			$this->badpassno = 0;
			$this->time = date("Y-m-d H:i:s");
			return $this->id;
		}else{
			$this->badpassno++;		
			$this->logout();
			return 0;
		}
	}
	
	public function checkCookie()
	{
		global $db, $userconfig;
		
		if(!empty($this->id)){
			return $this->id;
		}elseif(isset($_COOKIE[$userconfig['savepass']['CookieField']])){
			$sql = "SELECT {$userconfig['fieldprefix']}usernameid
					FROM {$userconfig['tableprefix']}username
					WHERE sha1(md5(CONCAT({$userconfig['fieldprefix']}usernameid,{$userconfig['fieldprefix']}username,{$userconfig['fieldprefix']}password,'{$_SERVER['REMOTE_ADDR']}','{$userconfig['sitekey']}')))='{$_COOKIE[$userconfig['savepass']['CookieField']]}'";
			$this->id = $db->getOne($sql);
			if(!empty($this->id)){
				$_SESSION[$userconfig['user']['UserId']] = $this->id;
				return $this->id;
			}else{
				//delete $_COOKIE
				@setcookie($userconfig['savepass']['CookieField'], '', time()-3600000,"/"); 
				return 0;
			}
		}else{
			return 0;
		}		
	}
	
	// user change password
	public function changePass($userid, $oldpassword, $password, $repassword, $admin=0)
	{
		global $db, $userconfig, $msg;
		$password  = @addslashes(trim($password));
		$repassword = @addslashes(trim($repassword));
		$oldpassword = @addslashes(trim($oldpassword));
		$sql = "SELECT {$userconfig['fieldprefix']}username
				FROM {$userconfig['tableprefix']}username
				WHERE {$userconfig['fieldprefix']}usernameid='$userid' ".
				(empty($admin) ? " AND {$userconfig['fieldprefix']}password=sha1('$oldpassword')" : "");
		$username = $db->getOne($sql);
		if(empty($username)){ //check user and pass 
			$this->error = $msg['user']['passwordError']['error'];
			return 0;
		}elseif($password!=$repassword){ //EQUAL password and repassword
			$this->error = $msg['user']['passwordError']['confirm'];
			return 0;
		}elseif(strlen($password)<$userconfig['min_pass_len']){ //password lenght
			$this->error = $msg['user']['passwordError']['lenght'];
			return 0;
		}else{//every things seen ok	
			// insert to xxuser table
			$fields_values = array(
							"{$userconfig['fieldprefix']}password"		=> sha1($password),
							);
			$res = $db->autoExecute("{$userconfig['tableprefix']}username", $fields_values, DB_AUTOQUERY_UPDATE, "{$userconfig['fieldprefix']}usernameid='$userid'");
			if(PEAR::isError($res)){
				return 0;
				//msg($msg['Error'], 'error', 'اخطار');
			}else{
				$this->savePass($userid, $username, $password);
				return 1;
			}
		}
	}
	
	// save user password in COOKIE
	public function savePass($userid, $username, $password)
	{
		global $userconfig;
		setcookie($userconfig['savepass']['CookieField'], sha1(md5($userid.$username.sha1($password).$_SERVER['REMOTE_ADDR'].$userconfig['sitekey'])), time() + 3600000,"/");
	}
	
	public function logout($redirect=NULL)
	{
		global $userconfig;
		@session_unset();
		@session_destroy();
		$this->id = NULL;
		setcookie($userconfig['savepass']['CookieField'], '', time()-3600000,"/"); 
		if(!empty($redirect)){ 
			redirect($redirect);
		}
		$this->logedin = 0;
		return 1;
	}
		
	// delete user
	public function delete($userid)
	{
		global $db, $userconfig;
		$userid = @intval($userid);
		
		$table = '';
		$leftjoin = '';
		foreach($userconfig['table'] as $tablename => $val){
			$table .= ", {$tablename}";
			$leftjoin .= " LEFT JOIN ($tablename)
						USING({$userconfig['fieldprefix']}usernameid)";
		}
		$sql = "DELETE {$userconfig['tableprefix']}username, {$userconfig['tableprefix']}groupuser $table
				FROM {$userconfig['tableprefix']}username
				$leftjoin
				LEFT JOIN({$userconfig['tableprefix']}groupuser)
				USING({$userconfig['fieldprefix']}usernameid)
				WHERE {$userconfig['fieldprefix']}usernameid='$userid'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			return 0;
			//msg($msg['Error'], 'error', 'اخطار');
		}else{
			return 1;
		}
	}
	
	public function getuserid($username)
	{
		global $userconfig, $db;
		$sql = "SELECT xusernameid
				FROM {$userconfig['tableprefix']}username
				WHERE {$userconfig['fieldprefix']}username='".$db->escapeSimple(strtolower(trim($username)))."'";
		$res = $db->getOne($sql);
		return $res;
	}
	
	// get user info field can be separate by , 
	//$table: info
	public function getInfo($table='', $field='*', $userid=0)
	{
		global $db, $userconfig;
		$field = explode(',', $field);		
		$userid = empty($userid) ? $this->id : $userid;
		$tbllist = (empty($table)) ? $userconfig['table'] : array($table=>'');
		foreach ($field as $key=>$val) {		// add field prefix to filed names
			$val = trim($val);
			$field[$key] = (empty($val) or $val=='*') ? '*' : $userconfig['fieldprefix'].$val;
		}
		$field = implode(', ', $field);
		
		// try to fetch data from all information tables
		foreach ($tbllist as $tblkey=>$tblval) {	
			$sql = "SELECT $field
					FROM {$tblkey}
					LEFT JOIN ({$userconfig['tableprefix']}username)
					USING ({$userconfig['fieldprefix']}usernameid)
					WHERE {$userconfig['fieldprefix']}usernameid = '$userid'";
			$res = $db->getRow($sql);
			if(!PEAR::isError($res) and !empty($res)) {
				foreach ($res as $key=>$val) {			
					//delete field prefix from result keys
					$res2[substr($key, strlen($userconfig['fieldprefix']), strlen($key)-strlen($userconfig['fieldprefix']))] = $val;
				}
				return (count($res2)==1) ? current($res2) : $res2;
			}		
		}
		return NULL;		
	}
		
	// update user info $user=array(gender=>زن, name=>xxx, family, cityid, tel, address, email, userdes)
	public function changeInfo($userid, $user)
	{
		global $db, $userconfig;
		//update info
		$fields_values = array();
		foreach($user as $key => $val){
			$fields_values[$userconfig['fieldprefix'].$key] = $val;
		}
		//find witch table
		foreach($userconfig['table'] as $tablename => $val){
			$sql = "SELECT {$userconfig['fieldprefix']}{$tablename}id 
					FROM {$tablename}
					WHERE {$userconfig['fieldprefix']}usernameid='$userid'";
			$tableid = $db->getOne($sql);
			if(!empty($tableid)){
				$res = $db->autoExecute("{$userconfig['tableprefix']}{$tablename}", $fields_values, DB_AUTOQUERY_UPDATE, "{$userconfig['fieldprefix']}usernameid='$userid'");
				
				if(PEAR::isError($res)){
					$this->error = __LINE__.': error in update';
					return 0;
					//msg($msg['Error'], 'error', 'اخطار');
				}else{
					return 1;
				}
			}
		}
		$this->error = __LINE__.': no table found';
		return 0;
	}
	
	//### php function
	public function checkPermision($f1=NULL, $f2=NULL, $f3=NULL, $f4=NULL, $f5=NULL, $f6=NULL, $userid=NULL)
	{
		global $db, $userconfig;
		$userid = @empty($userid)? $this->id : $userid;
		$sql = "SELECT {$userconfig['fieldprefix']}groupactionid
				FROM {$userconfig['tableprefix']}groupaction
				LEFT JOIN({$userconfig['tableprefix']}action)
				USING({$userconfig['fieldprefix']}actionid)
				LEFT JOIN({$userconfig['tableprefix']}group)
				USING({$userconfig['fieldprefix']}groupid)
				LEFT JOIN({$userconfig['tableprefix']}groupuser)
				USING({$userconfig['fieldprefix']}groupid)
				WHERE {$userconfig['fieldprefix']}usernameid='$userid' ".
					(($f1===NULL)? " AND {$userconfig['fieldprefix']}f1 IS NULL" : " AND {$userconfig['fieldprefix']}f1='$f1'").
					(($f2===NULL)? " AND {$userconfig['fieldprefix']}f2 IS NULL" : " AND {$userconfig['fieldprefix']}f2='$f2'").
					(($f3===NULL)? " AND {$userconfig['fieldprefix']}f3 IS NULL" : " AND {$userconfig['fieldprefix']}f3='$f3'").
					(($f4===NULL)? " AND {$userconfig['fieldprefix']}f4 IS NULL" : " AND {$userconfig['fieldprefix']}f4='$f4'"). 
					(($f5===NULL)? " AND {$userconfig['fieldprefix']}f5 IS NULL" : " AND {$userconfig['fieldprefix']}f5='$f5'"). 
					(($f6===NULL)? " AND {$userconfig['fieldprefix']}f6 IS NULL" : " AND {$userconfig['fieldprefix']}f6='$f6'");
		$groupaction = $db->getOne($sql);
		if($groupaction){
			return 1;
		}
		return 0;
	}
		
	// add/delete group
	public function manageGroup($cmd='add', $groupname, $actionarray=array())
	{
		//$cmd=add/delete
		global $db, $userconfig;
		switch($cmd){
			case 'add':
				$sql = "SELECT {$userconfig['fieldprefix']}groupid 
						FROM {$userconfig['tableprefix']}group
						WHERE {$userconfig['fieldprefix']}group='$groupname'";
				$groupid = $db->getOne($sql);
				if(!$groupid){ // add
					$fields_values = array(
									"{$userconfig['fieldprefix']}group"	=> $groupname,
									);
					$res = $db->autoExecute("{$userconfig['tableprefix']}group", $fields_values, DB_AUTOQUERY_INSERT);
					if(PEAR::isError($res)){
						return 0;
					}
					$groupid = $db->getOne("SELECT @@IDENTITY");
					if(is_array($actionarray)){
						foreach($actionarray as $actionid){
							$actionid = intval($actionid);
							if(!empty($actionid)){
								$sql = "SELECT * 
										FROM {$userconfig['tableprefix']}groupaction
										WHERE {$userconfig['fieldprefix']}groupid='$groupid' AND {$userconfig['fieldprefix']}actionid='$actionid'";
								$res = $db->query($sql);
								if($res->numRows()==0){
									$fields_values = array(
													"{$userconfig['fieldprefix']}groupid"	=> $groupid,
													"{$userconfig['fieldprefix']}actionid"	=> $actionid,
													);
									$res = $db->autoExecute("{$userconfig['tableprefix']}groupaction", $fields_values, DB_AUTOQUERY_INSERT);
									if(PEAR::isError($res)){
										return 0;
									}
								}
							}
						}	
					}else{
						$actionid = intval($actionarray);
						if(!empty($actionid)){
							$sql = "SELECT * 
									FROM {$userconfig['tableprefix']}groupaction
									WHERE {$userconfig['fieldprefix']}groupid='$groupid' AND {$userconfig['fieldprefix']}actionid='$actionid'";
							$res = $db->query($sql);
							if($res->numRows()==0){						
								$fields_values = array(
												"{$userconfig['fieldprefix']}groupid"	=> $groupid,
												"{$userconfig['fieldprefix']}actionid"	=> $actionid,
												);
								$res = $db->autoExecute("{$userconfig['tableprefix']}groupaction", $fields_values, DB_AUTOQUERY_INSERT);
								if(PEAR::isError($res)){
									return 0;
								}
							}
						}
					}
					return 1; // every thnigs ok										
				}elseif(!empty($actionarray)){ //update
					if(is_array($actionarray)){
						foreach($actionarray as $actionid){
							$actionid = intval($actionid);
							if(!empty($actionid)){
								$sql = "SELECT * 
											FROM {$userconfig['tableprefix']}groupaction
											WHERE {$userconfig['fieldprefix']}groupid='$groupid' AND {$userconfig['fieldprefix']}actionid='$actionid'";
								$res = $db->query($sql);
								if($res->numRows()==0){
									$fields_values = array(
													"{$userconfig['fieldprefix']}groupid"	=> $groupid,
													"{$userconfig['fieldprefix']}actionid"	=> $actionid,
													);
									$res = $db->autoExecute("{$userconfig['tableprefix']}groupaction", $fields_values, DB_AUTOQUERY_INSERT);
									if(PEAR::isError($res)){
										return 0;
									}
								}
							}
						}
					}else{
						$actionid = intval($actionarray);
						if(!empty($actionid)){
							$sql = "SELECT * 
										FROM {$userconfig['tableprefix']}groupaction
										WHERE {$userconfig['fieldprefix']}groupid='$groupid' AND {$userconfig['fieldprefix']}actionid='$actionid'";
							$res = $db->query($sql);
							if($res->numRows()==0){						
								$fields_values = array(
												"{$userconfig['fieldprefix']}groupid"	=> $groupid,
												"{$userconfig['fieldprefix']}actionid"	=> $actionid,
												);
								$res = $db->autoExecute("{$userconfig['tableprefix']}groupaction", $fields_values, DB_AUTOQUERY_INSERT);
								if(PEAR::isError($res)){
									return 0;
								}
							}
						}
					}
					return 1;				
				}
				break;
			case 'delete':
				if(empty($actionarray)){ // delete group, groupaction
					$sql = "DELETE {$userconfig['tableprefix']}group,{$userconfig['tableprefix']}groupaction,{$userconfig['tableprefix']}groupuser 
							FROM {$userconfig['tableprefix']}group
							LEFT JOIN({$userconfig['tableprefix']}groupaction)
							USING({$userconfig['fieldprefix']}groupid)							
							LEFT JOIN({$userconfig['tableprefix']}groupuser)
							USING({$userconfig['fieldprefix']}groupid)						
							WHERE {$userconfig['fieldprefix']}group='$groupname'";
					$res = $db->query($sql);
					if(PEAR::isError($res)){
						return 0;
						//msg($msg['Error'], 'error', 'اخطار');
					}
					return 1;
				}else{ // delete just groupaction
					$actionid = is_array($actionarray)? array_map('intval', $actionarray): intval($actionarray);
					$actionid = @implode(",", $actionarray);
					$sql = "DELETE {$userconfig['tableprefix']}group,{$userconfig['tableprefix']}groupaction 
							FROM {$userconfig['tableprefix']}groupaction					
							WHERE {$userconfig['fieldprefix']}actionid IN ($actionid)";
					$res = $db->query($sql);
					if(PEAR::isError($res)){
						return 0;
						//msg($msg['Error'], 'error', 'اخطار');
					}			
					return 1;
				}
				break;
		}
		return 0;	
	}
	
	// add/delete action
	public function manageAction($cmd='add', $f1=NULL, $f2=NULL, $f3=NULL, $f4=NULL, $f5=NULL, $f6=NULL)
	{
		//$cmd=add/delete, f1= section, f2= module, f3=action, f4=cmd2, ...
		global $db, $userconfig;
		switch($cmd){
			case 'add':
				$condition  = ($f1!==NULL)	? " AND {$userconfig['fieldprefix']}f1='$f1'": "";
				$condition .= ($f2!==NULL)	? " AND {$userconfig['fieldprefix']}f2='$f2'": "";
				$condition .= ($f3!==NULL) 	? " AND {$userconfig['fieldprefix']}f3='$f3'": "";
				$condition .= ($f4!==NULL) 	? " AND {$userconfig['fieldprefix']}f4='$f4'": "";
				$condition .= ($f5!==NULL) 	? " AND {$userconfig['fieldprefix']}f5='$f5'": "";
				$condition .= ($f6!==NULL) 	? " AND {$userconfig['fieldprefix']}f6='$f6'": "";
				$sql = "SELECT {$userconfig['fieldprefix']}actionid 
						FROM {$userconfig['tableprefix']}action
						WHERE 1=1 $condition";
				$res = $db->getOne($sql);
				if(!$res){
					$fields_values = array(
									"{$userconfig['fieldprefix']}f1"		=> $f1,						
									"{$userconfig['fieldprefix']}f2"		=> $f2,						
									"{$userconfig['fieldprefix']}f3"		=> $f3,						
									"{$userconfig['fieldprefix']}f4"		=> $f4,						
									"{$userconfig['fieldprefix']}f5"		=> $f5,						
									"{$userconfig['fieldprefix']}f6"		=> $f6,
									);
					$res = $db->autoExecute("{$userconfig['tableprefix']}action", $fields_values, DB_AUTOQUERY_INSERT);
				}
				break;
			case 'delete':
				$condition = "";
				$condition .= (!empty($f1))		? " AND {$userconfig['fieldprefix']}f1='$f1'": "";
				$condition .= (!empty($f2))		? " AND {$userconfig['fieldprefix']}f2='$f2'": "";
				$condition .= (!empty($f3)) 	? " AND {$userconfig['fieldprefix']}f3='$f3'": "";
				$condition .= (!empty($f4)) 	? " AND {$userconfig['fieldprefix']}f4='$f4'": "";
				$condition .= (!empty($f5)) 	? " AND {$userconfig['fieldprefix']}f5='$f5'": "";
				$condition .= (!empty($f6)) 	? " AND {$userconfig['fieldprefix']}f6='$f6'": "";
				$sql = "DELETE {$userconfig['tableprefix']}action, {$userconfig['tableprefix']}groupaction
						FROM {$userconfig['tableprefix']}action
						LEFT JOIN({$userconfig['tableprefix']}groupaction)
						USING({$userconfig['fieldprefix']}actionid)
						WHERE 1=1 $condition";
				$res = $db->query($sql);
				break;
		}
		if(PEAR::isError($res)){
			return 0;
			//msg($msg['Error'], 'error', 'اخطار');
		}else{
			return 1;
		}		
	}
	
	// add/delete user to/from group
	public function joinGroup($userid, $groupid, $cmd='add')
	{
		global $userconfig, $db;
		$userid = $userid;
		$groupid = intval($groupid);
		switch ($cmd){
			case 'add':
				$sql = "SELECT {$userconfig['fieldprefix']}groupuserid
						FROM {$userconfig['tableprefix']}groupuser
						LEFT JOIN({$userconfig['tableprefix']}group)
						USING({$userconfig['fieldprefix']}groupid)
						WHERE {$userconfig['fieldprefix']}groupid='$groupid' AND {$userconfig['fieldprefix']}usernameid='$userid'";
				$res = $db->getOne($sql);
				if(!$res){
					$fields_values = array(
									"{$userconfig['fieldprefix']}groupid"	=> $groupid,						
									"{$userconfig['fieldprefix']}usernameid"	=> $userid,
									);
					$res = $db->autoExecute("{$userconfig['tableprefix']}groupuser", $fields_values, DB_AUTOQUERY_INSERT);
					if(PEAR::isError($res)){
						return 0;
					}			
				}
				return 1;
				break;
			case 'delete':
				$sql = "DELETE FROM {$userconfig['tableprefix']}groupuser
						WHERE {$userconfig['fieldprefix']}groupid='$groupid' AND {$userconfig['fieldprefix']}usernameid='$userid'
						LIMIT 1";
				$res = $db->query($sql);
				if(PEAR::isError($res)){
					return 0;
				}
				return 1;
				break;
		}
		return 0;
	}
	
	// user's group info
	public function groupInfo($userid=0)
	{
		global $db, $userconfig;
		$userid = empty($userid) ? $this->id : $userid;
		$sql = "SELECT {$userconfig['fieldprefix']}groupid, {$userconfig['fieldprefix']}group 
				FROM {$userconfig['tableprefix']}groupuser
				LEFT JOIN({$userconfig['tableprefix']}group)
				USING({$userconfig['fieldprefix']}groupid)
				WHERE {$userconfig['fieldprefix']}usernameid='$userid'";
		$group = $db->getAll($sql, array(), DB_FETCHMODE_ASSOC | DB_FETCHMODE_FLIPPED);
		if(!empty($group)){
			$group = array_combine($group["{$userconfig['fieldprefix']}groupid"], $group["{$userconfig['fieldprefix']}group"]);
		}
		return ($group);
	}
	
	public function fetchGroup($groupname=NULL)
	{
		global $db, $userconfig;
		
		if(empty($groupname)){
			$sql = "SELECT *
					FROM {$userconfig['tableprefix']}group";
			$group = $db->getAll($sql, array(), DB_FETCHMODE_ASSOC | DB_FETCHMODE_FLIPPED);
		}else{
			$sql = "SELECT *
					FROM {$userconfig['tableprefix']}group
					WHERE {$userconfig['fieldprefix']}group='$groupname'";
			$group = $db->getAll($sql, array(), DB_FETCHMODE_ASSOC | DB_FETCHMODE_FLIPPED);
		}
		if(!empty($group)){
			$group = array_combine($group["{$userconfig['fieldprefix']}groupid"], $group["{$userconfig['fieldprefix']}group"]);
		}
		return($group);
	}
	// $name= 1 fetch fetch group member's username
	public function fetchGroupMember($groupname, $name=0)
	{
		global $userconfig, $db;
		$sql = "SELECT ".
				(empty($name)? "{$userconfig['fieldprefix']}usernameid" : "{$userconfig['fieldprefix']}username")
				." FROM {$userconfig['tableprefix']}group
				LEFT JOIN({$userconfig['tableprefix']}groupuser)
				USING({$userconfig['fieldprefix']}groupid)
				LEFT JOIN({$userconfig['tableprefix']}username)
				USING({$userconfig['fieldprefix']}usernameid)
				WHERE {$userconfig['fieldprefix']}group='$groupname'
				AND {$userconfig['fieldprefix']}userstatus='Active'";
		$userlist = $db->getCol($sql);
		return($userlist);
	}
}
?>