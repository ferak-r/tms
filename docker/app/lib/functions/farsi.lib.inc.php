<?PHP
/*		fa_normalize($string)											*
 *		farsi_sort($ar)													*
 *		fa_decode($str)													*
 *		fa_encode($str)													*
 * 																		*/

function fa_normalize($string, $normalizeDigits=false)
{	
	return $string;
	if (is_array($string)){
		return array_map("fa_normalize", $string);
	}
	$trans = array(
	"ا" => "ا", "أ" => "ا", "آ" => "آ", "ب" => "ب", "پ" => "پ", "ت" => "ت", "ث" => "ث", "ج" => "ج",
	"چ" => "چ", "ح" => "ح", "خ" => "خ", "د" => "د", "ذ" => "ذ", "ر" => "ر", "ز" => "ز", "ژ" => "ژ",
	"س" => "س", "ش" => "ش", "ص" => "ص", "ض" => "ض", "ط" => "ط", "ظ" => "ظ", "ع" => "ع", "غ" => "غ",
	"ف" => "ف", "ق" => "ق", "ک" => "ک", "ك" => "ک", "گ" => "گ", "ل" => "ل", "م" => "م", "ن" => "ن",
	"و" => "و", "ؤ" => "و", "ه" => "ه", "ة" => "ه", "ئ" => "ی", "ى" => "ی", "ي" => "ی", "ی" => "ی"); 
	if($normalizeDigits){
	foreach(array(
	"0" => "۰", "1" => "۱", "2" => "۲", "3" => "۳", "4" => "۴", "5" => "۵", "6" => "۶", "7" => "۷",
	"8" => "۸", "9" => "۹", 
	"٠" => "۰", "١" => "۱", "٢" => "۲", "٣" => "۳", "٤" => "۴", "٥" => "۵", "٦" => "۶", "٧" => "۷",
	"٨" => "۸", "٩" => "۹")
	as $k => $v){
		$trans[$k] = $v;}
	}
	return strtr($string, $trans); 
}

function farsi_sort($ar, $order='asc', $flags=SORT_STRING)
{
  foreach($ar as $k => $v)
    $ar[$k] = fa_encode($v);
  if (strtolower($order) == 'desc') {
  	arsort($ar, $flags);
  } else {	
  	asort($ar, $flags);
  }
  foreach($ar as $k => $v)
    $ar[$k] = fa_decode($v);
  return $ar;
}

function array_qsort(&$array, $column, $order='SORT_ASC', $first=0, $last= -2)
{
  // $array  - the array to be sorted
  // $column - index (column) on which to sort
  //          can be a string if using an associative array
  // $order  - SORT_ASC (default) for ascending or SORT_DESC for descending
  // $first  - start index (row) for partial array sort
  // $last  - stop  index (row) for partial array sort
  // $keys  - array of key values for hash array sort
 if (is_array($array)) {
  $keys = array_keys($array);
 
  if($last == -2) $last = count($array) - 1;
  if($last > $first) {
   $alpha = $first;
   $omega = $last;
   $key_alpha = $keys[$alpha];
   $key_omega = $keys[$omega];
   $guess = $array[$key_alpha][$column];
   while($omega >= $alpha) {
     if($order == 'SORT_ASC') {
       while($array[$key_alpha][$column] < $guess) {$alpha++; $key_alpha = $keys[$alpha]; }
       while($array[$key_omega][$column] > $guess) {$omega--; $key_omega = $keys[$omega]; }
     } else {
       while($array[$key_alpha][$column] > $guess) {$alpha++; $key_alpha = $keys[$alpha]; }
       while($array[$key_omega][$column] < $guess) {$omega--; $key_omega = $keys[$omega]; }
     }
     if($alpha > $omega) break;
     $temporary = $array[$key_alpha];
     $array[$key_alpha] = $array[$key_omega]; $alpha++;
     $key_alpha = $keys[$alpha];
     $array[$key_omega] = $temporary; $omega--;
     $key_omega = @$keys[$omega];
   }
   array_qsort ($array, $column, $order, $first, $omega);
   array_qsort ($array, $column, $order, $alpha, $last);
  }
 }
  return $array;
}

function farsi_dbSort(&$records, $sortby, $order)
{
	foreach($records as $k => $v) {
		$records[$k][$sortby] = fa_encode($v[$sortby]);
	}
	array_qsort($records, $sortby, ($order=="DESC")?"SORT_DESC":"SORT_ASC");
	foreach($records as $k => $v) {
		$records[$k][$sortby] = fa_decode($v[$sortby]);
	}
	return $records;
}

function fa_decode($str)
{
	$_to_farsi=array(
	chr(131).chr(48) => "ء", chr(131).chr(49) => "آ", chr(131).chr(50) => "ئ", chr(131).chr(51) => "ؤ",
	chr(131).chr(52) => "ا", chr(131).chr(53) => "ب", chr(131).chr(54) => "پ", chr(131).chr(55) => "ت",
	chr(131).chr(56) => "ث", chr(131).chr(57) => "ج", chr(131).chr(65) => "چ", chr(131).chr(66) => "ح",
	chr(131).chr(67) => "خ", chr(131).chr(68) => "د", chr(131).chr(69) => "ذ", chr(131).chr(70) => "ر",
	chr(131).chr(71) => "ز", chr(131).chr(72) => "ژ", chr(131).chr(73) => "س", chr(131).chr(74) => "ش",
	chr(131).chr(75) => "ص", chr(131).chr(76) => "ض", chr(131).chr(77) => "ط", chr(131).chr(78) => "ظ",
	chr(131).chr(79) => "ع", chr(131).chr(80) => "غ", chr(131).chr(81) => "ف", chr(131).chr(82) => "ق",
	chr(131).chr(83) => "ک", chr(131).chr(84) => "گ", chr(131).chr(85) => "ل", chr(131).chr(86) => "م",
	chr(131).chr(87) => "ن", chr(131).chr(88) => "و", chr(131).chr(89) => "ه", chr(131).chr(90) => "ي",
	chr(131).chr(91)=> "ی");
	return strtr($str, $_to_farsi);
}

function fa_encode($str)
{
	$_to_safe=array(
	"ء" => chr(131).chr(48), "آ" => chr(131).chr(49), "ئ" => chr(131).chr(50), "ؤ" => chr(131).chr(51),
	"ا" => chr(131).chr(52), "ب" => chr(131).chr(53), "پ" => chr(131).chr(54), "ت" => chr(131).chr(55),
	"ث" => chr(131).chr(56), "ج" => chr(131).chr(57), "چ" => chr(131).chr(65), "ح" => chr(131).chr(66),
	"خ" => chr(131).chr(67), "د" => chr(131).chr(68), "ذ" => chr(131).chr(69), "ر" => chr(131).chr(70),
	"ز" => chr(131).chr(71), "ژ" => chr(131).chr(72), "س" => chr(131).chr(73), "ش" => chr(131).chr(74),
	"ص" => chr(131).chr(75), "ض" => chr(131).chr(76), "ط" => chr(131).chr(77), "ظ" => chr(131).chr(78),
	"ع" => chr(131).chr(79), "غ" => chr(131).chr(80), "ف" => chr(131).chr(81), "ق" => chr(131).chr(82),
	"ک" => chr(131).chr(83), "ك" => chr(131).chr(83), "گ" => chr(131).chr(84), "ل" => chr(131).chr(85),
	"م" => chr(131).chr(86), "ن" => chr(131).chr(87), "و" => chr(131).chr(88), "ه" => chr(131).chr(89),
	"ي" => chr(131).chr(90), "ی" => chr(131).chr(91), "ى" => chr(131).chr(91));
	return strtr($str, $_to_safe);
}
 
//==============================================convert farsi===========


function farsi_mail($string)
{
	return $string;
	$trans = array(
	"0" => "&#1776;", "1" => "&#1777;", "2" => "&#1778;", "3" => "&#1779;", "4" => "&#1780;",
	"5" => "&#1781;", "6" => "&#1782;", "7" => "&#1783;", "8" => "&#1784;", "9" => "&#1785;",
	"٠" => "&#1776;", "١" => "&#1777;", "٢" => "&#1778;", "٣" => "&#1779;", "٤" => "&#1780;",
	"٥" => "&#1781;", "٦" => "&#1782;", "٧" => "&#1783;", "٨" => "&#1784;", "٩" => "&#1785;",
	" " => "&nbsp;",  "ا" => "&#1575;", "أ" => "&#1575;", "آ" => "&#1570;", "ب" => "&#1576;",
	"پ" => "&#1662;", "ت" => "&#1578;", "ث" => "&#1579;", "ج" => "&#1580;", "چ" => "&#1670;",
	"ح" => "&#1581;", "خ" => "&#1582;", "د" => "&#1583;", "ذ" => "&#1584;", "ر" => "&#1585;",
	"ز" => "&#1586;", "ژ" => "&#1688;", "س" => "&#1587;", "ش" => "&#1588;", "ص" => "&#1589;",
	"ض" => "&#1590;", "ط" => "&#1591;", "ظ" => "&#1592;", "ع" => "&#1593;", "غ" => "&#1594;",
	"ف" => "&#1601;", "ق" => "&#1602;", "ک" => "&#1705;", "ك" => "&#1705;", "گ" => "&#1711;",
	"ل" => "&#1604;", "م" => "&#1605;", "ن" => "&#1606;", "و" => "&#1608;", "ؤ" => "&#1608;",
	"ه" => "&#1607;", "ة" => "&#1607;", "ئ" => "&#1740;ی","ى" => "&#1740;ی","ي" => "&#1740;ی",
	"ی"  => "&#1740;ی"); 
	return strtr($string, $trans); 
}

function utf8_safe_substr($string,$length,$start=0) {
    //setting internal encoding to utf-8
    iconv_set_encoding('internal_encoding', 'UTF-8');
    $string=iconv_substr($string,$start,$length);
    $string=iconv_substr($string,0,iconv_strrpos($string,' ')+1);
    return $string;
}

function digitIt($String, $lang='en')										{
 /*if (!isset($String) or @$String == '') 
	if($lang == 'fa')
 		return fa_normalize('0');
	else	
		return '0';
 $neg = (intval($String) < 0)?true:false;
 $String = abs(intval($String));
 $String = strrev($String);
 $String = chunk_split($String, 3, ",");
 $String = strrev($String);
 $String = substr($String, 1, strlen($String)-1);
 if ($neg) $String = '-'.$String;
 if($lang == 'fa')
 	return fa_normalize($String);
 return $String; */  // remarked by ser
 return fa_normalize(number_format($String, 0, ".", ","), $lang=='fa');
}

function fa_normalize_number($val, $normalizeDigits=true)
{
	return $val;
	return fa_normalize(number_format($val, 0, ".", ","), $normalizeDigits);
}

function fa_normalize_jdate($val ,$normalizeDigits=true)
{
	return fa_normalize(jdate("Y/m/d", 0, 0, strtotime($val)), $normalizeDigits);
}
?>