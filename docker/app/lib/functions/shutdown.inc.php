<?PHP
function shutdown()
{
	global $db, $trace_val, $self;
	session_write_close (); // do this before closing $db
	if(!empty($db)) {
		@$db->disconnect();
	}	
	if($trace_val){
		trace($trace_val, -1);
	}	
}
register_shutdown_function("shutdown");
?>