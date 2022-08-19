{include file="_head.tpl"}
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<div class="main-title1">
Project No: {$transportcode}
</div>
<div class="main-title2">
Customs Section
</div> 
{assign var=g value="account&customs"}
{if $user->group.$g || $user->group.admin}
<div align="center">
<span  id="finished_div" style="margin: 4px; width: 16px;"></span>
<input type="button" id="customs_finished" value="{if $default.xcustomsfinished eq 1}Customs Closed{else}Customs Not Closed{/if}" class="{if $default.xcustomsfinished eq 1}btn-finished{else}btn-notfinished{/if}" onclick="new ajax('index.php?section=operation&module=transport-admin&step=finished&cmd=customs&transportid={$transportid}', {ldelim}update: 'finished_div', evalScripts: true{rdelim}).request();" /></div>
{/if}
<br>
<div>
<div>
<form name="form1" id="form1" method="post" action="index.php?section={$section}&module=customs-admin&page={$page}&cmd=update&transportid={$transportid}&popup={$popup}" enctype="multipart/form-data">
<table border="0" cellpadding="0" width="100%">
{section name=listID loop=$list}
	<tr  class="list_row">
		<td class="list-box">		
			<div class="list-title" onmouseover="this.className='list-title-over'" onmouseout="this.className='list-title'" onclick="swapView('{$list[listID].xloadingid}')">					
{if $list[listID].load}
					<a href="javascript:void(0);" style="float: left; margin: 4px;"><img src="../images/btn-more.png" id="icon{$list[listID].xloadingid}" width="24" height="24" border="0" alt="" /></a>
{else}
					<div style="display: inline; float: left; margin: 4px; width: 24px; height: 24px;"></div>
{/if}
					<a href="javascript:void(0);" onclick=" swapView('{$list[listID].xloadingid}'); showDetail('carrier', 'loading-equipment', '{$list[listID].xloadingid}', this)" style="margin-top: 8px; float{**}: left;">{$list[listID].xequipment} : {$list[listID].xfromcity}- {$list[listID].xtocity}</a>
			</div>
			<div id="sub{$list[listID].xloadingid}" class="{**}list-sub">
{if $list[listID].load}				
					<table border="0" cellpadding="2" cellspacing="0" width="100%">
						<tr class="row-box-head">
							<td width="40%">
						<b>Commodity</b></td>
							<td width="20%">
						<b>Weight <span style="font-size: 10px">( Kg )</span></b></td>
							<td width="20%">
						<b>Extra Weight <span style="font-size: 10px">( Kg )</span></b></td>
						</tr>
{foreach from=$list[listID].load key=key item=item}			
						<tr bgcolor="{cycle values='#F7FAEE,#F1F7FE'}" style="height: 32px;" class="transport_row">
							<td dir="ltr" align="left">{$item.xcommodity}</td>
							<td dir="ltr" align="left">{$item.xweight}&nbsp;{if $item.xcarrytype eq 'Bulk'}<span style="font-size: 10px">( total: {$item.xcargoweight} ){/if}</td>
							<td dir="ltr" align="left"><input type="text" name="frm_extraweight{$item.xloadingcontainerid}" value="{$item.xextraweight}" style="width: 100px" /></td>
						</tr>
{/foreach}
					</table>
{/if}						
			</div>		
		</td>
	</tr>
{/section}
	<tr>
	 <td colspan="7">
	 <hr style="color: #000000;"/>
	 <br />
	  <table align="center" style="width: 100%">
	   <tr>
		<td class="list-box" style="font-weight: 600">Transit License No</td>
		<td class="list-box">
			<input type="text" name="frm_tlno" value="{$default.xtlno}" />
		</td>
		<td class="list-box" style="font-weight: 600">Transit License Date</td>
		<td class="list-box">
		 <input type="text" name="frm_tldate" value="{$default.xtldate}" id="frm_tldate" />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_tldate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Border Row  No</td>
		<td class="list-box">
		 <input type="text" name="frm_cotazhno" value="{$default.xcotazhno}" />
		</td>
		<td class="list-box" style="font-weight: 600">Bonds No</td>
		<td class="list-box">
		 <textarea name="frm_insuranceno"/>{$default.xinsuranceno}</textarea>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Declaration Date</td>
		<td class="list-box">
		 <input type="text" name="frm_declarationdate" value="{$default.xdeclarationdate}" id="frm_declarationdate" />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_declarationdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		
		</td>
		<td class="list-box" style="font-weight: 600">RCVBL ANCMNT</td>
		<td class="list-box">
		 <select name="frm_receipt" onchange="{literal}if(this.value=='No'){$('frm_receiptdate').disabled=true;$('frm_receiptdate_link').style.display='none';}else{$('frm_receiptdate').disabled=false;$('frm_receiptdate_link').style.display='inline';}{/literal}"/>
		 {foreach from=$receipt item=item}
		 	<option value="{$item}" {if $item eq $default.xreceipt}selected{/if}>{$item}</option>
		 {/foreach}
		 </select>
		</td>
	   </tr>  
	   <tr>
		<td class="list-box" style="font-weight: 600">Declaration No</td>
		<td class="list-box">
		 <input type="text" name="frm_declarationno" value="{$default.xdeclarationno}" />
		</td>
		<td class="list-box" style="font-weight: 600">RCVBL ANCMNT Date</td>
		<td class="list-box">
		 <input type="text" name="frm_receiptdate" value="{$default.xreceiptdate}" id="frm_receiptdate" {if $default.xreceipt eq 'No'}disabled{elseif !$default.xcustomsid}disabled{/if} />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_receiptdate', 'y-mm-dd');" id="frm_receiptdate_link" {if $default.xreceipt eq 'No'}style='display:none'{elseif !$default.xcustomsid}style='display:none'{/if}><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Origin</td>
		<td class="list-box">
		<span id="frm_origincityid_span">
		<select name="frm_origincityid" style="width: 150px" class="cl_city">
			{foreach from=$city key=key item=item}
				<option value="{$key}" {if $key eq $default.xorigincityid}selected="selected"{/if}>{$item}</option>
			{/foreach}
		</select>
		</span>
		<input type="text" name="frm_origincity_new" dir="ltr" style="display: none" id="frm_origincityid_new" />
		<a id='frm_origincityid_ok' href="javascript:void(0)" onclick="swapLinkDisplay(form1.frm_origincityid, 'city', 1, 150)">New City</a>
		<a href="javascript:void(0)" id='frm_origincityid_cancle' onclick="swapLinkDisplay(form1.frm_origincityid, 'city', 0)" style="display: none">
			<img src="../images/icons/16x16/delete.png" border="0px"></a>
		</td>
		<td class="list-box" style="font-weight: 600">Destination</td>
		<td class="list-box">
		<span id="frm_destinationcityid_span">
		<select name="frm_destinationcityid" style="width: 150px" class="cl_city">
			{foreach from=$city key=key item=item}
				<option value="{$key}" {if $key eq $default.xdestinationcityid}selected="selected"{/if}>{$item}</option>
			{/foreach}
		</select>
		</span>
		<input type="text" name="frm_destinationcity_new" id="frm_destinationcityid_new" dir="ltr" style="display: none" />
		<a href="javascript:void(0)" id="frm_destinationcityid_ok" onclick="swapLinkDisplay(form1.frm_destinationcityid, 'city', 1, 150)">New City</a>
		<a href="javascript:void(0)" id='frm_destinationcityid_cancle' onclick="swapLinkDisplay(form1.frm_destinationcityid, 'city', 0)" style="display: none">
			<img src="../images/icons/16x16/delete.png" border="0px"></a>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Exit Border</td>
		<td class="list-box">
		<span id="frm_viaportid_span">
		<select name="frm_viaportid" style="width: 150px">
			{foreach from=$port key=key item=item}
				<option value="{$key}" {if $key eq $default.xviaportid}selected="selected"{/if}>{$item}</option>
			{/foreach}
		</select>
		</span>
		<input type="text" name="frm_viaport_new" id="frm_viaportid_new" dir="ltr" style="display: none" />
		<a href="javascript:void(0)" id="frm_viaportid_ok" onclick="swapLinkDisplay(form1.frm_viaportid, 'port', 1, 150)">New Port</a>
		<a href="javascript:void(0)" id='frm_viaportid_cancle' onclick="swapLinkDisplay(form1.frm_viaportid, 'port', 0)" style="display: none">
			<img src="../images/icons/16x16/delete.png" border="0px"></a>
		</td>
		<td class="list-box" style="font-weight: 600">Bond Type 
		</td>
		<td class="list-box">
		<select name="frm_bondtypeid" style="width: 150px" class="cl_bondtype">
			{foreach from=$bondtype key=key item=item}
				<option value="{$key}" {if $key eq $default.xbondtypeid}selected="selected"{/if}>{$item}</option>
			{/foreach}
		</select>		
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Transit Licence 1</td>
		<td class="list-box">
			<input type="file" name="frm_tlimage1" />
		</td>
		<td class="list-box" style="font-weight: 600">Transit Licence 2</td>
		<td class="list-box">
			<input type="file" name="frm_tlimage2" />
		</td>
	   </tr>
	   {if $default.tl1 || $default.tl2}
	   		<tr>
			<td class="list-box" align="center" colspan="2">
		   {if $default.tl1}
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=customs1&pic={$transportid}" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=customs1&pic={$transportid}', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id={$id}&transportid={$transportid}&popup={$popup}&img=1">Delete</a>
			{/if}
			</td>
			<td class="list-box" align="center" colspan="2">
		   {if $default.tl2}
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=customs2&pic={$transportid}" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=customs2&pic={$transportid}', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id={$id}&transportid={$transportid}&popup={$popup}&img=2">Delete</a>
			{/if}
			</td> 
			</tr>
	   {/if}
	   <tr>
		<td class="list-box" style="font-weight: 600">Transit Licence 3</td>
		<td class="list-box">
			<input type="file" name="frm_tlimage3" />
		</td>
		<td class="list-box" style="font-weight: 600">Transit Licence 4</td>
		<td class="list-box">
			<input type="file" name="frm_tlimage4" />
		</td>
	   </tr>
	   {if $default.tl3 || $default.tl4}
		   <tr>
			<td class="list-box" align="center" colspan="2">
		   {if $default.tl3}
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=customs3&pic={$transportid}" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=customs3&pic={$transportid}', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id={$id}&transportid={$transportid}&popup={$popup}&img=3">Delete</a>
			{/if}
			</td>
			<td class="list-box" align="center" colspan="2">
		   {if $default.tl4}
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=customs4&pic={$transportid}" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=customs4&pic={$transportid}', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id={$id}&transportid={$transportid}&popup={$popup}&img=4">Delete</a>
			{/if}
			</td>
		   </tr>
	   {/if}
	   <tr>
		<td class="list-box" style="font-weight: 600">Declaration Image</td>
		<td class="list-box">
			<input type="file" name="frm_declarationimage" />
		</td>
	   </tr>
	   {if $default.declaration_img}
	   <tr>
			<td class="list-box" align="center" colspan="2">
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=declaration&pic={$transportid}" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&module=declaration&pic={$transportid}', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id={$id}&transportid={$transportid}&popup={$popup}&declaration=1">Delete</a>
			</td>
	   </tr>
	   {/if}  
	   <tr>
		<td width="90%" class="list-box" style="padding-bottom: 3px;" colspan="6">	
<!-- {if $btnModule} -->
{include file=$btnModule}
<!-- {else} -->			
<!-- {/if} -->			</td>
	   </tr>
	  </table>
	 </td>
	</tr>
</table>
 </form>
			</div>
</div>

