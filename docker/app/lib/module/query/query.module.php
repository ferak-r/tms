<?PHP
require_once('query.conf.php');
require_once('query.class.php');

$qobject = new QUERY($config['query']);
$qobject->make();
?>