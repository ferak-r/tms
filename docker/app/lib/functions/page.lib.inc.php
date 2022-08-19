<?php
//### baraye page bandi safehat
function paging (&$Groups , &$Cpage_num) {
	$Cpage_num	= (intval(@$Cpage_num) <= 0)?1:intval($Cpage_num);// curent page
	$Groups = array_chunk($Groups , 5);
	$pages_num	= count($Groups);   ///number of pages
	$Cpage_num = min($Cpage_num, $pages_num);
	$Cpage_num = ($Cpage_num < 1) ? 1 : $Cpage_num;
	$en_first = ($Cpage_num > 1)? true: false;
	$en_last = ($Cpage_num < $pages_num)? true: false; 
	$Grouping = array('Cpage_num' => $Cpage_num,
		'pages_num' => $pages_num,
		'en_first' => $en_first,
		'en_last' => $en_last);
	return $Grouping;
}
?>