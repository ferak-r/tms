<?PHP

function checkReminder($userid)
{
	global $db;
	$sql = "SELECT xuserbodyid
			FROM xxmail_userbody
			WHERE xuserbodystatus = 'unread' AND xdir = 'inbox' AND xusernameid = '$userid' LIMIT 1";
	return $db->getOne($sql);
}

?>