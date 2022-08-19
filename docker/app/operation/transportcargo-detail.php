<?php
$transportcargoid = @intval($_REQUEST['transportcargoid_frm']);
$sql = "SELECT * FROM xxtransportcargo
		NATURAL LEFT JOIN xxtransportcontainer
		NATURAL LEFT JOIN zzcontainer
		NATURAL LEFT JOIN xxpackagetype
		WHERE xtransportcargoid = '$transportcargoid'";
$res = $db->getRow($sql);

$res = array_map('htmlspecialchars', $res);

$transport = "";
$transport .= "<b>".T_('Commodity').": </b>".$res['xcommodity']."<br />";
$transport .= "<b>".T_('Carrying Type').": </b>".$res['xcarrytype']."<br />";

if($res['xcarrytype'] == 'Container'){
	$transport .= "<b>".T_('Container Number').": </b>".$res['xcontainernumber']."<br />";
}

$transport .= "<b>".T_('Packing Type').": </b>".$res['xpackagetype']."<br />";
$transport .= "<b>".T_('Number of Packages').": </b>".$res['xpackagenumber']."<br />";
$transport .= "<b>".T_('Kind').": </b>".$res['xcargokind']."<br />";
$transport .= "<b>".T_('Size').": </b>".$res['xcargosize']."<br />";
$transport .= "<b>".T_('Danger Level').": </b>".$res['xcargodanger']."<br />";
$transport .= "<b>".T_('IMO').": </b>".$res['ximo']."<br />";
$transport .= "<b>".T_('Cargo Weight').": </b>".$res['xcargoweight']."<br />";
$transport .= "<b>".T_('Cargo Volume').": </b>".$res['xcargovolume']."<br />";
$transport .= "<b>".T_('Description').": </b>".$res['xcargodescription']."<br />";

echo $transport;
die();
?>