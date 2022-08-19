<?php
if(!is_secure($config['sitekey']) or ($section!='guest' and !$user->checkPermision($section, $module, $cmd) and !$user->checkPermision($section, $module, $cmd, $step) and !$user->checkPermision($section, $module, $cmd, $step, $carrytype))){
	require('guest/login.php');
	msg($msg['RestrictAccess'], 'lock', '');	
} elseif(file_exists($section."/".$module.".php")) {	// You can change $module in this included file to change the tpl that included in smarty
	require($section."/".$module.".php");
}
?>
