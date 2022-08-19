<?php
$partyaccountid = $_REQUEST['partyaccountid_frm'];

$sql = "SELECT * FROM zzidentity
		WHERE xpartyaccountid = '$partyaccountid'";
$res = $db->getRow($sql);

$res = array_map('htmlspecialchars', $res);

$partyaccount = "";
$partyaccount .= "<b>".T_('Party Account').": </b>".$res['xpartyaccount']."<br />";

$partyaccount .= "<b>".T_('Type').": </b>".$res['xtype']."<br />";

$partyaccount .= "<b>".T_('Phone').": </b>".$res['xphone']."<br />";
$partyaccount .= "<b>".T_('Fax').": </b>".$res['xfax']."<br />";
$partyaccount .= "<b>".T_('Address').": </b>".$res['xaddress']."<br />";

if($res['xtype'] == 'office'){
	$partyaccount .= "<b>".T_('Email').": </b>".$res['xemail']."<br />";
	$partyaccount .= "<b>".T_('Website').": </b>".$res['xwebsite']."<br />";
}elseif($res['xtype'] == 'customer'){
	$partyaccount .= "<b>".T_('Email').": </b>".$res['xemail']."<br />";
	$partyaccount .= "<b>".T_('Website').": </b>".$res['xwebsite']."<br />";
	$partyaccount .= "<b>".T_('Company').": </b>".$res['xcompany']."<br />";
	$partyaccount .= "<b>".T_('Position').": </b>".$res['xpost']."<br />";
	$partyaccount .= "<b>".T_('City').": </b>".$res['xcity']."<br />";
	$partyaccount .= "<b>".T_('Description').": </b>".$res['xdes']."<br />";
}elseif($res['xtype'] == 'carrier'){
	$partyaccount .= "<b>".T_('Manager').": </b>".$res['xmanager']."<br />";
	$partyaccount .= "<b>".T_('Manager Phone').": </b>".$res['xmanagerphone']."<br />";
	$partyaccount .= "<b>".T_('Responsible').": </b>".$res['xresponsible']."<br />";
	$partyaccount .= "<b>".T_('Responsible Phone').": </b>".$res['xresponsiblephone']."<br />";
}
echo $partyaccount;
die();
?>