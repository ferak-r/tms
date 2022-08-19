<div class="main-title1">
Container List
</div>
<div class="main-title2">
</div> 
<div>
<table style="width: 100%">
	<tr><td>
	{if !$hideSearchButton}
			<div class="button-ex-gray" style="margin-right: 2px;"><a title="Search" href="javascript:swapDisplay('searchbox');">
			<img border="0" src="../images/icons/48x48/searchen.png" width="48" height="48" alt="Search" /></a></div>
			<div class="button-ex-gray" style="margin-right: 2px;"><a title="Show All" href="{$href|regex_replace:'/&amp;query=[^&]*/':''}">
			<img border="0" src="../images/icons/48x48/showallen.png" width="48" height="48" alt="Show all records" /></a></div>	
	{/if}
	</td></tr>
	<tr><td>
	<div id="searchbox" style="display: {**}none;">
		<form action="{$href}" method="post" name="searchform" id="searchform">
	{include file="_list-search.tpl"}
		</form>
	</div>
	</td></tr>
</table>
<div>
<form name="form1" id="form1" method="post" action="index.php?section=admin&module=container-status-all&cmd=update&frm_id={$id}&popup={$popup}&query={$smarty.get.query}" enctype="multipart/form-data">
<table border="0" cellpadding="0" width="100%">
<tr>
<td colspan="3"><input type="checkbox" {if $smarty.get.reached eq 'true'}checked=checked{/if} onclick="document.location.href='{$href|regex_replace:'/&amp;reached=[^&]*/':''}&reached='+this.checked">&nbsp;Display reached containers</td>
</tr>
<tr class="row-box-head">
<td>Container No / Proj No</td>
<td>Customer</td>
<td>Shipping</td>
{*<td>Carrier</td>*}
</tr>
{foreach from=$containerlist key=key item=item}
<tr>
<td class="list-box" style="vertical-align: middle; width: 1px" nowrap="nowrap">
	{$item.xprojectcontainer|default:'&nbsp;'}
	<input type="hidden" name="frm_transportcontainerid[]" value="{$item.xtransportcontainerid}">
</td>
<td class="list-box" style="vertical-align: middle; width: 50%">
	<table style="background-color: {$item.xcustomercolor}; width: 100%">
	 <tr>
	  <td>Start Date:</td>
	  <td><input type="text" name="frm_customerstartdate{$item.xtransportcontainerid}" id="frm_customerstartdate{$item.xtransportcontainerid}" value="{$item.xcustomerstartdate}" style="width: 70px" />
		<a href="javascript:void(0)" onClick="return showCalendar('frm_customerstartdate{$item.xtransportcontainerid}', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
	 </tr>
	 <tr>
	  <td>Free Time:</td>
	  <td><input type="text" name="frm_customerfreetime{$item.xtransportcontainerid}" id="frm_customerfreetime{$item.xtransportcontainerid}" value="{$item.xcustomerfreetime}" style="width: 70px;" /></td>
	 </tr>
	 <tr>
	  <td>Status:</td><td>{$item.xcustomerstatus}</td>
	 </tr> 
	 <tr>
	  <td>Reached:</td><td><input type="checkbox" {if $item.xcustomerreached}checked="checked"{/if} value="1" name="frm_customerreached{$item.xtransportcontainerid}" class="cl_reached{$item.xtransportcontainerid}" onChange="if(this.checked){ldelim}$$('.cl_returndate_row{$item.xtransportcontainerid}').each(function(el){ldelim}el.style.display='table-row'{rdelim}); $$('.cl_reached{$item.xtransportcontainerid}').each(function(el){ldelim}el.checked='checked'{rdelim}){rdelim}else{ldelim}$('customerreturndate_row{$item.xtransportcontainerid}').style.display='none'{rdelim}" /></td>
	 </tr>  
	 <tr style="{if !$item.xcustomerreached}display: none{/if}" class="cl_returndate_row{$item.xtransportcontainerid}" id="customerreturndate_row{$item.xtransportcontainerid}">
	  <td>Return Date:</td>
	  <td><input type="text" name="frm_customerreturndate{$item.xtransportcontainerid}" id="frm_customerreturndate{$item.xtransportcontainerid}" class="cl_returndate{$item.xtransportcontainerid}" value="{$item.xcustomerrejectdate}" style="width: 70px" />
		<a href="javascript:void(0)" onClick="return showCalendar('frm_customerreturndate{$item.xtransportcontainerid}', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
	 </tr>
	</table>
</td>

		<td class="list-box" style="vertical-align: middle; width: 50%">
			<table style="background-color: {$item.xshippingcolor}; width: 100%">
			 <tr>
			  <td>Start Date:</td>
			  <td><input type="text" name="frm_shippingstartdate{$item.xtransportcontainerid}" id="frm_shippingstartdate{$item.xtransportcontainerid}" value="{$item.xshippingstartdate}" style="width: 70px" />
				<a href="javascript:void(0)" onClick="return showCalendar('frm_shippingstartdate{$item.xtransportcontainerid}', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
			 </tr>
			 <tr>
			  <td>Free Time:</td>
			  <td><input type="text" name="frm_shippingfreetime{$item.xtransportcontainerid}" id="frm_shippingfreetime{$item.xtransportcontainerid}" value="{$item.xshippingfreetime}" style="width: 70px" /></td>
			 </tr>
			 <tr>
			  <td>Status:</td><td>{$item.xshippingstatus}</td>
			 </tr>
			 <tr>
			  <td>Reached:</td><td><input type="checkbox" {if $item.xshippingreached}checked="checked"{/if} value="1" name="frm_shippingreached{$item.xtransportcontainerid}"  class="cl_reached{$item.xtransportcontainerid}"  onchange="if(this.checked){ldelim}$$('.cl_returndate_row{$item.xtransportcontainerid}').each(function(el){ldelim}el.style.display='table-row'{rdelim}); $$('.cl_reached{$item.xtransportcontainerid}').each(function(el){ldelim}el.checked='checked'{rdelim}){rdelim}else{ldelim}$('shippingreturndate_row{$item.xtransportcontainerid}').style.display='none'{rdelim}"/></td>
			 </tr> 
			 <tr style="{if !$item.xshippingreached}display: none{/if}" class="cl_returndate_row{$item.xtransportcontainerid}" id="shippingreturndate_row{$item.xtransportcontainerid}">
			  <td>Return Date:</td>
			  <td><input type="text" name="frm_shippingreturndate{$item.xtransportcontainerid}" id="frm_shippingreturndate{$item.xtransportcontainerid}" class="cl_returndate{$item.xtransportcontainerid}" value="{$item.xshippingrejectdate}" style="width: 70px" />
				<a href="javascript:void(0)" onClick="return showCalendar('frm_shippingreturndate{$item.xtransportcontainerid}', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
			 </tr>
			</table>
		</td>
		</tr>
		{/foreach}
		<tr>
		<td colspan="3">
			<div dir="ltr" align="right">
				{include file="_paging.tpl"}
			</div>
		</td>
		</tr>
		<tr>
		<td colspan="10">
		<!-- {if $btnModule} -->
		{include file=$btnModule}
		<!-- {else} -->			
		<!-- {/if} -->
		</td>
		</tr>
		</table>

	 
	 </td>
	</tr>
</table>
 </form>
  </div>
</div>

