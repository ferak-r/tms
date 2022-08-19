<?php
function readnull($value, $ar = '_SESSION'){
	global $$ar;
	$ar =& $$ar;
	@$temp = $ar[$value];
	unset($ar[$value]);
	return $temp;
}
?>