<?php

$mime_type = (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT']) and preg_match('@Safari/([0-9]*)@', $_SERVER['HTTP_USER_AGENT'])) ?
			'application/octet-stream' : 'text/x-sql';
header("Content-type: ".$mime_type);
header("Content-Disposition: attachment; filename={$config['sitename']}db".date("YmdHi").".sql; charset=utf-8");

define('BR', "\r\n");
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

function sortTables($a , $b)
{
	if ($a['Table_type']<$b['Table_type']) return -1;
	if ($a['Table_type']>$b['Table_type']) return 1;
	return 0; 
}

class DB_EXPORT {

	public $db;
	public $sql_constraints;
	public $conf;
	
	public function __construct($db, $sitename='')
	{
		$this->db = $db;
		$this->conf['server']  = $db->dsn['hostspec'];
		$this->conf['port']    = $db->dsn['port'];
		$this->conf['database']= $db->dsn['database'];
		$this->conf['sitename']= $sitename ? $sitename : $db->dsn['database'];
	}

	public function __destruct()
	{
	
	}

	public function makeHeader()
	{
		$head  =  '-- version ' . mysql_get_server_info() . BR
			   .  '-- ' . BR
			   .  '-- Server: ' . $this->conf['server'];
		if (!empty($this->conf['port'])) {
			 $head .= ':' . $this->conf['port'];
		}
		$head .= BR
			   .  '-- Generation Time: ' . date("Y-m-d H:i:s") . BR
			   .  '-- Server Version: ' . substr(mysql_get_server_info(), 0, 1) . '.' . (int) substr(mysql_get_server_info(), 1, 2) . '.' . (int) substr(mysql_get_server_info(), 3) . BR
			   .  '-- PHP Version: ' . phpversion() . BR;
	
		$head .=  BR . 'SET FOREIGN_KEY_CHECKS=0;' . BR;
		$head .= '-- --------------------------------------------------------' . BR . BR;
		return $head;
	}
	
	public function makeFooter()
	{
		$foot .=  BR . 'SET FOREIGN_KEY_CHECKS=1;' . BR;
		$foot .= '-- End of SQL ' . BR;
		$foot .= '-- --------------------------------------------------------';
		return $foot;
	}
	
	public function makeDB()
	{
		$res = "CREATE DATABASE IF NOT EXISTS ".$this->backQuote($this->conf['database']).";" . BR;
		$res .= "USE DATABASE ".$this->backQuote($this->conf['database']).";" . BR . BR;
		return $res;
	}
	
	public function getTableList()
	{		
		$sql = "SHOW FULL TABLES FROM ".$this->backQuote($this->conf['database']);
		$res = $this->db->getAll($sql);
		sortArr($res , "sortTables");
		foreach($res as $key => $val){
			$result[$val["Tables_in_" . $this->conf['database']]] = $val['Table_type'];
		}
		trace($result);
		return $result;
	}
	
	public function getFieldList($table)
	{
		$sql = "SHOW FULL COLUMNS
				FROM " . $this->backQuote($table);		
		return $this->db->getAll($sql);
	}
	
	public function backQuote($a_name)
    {
		if(!preg_match('/^`.*`$/', $a_name) and isset($a_name) and !empty($a_name) and $a_name != '*') {
			if (is_array($a_name)) {
				 $result = array();
				 foreach ($a_name AS $key => $val) {
					 $result[$key] = '`' . $val . '`';
				 }
				 return $result;
			} else {
				return '`' . $a_name . '`';
			}	
		}
		return $a_name;
    }
	
	public function makeStructure($table)
	{
		$dump = BR
			  .  '-- --------------------------------------------------------' . BR
			  .  BR . '-- ' . BR
			  .  '-- Table structure for table ' . $this->backQuote($table) . BR
			  .  '-- ' . BR
			  .  $this->getTableDef($table) . BR;	
		return $dump;
	}

	public function getTableDef($table, $type)
	{
		$type = ($type=='VIEW') ? $type : 'TABLE';
		$schema_create = "DROP $type IF EXISTS " . $this->backQuote($table) . ';' . BR;
		$this->db->query('SET SQL_QUOTE_SHOW_CREATE = 1');	
		$sql = "SHOW CREATE $type " . $this->backQuote($table);
		$result = $this->db->getRow($sql);
		if ($result) {
			$create_query = ($type=='VIEW') ? $result['Create View'] : $result['Create Table'];
			
			if (strpos($create_query, "(\r\n ")) {
				$create_query = str_replace("\r\n", BR, $create_query);
			} elseif (strpos($create_query, "(\n ")) {
				$create_query = str_replace("\n", BR, $create_query);
			} elseif (strpos($create_query, "(\r ")) {
				$create_query = str_replace("\r", BR, $create_query);
			}
	
			if (preg_match('/CONSTRAINT|FOREIGN[\s]+KEY/i', $create_query)) {
	
				$sql_lines = explode(BR, $create_query);
				$sql_count = count($sql_lines);
	
				for ($i = 0; $i < $sql_count; $i++) {
					if (preg_match('/^[\s]*(CONSTRAINT|FOREIGN[\s]+KEY)/i', $sql_lines[$i])) {
						break;
					}
				}
				
				if ($i != $sql_count) {
					$sql_lines[$i - 1] = preg_replace('/,$/', '', $sql_lines[$i - 1]);
	
					if (empty($this->sql_constraints)) {
						$this->sql_constraints = BR . '-- ' .
												 BR . '-- Constraints for dumped tables' .
												 BR . '-- ' . BR;
					}
	
					$this->sql_constraints .= BR . '-- ' .
											  BR . '-- Constraints for table ' . $this->backQuote($table) .
											  BR . '-- ' . BR;
					

					$this->sql_constraints .= 'ALTER TABLE ' . $this->backQuote($table) . BR;
					
					$first = TRUE;
					for ($j = $i; $j < $sql_count; $j++) {
						if (preg_match('/CONSTRAINT|FOREIGN[\s]+KEY/i', $sql_lines[$j])) {
							if (!$first) {
								$this->sql_constraints .= BR;
							}
							if (strpos($sql_lines[$j], 'CONSTRAINT') === FALSE) {
								$this->sql_constraints .= preg_replace('/(FOREIGN[\s]+KEY)/i', 'ADD \1', $sql_lines[$j]);
							} else {
								$this->sql_constraints .= preg_replace('/(CONSTRAINT)/i', 'ADD \1', $sql_lines[$j]);
							}
							$first = FALSE;
						} else {
							break;
						}
					}
					$this->sql_constraints .= ';' . BR;
					$create_query = implode(BR, array_slice($sql_lines, 0, $i)) . BR . implode(BR, array_slice($sql_lines, $j, $sql_count - 1));
					unset($sql_lines);					
				}
			}
			$schema_create .= $create_query;
			
		}	
		$schema_create = BR . '-- -----------------------------------------------------' .
						 BR . '-- ' .
						 BR . '-- Create ' . $type . ': ' . $this->backQuote($table) .
						 BR . '-- ' . BR . BR . $schema_create;
		$schema_create .= $auto_increment . ';' . BR . BR;
		$schema_create = ($type=="VIEW") ? preg_replace('/CREATE ALGORITHM=.* VIEW/i', 'CREATE VIEW', $schema_create) : $schema_create;
		return $schema_create;	
	}

	public function exportData($table)
	{
		$formatted_table_name = $this->backQuote($table);

		$buffer = '';
		$sql = "SELECT * FROM $formatted_table_name";
		$res = $this->db->getAll($sql);
		$field = $this->getFieldList($formatted_table_name);
		foreach($field as $val) {
			$field[$val['Field']] = $val;
			$field_set[] = $this->backQuote($val['Field']);
			if (preg_match('/text|blob|char|binary|enum|set/i', $val['Type'])) {  
				 $field[$val['Field']]['format'] = "'%s'";
			} else { //  /int|date|time|year|float|real|double|number|dec|fixed/i 
				 $field[$val['Field']]['format'] = "%s";			
			}
		}
		
		if ($res != FALSE) {
			$head = BR
				  . '-- ' . BR
				  . '-- Dumping data for table ' . $formatted_table_name . BR
				  . '-- ' . BR . BR;
			$fields        = implode(', ', $field_set);
			$schema_insert = $head . 'INSERT INTO ' . $this->backQuote($table)
						   . ' (' . $fields . ') VALUES '. BR;
	
			$search       = array("\x00", "\x0a", "\x0d", "\x1a", "'"); //\x08\\x09, not required
			$replace      = array('\0', '\n', '\r', '\Z', '\\\'');
			
			foreach ($res as $current_row=>$row) {
				$values = array();
				foreach ($row as $key=>$val) {
					if (!isset($val) || is_null($val)) {
						$values[] = 'NULL';
					} elseif (empty($val) && $val != '0') {
						$values[] = "''";
					} else {
						$values[] = sprintf($field[$key]['format'], str_replace($search, $replace, addslashes($val)));
					}
				}
				$insert_line[]  = '(' . implode(', ', $values) . ')';
			}
			$schema_insert .= implode(",".BR, $insert_line) . ';'. BR . BR;
			unset($values, $insert_line);

		}
		return @$schema_insert;
	}
}	


$dbex = new DB_EXPORT($db, $config['sitename']); 

$res = $dbex->makeHeader();
$res .= $dbex->makeDB();

foreach($dbex->getTableList() as $key => $val) {
	$res .= $dbex->getTableDef($key, $val);
	$res .= ($val=='VIEW') ? '' : $dbex->exportData($key);
}

$res .= $dbex->sql_constraints;
$res .= $dbex->makeHeader();

echo $res;
$testuser = false;
die();
?>