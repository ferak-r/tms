<?PHP
require_once("session.class.php");

$session = new SESSION(
						$config['db']['name'],
						$config['db']['server'],
						$config['db']['port'],
						$config['db']['user'],
						$config['db']['pass']
						);

session_set_save_handler(
						array(& $session, 'open'),
						array(& $session, 'close'), 
						array(& $session, 'read'), 
						array(& $session, 'write'), 
						array(& $session, 'destroy'), 
						array(& $session, 'gc')
						);

session_start();
?>