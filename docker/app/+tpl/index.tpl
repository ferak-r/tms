<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

{include file="_head.tpl"}

</head>
<body>
<div id="container" dir="ltr">
{if !$smarty.request.popup}
	<div id="header">
		<div id="logo">
			<div class="navigation" style="visibility: hidden;">
				<a href="javascript:void(0);">تیتر اصلی</a> /
				<a href="javascript:void(0);">تیتر فرعی</a> / تیتر 2</div>
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="main_menu">
							<div id="myMenuID">
							</div>
<script type="text/javascript" src="../+script/menu/menu-items.js.php"></script>
					</td>
				</tr>
			</table>
		</div>	
	</div>
		<table border="0" cellpadding="0" cellspacing="5" width="100%" style="height: 40px">
			<tr>
				<td style="vertical-align: middle">
{if $title1}
					<div class="main-title1">
						{$title1}			
					</div>
{/if}
{if $title2}
					<div class="main-title2">
						{$title2}</div>
{/if}&nbsp;
				</td>
				
				<td width="345">
					<div id="top_info">
									{* $user->info.name} به سیستم اتوماسیون {$config.sitename} خوش آمدید.<br /> *}
									Username: <span class="gray-val">{$user->info.username}</span><br />
									User Level: <span class="gray-val">{$groupname}</span><br />
									New Mails: <span class="gray-val">{$mail->newmail}</span>
					</div>
				</td>
			</tr>
		</table>
{/if}		
	<table id="main" cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td>
	<table border="0" cellpadding="10" cellspacing="0" width="100%" id="main_body">
{if !$user->id}
{assign var="tplModule" value="login.tpl"}
{/if}	
{if $tplModule}
		<tr>
			<td>
{include file=$tplModule}			
			</td>
{*{if $showmessage}			
			<td width="320" nowrap>
{include file="box-message.tpl"}					
			</td>
{/if}*}
		</tr>	
{else}		
		<tr>
			<td><div id="cpanel">
		<div style="float:left;">
			<div class="icon">
				<a href="index.php?section=guest&module=login&logincmd=logout">
					<div class="iconimage" title="Logout">
							<img src="../images/icons/48x48/shutdown.png"  align="middle" name="image" border="0" width="48" height="48" alt="" />
					</div>
					Logout
				</a>
			</div>
		</div>
	</div>
			</td>
			<td width="320" nowrap>
{*{include file="box-message.tpl"}*}
			</td>
		</tr>
{/if}		
	</table>
	</td>
	</tr>
	</table>
</div>
{if !$smarty.request.popup}
	<div id="footer" dir="ltr">
		© <a href="http://www.aryaweb.com" target="_blank">Aryaweb.com</a> Inc. 2006<br />
		All rights reserved.
	</div>
{/if}
<script language="javascript" type="text/javascript" src="../+script/final-script.js"></script>
<script type="text/javascript">
{literal}
function checkReminder(){
	/*var sec = parseInt(new Date()/1000%60);	
	if(sec > 10) {
		checkReminder.delay(9000);
		return;
	}*/
	var d = Number(new Date());
	d = parseInt(d/10000);
	for(i=0; i<reminder.length; i++){
		if(d >= reminder[i]['time'] && reminder[i]['view'] != 1){
			var r=new Ajax("index.php?section=user&module=reminder-admin&cmd=alert&reminderid="+reminder[i]['id']+"&reminderindex="+i, {method: 'get', evalScripts:true, onComplete: function(){checkReminder.delay(10000)}}).request();
			reminder[i]['view'] = 1;
		}
	}
	
	//check mail
	//new Ajax("index.php?section=user&module=mail-admin&cmd=newmail", {method: 'get', evalScripts:true}).request();
	
	setTimeout('checkReminder()', 10000);
}
{/literal}
{if $user->id}
checkReminder();
{/if}
{foreach from=$P.js item=item}
//--------
{$item};
//--------
{/foreach}
</script>
</body>
</html>

