<!-- {if $popup} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
{include file="_head.tpl"}
</head>
<body style="margin:10px" dir="rtl">
<!-- {/if} -->
<script language="javascript" type="text/javascript">
<!--
var adminModule		= String('{$module}').replace(/\-list/ig, '-admin');
var editHref		= 'index.php?section={$section}&module='+adminModule+'&page={$page}&step={$smarty.request.step}&filter={$smarty.request.filter}&query={$smarty.request.query}&frm_id=';
var deleteHref		= 'index.php?section={$section}&module='+adminModule+'&step={$smarty.request.step}&cmd=delete&page={$page}&transportid={$smarty.request.transportid}&companycontainer={$smarty.get.companycontainer}&frm_id=';
var newHref			= 'index.php?section={$section}&module='+adminModule+'&step={$smarty.request.step}&filter={$smarty.request.filter}&query={$smarty.request.query}&transportid={$smarty.request.transportid}&popup={$smarty.request.popup}&companycontainer={$smarty.get.companycontainer}';
{literal}
function doEdit(id)
{
	document.location.href = editHref+id;
}

function doDelete(id, obj)
{
	if(confirm('Do you want to delete this record?')) {
		ajaxDelete(deleteHref+id, 'row-box', obj);
	}
}

function doNew()
{
	document.location = newHref;
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
{if !$dataset.hidenew}		
		<div class="button-ex-gray"><a title="New" href="javascript:doNew()">
		<img border="0" src="../images/icons/48x48/newen.png" width="48" height="48" alt="New" /></a></div>
{/if}		
{if !$hideSearchButton}
		<div class="button-ex-gray" style="margin-right: 2px;"><a title="Search" href="javascript:swapDisplay('searchbox');">
		<img border="0" src="../images/icons/48x48/searchen.png" width="48" height="48" alt="Search" /></a></div>
		<div class="button-ex-gray" style="margin-right: 2px;"><a title="Show All" href="{$href|regex_replace:'/&amp;query=[^&]*/':''}">
		<img border="0" src="../images/icons/48x48/showallen.png" width="48" height="48" alt="Show all records" /></a></div>	
{/if}
		</td>
		<td align="center">
			<div dir="ltr" style="margin-top: 18px;">{include file="_paging.tpl"}</div>
		</td>
		</tr>
</table>
<div id="searchbox" style="display: {**}none;">
	<form action="{$href}" method="post" name="searchform" id="searchform">
{include file="_list-search.tpl"}
	</form>
</div>
<form action="index.php?section={$section}&amp;module={$module|replace:'-list':'-admin'}&amp;cmd=delete&amp;page={$cpage_num}&amp;step={$smarty.get.step}" method="post" name="form1" id="form1">
<table border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
	<tr class="row-box-head">
{if $dataset.showcheckbox}	
	  	<td width="10" height="34"><input type="checkbox" name="allbox" onclick="checkAll(document.forms['form1'])" /></td>

	  	{/if}
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
		<td><input type="checkbox" value="{$item[$dataset.id]}" name="frm_id[]" onClick="checkCheckedAll(document.forms['form1'])" /></td>
	{/if}	
	{foreach from=$dataset.row key=key2 item=item2}		
		<td class="{$item2.class}" {$item2.property}>{eval var=$item2.text assign="result"}{if $result}{$result}{else}&nbsp;{/if}</td>
	{/foreach}
	{if $dataset.button}
		<td style="vertical-align: middle; padding: 0; border: 0; width: 10px; height: 51px;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
{if $module neq 'transport-list'}
			<tr>
		{if $dataset.button.view}				
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray" style="float: right;">
					<a title="View" target="_blank" href="index.php?section={$section}&module={$module|replace:'-list':'-admin'}&cmd=favorresult&frm_id={$item[$dataset.id]}">
						<img border="0" src="../images/icons/48x48/view.png" width="48" height="48" alt="View" /></a></div></td>
		{/if}
		{if $dataset.button.edit}				
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray" style="float: right;">
					<a title="Edit" href="index.php?section={$section}&module={$module|replace:'-list':'-admin'}&page={$page}&step={$smarty.request.step}&filter={$smarty.request.filter}&query={$smarty.request.query}&frm_id={$item[$dataset.id]}&transportid={$smarty.request.transportid}&popup={$smarty.request.popup}&archive={$smarty.request.archive}&companycontainer={$smarty.get.companycontainer}">
						<img border="0" src="../images/icons/48x48/edit.png" width="48" height="48" alt="Edit" /></a></div></td>
		{/if}
		{if $dataset.button.delete}				
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray" style="float: right;">
					<a title="Delete" href="javascript:void(0);" onclick="doDelete('{$item[$dataset.id]}', this);">
						<img border="0" src="../images/icons/48x48/delete.png" width="48" height="48" alt="Delete" /></a></div></td>
		{/if}
			</tr>
{else}
			<tr>				
			{assign var=tr value='tr'|cat:$item[$dataset.id]}
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray2" style="float: right;">
					<a title="Edit" href="index.php?section=operation&module=transport-admin&page={$page}&step={$smarty.request.step}&query={$smarty.request.query}&frm_id={$item[$dataset.id]}&transportid={$smarty.request.transportid}">
						<img border="0" src="../images/icons/32x32/edit.png" width="32" height="32" alt="Edit" /></a></div></td>

				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray2" style="float: right;">
					<a title="Delete" href="javascript: void(0)" onclick="if(confirm('Do you want to delete this record?')){ldelim} ajaxDelete('index.php?section=operation&module=transport-admin&step={$smarty.request.step}&cmd=delete&page={$page}&transportid={$smarty.request.transportid}&frm_id={$item[$dataset.id]}', 'row-box', this);{rdelim}">
						<img border="0" src="../images/icons/32x32/delete.png" width="32" height="32" alt="Delete" /></a></div></td>

			</tr>
			<tr>
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="{if $finished.container.$tr eq 1}button-ex-green{else}button-ex-gray2{/if}" style="float: right;">
					<a title="Containers" href="#" onclick="openNewWindow('index.php?section=admin&module=container-status&frm_id={$item[$dataset.id]}&popup=1', 1000, 500)">
						<img border="0" src="../images/icons/32x32/container.png" width="32" height="32" alt="Containers" /></a></div></td>

				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="{if $finished.operation.$tr eq 1}button-ex-green{else}button-ex-gray2{/if}" style="float: right;">
					<a title="Operations" href="index.php?section=operation&module=operation-admin&frm_id={$item[$dataset.id]}">
						<img border="0" src="../images/icons/32x32/operation.png" width="32" height="32" alt="Operations" /></a></div></td>
			</tr>
		<tr>
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="{if $finished.customs.$tr eq 1}button-ex-green{else}button-ex-gray2{/if}" style="float: right;">
					<a title="Customs" href="#" onclick="openNewWindow('index.php?section=account&module=customs-admin&transportid={$item[$dataset.id]}&popup=1', 800, 600)">
						<img border="0" src="../images/icons/32x32/customs.png" width="32" height="32" alt="Customs" /></a></div></td>

				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="{if $finished.accounting.$tr eq 1}button-ex-green{else}button-ex-gray2{/if}" style="float: right;">
					<a title="Accounting" href="#" onclick="openNewWindow('index.php?section=account&module=account-list&transportid={$item[$dataset.id]}&popup=1', 750, 500)">
						<img border="0" src="../images/icons/32x32/accounting.png" width="32" height="32" alt="Accounting" /></a></div></td>

			</tr>	
		<tr>
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="{if $finished.cargodocument.$tr eq 1 && $finished.documentation.$tr eq 1}button-ex-green{else}button-ex-gray2{/if}" style="float: right;">
					<a title="Cargo Documents" href="index.php?section=operation&module=transport-admin&page={$page}&step={$smarty.request.step}&query={$smarty.request.query}&frm_id={$item[$dataset.id]}&transportid={$smarty.request.transportid}">
						<img border="0" src="../images/icons/32x32/cargo-docs.png" width="32" height="32" alt="Cargo Documents" /></a></div></td>

				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="{if $finished.transportdocument.$tr eq 1}button-ex-green{else}button-ex-gray2{/if}" style="float: right;">
					<a title="Transport Documents" href="index.php?section=operation&module=operation-admin&frm_id={$item[$dataset.id]}">
						<img border="0" src="../images/icons/32x32/transport-docs.png" width="32" height="32" alt="Transport Documents" /></a></div></td>
			</tr>	

{/if}
		</table></td>
	{/if}	
	</tr>
{foreachelse}
	<tr>
		<td colspan="70" height="48" align="center" style="vertical-align: middle">There is no record to display. &nbsp;</td>
	</tr>	
{/foreach}
{if $module eq 'account-list'}
<tr>
	<td></td><td></td><td></td>
	<td style="height: 20px; vertical-align: middle"><span style="color:#000033">Sum:</span>&nbsp;{$amount}</td>
</tr>	
{/if}
</table>
</form>
</td>
</tr>
</table>
{if $dataset.showcheckbox}	
	<div dir="ltr" style="float: left">
		<div class="button-ex-gray"><a title="Delete Selected Items" href="javascript:void(0)" onclick="if(checkCheckedAll(document.forms['form1'])==0) {ldelim} msg.info('Please select an item to delete.'); return false; {rdelim} if(confirm('Do you want to delete this records?')) document.forms['form1'].submit()">
			<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="Delete Selected Items" /></a>					
		</div>
	</div>
{/if}
<div dir="ltr" align="right">
	{include file="_paging.tpl"}

{if $module eq 'account-list'}
<div align="center">
<span  id="finished_div" style="margin: 4px; width: 16px;"></span>
<input type="button" id="accounting_finished" value="{if $accountingfinished eq 1}Accountings Closed{else}Accountings Not Closed{/if}" class="{if $accountingfinished eq 1}btn-finished{else}btn-notfinished{/if}" onclick="new ajax('index.php?section=operation&module=transport-admin&step=finished&cmd=accounting&transportid={$transportid}', {ldelim}update: 'finished_div', evalScripts: true{rdelim}).request();" /></div>
{/if}

<!-- {if $popup} -->
</div>
</body>
</html>
<!-- {/if} -->