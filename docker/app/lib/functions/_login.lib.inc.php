<?PHP
function LogIn($user, $remember=false, $value='--')					{
 global $config;
 $_SESSION["_retry_"] = 0;
 $_SESSION[$config['UserLevel']] = $user['fldlevel'];
 $_SESSION[$config['UserId']] = $user['fldid'];
 $_SESSION['Uname'] = $user['fldname'];
 $_SESSION['Ufamily'] = $user['fldfamily'];
 $_SESSION['Uusertype'] = $config['usertype'][$user['fldlevel']];
 $_SESSION['Ucompany'] = $user['fldcompany'];
 $_SESSION['Umoney'] = $user['fldpayed'] + $user['fldcredit'];
 $_SESSION['Utel'] = $user['fldtel'];
 $_SESSION['Ufax'] = $user['fldfax'];
 $_SESSION['Uaddress'] = $user['fldaddress'];
 $_SESSION['Uemail'] = $user['fldemail'];
 if($remember){
	setcookie($config['CookieField']."id", $user['fldid'], time() + 3600000,"/");
	setcookie($config['CookieField'], sha1(md5($user["flduser"].$user["fldid"].$user["fldpass"].$_SERVER['REMOTE_ADDR'])), time() + 3600000,"/");
	
 }
}

//----------------------------------------------------------------------------------------------------Login Functions
function LoginCheck($User='', $CheckOnly=false)				{
 if($CheckOnly)
 	return intval(@$_SESSION[$config['UserLevel']]);
 global $db;
 global $config;
 global $tplModule;
 if ($User!='')
 	$User = (is_int($User))?$User:intval($config['Permission'][trim(strtolower($User))]);
 if(isset($_SESSION[$config['UserLevel']]) and intval($_SESSION[$config['UserLevel']])>=$User){
 	return($_SESSION[$config['UserLevel']]);
 } elseif(isset($_COOKIE[$config['CookieField']."id"])){
	$RES=$db->getRow("SELECT * FROM tblusers WHERE fldid = ".$_COOKIE[$config['CookieField']."id"]);
	if((($RES["fldlevel"] >= $User) and ($RES["fldlevel"] >= $User)) or (sha1(md5($RES["flduser"].$RES["fldid"].$RES["fldpass"].$_SERVER['REMOTE_ADDR'])) == $_COOKIE[$config['CookieField']])){
		$_SESSION[$config['UserLevel']] 	= $RES["fldlevel"];
		$_SESSION[$config['UserId']] 	= $RES["fldid"];
		 $_SESSION['Uname'] = $RES['fldname'];
		 $_SESSION['Ufamily'] = $RES['fldfamily'];
		 $_SESSION['Uusertype'] = $config['usertype'][$RES['fldlevel']];
		 $_SESSION['Ucompany'] = $RES['fldcompany'];
		 $_SESSION['Umoney'] = $RES['fldpayed'] + $RES['fldcredit'];
		 $_SESSION['Utel'] = $RES['fldtel'];
		 $_SESSION['Ufax'] = $RES['fldfax'];
		 $_SESSION['Uaddress'] = $RES['fldaddress'];
		 $_SESSION['Uemail'] = $RES['fldemail'];
		return($RES["fldlevel"]);
	}
  }
  $tplModule = 'login.tpl';
  return (0);
}
function LogOut()															{
 global $config;
 $_SESSION["_retry_"] = '';
 $_SESSION[$config['UserLevel']] = '';
 $_SESSION[$config['UserId']] = '';
 $_SESSION['Uname'] = '';
 $_SESSION['Ufamily'] = '';
 $_SESSION['Uusertype'] = '';
 $_SESSION['Ucompany'] = '';
 $_SESSION['Umoney'] = '';
 $_SESSION['Utel'] = '';
 $_SESSION['Ufax'] = '';
 $_SESSION['Uaddress'] = '';
 $_SESSION['Uemail'] = '';
 
 @setcookie($config['CookieField']."id", '', time()-3600000,"/");
 @setcookie($config['CookieField'], '', time()-3600000,"/"); 
 unset($_SESSION[$config['UserLevel']], $_SESSION[$config['UserId']], $_SESSION['Uname'], $_SESSION['Ufamily'], $_SESSION['Ucompany'], $_SESSION['Umoney'], $_SESSION['Utel'], $_SESSION['Ufax'], $_SESSION['Uaddress'], $_SESSION['Uemail'], $_SESSION["_retry_"],$_SESSION['Uusertype']);
}


function isAdmin()
{
	global $config;
	if(@intval($_SESSION['Level'])>=$config['admin']) {
		return(1);
    } else {
		return(0);
	}
}

function isUser()
{
	global $config;
	if(@intval($_SESSION['Level'])>=$config['user']) {
		return(1);
    } else {
		return(0);
	}
}

function showLogin($level, $hint='')
{
	global $root_dir, $smarty, $sessid;
	
	if(login(@$_POST['frmUserName'], @$_POST['frmPassword']) < $level) {
		$singleLogin = true;
		require('login.php');
		$smarty->assign("hint", $hint);
		$smarty->assign("showHead", true);
		$smarty->display("file:$root_dir/content/login.tpl");
		die();
	}
	return 0;
}


?>