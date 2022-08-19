<?PHP
function normalizeInputs()
{
	if(get_magic_quotes_gpc()){
		foreach($_GET as $k => $v){
			if(is_array($v)) {
				$_GET[$k]	= $_REQUEST[$k] = array_map("stripslashes", array_map("fa_normalize", $v));
			} else {
				$_GET[$k]	= $_REQUEST[$k] = stripslashes(fa_normalize($v));
			}
		}
		foreach($_POST as $k => $v){
			if(is_array($v)) {
				$_POST[$k]	= $_REQUEST[$k] = array_map("stripslashes", array_map("fa_normalize", $v));
			} else {
				$_POST[$k]	= $_REQUEST[$k] = stripslashes(fa_normalize($v));
			}
		}
	}else{
		foreach($_GET as $k => $v){
			if(is_array($v)) {
				$_GET[$k]	= $_REQUEST[$k] = array_map("fa_normalize", $v);
			} else {
				$_GET[$k]	= $_REQUEST[$k] = fa_normalize($v);
			}
		}
		foreach($_POST as $k => $v){
			if(is_array($v)) {
				$_POST[$k]	= $_REQUEST[$k] = array_map("fa_normalize", $v);
			} else {
				$_POST[$k]	= $_REQUEST[$k] = fa_normalize($v);
			}
		}
	}
}
?>