<?php
$transportcontainerid = @intval($_REQUEST['transportcontainerid_frm']);
$sql = "SELECT * FROM xxtransportcontainer
		NATURAL LEFT JOIN zzcontainer
		NATURAL LEFT JOIN xxcontainertype
		NATURAL LEFT JOIN xxcontainersize
		WHERE xtransportcontainerid = '$transportcontainerid'";
$res = $db->getRow($sql);

$res = array_map('htmlspecialchars', $res);

$transport = "";
$transport .= "<b>".T_('Container No').": </b>".$res['xcontainernumber']."<br />";

if($res['xown'] == 'COC'){
	$transport .= "<b>".T_('Owner').": </b>".$res['xcarrier']."<br />";
}elseif($res['xcompanycontainer']){
	$transport .= "<b>".T_('Owner').": </b>".$config['sitename']."<br />";
}

$transport .= "<b>".T_('Container Type').": </b>".$res['xcontainertype']."<br />";
$transport .= "<b>".T_('Container Size').": </b>".$res['xcontainersize']."<br />";
$transport .= "<b>".T_('Return Date ( for shipping )').": </b>".$res['xshippingrejectdate']."<br />";
$transport .= "<b>".T_('Return Date ( for customer )').": </b>".$res['xcustomerrejectdate']."<br />";
$transport .= "<b>".T_('')."</b>".$res['xown']."<br />";

echo $transport;
die();
?>