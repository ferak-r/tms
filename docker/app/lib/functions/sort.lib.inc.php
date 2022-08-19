<?PHP

/*function sortFunc($a , $b){
	if ($a['lbno']<$b['lbno']) return -1;
	if ($a['lbno']>$b['lbno']) return 1;
	return $a['goodid'] - $b['goodid']; 
}*/
function sortArr(&$arr, $sortFunc){
	if(empty($arr))
		return;
	$arraysize = sizeof($arr);
	$flag = 0;
	for($i=$arraysize-1 ; $i>0 ;  $i--){
		for($j=0 ; $i > $j ;  $j++){
			if ( $sortFunc($arr[$j], $arr[$j+1]) > 0 ){/////////////////////////////
				$temp = $arr[$j];
				$arr[$j] = $arr[$j+1];
				$arr[$j+1] = $temp;
				$flag = 1;
			}
		}
		if(!$flag) 
			break;	 
	}
}

?>