<?php

$mailconfig['zzuser'] = "SELECT xusernameid as xusernameid, xusername as xusername
						 FROM xxuser_username
						 WHERE xuserstatus = 'Active'";
$mailconfig['maxrow'] = 10;
$mailconfig['upload']['attachment']	= 'images/upload/mailattachment/';

?>