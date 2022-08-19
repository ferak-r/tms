<?PHP
function trace($val, $die=false, $dir='ltr')
{
	global $trace_val, $testuser;
	if(!$testuser){
		return;
	}
	if(is_string($die)) {
		$title = $die;
		$die = ($dir=='ltr') ? 0 : $dir;
	}
	$val = is_null($val) ? '[NULL]' : $val;
	if($die != -1) {
		$idx = count($trace_val);
		$trace_val[$idx]['value'] = $val;
		$trace_val[$idx]['title'] = @$title;
		if(empty($die)){
			return;
		} else {
			die();
		}
	}
	$res = "
<style type=\"text/css\">
.trace_master {	position: absolute;	z-index:100;	border: 1px solid #999999; 	background-color: #FFFFEE;}
.trace_head {	font-family: verdana, arial;	height: 22px;	background-color: #3366CC;	border-bottom: 1px solid #999999; 	cursor: default;}
.trace_close {	float: left;	width: 16px;	margin: 2px;	background-color: #FF6633;	border: 1px solid #000000;	cursor: pointer; 	font-size: 14px;	text-align: center;	color: #000066;}
.trace_max {	float: left;	width: 16px;	margin: 2px;	background-color: #66EE00;	border: 1px solid #000000;	cursor: pointer;	font-size: 14px;	text-align: center;	color: #000066;}
.trace_min {	float: left;	width: 16px;	margin: 2px;	background-color: #CCCCCC;	border: 1px solid #000000;	cursor: pointer;	font-size: 14px;	text-align: center;	color: #000066;}
.trace_title {	font-size: 12px;	color: #FFFFFF;	text-align: left;	float: left;	margin-top: 4px;}
.trace_content{	overflow: hidden;	width: 150px;	height: 0px;	padding: 4px;}
</style>
	";	
	$code = "
var sels = new Array();
function maximizeTrace(id)
{
	var master = document.getElementById('trace_master_'+id);
	var content = document.getElementById('trace_content_'+id);
	content.style.overflow='auto';
	content.style.width = screen.availWidth - 70 + 'px';
	content.style.height = screen.availHeight - 260 + 'px';
	master.style.top = '30px';
	master.style.left = '2px';
	master.style.overflow='';
	master.style.width = screen.availWidth - 62 + 'px';
	master.style.height = screen.availHeight - 229 + 'px';
	document.cookie = 'trace_window_max='+id;
	var tmpSels = document.getElementsByTagName('SELECT');
	var cnt = 0;
	if(document.all){
		for(var i=0; i<tmpSels.length; i++){
			if(tmpSels[i].style.visibility != 'hidden'){
				sels[cnt++] = tmpSels[i];
				tmpSels[i].style.visibility = 'hidden';
			}
		}
	}
}
function minimizeTrace(id)
{
	var master = document.getElementById('trace_master_'+id);
	var content = document.getElementById('trace_content_'+id);
	content.style.overflow='hidden';
	content.style.width = '150px';
	content.style.height = '0px';
	master.style.left = id*165+2+'px';
	master.style.top = '2px';
	master.style.overflow='hidden';
	master.style.width = '150px';
	master.style.height =  '25px';
	document.cookie = 'trace_window_max=0';
	for(var i=0; i<sels.length; i++){
		sels[i].style.visibility = '';
	}
	sels = new Array();
}
function closeTrace(id)
{	
	var master = document.getElementById('trace_master_'+id);
	master.style.display = 'none';
	document.cookie = 'trace_window_max=0';
	for(var i=0; i<sels.length; i++){
		sels[i].style.visibility = '';
	}
	sels = new Array();
}

	";	
	foreach($trace_val as $key=>$val){
		$key++;
		$res .= "
				<div id='trace_master_$key' class='trace_master' dir='ltr' align='left'>
					<div class='trace_head'>
						<div class='trace_close' onclick=\"closeTrace('$key')\">x</div>
						<div class='trace_max' onclick=\"maximizeTrace('$key')\">+</div>
						<div class='trace_min' onclick=\"minimizeTrace('$key')\">-</div>
						<div class='trace_title'>".(empty($val['title']) ? gettype($val['value']) : $val['title'])."</div>
					</div>
					<div class='trace_content' id='trace_content_$key'><pre>\r\n";
		$res .= str_replace("\r\n", "\n", htmlspecialchars(print_r($val['value'], true)));
		$res .= "</pre></div></div>";
		if(@$_COOKIE["trace_window_max"]==$key){
			$code .= "maximizeTrace($key);";
		} else {
			$code .= "minimizeTrace($key);";
		}
	}
	unset($trace_val);
	$res = str_replace("\r\n", "", $res);
	$code = str_replace("\r\n", "", $code);
	echo "<script language='javascript' type='text/javascript'>document.write('". addcslashes( $res, "/\\\r\n\t'" ) ."'); $code </script>";
	die();
}


function smartyTrace()
{
	global $smarty;
	if (version_compare(phpversion(), '5.0') < 0) {
		eval('function clone($object) {return $object;}');
		$clone = clone($smarty);
 	} else {
		$clone = clone $smarty;	
	}
	$arglist = func_get_args();
	foreach($arglist as $arg){
		unset($clone->_tpl_vars[$arg]);
	}	
	trace($clone->_tpl_vars, "SMARTY");
}

function traceAll($die=false, $dir='ltr'){
	$allInfo['GET']		=@$_GET;
	$allInfo['POST']	=@$_POST;
	$allInfo['SESSION']	=@$_SESSION;
	$allInfo['COOKIE']	=@$_COOKIE;
	$allInfo['FILES']	=@$_FILES;
	$allInfo['REQUEST']	=@$_REQUEST;
	//$allInfo['SERVER']	=$_SERVER;
	trace($allInfo, $die, $dir);
}

?>