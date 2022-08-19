<?PHP
function random($passwordLength, $maps=0)
{
	$map[0]='0123456789';
	$map[1]='abcdefghijklmnopqrstuvwxyz';
	$map[2]='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$map[3]='-_';
	$map[4]='<>,.?/|:;"\'[]{}`~!@#$%^&*()+=\\';
	$str=strrev(decbin($maps));
	$rnd='';
	for($i=0; $i<5; $i++){
		if(substr($str, $i, 1)=='1'){
			$rnd.=$map[$i];
		}
	}
	$rnd;
    $password = "";
    for ($index = 1; $index <= $passwordLength; $index++) {
         $randomNumber = rand(0, strlen($rnd)-1);
         $password.=substr($rnd, $randomNumber, 1);
    }
    return $password;
}
?>