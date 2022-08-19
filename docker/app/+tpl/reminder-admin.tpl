<!-- {if $popup} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" href="../+assets/style-en.css" type="text/css" />
{include file="_head.tpl"}
</head>
<body style="margin:10px;">
<div dir="rtl">
<!-- {/if} -->
<form action="index.php?section={$section}&module=reminder-admin&cmd={if $id}update{else}add{/if}&frm_id={$id}&popup={$popup}" method="post" name="form1" id="form1" enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="3" width="100%">
	<tr>
		<td>
		<table border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
{capture name=buttons}	
	<tr>
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap>&nbsp;			</td>
		<td class="list-box" width="90%" style="padding-bottom: 3px;" colspan="2">		
				<div class="button-ex-gray" style="margin: 3px;"><a title="Cancle and Return" href="{if $popup}javascript:window.close(); {else}index.php?section={$section}&amp;module=reminder-list&amp;page={$page}{/if}">
			<img border="0" src="../images/icons/48x48/cancelen.png" width="48" height="48" alt="" /></a>			</div>		
				<div class="button-ex-gray" style="margin: 3px;"><a title="Set Defaults" href="javascript:if(confirm('Do you want to load default values?')) document.form1.reset();">
			<img border="0" src="../images/icons/48x48/refreshen.png" width="48" height="48" alt="" /></a>			</div>
				<div class="button-ex-gray" style="margin: 3px;"><a title="Save and Continue" href="#" onclick="calc_timestamp(); form1.submit();">
			<img border="0" src="../images/icons/48x48/oken.png" width="48" height="48" alt="" /></a>			</div></td>
	</tr>
{/capture}
{$smarty.capture.buttons}		
	<tr>
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap><div class="form-title">Reminder: </div></td>
		<td class="list-box" width="90%" colspan="2"><div class="form-input">
			<textarea name="frm_reminder" dir="ltr" />{$list.xreminder}</textarea></div></td>
	</tr>
	<tr>
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap><div class="form-title">Reminder Date</div></td>
		<td class="list-box" width="90%" colspan="2"><div class="form-input">
		 <input type="text" name="frm_reminderdate" value="{$list.xreminderdate}" id="frm_reminderdate" />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_reminderdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>
		</div></td>
	</tr>
	<tr>
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap><div class="form-title">Reminder Time:</div></td>
		<td class="list-box" width="90%" colspan="2"><div class="form-input">
			<select name="frm_reminderhour" style="width: 40px">
				{foreach from=$hour key=key item=item}
					<option value="{$key}" {if $key eq $list.xreminderhour}selected{/if}>{$item}</option>
				{/foreach}
			</select>
			:
			<select size="1" name="frm_reminderminute" style="width: 40px">
				{foreach from=$minute key=key item=item}
					<option value="{$key}" {if $key eq $list.xreminderminute}selected{/if}>{$item}</option>
				{/foreach}
			</select>
			<input type="hidden" name="frm_clienttimestamp" />
			<input type="hidden" name="frm_remindertimestamp" />
		</div></td>
	</tr>
{$smarty.capture.buttons}	
	</table>
		</td>
{if !$popup}		
		<td width="319" nowrap class="list-box" style="background-color: #fff; padding: 3px;" align="center">&nbsp;
	  </td>
{/if}	 
	</tr>
</table>
<input type="submit" style="display: none;" />
</form>
<!-- {if $popup} -->
</div>
</body>
</html>
<!-- {/if} -->
{literal}
<script type="text/javascript">
function calc_timestamp(){
	var year  = document.form1.frm_reminderdate.value.substring(0, 4);
    var month = document.form1.frm_reminderdate.value.substring(5, 7) - 1;
	var day   = document.form1.frm_reminderdate.value.substring(8, 10);
	var hour  = document.form1.frm_reminderhour.value;
	var minute= document.form1.frm_reminderminute.value;
	document.form1.frm_remindertimestamp.value = Number(new Date(year, month, day, hour, minute));
}
</script>
{/literal}