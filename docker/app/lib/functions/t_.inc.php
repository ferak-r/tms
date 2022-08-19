<?
function T_($txt)
{
	global $msg;
	if(is_array($txt) or is_object($txt)) {
		$res = array();
		foreach($txt as $key => $val) {
			$res[$key] = T_($val);
		}
		return $res;
	} else {
		return isset($msg[strtolower($txt)]) ? $msg[strtolower($txt)] : $txt;
	}
}
?>