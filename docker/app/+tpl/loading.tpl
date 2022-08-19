<html>
<head>
{include file="_head.tpl"}
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<script type="text/javascript" language="javascript">
{if $smarty.get.refreshparent eq 'path'}
window.opener.window.setTimeout("new Ajax('index.php?section=carrier&module=loading-admin&step=path&cmd=pathoutput&transportid={$transportid}', {ldelim} update:'path_span' , method:'get', evalScripts:true {rdelim}).request();", 100);
{/if}
</script>
</head>
<body>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="left">
				Cargo List: From {$from} To {$to}
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="30%" align="center">Commodity</td>
						<td width="25%" align="center">Carrier</td>
						<td width="25%" align="center">Vehicle</td>
						<td width="25%" align="center">Loading Date</td>
						<td width="1px">&nbsp;</td>
					</tr>
{section name=listID loop=$loadinglist}					
					<tr>
						<td width="30%" class="list-box" style="padding: 2px;">{$loadinglist[listID].xcommodity}&nbsp;</td>
						<td width="25%" class="list-box" style="padding: 2px;" {* *}nowrap>{$loadinglist[listID].xcarrier}&nbsp;</td>
						<td width="25%" class="list-box" style="padding: 2px;" {* *}nowrap>{$loadinglist[listID].xequipment}&nbsp;</td>
						<td width="25%" class="list-box" style="padding: 2px;" {* *}nowrap>{$loadinglist[listID].xloadingdate}&nbsp;</td>
						<td width="1px">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Cargo" href="index.php?section={$section}&module=loading-admin&step=loading&frm_id={$loadinglist[listID].xloadingid}&transportid={$transportid}&pathid={$pathid}&popup={$popup}">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Cargo" href="index.php?section={$section}&module=loading-admin&step=loading&frm_id={$loadinglist[listID].xloadingid}&transportid={$transportid}&pathid={$pathid}&cmd=delete&popup={$popup}">
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
	 <td colspan="7">
	 <hr style="color: #000000;"/>
	 <br />
	 <form name="form1" id="form1" method="post" action="index.php?section={$section}&module=loading-admin&step=loading&cmd={if $id}update{else}add{/if}&frm_id={$id}&transportid={$transportid}&pathid={$pathid}&popup={$popup}">
	  <table align="center" style="width: 100%">
	   <tr>
	   	<td width="20%" class="list-box" style="font-weight: 600">Rail </td>
	   	<td width="30%" class="list-box"><input id='israil'  {if $default.xisrail}checked="checked"{/if} type="checkbox" name="frm_israil" value="1" onClick="
{literal}
$('frm_carrierid').value = 33;
setSub('frm_carrierid', 'frm_equipmentid', optEquipment, 0);
$('frm_equipmentid').value = 1;
$$('.rail').each(function(el){
	if($('israil').checked)
		el.removeClass('hidden');
	else 
		el.addClass('hidden');
});
$$('.nonrail').each(function(el){
	if($('israil').checked)
		el.addClass('hidden');
	else 
		el.removeClass('hidden');
});
{/literal}		
		">
	   		Yes</td>
	   	<td width="20%" class="list-box" style="font-weight: 600">&nbsp;</td>
	   	<td width="30%" class="list-box">&nbsp;</td>
   	</tr>
	   {*<!--<tr class="rail {if !$default.xisrail}hidden{/if}">
	   	<td class="list-box" style="font-weight: 600">Wg No. </td>
	   	<td class="list-box"><input type="text" name="frm_wgno" value="{$default.xwgno}" id="frm_wgno" /></td>
	   	<td class="list-box" style="font-weight: 600">SMGS No. </td>
	   	<td class="list-box"><input type="text" name="frm_smgsno" value="{$default.xsmsgno}" id="frm_smsgno" /></td>
   	</tr>-->*}
	   <tr class="rail {if !$default.xisrail}hidden{/if}">
	   	<td class="list-box" style="font-weight: 600">Date of Rail Code </td>
	   	<td class="list-box"><input type="text" name="frm_railcodedate" value="{$default.xrailcodedate}" id="frm_railcodedate" />
			<a href="javascript:void(0)" onClick="return showCalendar('frm_railcodedate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt=" " /></a></td>
	   	<td class="list-box" style="font-weight: 600">Wg No</td>
	   	<td class="list-box"><input type="text" name="frm_wgno" value="{if $default.xequipmentcat eq 'Rail'}{$default.xequipmentno}{/if}" id="frm_wgno" /></td>
   	</tr>
	   <tr class="nonrail {if $default.xisrail}hidden{/if}">
		<td class="list-box" style="font-weight: 600">Carrier</td>
		<td class="list-box">
			<select name="frm_carrierid" id="frm_carrierid" style="width: 150px" onChange="setSub('frm_carrierid', 'frm_equipmentid', optEquipment, 0);">
{foreach from=$carrierlist key=key item=item}
	{if $item.xtruck ne $preitem}<optgroup label="{$item.xtruck}">{/if}
	{assign var=preitem value=$item.xtruck}
					<option value="{$item.xcarrierid}" {if $item.xcarrierid eq $default.xcarrierid}selected="selected"{/if}>{$item.xcarrier}</option>
{/foreach}
			</select>
			<a href="javascript:void(0)" onClick="openNewWindow('index.php?section=admin&module=carrier-admin&popup=1&object=frm_carrierid')">New Carrier</a>		</td>
		<td class="list-box" style="font-weight: 600">Vehicle</td>
		<td class="list-box">
			<select name="frm_equipmentid" id="frm_equipmentid" style="width: 150px">
				{foreach from=$equipmentlist key=key item=item}
					<option value="{$key}" {if $key eq $default.xequipmentid}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>
			<a href="javascript:void(0)" onClick="openNewWindow('index.php?section=admin&module=equipment-admin&object=frm_equipmentid&carrierid='+$('frm_carrierid').value)">New Equipment</a>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Start Date<span style="font-weight: normal; font-size: 10px">&nbsp;(&nbsp;for carrier&nbsp;)</span></td>
		<td class="list-box">
		 <input type="text" name="frm_carrierstartdate" value="{$default.xcarrierstartdate}" id="frm_carrierstartdate" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_carrierstartdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">Free Time<span style="font-weight: normal; font-size: 10px">&nbsp;(&nbsp;for carrier&nbsp;)</span></td>
		<td class="list-box">
		 <input type="text" name="frm_carrierfreetime" value="{$default.xcarrierfreetime}" id="frm_carrierfreetime" />		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Loading Date</td>
		<td class="list-box">
		 <input type="text" name="frm_loadingdate" value="{$default.xloadingdate}" id="frm_loadingdate" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_loadingdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">Penalty</td>
		<td class="list-box">
			<select name="frm_penalty" style="width: 150px">
				{foreach from=$penalty key=key item=item}
					<option value="{$key}" {if $key eq $default.xpenalty}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">ATD From Arrival Port/Border</span></td>
		<td class="list-box">
		 <input type="text" name="frm_atdarrivalport" value="{$default.xatdarrivalport}" id="frm_atdarrivalport" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_atdarrivalport', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">Receiving Arrival Notice</td>
		<td class="list-box">
		 <input type="text" name="frm_etaarrivalport" value="{$default.xetaarrivalport}" id="frm_etaarrivalport" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_etaarrivalport', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">ATD From Exit Port/Border</td>
		<td class="list-box">
		 <input type="text" name="frm_atdexitport" value="{$default.xatdexitport}" id="frm_atdexitport" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_atdexitport', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">ATA Exit Port/Border</span></td>
		<td class="list-box">
		 <input type="text" name="frm_etaexitport" value="{$default.xetaexitport}" id="frm_etaexitport" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_etaexitport', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">ATD Final Destination</td>
		<td class="list-box">
		 <input type="text" name="frm_atddestination" value="{$default.xatddestination}" id="frm_atddestination" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_atddestination', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">ATA Final Destination</span></td>
		<td class="list-box">
		 <input type="text" name="frm_etadestination" value="{$default.xetadestination}" id="frm_etadestination" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_etadestination', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Last Status</td>
		<td class="list-box" colspan="3">
		 <textarea name="frm_laststatus" style="width: 500px; height: 100px" />{$default.xlaststatus}</textarea>		</td>
	   </tr>
	   <tr>
	    <td class="list-box" colspan="6">
		 <table style="width: 50%; border: 1px solid #000000;" align="right">
		  <th style="font-size: 12px">Container List</th>
		  <tr class="row-box-head">
		   <td>Container</td>
		   <td>Weight <span style="font-size: 10px">(Kg)</span></td>
		   <td>Real Weight <span style="font-size: 10px">(Kg)</span></td>
		   <td><input type="checkbox" onClick="$$('.cntr').each(function(el){ldelim}el.checked=form1.checkAllCntr.checked{rdelim})" name="checkAllCntr"/></td>
		  </tr>
		  {section name=listID loop=$containerlist}
		  	<tr>
			 <td class="list-box">{$containerlist[listID].xcommodity|default:'&nbsp;'}</td>
			 <td class="list-box">{$containerlist[listID].xcargoweight|default:'0'}</td>
			 <td class="list-box">{assign var=x value=$containerlist[listID].xtransportcontainerid}<input type="text" name="frm_extraweight{$x}" value="{if $default.$x.containerid}{$default.$x.extraweight}{else}{$containerlist[listID].xcargoweight}{/if}" style="width: 50px" onKeyPress="document.getElementById('frm_container'+{$containerlist[listID].xtransportcontainerid}).checked='checked'" ></td>
			 <td class="list-box" align="center">
			  {assign var=x value=$containerlist[listID].xtransportcontainerid}
			  <input type="checkbox" name="frm_container[]" id="frm_container{$containerlist[listID].xtransportcontainerid}" value="{$containerlist[listID].xtransportcontainerid}" class="cntr" {if $default.$x.containerid}checked="checked"{/if}/></td>
			</tr>
		  {sectionelse}
		  	<tr><td colspan="6">There is not any unloaded container.</td></tr>
		  {/section}
		 </table>
		 <table style="width: 50%; border: 1px solid #000000;" align="left">
		  <th style="font-size: 12px;">Bulk List</th>
		  <tr class="row-box-head">
		   <td>Commodity</td>
		   <td nowrap="nowrap">Wheight <span style="font-size: 10px">(Kg)</span></td>
		   <td><input type="checkbox" onClick="$$('.blk').each(function(el){ldelim}el.checked=form1.checkAllBlk.checked{rdelim})"  name="checkAllBlk" /></td>
		  </tr>
		  {section name=listID loop=$bulklist}
		  	<tr>
			 <td class="list-box">{$bulklist[listID].xcommodity|default:'&nbsp;'}</td>
			 <td class="list-box" nowrap="nowrap">{assign var=x value=$bulklist[listID].xtransportcontainerid}<input type="text" name="frm_weight{$x}" value="{if $default.$x.containerid}{$default.$x.weight}{else}{$bulklist[listID].xunloadedcargoweight}{/if}" style="width: 50px; float: left;" onKeyPress="document.getElementById('frm_bulk'+{$bulklist[listID].xtransportcontainerid}).checked='checked'" onKeyUp="if(!this.value.match(/^[0-9,.]+$/))this.value=''; {if $default.$x.containerid}if(this.value>{$default.$x.weight+$bulklist[listID].xunloadedcargoweight})this.value={$default.$x.weight+$bulklist[listID].xunloadedcargoweight}{else}if(this.value>{$bulklist[listID].xunloadedcargoweight})this.value={$bulklist[listID].xunloadedcargoweight}{/if}"/>
			  <span style="font-size: 10px; vertical-align: middle">&nbsp;(&nbsp;total: {$bulklist[listID].xcargoweight}&nbsp;)&nbsp;</span>
			  <span style="font-size: 10px; vertical-align: middle">(&nbsp;Real Weight: <input type="text" name="frm_extraweight{$x}" value="{if $default.$x.extraweight}{$default.$x.extraweight}{else}{$bulklist[listID].xcargoweight}{/if}" style="width: 50px; height: 15px; font-size: 10px; vertical-align: middle" onKeyPress="document.getElementById('frm_bulk'+{$bulklist[listID].xtransportcontainerid}).checked='checked'" />&nbsp;)</span>			 </td>
			 <td class="list-box" align="center"><input type="checkbox" name="frm_bulk[]" id="frm_bulk{$bulklist[listID].xtransportcontainerid}" value="{$bulklist[listID].xtransportcontainerid}" class="blk" {if $default.$x.containerid}checked="checked"{/if}/></td>
			</tr>
		  {sectionelse}
		  	<tr><td colspan="6">There is not any unloaded bulk.</td></tr>
		  {/section}
		 </table>		</td>
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
setSub('frm_carrierid', 'frm_equipmentid', optEquipment, 0, {if $default.xequipmentid}{$default.xequipmentid}{else}null{/if});
</script>
</body>
</html>


