<?php
$mac = null;
if(file_exists('security/mac.txt')){
	$mac = file_get_contents('security/mac.txt');
	//get mac address
	$res = shell_exec('net config server');
	preg_match_all('/NetBT_Tcpip_(\{.*\}.*)/', $res, $macs);
	foreach($macs[1] as $val){
		if(sha1($config['sitekey'].$val) ==  $mac){
			$mac = $config['sitekey'];
			break;
		}
	}
}
if($mac != $config['sitekey']) {
	$smarty = null;
	$db = null;
	$user = null;
}
?>