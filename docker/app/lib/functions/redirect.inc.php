<?PHP
function redirect($loc, $header=false)
{
  if($header){
  	header("Location: $loc");
  	header ("HTTP/1.0 301 Moved Permanently");
  }	
  die("<meta http-equiv='refresh' content='0; $loc'>".
      "<script language='javascript' type='text/javascript'>".
      "document.location.replace('$loc')".
      "</script>"."<a href=\"$loc\">$loc</a>");
}
?>