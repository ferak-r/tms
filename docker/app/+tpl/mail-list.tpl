<!-- {if $popup} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="fa">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="fa" />
<link rel="stylesheet" href="../+script/style-en.css" type="text/css" />
<link rel="stylesheet" href="../+script/calendar-mos.css" type="text/css" />
<link rel="stylesheet" href="../+script/cpanel.css" type="text/css" />
<link rel="stylesheet" href="../+script/theme.css" type="text/css" />
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../+script/tabpane.css" />
</head>
<body style="margin:10px" dir="rtl">
<!-- {/if} -->
<script language="javascript" type="text/javascript">
<!--
var adminModule		= String('{$module}').replace(/-list/, '-admin');
var deleteHref		= 'index.php?section={$section}&module='+adminModule+'&cmd=delete&frm_id=';

{literal}
function doDelete(id, obj)
{
	if(confirm('Do you want to delete this record?')) {
		ajaxDelete(deleteHref+id, 'row-box', obj);
	}
}

function doFilter()
{
	var cmd = findObject('cmd');
	var url = document.location.href.replace(/&cmd=[^&]*/, '');
	if(cmd && cmd.selectedIndex > 0)
		url = url + '&cmd=' + cmd.options[cmd.selectedIndex].value;
	document.location = url;
}
{/literal}
//-->
</script>
<table cellpadding="0" cellspacing="3" width="100%">
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 4px; margin-right: 1px;">
	<tr>
		<td width="100%">
		<div class="button-ex-gray"><a title="New" href="index.php?section={$section}&module={$module|replace:'-list':'-admin'}">
		<img border="0" src="../images/icons/48x48/newen.png" width="48" height="48" alt="New" /></a></div>
		<div class="button-ex-gray" style="margin-right: 2px; width:500px; text-align:center; margin-top: 20px; height: 20px;">
		<select name="cmd" style="width: 140px;">
			<option value="inbox" {if $smarty.request.cmd eq 'inbox'}selected="selected"{/if}>Received Messages</option>
			<option value="sent" {if $smarty.request.cmd eq 'sent'}selected="selected"{/if}>Sent Messages</option>
			<option value="draft" {if $smarty.request.cmd eq 'draft'}selected="selected"{/if}>Draft</option>
		</select>							  
		<input type="button" onclick="doFilter();" value="Show" style="height: 20px; font-size: 10px; font-family:Tahoma, Verdana; width: 50px;" />
		</div>
		</td>
		<td align="center">
			<div dir="ltr" style="margin-top: 18px;">{include file="_paging.tpl"}</div>
		</td>
		</tr>
</table>
<div class="form-input" id="searchbox" style="display: {**}none; padding-right: 42px; border: 1px solid #999; margin: 4px; background-color: #FFFFEE">
{include file="_search.tpl"}
</div>
<form action="index.php?section={$section}&module={$module|replace:'-list':'-admin'}&cmd=delete&page={$page}" method="post" name="form1" id="form1">
<table border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
	<tr class="row-box-head">
{if $dataset.showcheckbox}	
	  	<td width="10" height="34"><input type="checkbox" name="allbox" onclick="checkAll(document.forms['form1'])" /></td>
{/if}
		<td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
{foreach from=$dataset.header key=key item=item}
		<td class="{$item.class}" width="{$item.width}" {$item.property}>{$item.text}</td>
{/foreach}
{if $dataset.button}
		<td style="vertical-align:middle" width="10">&nbsp;</td>
{/if}		
	</tr>
{foreach from=$dataset.result key=key item=item}
	<tr class="row-box" id="rowId{$item[$dataset.id]}">
	{if $dataset.showcheckbox}
		<td><input type="checkbox" value="{$item[$dataset.id]}" name="frm_listid[]" onClick="checkCheckedAll(document.forms['form1'])" /></td>
	{/if}
		<td>
			<img src="../images/icons/16x16/{if $item.xpriority eq 'normal'}spacer.gif{elseif $item.xpriority eq 'high'}mail-priority-high.png{else}mail-priority-low.png{/if}" width="16" height="16" alt="" border="0" align="right" />
			<img src="../images/icons/16x16/{if $item.xattachment}mail-attach.png{else}spacer.gif{/if}" width="16" height="16" alt="" border="0" align="right" />
			<img src="../images/icons/16x16/{if $item.xuserbodystatus eq 'read'}mail-read.png{else}mail-unread.png{/if}" width="16" height="16" alt="" border="0" align="right" />
		</td>
	{foreach from=$dataset.row key=key2 item=item2}		
		<td class="{$item2.class}" {$item2.property}>{eval var=$item2.text assign="result"}{$result|default:'--'}</td>
	{/foreach}
	{if $dataset.button}
		<td style="vertical-align: middle; padding: 0; border: 0; width: 10px; height: 19px;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
		{if $dataset.button.delete}				
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray" style="height: 18px; width: 18px; float: right;">
					<a title="Delete" href="javascript:void(0);" onclick="doDelete('{$item[$dataset.id]}', this);">
						<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="Delete" /></a></div></td>
		{/if}
			</tr>
		</table></td>
	{/if}	
	</tr>
{foreachelse}
	<tr>
		<td colspan="70" height="48" align="center" style="vertical-align: middle">There is no message to display. &nbsp;</td>
	</tr>	
{/foreach}
</table>
</form>
</td>
</tr>
</table>
{if $dataset.showcheckbox}	
	<div dir="ltr" style="float: right">
		<div class="button-ex-gray"><a title="Delete selected items." href="javascript:void(0)" onclick="if(checkCheckedAll(document.forms['form1'])==0) {ldelim} alert('Please select an item to delete.'); return false; {rdelim} if(confirm('Do you want to delete this messages?')) document.forms['form1'].submit()">
			<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="Delete selected items." /></a>					
		</div>
	</div>
{/if}
<div dir="ltr" align="left">
	{include file="_paging.tpl"}
<!-- {if $popup} -->
</div>
</body>
</html>
<!-- {/if} -->