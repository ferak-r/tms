<?PHP #1.01	2006-11-15	ser

class xDB extends DB {	

	public function __destruct()
	{
		$this->commit();
		$this->disconnect();	
	}
	
	public static function staticConnect($dsn, $options = array())
    {
        $dsninfo = DB::parseDSN($dsn);
        $type = $dsninfo['phptype'];

        if (!is_array($options)) {
            /*
             * For backwards compatibility.  $options used to be boolean,
             * indicating whether the connection should be persistent.
             */
            $options = array('persistent' => $options);
        }

        if (isset($options['debug']) && $options['debug'] >= 2) {
            // expose php errors with sufficient debug level
            include_once "DB/${type}.php";
        } else {
            @include_once "DB/${type}.php";
        }

        $classname = "DB_${type}";
        if (!class_exists($classname)) {
            $tmp = PEAR::raiseError(null, DB_ERROR_NOT_FOUND, null, null,
                                    "Unable to include the DB/{$type}.php"
                                    . " file for '$dsn'",
                                    'DB_Error', true);
            return $tmp;
        }
		if($classname == "DB_mysqli") {
			//use customized class for mysql
			$classname = "myDB_mysqli";
		}
        @$obj = new $classname;

        foreach ($options as $option => $value) {
            $test = $obj->setOption($option, $value);
            if (DB::isError($test)) {
                return $test;
            }
        }

        $err = $obj->connect($dsninfo, $obj->getOption('persistent'));
        if (DB::isError($err)) {
            $err->addUserInfo($dsn);
            return $err;
        }
        return $obj;
    }
}

class myDB_mysqli extends DB_mysqli{
	
	function __call($m, $p){
		$n = preg_replace('/^__/', '_', $m);
		if(preg_match('/^_[a-z]+/i', $n)) {
			if($p) foreach($p as $k=>$v){
				$param[] = "\$p[$k]";
			}
			$param = implode(', ', $param);
			eval("\$this->$n($param);");
			die();
		}
		#alert("Undefined function for DB class: ".$m);
	}
	
	public function getAllTransacted($query, $params = array(), $fetchmode = DB_FETCHMODE_DEFAULT)
	{
		DB_mysqli::query($query, $params);
		$res =& DB_mysqli::getAll($query, $params, $fetchmode);
		return $res;
	}
	
	public function multiQuery($query, $params = array())
	{
		if(empty($query)) return NULL;
		
		$qLine = explode("\n", $query);
		foreach($qLine as $key=>$q) {
			$qLine[$key] = trim($q);
		}
		$query = implode("\n", $qLine);
		$qLine = explode(";\n", $query);
		foreach($qLine as $key=>$q) {
			if(trim($q)){
				$res[] =& DB_mysqli::query($q, @$params[$key]);
			}	
		}
		return $res;
	}
		
	public function _multiQuery($query, $params = array())
	{
		if(empty($query)) return NULL;
		
		$qLine = explode("\n", $query);
		foreach($qLine as $key=>$q) {
			$qLine[$key] = trim($q);
		}
		$query = implode("\n", $qLine);
		$qLine = explode(";", $query);
		foreach($qLine as $key=>$q) {
			if($q=trim($q)){
				$res[] =& $this->_query($q.";\n", @$params[$key]);
			}	
		}
		return $res;
	}
	
	public function _getOne($query, $params = array())
	{
		$res =& DB_mysqli::getOne($query, $params);
		trace($this->last_query."\n".print_r($res, 1), "_getOne", $params===1);
		return $res;
	}
	
	public function _getRow($query, $params = array(), $fetchmode = DB_FETCHMODE_DEFAULT)
	{
		$res =& DB_mysqli::getRow($query, $params, $fetchmode);
		trace($this->last_query."\n".print_r($res, 1), "_getRow", $params===1);
		return $res;
	}
	
	public function _getCol($query, $col = 0, $params = array())
	{
		$res =& DB_mysqli::getCol($query, $col, $params);
		trace($this->last_query."\n".print_r($res, 1), "_getCol", $params===1);
		return $res;
	}
	
	public function _getAll($query, $params = array(), $fetchmode = DB_FETCHMODE_DEFAULT)
	{
		$res =& DB_mysqli::getAll($query, $params, $fetchmode);
		trace($this->last_query."\n".print_r($res, 1), "_getAll", $params===1);
		return $res;
	}
	
	public function _getAllTransacted($query, $params = array(), $fetchmode = DB_FETCHMODE_DEFAULT)
	{
		DB_mysqli::query($query, $params);
		$res =& DB_mysqli::getAll($query, $params, $fetchmode);
		trace($this->last_query."\n".print_r($res, 1), "_getAll", $params===1);
		return $res;
	}
	
	public function _query($query, $params = array())
	{
		$res =& DB_mysqli::query($query, $params);
		trace($query."\n".(is_object($res)? print_r(DB_mysqli::getAll($query, $params), 1):print_r($res, 1)), "_query", $params===1);
		return $res;
	}
	
	public function _autoExecute($table, $fields_values, $mode=DB_AUTOQUERY_INSERT, $where=FALSE, $die=false)
	{
		$res =& $this->autoExecute($table, $fields_values, $mode, $where);
		trace($this->last_query."\n\nAffected Rows: ".$this->affectedRows()."\nResult: ".print_r($res, 1), "_autoExec", $die);
		return $res;
	}
	
	public function escapeSimple($var)
	{
		switch(gettype($var)){
			case 'array':
				foreach($var as $k=>$v){
					$var[$k] = $this->escapeSimple($v);
				}
				break;
			case 'object':
				foreach($var as $k=>$v){
					$var->$k = $this->escapeSimple($v);
				}
				break;
			default:
				$var = parent::escapeSimple($var);	
		}
		return $var;
	}
	
	public function fetchEnum($table, $colum)
	{
		$res = array();
		$sql = "SHOW COLUMNS FROM $table LIKE '$colum'";
		$result = $this->getRow($sql);
		if( count( $result ) > 0 and !DB::isError($result)){
			$type = @$result['type'] ? $result['type'] : $result['Type'];
			preg_match_all("/'(.*?)'/", $type, $matches);
			if(@$matches[1]){
				foreach($matches[1] as $key=>$val){
					$res[$key+1] = $val; 
				}
			}	
		} 
		return $res;
	}

	public function fetchSet($table, $colum)
	{
		$res = array();
		$sql = "SHOW COLUMNS FROM $table LIKE '$colum'";
		$result = $this->getRow($sql);
		if( count( $result ) > 0 and !DB::isError($result)){
			$type = @$result['type'] ? $result['type'] : $result['Type'];
			preg_match_all("/'(.*?)'/", $type, $matches);
			if(@$matches[1]){
				foreach($matches[1] as $val){
					$res[$val] = $val; 
				}
			}	
		} 
		return $res;
	}
	
	public function getList($table, $field='', $where='', $orderby='')
	{
		$res = array();
		$fid = substr($table."id", 1, strlen($table)+1); 
		$orderby = $orderby ? $orderby : $fid;
		$sql = $field ? "SELECT *, $field FROM $table $where ORDER BY $orderby" : "SELECT * FROM $table $where ORDER BY $orderby";
		$result1 = $this->getAll($sql, array(), DB_FETCHMODE_ORDERED);
		$result2 = $this->getAll($sql, array(), DB_FETCHMODE_ASSOC);
		if( count( $result1 ) > 0 and !DB::isError($result1)){
			foreach($result1 as $key=>$val){
				$res[$val[0]] = $field ? $result2[$key][$field] : $val[1];
			}	
		} 
		return $res;
	}
	
	public function lastId()
	{
		return $this->getOne("SELECT @@IDENTITY");
	}
	
	public function groupBy($inp, $groupfield)
	{
		$res = array();
		$cnt = 0;
		if(is_array($inp)) foreach($inp as $key=>$val) {
			$fl = $val[$groupfield];

			$res[$fl][$key] = $val;
		}
		return $res;
	}

}

?>