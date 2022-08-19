<?PHP
function alert($val)
{
	$res = addcslashes(print_r($val, 1), "\r\n\t\"\'");
	echo "<script>alert('$res')</script>";
}
?>