<?php
$userconfig['tableprefix'] = "xxuser_"; //default xx

$userconfig['fieldprefix'] = "x"; //default x
 
$userconfig['savepass']['CookieField'] = 'user@';
$userconfig['sitekey'] = ':-(';
$userconfig['min_username_len'] = 1;
$userconfig['min_pass_len'] = 1;
$userconfig['user']['UserId'] = 'UserId';

$userconfig['table']['xxuser_info']['infoid'] 			= "int(20) unsigned NOT NULL auto_increment";
$userconfig['table']['xxuser_info']['usernameid']		= "varchar(20) NOT NULL";
$userconfig['table']['xxuser_info']['name'] 			= "varchar(128) collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['family'] 			= "varchar(128) collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['gender'] 			= "enum('Female','Male') collate utf8_persian_ci NOT NULL default 'Male'";
$userconfig['table']['xxuser_info']['marital'] 			= "enum('Single','Married') collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['company'] 			= "varchar(128) collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['post'] 			= "varchar(64) collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['address'] 			= "text collate utf8_persian_ci";
$userconfig['table']['xxuser_info']['city'] 			= "varchar(128) collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['tel'] 				= "varchar(64) collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['fax'] 				= "varchar(64) collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['countryid'] 		= "int(20) unsigned default NULL";
$userconfig['table']['xxuser_info']['email'] 			= "varchar(256) collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['web'] 				= "varchar(256) collate utf8_persian_ci default NULL";
$userconfig['table']['xxuser_info']['userdes'] 			= "text collate utf8_persian_ci";

$userconfig['table']['xxoffice']['officeid'] 			= "int(20) unsigned NOT NULL auto_increment";
$userconfig['table']['xxoffice']['usernameid']			= "varchar(20) NOT NULL";
$userconfig['table']['xxoffice']['office'] 				= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxoffice']['phone'] 				= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxoffice']['address'] 			= "text collate utf8_persian_ci";
$userconfig['table']['xxoffice']['fax'] 				= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxoffice']['email'] 				= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxoffice']['website'] 			= "varchar(100) collate utf8_persian_ci default NULL";

$userconfig['table']['xxcustomer']['customerid']		= "int(20) unsigned NOT NULL auto_increment";
$userconfig['table']['xxcustomer']['usernameid']		= "varchar(20) NOT NULL";
$userconfig['table']['xxcustomer']['name'] 				= "varchar(128) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcustomer']['family'] 			= "varchar(128) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcustomer']['gender'] 			= "enum('Male','Female') collate utf8_persian_ci NOT NULL default 'Male'";
$userconfig['table']['xxcustomer']['company'] 			= "varchar(128) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcustomer']['post'] 				= "varchar(64) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcustomer']['address'] 			= "text collate utf8_persian_ci";
$userconfig['table']['xxcustomer']['city'] 				= "varchar(128) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcustomer']['phone'] 			= "varchar(64) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcustomer']['fax'] 				= "varchar(64) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcustomer']['countryid'] 		= "int(20) unsigned default NULL";
$userconfig['table']['xxcustomer']['email'] 			= "varchar(256) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcustomer']['website'] 			= "varchar(256) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcustomer']['des'] 				= "text collate utf8_persian_ci";

$userconfig['table']['xxcarrier']['carrierid']			= "int(20) unsigned NOT NULL auto_increment";
$userconfig['table']['xxcarrier']['usernameid']			= "varchar(20) NOT NULL";
$userconfig['table']['xxcarrier']['carrier'] 			= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcarrier']['carriertype'] 		= "enum('Person','Company') collate utf8_persian_ci default NULL";
$userconfig['table']['xxcarrier']['phone'] 				= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcarrier']['fax'] 				= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcarrier']['manager'] 			= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcarrier']['managerphone'] 		= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcarrier']['responsible'] 		= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcarrier']['responsiblephone'] 	= "varchar(100) collate utf8_persian_ci default NULL";
$userconfig['table']['xxcarrier']['address'] 			= "varchar(100) collate utf8_persian_ci default NULL";

$userconfig['sql'] = "
	INSERT INTO `xxuser_group` VALUES (1, 'admin');
	INSERT INTO `xxuser_group` VALUES (2, 'customer');
	INSERT INTO `xxuser_group` VALUES (3, 'office');
	INSERT INTO `xxuser_group` VALUES (4, 'carrier');
	INSERT INTO `xxuser_group` VALUES (5, 'webcarrier');
	INSERT INTO `xxuser_group` VALUES (6, 'operation');
	INSERT INTO `xxuser_group` VALUES (7, 'document');
	INSERT INTO `xxuser_group` VALUES (8, 'account&customs');
	INSERT INTO `xxuser_username` VALUES ('inf1', 'sa', 'd01ab6f69805615b74a4cd846cc0728f6c84a4da', 'Active');
	INSERT INTO `xxuser_info` VALUES (1, 'inf1', 1, 1, 'Male', 'Single', 'admin', 'Super Admin', NULL, NULL, '', NULL, 0, 0, NULL, NULL);
	INSERT INTO `xxuser_groupuser` VALUES (1, 'inf1', 1);";
	
//user privileges	$userconfig[page][filed] = array(disabled groups)
$userconfig['transport-admin']['frm_transportcode'] 	= array('operation');
$userconfig['transport-admin']['frm_fromcityid'] 		= array('operation');
$userconfig['transport-admin']['frm_arrivalportid'] 	= array('operation');
$userconfig['transport-admin']['frm_etaarrivalport'] 	= array('operation');
$userconfig['transport-admin']['frm_etl'] 				= array('document');
$userconfig['transport-admin']['frm_origincityid'] 		= array('operation');
$userconfig['transport-admin']['frm_etadestination'] 	= array('document');
$userconfig['transport-admin']['frm_shipperid'] 		= array('operation');
$userconfig['transport-admin']['frm_consigneeid'] 		= array('operation');
$userconfig['transport-admin']['frm_senderofficeid'] 	= array('operation');
$userconfig['transport-admin']['frm_receiverofficeid'] 	= array('operation');

$userconfig['operation-admin']['frm_etaarrivalport'] 	= array('operation', 'carrier');
$userconfig['operation-admin']['frm_ataarrivalport'] 	= array('operation', 'carrier');
$userconfig['operation-admin']['frm_do'] 				= array('operation', 'carrier');
$userconfig['operation-admin']['frm_rlz'] 				= array('operation', 'carrier');
$userconfig['operation-admin']['frm_customs'] 			= array('document', 'carrier');
$userconfig['operation-admin']['frm_loading'] 			= array('document');
$userconfig['operation-admin']['frm_penalty'] 			= array('document');
$userconfig['operation-admin']['frm_atdarrivalport'] 	= array('document');
$userconfig['operation-admin']['frm_etaexitport'] 		= array('document');
$userconfig['operation-admin']['frm_atdexitport'] 		= array('document');
$userconfig['operation-admin']['frm_etadestination'] 	= array('document', 'carrier');
$userconfig['operation-admin']['frm_atddestination'] 	= array('document', 'carrier');
?>