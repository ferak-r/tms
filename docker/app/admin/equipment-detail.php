<?php
$equipmentid = @intval($_REQUEST['equipmentid_frm']);
$sql = "SELECT *
		FROM xxequipment
		NATURAL LEFT JOIN xxcarrier
		NATURAL LEFT JOIN xxequipmenttype
		NATURAL LEFT JOIN xxequipmentquantity
		WHERE xequipmentid = '$equipmentid'";				
$res = $db->getRow($sql);

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
echo $equipment;
die();
?>