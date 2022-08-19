<?php

class REPORT {
	
	public function __construct()
	{
		if(empty($_SESSION['reportinstall'])){
			$this->install();
			$_SESSION['reportinstall'] = 1;
		}
	}
	
	public function __destruct()
	{}
	
	public function uninstall()
	{
		global $db;
		$sql = "DROP TABLE IF EXISTS `xxreport_favor`";
		$res = $db->query($sql);

		$sql = "DROP TABLE IF EXISTS `xxreport_main`";
		$res = $db->query($sql);

		$sql = "DROP TABLE IF EXISTS `xxreport_showfield`";
		$res = $db->query($sql);

		$sql = "DROP TABLE IF EXISTS `xxreport_wherefield`";
		$res = $db->query($sql);	
	}
	
	private function install()
	{
		global $db,$reportconfig;
		$sql = "CREATE TABLE IF NOT EXISTS `xxreport_favor` (
				  `xfavorid` int(20) unsigned NOT NULL auto_increment,
				  `xfavor` varchar(128) collate utf8_persian_ci default NULL,
				  `xshowfield` text collate utf8_persian_ci NOT NULL,
				  `xsql` text collate utf8_persian_ci,
				  `xfunction` text collate utf8_persian_ci,
				  `xusernameid` int(20) unsigned default NULL,				  
				  PRIMARY KEY  (`xfavorid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);	

		$sql = "CREATE TABLE IF NOT EXISTS `xxreport_main` (
				  `xmainid` int(20) unsigned NOT NULL auto_increment,
				  `xmain` varchar(256) collate utf8_persian_ci NOT NULL,
				  `xsql` text collate utf8_persian_ci NOT NULL,
				  `xgroupby` varchar(256) collate utf8_persian_ci default NULL,
				  `xfunction` text collate utf8_persian_ci,
				  PRIMARY KEY  (`xmainid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);				

		$sql = "CREATE TABLE IF NOT EXISTS `xxreport_showfield` (
				  `xshowfieldid` int(20) unsigned NOT NULL auto_increment,
				  `xmainid` int(20) unsigned NOT NULL,
				  `xfield` varchar(256) collate utf8_persian_ci NOT NULL,
				  `xname` varchar(256) collate utf8_persian_ci NOT NULL,
				  PRIMARY KEY  (`xshowfieldid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);				

		$sql = "CREATE TABLE IF NOT EXISTS `xxreport_wherefield` (
				  `xwherefieldid` int(20) unsigned NOT NULL auto_increment,
				  `xmainid` int(20) unsigned NOT NULL,
				  `xfield` varchar(256) collate utf8_persian_ci NOT NULL,
				  `xname` varchar(256) collate utf8_persian_ci NOT NULL,
				  `xtype` varchar(256) collate utf8_persian_ci NOT NULL,
				  PRIMARY KEY  (`xwherefieldid`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
		$res = $db->query($sql);
		
		// ### table miyani
		// xxreport_groupreport
		$res = $db->query($reportconfig['groupreport']);
		
		// xxreport_groupfavor
		$res = $db->query($reportconfig['groupfavor']);	
	
		//### VIEW
		// xxreport_group
		$res = $db->query($reportconfig['group_view']);
		
		//xxreport_username
		$res = $db->query($reportconfig['username_view']);				
	}
	
	public function add($reportname, $sql, $groupby='', $function=NULL,$showfield, $showname, $wherefield, $wherename, $types, $condition='', $group)
	{
		global $db, $reportconfig, $user;
		$sql = empty($condition)? $sql : $sql.' WHERE ('.$condition.')'; 
		$fields_values = array( 
						'xmain'		=> $reportname,
						'xsql'		=> $sql,
						'xgroupby'	=> $groupby,
						'xfunction'	=> $function,
						);
		$res = $db->autoExecute('xxreport_main', $fields_values, DB_AUTOQUERY_INSERT);
		if(PEAR::isError($res)){
			return(0);
		}
		$mainid = $db->getOne("SELECT @@IDENTITY");
		
		// groupreport
		if(empty($group)){
			$sql = "SELECT xgroupid
					FROM xxreport_group";
			$group = $db->getCol($sql);
		}
		foreach($group as $val){
			$fields_values = array( 
						'xgroupid'	=> $val,
						'xmainid'	=> $mainid,
						);
			$res = $db->autoExecute('xxreport_groupreport', $fields_values, DB_AUTOQUERY_INSERT);
		}
		
		//showfield
		foreach($showfield as $key => $val){
			if(!empty($val)){
				$fields_values = array( 
								'xmainid'	=> $mainid,
								'xfield'	=> $val,
								'xname'		=> $showname[$key],
								);
				$res = $db->autoExecute('xxreport_showfield', $fields_values, DB_AUTOQUERY_INSERT);
			}
		}
		
		//wherefield
		foreach($wherefield as $key => $val){
			if(!empty($val)){
				$fields_values = array( 
								'xmainid'	=> $mainid,
								'xfield'	=> $val,
								'xname'		=> $wherename[$key],
								'xtype'		=> $reportconfig['ColumnTypes'][$types[$key]],
								);
				$res = $db->autoExecute('xxreport_wherefield', $fields_values, DB_AUTOQUERY_INSERT);
			}
		}
		return($mainid);		
	}
	
	public function delete($mainid)
	{
		global $db;
		$sql = "DELETE FROM xxreport_main
				WHERE xmainid='$mainid'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			return(0);
		}
		
		$sql = "DELETE FROM xxreport_showfield
				WHERE xmainid='$mainid'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			return(0);
		}
		
		$sql = "DELETE FROM xxreport_wherefield
				WHERE xmainid='$mainid'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			return(0);
		}		
		
		$sql = "DELETE FROM xxreport_groupreport
				WHERE xmainid='$mainid'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			return(0);
		}
		return(1);			
	}
	
	private function showfield($mainid)
	{
		global $db;
		$sql = "SELECT xfield, xname
				FROM xxreport_showfield
				WHERE xmainid='$mainid'
				ORDER BY xshowfieldid";
		$list = $db->getAll($sql, array(), DB_FETCHMODE_ASSOC | DB_FETCHMODE_FLIPPED);
		$list = array_combine($list['xfield'], $list['xname']);
		return($list);
	}
	
	private function wherefield($mainid, $form=0)
	{
		global $db;
		if(!empty($form)){
			$sql = "SELECT xfield, xname
					FROM xxreport_wherefield
					WHERE xmainid='$mainid'
					ORDER BY xwherefieldid";
			$list = $db->getAll($sql, array(), DB_FETCHMODE_ASSOC | DB_FETCHMODE_FLIPPED);
			if(!empty($list)){
			$list = array_combine($list['xfield'], $list['xname']);
			}
			return($list);
		}
		$sql = "SELECT *
				FROM xxreport_wherefield
				WHERE xmainid='$mainid'
				ORDER BY xwherefieldid";
		$list = $db->getAll($sql);
		return($list);
	}
	
	private function fetchReportBody($mainid)
	{
		global $db;
		$sql = "SELECT xsql, xgroupby, xfunction
				FROM xxreport_main
				WHERE xmainid='$mainid'";
		$list = $db->getRow($sql, array(), DB_FETCHMODE_ORDERED);
		return($list);
	}
	
	private function fetchFavorBody($mainid)
	{
		global $db;
		$sql = "SELECT xsql, xshowfield, xfunction
				FROM xxreport_favor
				WHERE xfavorid='$mainid'";
		$list = $db->getRow($sql, array(), DB_FETCHMODE_ORDERED);
		return($list);
	}
	
	private function saveAsFavor($favorname, $showfield, $sql, $groupid=NULL, $function=NULL)
	{
		global $db, $user;
		$fields_values = array( 
						'xfavor'		=> $favorname,
						'xshowfield'	=> $showfield,
						'xsql'			=> $sql,
						'xfunction'	=> $function,
						'xusernameid'	=> empty($groupid)? $user->id : NULL,
						);
		$res = $db->autoExecute('xxreport_favor', $fields_values, DB_AUTOQUERY_INSERT);
		trace($res);
		if(PEAR::isError($res)){
			return(0);
		}
		$favorid = $db->getOne("SELECT @@IDENTITY");
		
		if(!empty($groupid)){
			foreach($groupid as $val){
				$fields_values = array( 
								'xgroupid'		=> $val,
								'xfavorid'		=> $favorid,
								);
				$res = $db->autoExecute('xxreport_groupfavor', $fields_values, DB_AUTOQUERY_INSERT);
				trace($res);
			}
		}
		return($favorid);
	}
	
	public function deleteFavor($favorid)
	{
		global $db;
		$sql = "DELETE FROM xxreport_favor
				WHERE xfavorid='$favorid'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			return(0);
		}
		
		$sql = "DELETE FROM xxreport_groupfavor
				WHERE xfavorid='$favorid'";
		$res = $db->query($sql);
		if(PEAR::isError($res)){
			return(0);
		}
		return(1);
	}

	private function PMA_sqlAddslashes($a_string = '', $is_like = false, $crlf = false, $php_code = false)
    {
        if ($is_like) {
            $a_string = str_replace('\\', '\\\\\\\\', $a_string);
        } else {
            $a_string = str_replace('\\', '\\\\', $a_string);
        }

        if ($crlf) {
            $a_string = str_replace("\n", '\n', $a_string);
            $a_string = str_replace("\r", '\r', $a_string);
            $a_string = str_replace("\t", '\t', $a_string);
        }

        if ($php_code) {
            $a_string = str_replace('\'', '\\\'', $a_string);
        } else {
            $a_string = str_replace('\'', '\'\'', $a_string);
        }

        return $a_string;
    }
	
	public function createQuery($reportid, $showfield, $wherefield, $operator, $value, $value_min, $value_max, $type, $orderby, $sortorder='DESC', $limit='', $maxrow=45, $favor='', $groupid=NULL)
	{
		global $reportconfig; 
		$sql_query = 'SELECT ';

		$sql_query .= @implode( ', ', $showfield );
			
		list($body, $groupby, $function) = $this->fetchReportBody($reportid);
		$sql_query .= ' '.$body;

		// The where clause
		$cnt_operator = count($operator);
		@reset($operator);
		while (list($i, $operator_type) = @each($operator)) {
			if (@$reportconfig['unary']['operator'][$operator_type] == 1) {
				$value[$i] = '';
				$w[] = $wherefield[$i] . ' ' . $operator_type;

			} elseif (strncasecmp($type[$i], 'enum', 4) == 0) {
				if (!empty($value[$i])) {
					if (!is_array($value[$i])) {
						$value[$i] = explode(',', $value[$i]);
					}
					$enum_selected_count = count($value[$i]);
					if ($operator_type == '=' && $enum_selected_count > 1) {
						$operator_type    = $operator[$i] = 'IN';
						$parens_open  = '(';
						$parens_close = ')';

					} elseif ($operator_type == '!=' && $enum_selected_count > 1) {
						$operator_type    = $operator[$i] = 'NOT IN';
						$parens_open  = '(';
						$parens_close = ')';

					} else {
						$parens_open  = '';
						$parens_close = '';
					}
					$enum_where = '\'' . $this->PMA_sqlAddslashes($value[$i][0]) . '\'';
					for ($e = 1; $e < $enum_selected_count; $e++) {
						$enum_where .= ', ';
						$tmp_literal = '\'' . $this->PMA_sqlAddslashes($value[$i][$e]) . '\'';
						$enum_where .= $tmp_literal;
						unset($tmp_literal);
					}

					$w[] = $wherefield[$i] . ' ' . $operator_type . ' ' . $parens_open . $enum_where . $parens_close;
				}

			} elseif ($value[$i] != '') {
				// LIKE %...%
				if ($operator_type == 'LIKE %...%') {
					$operator_type = 'LIKE';
					$value[$i] = '%' . $value[$i] . '%';
				}
				$w[] = $wherefield[$i] . ' ' . $operator_type . " '" . $this->PMA_sqlAddslashes($value[$i])."' ";

			}elseif($operator_type=='BETWEEN' && $value_min[$i]!='' && $value_max[$i]!=''){
				$w[] = $wherefield[$i] . ' ' . $operator_type . ' ' . $this->PMA_sqlAddslashes($value_min[$i]) . ' AND ' . $this->PMA_sqlAddslashes($value_max[$i]);
			} // end if
			
		} // end for
		
		$findwhere = strpos($sql_query, ' WHERE '); 
		if(!empty($w)){
			if($findwhere === false ){
				$sql_query .= ' WHERE '. implode(' AND ', $w);
			}else{
				$sql_query .= ' AND ' . implode(' AND ', $w);
			}
		}
		if(!empty($groupby)){
			$sql_query .= ' GROUP BY '.$groupby;
		}
		$sql_query .= ' ORDER BY ' . $orderby . ' ' . $sortorder;
		if(!empty($limit)){
			$sql_query .= ' LIMIT 0, '.intval($limit);
		}
		// save as favor
		if(!empty($favor)){
			$showname = $this->showname($reportid, $showfield); 
			$this->saveAsFavor($favor, implode("\n",$showname), $sql_query, $groupid,$function);
		}
				
		return($this->result(0, $reportid, $sql_query, $function, $showfield, 0,$maxrow));
	}
	
	public function reportList($paging=0, $checkuser=1, $sort='xmain', $sortorder='DESC', $page=0)
	{
		global $db, $reportconfig, $user;
		if(!empty($checkuser)){
			$sql = "SELECT xgroupid
					FROM xxreport_group";
			$group = $db->getCol($sql);
			$group = implode(',', $group);
			$sql = "SELECT *, xmainid as xreportid,
					GROUP_CONCAT(xgroup ORDER BY xgroup ASC SEPARATOR ', ') as xgroup			
					FROM xxreport_groupreport
					LEFT JOIN(xxreport_main)
					USING(xmainid)
					LEFT JOIN(xxreport_group)
					USING(xgroupid)
					WHERE xxreport_groupreport.xgroupid IN ($group)
					GROUP BY xmainid";
		}else{
			$sql = "SELECT *, xmainid as xreportid, 
					GROUP_CONCAT(xgroup ORDER BY xgroup ASC SEPARATOR ', ') as xgroup
					FROM xxreport_groupreport
					LEFT JOIN(xxreport_main)
					USING(xmainid)
					LEFT JOIN(xxreport_group)
					USING(xgroupid)
					GROUP BY xmainid";
		}
		
		if($paging){
			return($this->paging($sql));
		}
		$sort = empty($sort)? 'xmain': $sort;
		$sortorder = ($sortorder=='DESC')? $sortorder : 'ASC';				
		$list = $db->getAll($sql." ORDER BY $sort $sortorder LIMIT $page, $reportconfig[maxrow]");
		return($list);
	}
		
	public function favorList($paging=0, $checkuser=1, $sort='xfavor', $sortorder='DESC', $page=0)
	{
		global $db, $reportconfig, $user;
		if(!empty($checkuser)){
			$sql = "SELECT xgroupid
					FROM xxreport_group";
			$group = $db->getCol($sql);
			$group = implode(',', $group);
			$sql = "SELECT *, xfavorid as xreportid			
					FROM xxreport_favor
					LEFT JOIN(xxreport_groupfavor)
					USING(xfavorid)
					WHERE xxreport_groupfavor.xgroupid IN ($group) OR xusernameid='$user->id'
					GROUP BY xfavorid";
		}else{
			$sql = "SELECT *, xfavorid as xreportid
					FROM xxreport_favor
					LEFT JOIN(xxreport_groupfavor)
					USING(xfavorid)
					GROUP BY xfavorid";
		}				
		if($paging){
			return($this->paging($sql));
		}
		$sort = empty($sort)? 'xfavor': $sort;
		$sortorder = ($sortorder=='DESC')? $sortorder : 'ASC';				
		$list = $db->getAll($sql." ORDER BY $sort $sortorder LIMIT $page, $reportconfig[maxrow]");
		return($list);
	}
	
	// for admin make result from report
	public function reportFormdata($link, $reportid)
	{
		global $db, $reportconfig, $msg, $user;
		
		$showfield = $this->showfield($reportid);
		$wherefield = $this->wherefield($reportid);
		
		$form = new HTML_QuickForm('form1', 'POST', @$link, '_blank');
		
		//showfield
		$form->addElement('select','showfield', $msg['report']['showfield'], $showfield, "class='select-input' multiple='multiple'");

		//wherefield
		foreach($wherefield as $key => $val){
			$operator = array();
			if (strncasecmp($val['xtype'], 'enum', 4) == 0) {
				$operator = $reportconfig['enum']['operator'];
			} elseif (preg_match('@char|blob|text|set@i', $val['xtype'])) {
				$operator = $operator + $reportconfig['text']['operator'];
			} else {
				$operator = $operator + $reportconfig['num']['operator'];
			} // end if... else...
			$operator = $operator + $reportconfig['null']['operator'];
		
			$grp = array();
			$grp[] =& HTML_QuickForm::createElement('select',"operator[$key]", NULL, $operator, "class='select-input' style='width:100px' onchange='checkBetween($key);'");
			$grp[] =& HTML_QuickForm::createElement('text',"value[$key]", NULL, "class='text-input' style='width:100px'");
			$grp[] =& HTML_QuickForm::createElement('text',"value_min[$key]", NULL, "class='text-input' style='width:40px'");
			$grp[] =& HTML_QuickForm::createElement('text',"value_max[$key]", NULL, "class='text-input' style='width:40px'");
			$grp[] =& HTML_QuickForm::createElement('hidden',"wherefield[$key]", $val['xfield']);
			$grp[] =& HTML_QuickForm::createElement('hidden',"types[$key]", $val['xtype']);
			$form->addGroup($grp, NULL, $val['xname'], array('',"<span id='between$key' style='display:none'>&nbsp;".$msg['report']['from'],"&nbsp;".$msg['report']['to'], "</span>"));
		}
		//order by			
		$orderby = array() + $this->wherefield($reportid, 1);
		$grp = array();
		$form->addElement('select',"orderby", $msg['report']['orderby'], $orderby, "class='select-input' style='width:100px'");
		$grp[] =& HTML_QuickForm::createElement('radio', NULL, NULL, $msg['report']['ascending'], 'ASC', "style='width:20px'");
		$grp[] =& HTML_QuickForm::createElement('radio', NULL, NULL, $msg['report']['descending'], 'DESC',"style='width:20px'");
		$form->addGroup($grp, 'sortorder', NULL);

		//favor
		$form->addElement('text',"favor", $msg['report']['favor'], "class='text-input'");
		if(!empty($user->group['admin'])){
			$sql = "SELECT xgroupid , xgroup
					FROM xxreport_group";
			$group = $db->getAll($sql, array(), DB_FETCHMODE_ASSOC | DB_FETCHMODE_FLIPPED);
			$group = array_combine($group['xgroupid'], $group['xgroup']);
		
			$form->addElement('select',"groupfavor", $msg['report']['accessgroup'], $group,"class='select-input' multiple='multiple'");
		}
		
		//limit
		$form->addElement('text',"limit", $msg['report']['maxresultrow'], "class='text-input' style='width:40px' dir='ltr'");

		//
		$form->addElement('text',"maxrow", $msg['report']['maxrowinpage'], "class='text-input' style='width:40px' dir='ltr'");
		
		//hidden value
		$form->addElement('hidden',"reportid", $reportid);
		$form->setDefaults(array(
								'showfield'=>array_keys($showfield),
								'sortorder'=> 'ASC',
								'maxrow'=>45,
								));
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();
		return($formData);
	
	
	}
		
	//for super admin and make report
	public function queryFormdata($link)
	{
		global $db, $reportconfig, $msg, $user;
		
		$sql = "SELECT xgroupid , xgroup
				FROM xxreport_group";
		$group = $db->getAll($sql, array(), DB_FETCHMODE_ASSOC | DB_FETCHMODE_FLIPPED);
		$group = array_combine($group['xgroupid'], $group['xgroup']);
		
		$form = new HTML_QuickForm('form1', 'POST', @$link);
		
		$form->addElement('text','main',$msg['report']['mainname'], "class='text-input'");
		$form->addElement('static', NULL, NULL, "<span dir='ltr'>FROM ...  LEFT JOIN() USING() ... </span>");
		$form->addElement('textarea','sql',$msg['report']['mainsql'], "class='textarea-input' rows='7' dir='ltr'");
		
		//show field
		$form->addElement('static', NULL, NULL, "<span>{$msg['report']['fieldid']}: xxcity.xcity,  {$msg['report']['fieldnameshow']}: شهر</span>");
		$grp = array();
		$grp[] =& HTML_QuickForm::createElement('text','showfield[]', NULL, "style='width:100px' dir='ltr'");
		$grp[] =& HTML_QuickForm::createElement('text','showname[]', NULL, "style='width:100px'");
		$grp[] =& HTML_QuickForm::createElement('static');
		for($i=0;$i<=$reportconfig['fieldcount'];$i++){
			$form->addGroup($grp, NULL, $msg['report']['showfield'], array($msg['report']['fieldid']."<br />", $msg['report']['fieldnameshow']));
		}
		
		//wherefield
		$grp = array();
		$grp[] =& HTML_QuickForm::createElement('text','wherefield[]', NULL, "style='width:100px' dir='ltr'");
		$grp[] =& HTML_QuickForm::createElement('text','wherename[]', NULL, "style='width:100px'");
		$grp[] =& HTML_QuickForm::createElement('select','types[]', NULL, $reportconfig['ColumnTypes'], "style='width:100px' dir='ltr'");
		$grp[] =& HTML_QuickForm::createElement('static');
		for($i=0;$i<=$reportconfig['fieldcount'];$i++){
			$form->addGroup($grp, NULL, $msg['report']['wherefield'], array("&nbsp;&nbsp;".$msg['report']['fieldid']."<br />", "&nbsp;&nbsp;".$msg['report']['fieldnameshow']."<br />", "&nbsp;&nbsp;".$msg['report']['fieldtype']));
		}	
			
		$form->addElement('static', NULL, NULL, "<span dir='ltr'>xxcity.xstateid=5 OR xxcity.xstateid=6</span>");
		$form->addElement('text','condition',$msg['report']['condition'], "class='text-input' dir='ltr'");
		$form->addElement('static', NULL, NULL, "<span dir='ltr'>xxcity.xcityid, xxcity.xstateid, ...</span>");
		$form->addElement('text','groupby',$msg['report']['groupby'], "class='text-input' dir='ltr'");
		$form->addElement('static', NULL, NULL, '<span dir="rtl">از متغییر list$& به عنوان ورودی استفاده شود</span><span dir="ltr"><br>array($list[result], $list[maxrow], $list[showfield])</span>');
		$form->addElement('textarea','function',$msg['report']['function'], "class='textarea-input' dir='ltr' rows='7'");

		$form->addElement('select', 'groupreport', $msg['report']['accessgroup'], $group, "class='text-input' multiple='multiple'");
		$form->setDefaults(array('groupreport' => array_keys($group)));
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty,true);
		$form->accept($renderer);
		$formData = $renderer->toArray();

		return($formData);
	}
	
	private function showname($reportid, $showfield)
	{
		$showname = $this->showfield($reportid);
		foreach($showfield as $val){
			if(array_key_exists($val, $showname)){
				$list[] = $showname[$val];
			}
		}
		return ($list);
	}
	
	private function result($paging=0, $reportid, $sql, $function=NULL, $showfield=array(), $favor=0, $maxrow=45)
	{
		global $db;
		if(!empty($paging)){
			return($this->paging($sql));
		}
		$res = $db->getAll($sql);
		if(!empty($favor)){				
			$header = $showfield;
		}else{
			$header = $this->showname($reportid, $showfield);
		}
		$list['maxrow'] = $maxrow;
		$list['showfield'] = $header;
		if(PEAR::isError($res)){
			return($list);
		}
		$list['result'] = $res;

		if(!empty($function)){
			eval($function);
		}
		return($list);
	}
	
	public function favorResult($reportid)
	{
		list($sql, $showfield, $function) = $this->fetchFavorBody($reportid);
		$showfield = explode("\n", $showfield);
		return($this->result(0, $reportid, $sql, $function, $showfield, 1));
	}	
	
	public function paging($sql)
	{
		global $db, $reportconfig;
		$res =& $db->query($sql);
		$list['numrow']  = $res->numRows();	
		$list['maxpage'] = empty($list['numrow']) ? 1 : ceil($list['numrow']/$reportconfig['maxrow']);
		return $list;		
	}
}	
?>