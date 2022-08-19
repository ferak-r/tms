<?php
$reportconfig['groupreport'] = "
	CREATE TABLE IF NOT EXISTS `xxreport_groupreport` (
	  `xgroupreportid` int(20) unsigned NOT NULL auto_increment,
	  `xgroupid` int(20) unsigned NOT NULL,
	  `xmainid` int(20) unsigned NOT NULL,
	  PRIMARY KEY  (`xgroupreportid`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
	
$reportconfig['groupfavor'] = "
	CREATE TABLE `xxreport_groupfavor` (
	  `xgroupfavorid` int(20) unsigned NOT NULL auto_increment,
	  `xgroupid` int(20) unsigned NOT NULL,
	  `xfavorid` int(20) unsigned NOT NULL,
	  PRIMARY KEY  (`xgroupfavorid`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1";
	
// view'name is not optional (xxreport_group)
$reportconfig['group_view'] = "
	CREATE VIEW `xxreport_group` AS 
	SELECT xgroupid, xgroup
	FROM xxuser_group";

// view'name is not optional (xxreport_usernam)
$reportconfig['username_view'] = "
	CREATE VIEW `xxreport_username` AS 
	SELECT xusernameid, xusername
	FROM xxuser_name
	WHERE xuserstatus = 'فعال'";

$reportconfig['maxrow'] = 10;

//### operators
$reportconfig['enum']['string'] = 'enum';
$reportconfig['enum']['operator'] = array(
										'='	=> 'مساوی',
										'!='=> 'نامساوی'
										);

$reportconfig['num']['string'] = 'NumOperators';
$reportconfig['num']['operator'] = array(
										'=' 		=> 'مساوی',
										'>' 		=> 'بزرگتر از',
										'>='		=> 'بزرگتر مساوی',
										'<' 		=> 'کوچکتر',
										'<=' 		=> 'کوچکتر مساوی',
										'!=' 		=> 'نامساوی',
										'LIKE'		=> 'همانند',
										'NOT LIKE'	=> 'نا همانند',
										'BETWEEN'	=> 'مابین'
										);
										
$reportconfig['text']['string'] = '@char|blob|text|set@i';
$reportconfig['text']['operator'] = array(
										'LIKE' 			=> 'همانند',
										'LIKE %...%' 	=> 'همانند %...%',
										'NOT LIKE' 		=> 'نا همانند',
										'=' 			=> 'مساوی',
										'!=' 			=> 'نامساوی',
										'REGEXP'		=> 'گزاره منطقی',
										'NOT REGEXP' 	=> 'نقیض گزاره منطقی',
										);

$reportconfig['null']['operator'] = array(
										'IS NULL' 		=> 'تهی باشد',
										'IS NOT NULL' 	=> 'تهی نباشد',
										);
										
$reportconfig['ColumnTypes'] = array(
						   0  => 'VARCHAR',
						   1  => 'TINYINT',
						   2  => 'TEXT',
						   3  => 'DATE',
						   4  => 'SMALLINT',
						   5  => 'MEDIUMINT',
						   6  => 'INT',
						   7  => 'BIGINT',
						   8  => 'FLOAT',
						   9  => 'DOUBLE',
						   10 => 'DECIMAL',
						   11 => 'DATETIME',
						   12 => 'TIMESTAMP',
						   13 => 'TIME',
						   14 => 'YEAR',
						   15 => 'CHAR',
						   16 => 'TINYBLOB',
						   17 => 'TINYTEXT',
						   18 => 'BLOB',
						   19 => 'MEDIUMBLOB',
						   20 => 'MEDIUMTEXT',
						   21 => 'LONGBLOB',
						   22 => 'LONGTEXT',
						   23 => 'ENUM',
						   24 => 'SET'
   								);
// for showfield or wherefield report
$reportconfig['fieldcount'] = 10;

// max row for result 
$reportconfig['maxrow'] = 20;

//$reportconfig['set']['operator'] = array('IN','NOT IN');
$reportconfig['unary']['operator'] = array('IS NULL'     => 1,'IS NOT NULL' => 1);

?>