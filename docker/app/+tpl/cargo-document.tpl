{include file="_head.tpl"}
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<script type="text/javascript" language="javascript">
{if $smarty.get.refreshparent eq 'doc'}
window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=cargodocument-admin&cmd=docoutput&transportid={$transportid}', {ldelim} update:'doc_span' , method:'get', evalScripts:true {rdelim}).request();", 100);
{/if}
</script>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="left">
				Document List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="30%" align="center">Document</td>
						<td width="30%" align="center">Carrier</td>
						<td width="30%" align="center">Path</td>
						<td width="16">&nbsp;</td>
					</tr>
{section name=listID loop=$documentlist}					
					<tr>
						<td width="30%" class="list-box" style="padding: 2px;">{$documentlist[listID].xdocument2}&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{$documentlist[listID].xcarrier|default:'Rah Ahan'}</td>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{$documentlist[listID].xpath}&nbsp;</td>
						<td width="1%">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Document" href="index.php?section={$section}&module=cargodocument-admin&frm_id={$documentlist[listID].xloadingdocumentid}&transportid={$transportid}&popup={$popup}">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Document" href="index.php?section={$section}&module=cargodocument-admin&frm_id={$documentlist[listID].xloadingdocumentid}&transportid={$transportid}&cmd=delete&popup={$popup}">
									<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="" /></a></div></td>
							</tr>
						</table>
						</td>
					</tr>
{sectionelse}
	<tr>
		<td colspan="6" height="16" align="center">There is no record to display.</td>
	</tr>	
{/section}	
	<tr>
	 <td colspan="6">
	 <hr style="color: #000000"/>
	 <br />
	 <form name="form1" id="form1" method="post" action="index.php?section={$section}&module=cargodocument-admin&cmd={if $id}update{else}add{/if}&frm_id={$id}&transportid={$transportid}&popup={$popup}" enctype="multipart/form-data">
	  <table align="center" style="width: 100%">
	   <tr>
		<td class="list-box" style="font-weight: 600">Document</td>
		<td class="list-box">
			<select name="frm_document2id" style="width: 150px" onchange="
{literal}
var israil = this.value==4;
$('frm_carrierid').value = 33;
setSub('frm_carrierid', 'frm_loadingid', optPathEquipment, 0);
$$('.rail').each(function(el){
	if(israil)
		el.removeClass('hidden');
	else 
		el.addClass('hidden');
});
$$('.nonrail').each(function(el){
	if(israil)
		el.addClass('hidden');
	else 
		el.removeClass('hidden');
});
{/literal}				
			">
				{foreach from=$documents key=key item=item}
					<option value="{$key}" {if $key eq $default.xdocument2id}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>		</td>
		<td class="list-box" style="font-weight: 600" nowrap="nowrap">Document No.</td>
		<td class="list-box"><input type="text" name="frm_documentno" value="{$default.xdocumentno}" /></td>
	   </tr>
	   <tr>
		<td class="list-box nonrail {if $default.xdocument2id eq 4}hidden{/if}" style="font-weight: 600">Carrier</td>
		<td class="list-box nonrail {if $default.xdocument2id eq 4}hidden{/if}">
			<select id="frm_carrierid" name="frm_carrierid" style="width: 150px" onchange="setSub('frm_carrierid', 'frm_loadingid', optPathEquipment, 0);">
{foreach from=$carrierlist key=key item=item}
	{if $item.xtruck ne $preitem}<optgroup label="{$item.xtruck}">{/if}
	{assign var=preitem value=$item.xtruck}
					<option value="{$item.xcarrierid}" {if $item.xcarrierid eq $default.xcarrierid}selected="selected"{/if}>{$item.xcarrier}</option>
{/foreach}
			</select>		</td>
		<td class="list-box" style="font-weight: 600">Vehicle</td>
		<td class="list-box">
			<select id="frm_loadingid" name="frm_loadingid" style="width: 250px">
				{foreach from=$equipmentlist key=key item=item}
					<option value="{$key}" {if $key eq $default.xequipmentid}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>		</td>
	   </tr>
<!--	   <tr class="rail {if $default.xdocument2id ne 4}hidden{/if}">
	   	<td class="list-box" style="font-weight: 600">Wg No. </td>
	   	<td width="30%" class="list-box"><input type="text" name="frm_wgno" value="{$default.xwgno}" id="frm_wgno" /></td>
	   	<td width="20%" class="list-box" style="font-weight: 600">SMGS No. </td>
	   	<td width="30%" class="list-box"><input type="text" name="frm_smgsno" value="{$default.xsmgsno}" id="frm_smgsno" /></td>
   	</tr>
	   <tr class="rail {if $default.xdocument2id ne 4}hidden{/if}">
	     <td class="list-box" style="font-weight: 600">Path</td>
	     <td class="list-box">
			<select id="frm_documenttransportpathid" name="frm_documenttransportpathid" style="width: 150px" >
{*{foreach from=$pathlist key=key item=item} *}
					<option value="{$item.xtransportpathid}" {if $item.xtransportpathid eq $default.xdocumenttransportpathid}selected="selected"{/if}>{$item.xfrom} to {$item.xto}</option>
{*{/foreach}*}
			</select></td>
	     <td class="list-box" style="font-weight: 600">&nbsp;</td>
	     <td class="list-box">&nbsp;</td>
	     </tr>-->
	   <tr>
	   	<td class="list-box" style="font-weight: 600">Send Date</td>
	   	<td class="list-box"> <input type="text" name="frm_documentdate" id="frm_documentdate" value="{$default.xdocumentdate}" />
		 <a href="javascript:void(0);" onclick="return showCalendar('frm_documentdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		 </td>
	   	<td class="list-box" style="font-weight: 600">Receive Date</td>
		<td class="list-box"><input type="text" name="frm_documentdate2" id="frm_documentdate2" value="{$default.xdocumentdate2}" />
	   		<a href="javascript:void(0);" onclick="return showCalendar('frm_documentdate2', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" />		</td>
   	</tr>
	   <tr>
		<td rowspan="2" class="list-box" style="font-weight: 600">Comment</td>
		<td rowspan="2" class="list-box">
				<textarea name="frm_documentcomment" >{$default.xdocumentcomment}</textarea>		</td>
		<td class="list-box" style="font-weight: 600">Image</td>
		<td class="list-box">
			<table id="image_tbl">
				<tr><td><input type="file" name="frm_img[]" /></td></tr>
				<tr><td><a href="javascript:addrow()">More Images</a></td></tr>
			</table>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" colspan="2" align="center">
		 {if $id && $default.img}
		 	<table><tr>
		 	{foreach from=$default.img key=key item=item}
				<td>
					{if $item.ext neq 'pdf'}
						<img style="cursor: pointer" src="showpic.php?w=80&mh=80&module=cargodocument&pic={$item.xloadingdocumentimgid}&folder={$id}" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=cargodocument&pic={$item.xloadingdocumentimgid}&folder={$id}', 640, 480, 'noscroll'); return false;"  />
					{else}
						<a href="download.php?module=loadingdocument&id={$item.xloadingdocumentimgid}&dir=document2&folder={$id}"><img src="../images/symbol-pdf.gif" style="border: 0px" /></a>
					{/if}
				   <br />	   
				   <a href="index.php?section={$section}&module=cargodocument-admin&cmd=del_img&frm_id={$item.xloadingdocumentimgid}&folder={$id}&transportid={$transportid}&popup={$popup}">Delete</a>
				 </td>
			{/foreach}
			</tr></table>
			
		 {/if}		</td>
	   </tr>
	   <tr>
		<td width="90%" class="list-box" style="padding-bottom: 3px;" colspan="6">	
<!-- {if $btnModule} -->
{include file=$btnModule}
<!-- {else} -->			
<!-- {/if} -->			</td>
	   </tr>
	  </table>
	  </form>
	 </td>
	 
	</tr>
</table>
			</div>
</div>
<script type="text/javascript">
setSub('frm_carrierid', 'frm_loadingid', optPathEquipment, 0, {if $default.xloadingid}{$default.xloadingid}{else}null{/if});
</script>

{literal}
<Script Language="JavaScript">

function addrow(){
	var tbl = document.getElementById('image_tbl');
	var lastrow = tbl.rows.length - 1;
	var row = tbl.insertRow(lastrow);

	var cell0 = row.insertCell(0);
	var el = document.createElement('input');
	el.type = 'file';
	el.name = 'frm_img[]';
	
	cell0.appendChild(el);
}
</Script>
{/literal}

