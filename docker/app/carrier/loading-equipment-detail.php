<?php
$loadingid = @intval($_REQUEST['loading-equipmentid_frm']);
$sql = "SELECT *
		FROM xxloading
		NATURAL LEFT JOIN xxequipment
		NATURAL LEFT JOIN xxcarrier
		NATURAL LEFT JOIN xxequipmenttype
		NATURAL LEFT JOIN xxequipmentquantity
		WHERE xloadingid = '$loadingid'";				
$res = $db->_getRow($sql);

$res = array_map('htmlspecialchars', $res);

$equipment = "";

if(@$res['xcarrierid']){
	$equipment .= "<b>".T_('Company').": </b>".$res['xcarrier']."<br />";
}

if(@$res['xequipment']){
	$equipment .= "<b>".T_('Equipment').": </b>".$res['xequipment']."<br />";
}
$equipment .= "<b>".T_('Category').": </b>".$res['xequipmentcat']."<br />";
$equipment .= "<b>".T_('Type').": </b>".$res['xequipmenttype']."<br />";

if(@$res['xequipmentno']){
	$equipment .= "<b>".T_('Equipment No').": </b>".$res['xequipmentno']."<br />";
}

if(@$res['xequipmentcat'] == 1){
	$equipment .= "<b>".T_('Chassis No').": </b>".$res['xchassisno']."<br />";
	$equipment .= "<b>".T_('Certificate').": </b>".$res['xcertificate']."<br />";
}
$equipment .= "<b>".T_('Quantity').": </b>".$res['xequipmentquantity']."<br />";
$equipment .= "<b>".T_('Description').": </b>".$res['xequipmentdes']."<br />";

$equipment .= "<b>".T_('Loading Date').": </b>".$res['xloadingdate']."<br />";
$equipment .= "<b>".T_('Penalty').": </b>".$res['xpenalty']."<br />";
$equipment .= "<b>".T_('Start Date (for carrier)').": </b>".$res['xcarrierstartdate']."<br />";
$equipment .= "<b>".T_('Reject Date (for carrier)').": </b>".$res['xcarrierrejectdate']."<br />";
$equipment .= "<b>".T_('ATD Arrival Port/Border').": </b>".$res['xatdarrivalport']."<br />";
$equipment .= "<b>".T_('Receiving Arrival Notice').": </b>".$res['xetaarrivalport']."<br />";
$equipment .= "<b>".T_('ATD Exit Port').": </b>".$res['xatdexitport']."<br />";
$equipment .= "<b>".T_('ATA Exit Port').": </b>".$res['xetaexitport']."<br />";
$equipment .= "<b>".T_('ATD Destination').": </b>".$res['xatddestination']."<br />";
$equipment .= "<b>".T_('ATA Destination').": </b>".$res['xetadestination']."<br />";
$equipment .= "<b>".T_('Last Status').": </b>".$res['xlaststatus']."<br />";

echo $equipment;
die();
?>