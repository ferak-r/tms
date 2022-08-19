<?
//define('NO_CACHE', true);
chdir("../");
require_once("lib/site.module.php");
error_reporting(0);

$transportid = @$_REQUEST['transportid'];

function makejs($list1, $list2, $name)
{
	$res = "$name = new Array();\n";
	foreach ($list1 as $hi) {
		$cnt = 0;
		$res .= "{$name}[$hi[xlist1id]] = new Array();\n";
		foreach ($list2 as $low) {
			if ($hi['xlist1id'] == $low['xlist1id']){
				$res .= "{$name}[$hi[xlist1id]][$cnt]='$low[xlist2id]*:-)".addslashes($low[xlist2])."';\n";
				$cnt ++;
			}else{
				$cnt = 0;
			}
		}
	}
	return $res;
}

$globjs = '';

$sql = "SELECT DISTINCT xcarrierid AS xlist1id, xcarrier AS xlist1
		FROM xxequipment
		NATURAL LEFT JOIN xxcarrier
		ORDER BY xcarrier ASC";
$carrier = $db->getAll($sql);

$sql = "SELECT xcarrierid AS xlist1id, xcarrier AS xlist1, xequipmentid AS xlist2id, CONCAT(xequipmentcat, '(', IF(xequipmentcat='VSL', xequipment, xequipmentno), ')')AS xlist2
		FROM xxequipment
		NATURAL LEFT JOIN xxcarrier
		ORDER BY xcarrier, xequipment";
$equipment = $db->getAll($sql);

$globjs .= makejs($carrier, $equipment, 'optEquipment');

$sql = "SELECT xcarrierid AS xlist1id, xcarrier AS xlist1, xloadingid AS xlist2id, CONCAT(xequipmentcat, '(', IF(xequipmentcat='VSL', xequipment, xequipmentno), ')', '(', xfrom, ' to ', xto, ')')AS xlist2
		FROM xxloading
		NATURAL LEFT JOIN xxtransportpath
		NATURAL LEFT JOIN (SELECT xcityid AS xfromcityid, xcity AS xfrom FROM xxcity) AS xxfromcity 
		NATURAL LEFT JOIN (SELECT xcityid AS xtocityid, xcity AS xto FROM xxcity) AS xxtocity
		NATURAL LEFT JOIN xxequipment
		NATURAL LEFT JOIN xxcarrier
		WHERE xtransportid = '$transportid'
		ORDER BY xcarrier, xequipment";
$pathequipment = $db->_getAll($sql);

$globjs .= makejs($carrier, $pathequipment, 'optPathEquipment');

$sql = "SELECT *
		FROM xxreminder
		WHERE xusernameid = '$user->id' AND xreminderview='0'";
$res = $db->getAll($sql);
$reminder = "reminder = new Array();\n";
if($res){
	$cnt = 0;
	foreach($res as $key => $val){
		$reminder .= "reminder[$cnt] = new Array();\n";
		$reminder .= "reminder[$cnt]['id'] = $val[xreminderid];\n";
		$reminder .= "reminder[$cnt]['time'] = $val[xremindertimestamp];\n";
		$reminder .= "reminder[$cnt]['view'] = $val[xreminderview];\n";
		$cnt++;
	}
}
$globjs .= $reminder;

echo $globjs;
?>
//