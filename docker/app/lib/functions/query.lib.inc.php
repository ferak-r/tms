<?php

function CreateQuery($Type, $Arr, $Func, $Vals="")							{
	if($Vals == "") $Vals = $_POST;
	foreach($Arr as $key => $val){
		if(isset($Func[$val]))
			eval('$VAL[$val] = '.$Func[$val].'(@$Vals["frm_".$val]);');
		else
			$VAL[$val]	= addslashes(@$Vals["frm_".$val]);
		}		
		
		if(strtolower(trim($Type)) == "insert"){
			$Q1 = "";
			$Q2 = "";
			foreach($VAL as $key => $val){
				$Q1 .= ($Q1)?", fld$key":"fld$key";
				$Q2 .= ($Q2)?", '$val'":"'$val'";
			}
			return array(1=>$Q1, 2=>$Q2);
		}	
		
		if(strtolower(trim($Type)) == "update"){
			$Q = "";
			foreach($VAL as $key => $val)
				$Q .= ($Q)?", fld$key='$val'":"fld$key='$val'";
			return $Q;
		}	
}

?>