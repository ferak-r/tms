<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="fa" />

<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<link rel="stylesheet" href="../+script/cpanel/cpanel.css" type="text/css" />
<link rel="stylesheet" href="../+script/cpanel/tabpane.css" type="text/css" id="luna-tab-style-sheet" />
<link rel="stylesheet" href="../+script/menu/theme-en.css" type="text/css" />
<link rel="stylesheet" href="../+script/calendar/calendar-mos.css" type="text/css" />

<link rel="icon" href="../images/icon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../images/icon.ico" type="image/x-icon" />
<script type="text/javascript" src="../+script/menu/JSCookMenu_mini.js"></script>
<script type="text/javascript" src="../+script/menu/theme.js"></script>
<script type="text/javascript" src="../+script/cpanel/tabpane_mini.js"></script>
<script type="text/javascript" src="../+script/class.big.js"></script>
<script type="text/javascript" src="../+script/ajax.js"></script>
<script type="text/javascript" src="../+script/global-script.js"></script>
<script type="text/javascript" src="../+script/site-script.js"></script>
<script type="text/javascript" src="../+script/calendar/calendar-mini.js"></script>
<script type="text/javascript" src="../+script/calendar/calendar-en.js"></script>
<script type="text/javascript" src="../+script/dbs.js.php?transportid={$transportid}"></script>
<title>{$title}</title>

<!-- messaging system -->
<link rel="stylesheet" type="text/css" href="../+script/message/message.css" />
<script language="javascript" type="text/javascript" src="../+script/message/message.js"></script>

<script language="javascript" type="text/javascript">
<!--
msg.text = '{$msg.text|escape:"quotes"}';
msg.type = '{$msg.type|escape:"quotes"}';
msg.title= '{$msg.title|escape:"quotes"}';
msg.cmd  = '{$msg.cmd|escape:"quotes"}';

{literal}

function loader()
{
	if(msg.text){
	  msg.display(msg.text, msg.type, msg.title, msg.cmd);
	}
}

{/literal}
//-->
</script>
<!-- end of messaging system -->