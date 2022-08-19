<!-- {if $popup} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
{include file="_head.tpl"}
</head>
<body style="margin:10px;">
{if $object}
<script language="javascript" type="text/javascript">
<!--
	{if $newcustomer.xcustomerid}
		window.opener.window.setTimeout('idx=$("{$object}").options.length; $("frm_shipperid").options[idx] = new Option("{$newcustomer.xname} {$newcustomer.xfamily}", "{$newcustomer.xcustomerid}"); $("frm_consigneeid").options[idx] = new Option("{$newcustomer.xname} {$newcustomer.xfamily}", "{$newcustomer.xcustomerid}"); $("{$object}").selectedIndex = idx;', 100);
	{elseif $newoffice.xofficeid}
		window.opener.window.setTimeout('idx=$("{$object}").options.length; $("frm_senderofficeid").options[idx] = new Option("{$newoffice.xoffice}", "{$newoffice.xofficeid}"); $("frm_receiverofficeid").options[idx] = new Option("{$newoffice.xoffice}", "{$newoffice.xofficeid}"); $("{$object}").selectedIndex = idx;', 100);
	{elseif $newcarrier.xcarrierid}
		window.opener.window.setTimeout('idx=$("{$object}").options.length; $("frm_carrierid").options[idx] = new Option("{$newcarrier.xcarrier}", "{$newcarrier.xcarrierid}"); $("{$object}").selectedIndex = idx;', 100);
	{elseif $newequipment.xequipmentid}
		//optEquipment[{$newequipment.xcarrierid}][optEquipment[{$newequipment.xcarrierid}].length-1] = "{$newequipment.xequipmentid}*:-){$newequipment.xequipment}";
		if(window.opener.$('frm_carrierid').value == {$newequipment.xcarrierid})
			{ldelim}
				window.opener.window.setTimeout('idx=$("{$object}").options.length; $("frm_equipmentid").options[idx] = new Option("{$newequipment.xequipment}", "{$newequipment.xequipmentid}"); $("{$object}").selectedIndex = idx;', 100);
			{rdelim}
	{/if}	
	window.close();
-->
</script>
<div align="center" style="padding:50px;">
	<input type="button" value=" Exit " onclick="window.close();" />
</div>
{/if}
<script type="text/javascript">
{if $smarty.get.refreshparent eq 'doc'}
	window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=transport-admin&step=document&cmd=docoutput&transportid={$transportid}', {ldelim} update:'doc_span' , method:'get', evalScripts:true {rdelim}).request();", 100);
{else}
	{if $smarty.get.refreshparent eq 'cargo'}
		window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=transport-admin&step=document&cmd=cargooutput&transportid={$transportid}', {ldelim} update:'cargo_span' , method:'get', evalScripts:true {rdelim}).request();", 100);
	{else}
		{if $smarty.get.refreshparent eq 'equipment'}
			window.opener.window.setTimeout("new Ajax('index.php?section=admin&module=carrier-admin&step=equipment&cmd=equipmentoutput&carrierid={$carrierid}', {ldelim} update:'equipment_span' , method:'get', evalScripts:true {rdelim}).request();", 100);
		{/if}
	{/if}
{/if}
</script>

<div dir="ltr">
<!-- {/if} -->
<script language="javascript" type="text/javascript">
<!--
var newHref = 'index.php?section={$section}&module={$module}&step={$step}&transportid={$transportid}&containerid={$containerid}&popup={$popup}&carrytype={$carrytype}';
{literal}
function getRowNumber(obj) // return row number of an object in admin rows 
{
	obj = findObject(obj);
	if(typeof(obj)=='object'){
		var p = obj;
		while(p = p.parentNode){
			if(p.id && p.id.match(/adminRow_.+/ig)) {
				return p.id.replace(/adminRow_/ig, '');
			}	
		}
	}	
	return false;
}

function doNew(){
	document.location = newHref;
}
{/literal}
//-->
</script>
<form {$formData.attributes}>
{$formData.hidden}
<table border="0" cellpadding="0" cellspacing="3" width="100%" name="uuu">
	<tr>
		<td>
		<table border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF" dir="ltr">
{capture name=buttons}
	<tr>
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td nowrap class="list-box">
		{*if !$dataset.hidenew}		
				<div class="button-ex-gray" style="margin: 3px;"><a title="New" href="javascript:doNew()">
				<img border="0" src="../images/icons/48x48/newen.png" width="48" height="48" alt="New" /></a></div>
		{/if*}				
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
{foreach from=$formData key=key item=item}	
{if $item.type eq 'text' or $item.type eq 'textarea' or $item.type eq 'radio' or $item.type eq 'checkbox' or $item.type eq 'select' or $item.type eq 'group' or $item.type eq 'file' or $item.type eq 'image' or $item.type eq 'password' or $item.type eq 'link' or $item.type eq 'static'}
  {if $item.type eq 'static' and $item.label eq '[tpl]'}
	<tr id="adminRow_{counter name=adminRow}">
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap></td>
		<td class="list-box" width="90%" dir="ltr"><div class="form-input">{include file=$item.html}</div></td>
	</tr>	
  {else}	 
	<tr id="adminRow_{counter name=adminRow}">
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap><div class="form-title">{$item.label}&nbsp;</div></td>
		<td class="list-box" width="90%" dir="ltr"><div class="form-input">{$item.html}</div></td>
	</tr>
  {/if}	
{/if}	
{/foreach}
{$smarty.capture.buttons}
	</table>
		</td>
{if !$popup}		
		<td width="319px" class="list-box" style="background-color: #fff; padding: 3px;" valign="top" align="center">&nbsp;
{foreach name=ext from=$extModule key=key item=item}
	{include file=$item}
	{if !$smarty.foreach.ext.last}
		<hr style="color: #000000"/>
	{/if}
{/foreach}
	  </td>
{/if}	
	</tr>
</table>
<input type="submit" style="display: none;" />
</form>	
<script  language="javascript" type="text/javascript">
{if $smarty.get.popupwin}
openNewWindow("index.php?section={$section}&module={$module}&step={$smarty.get.popupwin}&transportid={$id}&carrierid={$id}&popup=1", 500, 520);
{/if}
{if $smarty.get.loadformvalues}
loadForm('form1', '{$section}/{$module}/{$step}/{$carrytype}');
{/if}
</script>

<!-- {if $popup} -->
</div>
<script language="javascript" type="text/javascript">
{foreach from=$P.js item=item}
//--------
{$item};
//--------
{/foreach}
</script>
</body>
</html>
<!-- {/if} -->
