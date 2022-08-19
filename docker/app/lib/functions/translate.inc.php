<?php
function translate ($source, $languageArray, $key=0)
{
	if(empty($key)){
		foreach($source as $key => $val){
			$res[$key] = $languageArray[$val];
		}
	}else{
		foreach($source as $key => $val){
			$res[$languageArray[$key]] = $val;
		}
	}
	return($res);
}
?>