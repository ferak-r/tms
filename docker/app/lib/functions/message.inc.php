<?php
//$type=alert,error,help,info,lock,ok
function msg($text, $type='', $title='', $add=false)
{
	$_SESSION['msg']['text'] = ($add) ? $_SESSION['msg']['text']."<BR />".$text : $text;
	$_SESSION['msg']['type'] = $type;
	$_SESSION['msg']['title'] = $title;
}
?>