<!-- {if $popup} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
{include file="_head.tpl"}
</head>
<body style="margin:10px;">

<div dir="ltr">
<!-- {/if} -->
<script language="javascript" type="text/javascript">
<!--
var newHref = 'index.php?section={$section}&module={$module}&step={$step}&transportid={$transportid}&containerid={$containerid}&popup={$popup}&carrytype={$carrytype}';
{literal}
function doNew(){
	document.location = newHref;
}
{/literal}
{if $smarty.get.refreshparent eq 'cargo'}
window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=transport-admin&step=document&cmd=cargooutput&transportid={$transportid}', {ldelim} update:'cargo_span' , method:'get', evalScripts:true {rdelim}).request();", 100);
{/if}
//-->
</script>
<form name="form1" id="form1" method="post" action="index.php?section={$section}&module=transport-admin&page={$page}&step=cargo&cmd={if $id}update{else}add{/if}&frm_id={$id}&transportid={$transportid}&popup={$popup}&carrytype=Container">
<table border="0" cellpadding="0" cellspacing="3" width="100%" name="uuu">
	<tr>
		<td>
		<table border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF" dir="ltr">
{capture name=buttons}
	<tr>
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td nowrap class="list-box">
		</td>
		<td width="90%" class="list-box" style="padding-bottom: 3px;">	
<!-- {if $btnModule} -->
{include file=$btnModule}
<!-- {else} -->			
<!-- {/if} -->
			</td>
	</tr>
{/capture}
{$smarty.capture.buttons}	
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Carrying Type</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_carrytype" onchange="var href=document.location.href; document.location.href=(href.indexOf('carrytype')!='-1'?href.substr(0, href.indexOf('carrytype'))+href.substr(href.indexOf('carrytype')+20, href.length):href)+'&carrytype=Bulk'">
				{foreach from=$carryingtype key=key item=item}
					<option value="{$key}" {if $key eq $default.xcarrytype}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>
	</div></td>
</tr>
<tr id="containerCombo" style="display: table-row">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Container</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_containerid" id="frm_containerid">
				{foreach from=$container key=key item=item}
					<option value="{$key}" {if $key eq $default.xcontainerid}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>&nbsp;<a href="#" onclick="$$('.newContainerItem').each(function(el){ldelim}el.style.display='table-row';{rdelim}); $('containerCombo').style.display='none'; $('frm_containerid').disabled='disabled'; ">New Container</a>
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;</td>
	<td class="list-box" nowrap><div class="form-title">&nbsp;</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		<a href="#" onclick="$$('.newContainerItem').each(function(el){ldelim}el.style.display='none';{rdelim}); $('containerCombo').style.display='table-row'; $('frm_containerid').disabled=false;"/>Container List</a>
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Container No</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		<input type="text" name="frm_containernumber" value="{$default.xcontainernumber}" />
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Container Type</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_containertypeid">
				{foreach from=$containertype key=key item=item}
					<option value="{$key}" {if $key eq $default.xcontainertypeid}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Container Size</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_containersizeid">
				{foreach from=$containersize key=key item=item}
					<option value="{$key}" {if $key eq $default.xcontainersize}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Type</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_own" onchange='if(this.options[selectedIndex].innerHTML == "COC")$("ownerRow").style.display="table-row";else $("ownerRow").style.display="none";'>
				{foreach from=$own key=key item=item}
					<option value="{$key}" {if $key eq $default.xown}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>
	</div></td>
</tr>
<tr id="ownerRow" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Owner</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">


			<select name="frm_carrierid" style="display: none">
				{foreach from=$carrier key=key item=item}
					<option value="{$key}" {if $key eq $default.xcarrierid}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>
			<input type="text" name="frm_carrier" />
			<a href="#" onclick="form1.frm_carrierid.disabled=false; form1.frm_carrier.disabled=false; if(form1.frm_carrierid.style.display == 'none'){ldelim} this.innerHTML = 'A Person'; form1.frm_carrierid.style.display = 'inline'; form1.frm_carrier.disabled='disabled'; form1.frm_carrier.style.display='none';{rdelim}else{ldelim} this.innerHTML = 'A Company'; form1.frm_carrierid.disabled='disabled'; form1.frm_carrierid.style.display = 'none'; form1.frm_carrier.style.display='inline'; {rdelim}">A Company</a>
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Start Date <br /><span style="font-weight: normal; font-size: 10px">(&nbsp;for shipping&nbsp;)</span></div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		 <input type="text" name="frm_shippingstartdate" value="{$default.xshippingstartdate}" id="frm_shippingstartdate" />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_shippingstartdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Free Time <br /><span style="font-weight: normal; font-size: 10px">(&nbsp;for shipping&nbsp;)</span></div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		 <input type="text" name="frm_shippingfreetime" value="{$default.xshippingfreetime}" id="frm_shippingfreetime" />
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Start Date <br /><span style="font-weight: normal; font-size: 10px">(&nbsp;for customer&nbsp;)</span></div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		 <input type="text" name="frm_customerstartdate" value="{$default.xcustomerstartdate}" id="frm_customerstartdate" />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_customerstartdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Free Time <br /><span style="font-weight: normal; font-size: 10px">(&nbsp;for customer&nbsp;)</span></div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		 <input type="text" name="frm_customerfreetime" value="{$default.xcustomerfreetime}" id="frm_customerfreetime" />
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">&nbsp;</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		<a href="#" onclick="form1.action=form1.action+'&addcontainercargo=1'; form1.submit();">{if $id}View Cargo{else}Add Cargo{/if}</a>
	</div></td>
</tr>
{$smarty.capture.buttons}
	</table>
		</td>
	</tr>
</table>
<input type="submit" style="display: none;" />
</form>	
<script  language="javascript" type="text/javascript">
{if $smarty.get.loadformvalues}
loadForm('form1', '{$section}/{$module}/{$step}/{$carrytype}');
{/if}
</script>

<!-- {if $popup} -->
</div>
</body>
</html>
<!-- {/if} -->