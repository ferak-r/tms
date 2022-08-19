<?php
$carrierid = @intval($_REQUEST['carrierid_frm']);
$sql = "SELECT * FROM xxcarrier
		WHERE xcarrierid = '$carrierid'";
$res = $db->getRow($sql);

$res = array_map('htmlspecialchars', $res);

$carrier = "";
$carrier .= "<b>".T_('Carrier').": </b>".$res['xcarrier']."<br />";

$carrier .= "<b>".T_('Phone').": </b>".$res['xphone']."<br />";
$carrier .= "<b>".T_('Fax').": </b>".$res['xfax']."<br />";
$carrier .= "<b>".T_('Manager').": </b>".$res['xmanager']."<br />";
$carrier .= "<b>".T_('Manager Phone').": </b>".$res['xmanagerphone']."<br />";
$carrier .= "<b>".T_('Responsible').": </b>".$res['xresponsible']."<br />";
$carrier .= "<b>".T_('Responsible Phone').": </b>".$res['xresponsiblephone']."<br />";
$carrier .= "<b>".T_('Address').": </b>".$res['xaddress']."<br />";

echo $carrier;
die();
?>