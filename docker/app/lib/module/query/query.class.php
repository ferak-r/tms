<?PHP

class QUERY{
	private $conf;
	public  $q = array();
	public	$query;
	
	public function __construct($conf)
	{
		$this->conf = $conf;
		$list = "_".strtoupper($this->conf['read']);
		eval("\$list = @\$$list;");
		$redirect = false;
		$res = $this->decode();
		if($list) {
			foreach($list as $key => $val) {
				if(substr($key, 0, strlen($this->conf['prefix']))==$this->conf['prefix']) {
					$redirect = true;
					unset($_POST[$key]);
					if(is_null($val) or $val=='') { 
						unset($res[$key]);
					} else {
						if(preg_match('/[a-z_][a-z0-9_]*/i', $key)) {
							if(is_array($val)) {
								$res[$key] = get_magic_quotes_gpc() ? array_map('stripslashes', $val) : $val;
							} else {
								$res[$key] = get_magic_quotes_gpc() ? stripslashes($val) : $val;
							}	
						}
					}	
				}
			}
		}
		$this->query = $this->encode($res);
		if($redirect) {		
			$php_self 		= $_SERVER['PHP_SELF'];
			$query_string 	= $_SERVER['QUERY_STRING'];
			$href 			= $php_self.(empty($query_string) ? '' : '?'.$query_string);
			$url = preg_replace('/&'.addcslashes($this->conf['request'], '\\.+^$(){}=!<>|').'=[^&]*/', '', $href);
 			$url = preg_replace('/&'.addcslashes($this->conf['prefix'], '\\.+^$(){}=!<>|').'[^&]*/', '', $url);
			$url .= "&{$this->conf['request']}=".$this->query;
			$this->redirect($url);
		}
		$this->q = $res;
	}
	
	public function encode($ar)
	{
		$res = '';
		foreach($ar as $key => $val) {
			if(is_array($val)) {
				foreach($val as $k => $v) {
					$res .= $key."[$k]=".$v."&";
				} 
			} else {
				$res .= $key."=".$val."&";
			}
		}
		$res = substr($res, 0, strlen($res)-1);
		return base64_encode($res);
	}
	
	public function decode($txt=NULL)
	{
		$txt = empty($txt) ? addslashes(@$_REQUEST[$this->conf['request']]) : $txt;
		$txt = base64_decode($txt);
		$ar = explode('&', $txt);
		$res = array();
		foreach($ar as $item) {
			$item = explode('=', $item, 2);
			if(isset($item[0]) and isset($item[1]) and substr($item[0], 0, strlen($this->conf['prefix']))==$this->conf['prefix']){
				if(preg_match('/^([^\[]+)\[(.*)\]$/', $item[0], $preg)) {
					$res[$preg[1]][$preg[2]] = $item[1];
				} else {
					$res[$item[0]] = $item[1];
				}	
			}
		}
		return $res;
	}
	
	public function make()
	{
		$res = $this->decode();
		foreach($res as $key => $val) {
			global $$key;
			if(is_array($val)) {
				$$key = array_map('urldecode', $val);
			} else {
				$$key = urldecode($val);
			}	
		}
		global ${$this->conf['request']};
		${$this->conf['request']} = $this->query;
	}
	
	public function makeWhere($cond='AND')
	{
		// like:     %LIKE%
		// likepre:   LIKE%
		// likepost: %LIKE
		// eq: =
		// ne: !=
		// gr: >
		// ge: >=
		// lt: <
		// le: <=
		$where = "";
		foreach($this->q as $key=>$val){
			$p = explode("_", $key, 3);
			if($p[0] == 'zf'){
				$where .= empty($where) ? " AND (".$this->getOpt($p,$val) : " $cond ".$this->getOpt($p,$val);
			}
		}
		if(!empty($where)){
			$where .= ")";
		}
		return $where;
	}
	
	private function getOpt($p,$val)
	{
		$tr  = array (
						'like'		=> "$p[2] LIKE '%$val%'",
						'likepre'	=> "$p[2] LIKE '$val%'",
						'likepost'	=> "$p[2] LIKE '%$val'",
						'eq'		=> "$p[2]='$val'",
						'ne'		=> "$p[2]!='$val'",
						'gr'		=> "$p[2]>'$val'",
						'ge'		=> "$p[2]>='$val'",
						'lt'		=> "$p[2]<'$val'",
						'le'		=> "$p[2]<='$val'"
		);
		return strtr($p[1], $tr);
	}

	private function redirect($loc)
	{
		$t ="
				<html>
				<head>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<meta http-equiv='refresh' content='2; $loc'>
				</head>
				<body>
			";
		if(empty($_POST)) {
			if(0 and !headers_sent()) {
				header("Location: $loc");
				header("HTTP/1.0 301 Moved Permanently");
				die();
			}
			$t .= "
				<noscript>
					<a href='$loc'>$loc</a>
				</noscript>
				<script language='javascript' type='text/javascript'>
				<!--
					document.location.replace('$loc');
				//-->
				</script>
			";
		} else {
			$t .= "
				<form name='form1' id='form1' method='post' action='$loc'>
			";
			foreach($_POST as $key => $val){
				$t .= "	<input type='hidden' name='".strtr($key, "'", "\\'")."' value='".strtr($val, "'", "\\'")."'> ";
			}		
			$t .= "
					<noscript>
						<input type='submit' value='$loc'>
					</noscript>
				</form>
				<script language='javascript' type='text/javascript'>
				<!--
					document.forms['form1'].submit();
				//-->
				</script>
			";
		}		
		$t .= "</body></html>";
		die($t);
	}
}

?>