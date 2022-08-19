<?PHP

$loc = 'global/index.php';
header("Location: $loc");

die("<meta http-equiv='refresh' content='0; $loc'>".
	"<script language='javascript' type='text/javascript'>".
	"document.location.replace('$loc')".
	"</script>"."<a href=\"$loc\">$loc</a>");
?>