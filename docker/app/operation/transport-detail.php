<?php
$transportid = @intval($_REQUEST['transportid_frm']);
$sql = "SELECT *, IF( INSTR( xtransportmethod, ',' ), CONCAT('Multimodal(', xtransportmethod, ')'), xtransportmethod) AS xtransportmethod,
		GROUP_CONCAT(xcontainer SEPARATOR ', ') AS xcontainer, xcontainerno
		FROM xxtransport
		NATURAL LEFT JOIN xxcarrier
		NATURAL LEFT JOIN(SELECT xcityid AS xfromcityid, xcity AS xfromcity FROM xxcity) AS xxfromcity
		NATURAL LEFT JOIN(SELECT xcityid AS xtocityid, xcity AS xtocity FROM xxcity) AS xxtocity
		NATURAL LEFT JOIN(SELECT xcityid AS xorigincityid, xcity AS xorigincity FROM xxcity) AS xxorigincity
		NATURAL LEFT JOIN(SELECT xcityid AS xdestinationcityid, xcity AS xdestinationcity FROM xxcity) AS xxdestinationcity
		NATURAL LEFT JOIN(SELECT xportid AS xviaportid, xport AS xviaport FROM xxport) AS xxviaport
		NATURAL LEFT JOIN(SELECT xportid AS xarrivalportid, xport AS xarrivalport FROM xxport) AS xxarrivalport
		NATURAL LEFT JOIN(SELECT xofficeid AS xsenderofficeid, xoffice AS xsenderoffice FROM xxoffice) AS xxsenderoffice
		NATURAL LEFT JOIN(SELECT xofficeid AS xreceiverofficeid, xoffice AS xreceiveroffice FROM xxoffice) AS xxreceiveroffice
		NATURAL LEFT JOIN(SELECT xcustomerid AS xshipperid, CONCAT_WS(' ', xname, xfamily) AS xshipper FROM xxcustomer) AS xxshipper
		NATURAL LEFT JOIN(SELECT xcustomerid AS xconsigneeid, CONCAT_WS(' ', xname, xfamily) AS xconsignee FROM xxcustomer) AS xxconsignee
		NATURAL LEFT JOIN (
			SELECT xtransportid, IFNULL( CONCAT( xcontainernumber, ':', IF(xown='COC', xcarrier, IF(xcompanycontainer=1, '$config[sitename]', 'SOC')), '( ', GROUP_CONCAT( CONCAT( xcommodity, '<small>( ', xcargoweight, ' kg )</small>') SEPARATOR ', ' ), ' )' ), xcontainernumber ) AS xcontainer
			FROM xxtransportcontainer
			NATURAL LEFT JOIN xxtransportcargo
			NATURAL LEFT JOIN zzcontainer
			WHERE xcarrytype = 'Container'
			GROUP BY xtransportcontainerid
		) AS xxcontainer
		NATURAL LEFT JOIN (
			SELECT xtransportid, GROUP_CONCAT( CONCAT( xcommodity, '<small>( ', xcargoweight, ' kg )</small>') SEPARATOR ', ' ) AS xbulk
			FROM xxtransportcontainer
			NATURAL LEFT JOIN xxtransportcargo
			NATURAL LEFT JOIN zzcontainer
			WHERE xcarrytype = 'Bulk'
			GROUP BY xtransportid
		) AS xxbulk
		NATURAL LEFT JOIN (
			SELECT xtransportid, GROUP_CONCAT( xcontainerno SEPARATOR ', ' ) AS xcontainerno
			FROM (
				SELECT xtransportid, CONCAT(xcontainersize, ':', count(*)) AS xcontainerno
				FROM xxtransportcontainer
				LEFT JOIN zzcontainer USING (xcontainerid) 
				WHERE xcarrytype='Container' AND xtransportid = '$transportid'
				GROUP BY xcontainersizeid
			) AS xxtemp
			GROUP BY xtransportid
		) AS xxcontainerno
		WHERE xtransportid = '$transportid'
		GROUP BY xtransportid";				
$res = $db->_getRow($sql);

//$res = array_map('htmlspecialchars', $res);

$transport = "";
$transport .= "<b>".T_('Proj No').": </b>".$res['xtransportcode']."<br />";
$transport .= "<b>".T_('From').": </b>".$res['xfromcity']."<br />";
$transport .= "<b>".T_('To').": </b>".$res['xtocity']."<br />";
$transport .= "<b>".T_('Exit Border').": </b>".$res['xviaport']."<br />";
$transport .= "<b>".T_('Shipping Line/Carrier').": </b>".$res['xcarrier']."<br />";
$transport .= "<b>".T_('Transport Type').": </b>".$res['xtransporttype']."<br />";
$transport .= "<b>".T_('Arrival Port/Border').": </b>".$res['xarrivalport']."<br />";
$transport .= "<b>".T_('Receiving Arrival Notice').": </b>".$res['xetaarrivalport']."<br />";
$transport .= "<b>".T_('ETL').": </b>".$res['xetl']."<br />";
$transport .= "<b>".T_('Origin').": </b>".$res['xorigincity']."<br />";
$transport .= "<b>".T_('Destination').": </b>".$res['xdestinationcity']."<br />";
$transport .= "<b>".T_('ATA Destination').": </b>".$res['xetadestination']."<br />";
$transport .= "<b>".T_('Transport Kind').": </b>".$res['xtransportmethod']."<br />";
$transport .= "<b>".T_('Shipper').": </b>".$res['xshipper']."<br />";
$transport .= "<b>".T_('Consignee').": </b>".$res['xconsignee']."<br />";
$transport .= "<b>".T_('Sender Office').": </b>".$res['xsenderoffice']."<br />";
$transport .= "<b>".T_('Receiver Office').": </b>".$res['xreceiveroffice']."<br />";
$transport .= "<b>".T_("Project's Start Date").": </b>".$res['xstartdate']."<br />";
$transport .= "<b>".T_("Project's End Date").": </b>".$res['xenddate']."<br />";
$transport .= "<b>".T_('Number of Containers').": </b>".$res['xcontainerno']."<br />";
$transport .= "<b>".T_('Containers').": </b>".$res['xcontainer']."<br />";
$transport .= "<b>".T_('Bulk').": </b>".$res['xbulk']."<br />";
$transport .= "<b>".T_('Comment').": </b>".$res['xtransportcomment']."<br />";
echo $transport;
die();
?>