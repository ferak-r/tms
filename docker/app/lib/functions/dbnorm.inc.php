<?PHP
function dbnorm($str)
{
	return strtr(fa_normalize(trim($str)), array("\\"=>"\\\\", "'"=>"\\'", "\""=>"\\\"", ";"=>"\\;"));
}
?>