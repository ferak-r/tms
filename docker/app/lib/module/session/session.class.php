<?PHP #1.01		ser		2006-11-19

class SESSION{

	private $conn;
	private $res;
	private $table;
	private $timeout;
		
	public function __construct($db, $host='localhost', $port='3306', $user='root', $pass='', $table='xxsession', $timeout=18000)
	{
		$this->table = $table;
		$this->timeout = $timeout;
		$this->conn = mysqli_connect($host, $user, $pass, $db, $port);
		if (mysqli_connect_errno()) {
			die("Connect failed: %s\n".mysqli_connect_error());
		}		
   		mysqli_autocommit($this->conn, true);		
		$sql = "CREATE TABLE IF NOT EXISTS {$this->table}
				 (
				  xsessionid     char(255)   not null,
				  xlastupdated   datetime    not null,
				  xdatavalue     text,
				  PRIMARY KEY ( xsessionid ),
				  INDEX ( xlastupdated )
				 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci";
		mysqli_query($this->conn, $sql);
		$sql = "SET CHARACTER SET UTF8";
		mysqli_query($this->conn, $sql);		
	}
	
	public function __destruct()
	{
		if($this->res) {
			@mysqli_free_result($this->res);
		}
		if($this->conn) { 	
			@mysqli_close($this->conn); 
		}	
	}
	
	public function open($aSavaPath, $aSessionName)
	{
		  $this->gc();
		  return true;
	}
	
	public function close()
	{
		  $this->__destruct();
		  return true;
	}
	
	public function read($aKey)
	{
		$sql = "SELECT xdatavalue FROM {$this->table} WHERE xsessionid='$aKey'";
		$this->res = mysqli_query($this->conn, $sql);	
		if(mysqli_num_rows($this->res) == 1){	
		 	$res = mysqli_fetch_row($this->res);
			return $res[0];
		} else {
			$sql = "INSERT INTO {$this->table} (xsessionid,	xlastupdated,	xdatavalue)
										VALUES ('$aKey',		NOW(),			'')";
			mysqli_query($this->conn, $sql);
			return "";
		}
	}
	
	public function write( $aKey, $aVal )
	{
		  $aVal = addslashes( $aVal );
		  $sql  = "UPDATE {$this->table} SET xdatavalue='$aVal', xlastupdated=NOW() WHERE xsessionid='$aKey'";
		  
		  return mysqli_query($this->conn, $sql);
	}
	
	public function destroy( $aKey )
	{
		  $sql = "DELETE FROM {$this->table} WHERE xsessionid='$aKey'";
		  return mysqli_query($this->conn, $sql);
	}
	
	public function gc()
	{
		  $sql = "DELETE FROM {$this->table} WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(xlastupdated) > $this->timeout";
		  return mysqli_query($this->conn, $sql);
	}
}


?>