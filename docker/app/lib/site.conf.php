<?php
//----------------------------DB.CONFIG

$config['db']['type']	= 'mysqli';
$config['db']['server'] = 'mysql';
$config['db']['port']	= '3306';

$config['db']['name']		= 'tirtash_db';
$config['db']['user']		= 'root';
$config['db']['pass']		= 'root';

$config['adminmail']   = '';
$config['sitename']	  = 'TIRTASH';
//----------------------------------------------PUBLIC.CONFIG 
$config['sessionTimeout']	= 180000; 

$config['title'] 			= "Tirtash";

$config['sitekey'] 			= "rE#.Mb%TYcde4#$(O;";

##############################################
//----------------------------------------------SMARTY.CONFIG 
$config['template_dir'] = "+tpl/";            
$config['config_dir']   = 'lib/templatedir/config/';
$config['compile_dir']  = "lib/templatedir/_compile/";
$config['cache_dir']    = 'lib/templatedir/_cache/';
//----------------------------------------------upload dir.config	
$config['upload']['document'] = "images/upload/document/";
$config['upload']['document2'] = "images/upload/document2/";
$config['upload']['tl1'] = "images/upload/tl1/";
$config['upload']['tl2'] = "images/upload/tl2/";
$config['upload']['tl3'] = "images/upload/tl3/";
$config['upload']['tl4'] = "images/upload/tl4/";
$config['upload']['tlback'] = "images/upload/tlback/";
$config['upload']['declaration'] = "images/upload/declaration/";
$config['upload']['accounting'] = "images/upload/accounting/";

//----------------------------------------------PAGE INFO.CONFIG
$config['page']		= 10;		

//-----------------------------------------------END.CONFIG 
?>