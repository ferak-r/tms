<?php
$res = shell_exec('net config server');
preg_match_all("/NetBT_Tcpip_({.*}.*)/", $res, $macs);
foreach($macs[1] as $val){
	echo "$val<br>";
}
//echo sha1("rE#.Mb%TYcde4#$(O;{CBEDB812-E041-44BD-919C-83CCBFD874C3} (00e081717cf8)"); tirtash mac
//echo sha1("rE#.Mb%TYcde4#$(O;{36EBBC31-CDBC-490A-BFD3-24AD96C6BA45} (00142a89e51b)");
echo sha1("rE#.Mb%TYcde4#$(O;{DEC587DB-2188-4B42-B0EB-1F67E9280A61} (00e081717cf8)");

?>