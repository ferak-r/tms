<?php 
require_once("xdb.conf.php");
require_once("xdb.class.php");

if(empty($db)){
	$db = xDB::staticConnect($config['db']['dsn'], $config['db']['options']);	
	if (PEAR::isError($db)) {
		echo '<pre>Error Message: ' . $db->getMessage() . "\n";
		echo 'Error Code: ' . $db->getCode() . "\n";
		die();
	}	
	if (version_compare(mysqli_get_server_info($db->connection), '4.1.0', '>=')) {
		$db->multiQuery('
			SET NAMES "utf8";
			SET collation_connection = "utf8_persian_ci;
			SET collation_server = "utf8_persian_ci";
			SET character_set_client = "utf8";
			SET character_set_connection = "utf8";
			SET character_set_results = "utf8";
			SET character_set_server = "utf8";
			SET CHARACTER SET UTF8;
			DEFAULT CHARSET = "utf8";
			SET group_concat_max_len = 4294967296;');
	}
	$db->setFetchMode(DB_FETCHMODE_ASSOC);
}
?>