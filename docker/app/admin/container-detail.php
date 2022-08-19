<?php
$containerid = @intval($_REQUEST['containerid_frm']);
$sql = "SELECT * FROM xxcontainer
		NATURAL LEFT JOIN xxcontainertype
		NATURAL LEFT JOIN xxcontainersize
		NATURAL LEFT JOIN xxcarrier
		WHERE xcontainerid = '$containerid'";
$res = $db->_getRow($sql);

$res = array_map('htmlspecialchars', $res);

$container = "";
$container .= "<b>".T_('Container No').": </b>".$res['xcontainernumber']."<br />";

if($res['xown'] == 'COC' && $res['xcarrier']){
	$container .= "<b>".T_('Owner').": </b>".$res['xcarrier']."<br />";
}elseif($res['xcompanycontainer']){
	$container .= "<b>".T_('Owner').": </b>".$config['sitename']."<br />";
}

$container .= "<b>".T_('Container Type').": </b>".$res['xcontainertype']."<br />";
$container .= "<b>".T_('Container Size').": </b>".$res['xcontainersize']."<br />";
$container .= "<b>".T_('')."</b>".$res['xown']."<br />";

echo $container;
die();
?>