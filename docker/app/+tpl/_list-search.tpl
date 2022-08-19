<table border="0" cellspacing="0" cellpadding="3" class="search-input"> <!--{* ino badan objectivesh mikonam ;) *}-->
{if $module eq 'transport-list'}
  <tr>
    <td>Project No:</td><td><input name="zf_like_xtransportcode" value="{$zf_like_xtransportcode}" type="text" /></td>
    <td>From:</td><td>
		<select name="zf_eq_xfromcityid" /><option></option>
		{foreach from=$city key=key item=item}
			<option value="{$key}" {if $zf_eq_xfromcityid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
    <td>To:</td><td>
		<select name="zf_eq_xtocityid" /><option></option>
		{foreach from=$city key=key item=item}
			<option value="{$key}" {if $zf_eq_xtocityid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
    <td>Exit Border:</td><td>
		<select name="zf_eq_xviaportid" /><option></option>
		{foreach from=$port key=key item=item}
			<option value="{$key}" {if $zf_eq_xviaportid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>	
  </tr>
  <tr>
  	<td>Shipping Line/Carrier:</td><td>
		<select name="zf_eq_xcarrierid" /><option></option>
		{foreach from=$carrier key=key item=item}
			<option value="{$key}" {if $zf_eq_xcarrierid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>	
  	<td>Transport Type:</td><td>
		<select name="zf_eq_xtransporttype" /><option></option>
		{foreach from=$transporttype key=key item=item}
			<option value="{$item}" {if $zf_eq_xtransporttype eq $item}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>	
  	<td>Kind Of Transport:</td><td>
		<select name="zf_like_xtransportmethod" /><option></option>
		{foreach from=$transportmethod key=key item=item}
			<option value="{$item}" {if $zf_like_xtransportmethod eq $item}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
  	<td>Arrival Port/Border:</td><td>
		<select name="zf_eq_xarrivalportid" /><option></option>
		{foreach from=$port key=key item=item}
			<option value="{$key}" {if $zf_eq_xarrivalportid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
  </tr>
  <tr>
  	<td>Shipper:</td><td>
		<select name="zf_eq_xshipperid" /><option></option>
		{foreach from=$customer key=key item=item}
			<option value="{$key}" {if $zf_eq_xshipperid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
  	<td>Consignee:</td><td>
		<select name="zf_eq_xconsigneeid" /><option></option>
		{foreach from=$customer key=key item=item}
			<option value="{$key}" {if $zf_eq_xconsigneeid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
  	<td>Sender Office:</td><td>
		<select name="zf_eq_xsenderofficeid" /><option></option>
		{foreach from=$office key=key item=item}
			<option value="{$key}" {if $zf_eq_xsenderofficeid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
  	<td>Reciever Office:</td><td>
		<select name="zf_eq_xreceiverofficeid" /><option></option>
		{foreach from=$office key=key item=item}
			<option value="{$key}" {if $zf_eq_xreceiverofficeid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
  </tr>
  <tr>
   	<td>Transit License No:</td><td><input name="zf_like_xtlno" value="{$zf_like_xtlno}" type="text" /></td>
  	<td>Border Row No:</td><td><input name="zf_like_xcotazhno" value="{$zf_like_xcotazhno}" type="text" /></td>
  	<td>Bond No:</td><td><input name="zf_like_xinsuranceno" value="{$zf_like_xinsuranceno}" type="text" /></td>
	<td>Container No:</td><td><input name="zf_like_xcontainerno" value="{$zf_like_xcontainerno}" type="text" /></td>
  </tr>
  <tr>
  	<td>BL No:</td><td><input name="zf_like_xdocumentnumber" value="{$zf_like_xdocumentnumber}" type="text" /></td>
  </tr>
{elseif $module eq 'customer-list'}
  <tr>
    <td>Name:</td><td><input name="zf_like_xname" value="{$zf_like_xname}" type="text" /></td>
    <td>Family:</td><td><input name="zf_like_xfamily" value="{$zf_like_xfamily}" type="text" /></td>
	<td>Company:</td><td><input name="zf_like_xcompany" value="{$zf_like_xcompany}" type="text" /></td>
    <td>Country:</td><td>
		<select name="zf_eq_xcountryid" /><option></option>
		{foreach from=$country key=key item=item}
			<option value="{$key}" {if $zf_eq_xcountryid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
    <td>City:</td><td><input name="zf_like_xcity" value="{$zf_like_xcity}" type="text" /></td>	
  </tr>
{elseif $module eq 'carrier-list'}
  <tr>
    <td>Company Name:</td><td><input name="zf_like_xcarrier" value="{$zf_like_xcarrier}" type="text" /></td>
    <td>Company Manager:</td><td><input name="zf_like_xmanager" value="{$zf_like_xmanager}" type="text" /></td>
	<td>Responsible:</td><td><input name="zf_like_xresponsible" value="{$zf_like_xresponsible}" type="text" /></td>
  </tr>
{elseif $module eq 'equipment-list'}
  <tr>
    <td>Equipment Name:</td><td><input name="zf_like_xequipment" value="{$zf_like_xequipment}" type="text" /></td>
    <td>Equipment No:</td><td><input name="zf_eq_xequipmentno" value="{$zf_eq_xequipmentno}" type="text" /></td>
	<td>Category:</td><td>
		<select name="zf_eq_xequipmentcat" /><option></option>
		{foreach from=$equipmentcat key=key item=item}
			<option value="{$item}" {if $zf_eq_xequipmentcat eq $item}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
	<td>Owner:</td><td><input name="zf_like_xcarrier" value="{$zf_like_xcarrier}" type="text" /></td>
  </tr>
{elseif $module eq 'container-list'}
  <tr>
    <td>Container Number:</td><td><input name="zf_eq_xcontainernumber" value="{$zf_eq_xcontainernumber}" type="text" /></td>
    <td>Container Type:</td><td>
		<select name="zf_eq_xcontainertypeid" /><option></option>
		{foreach from=$containertype key=key item=item}
			<option value="{$key}" {if $zf_eq_xcontainertypeid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
	<td>Container Size:</td><td>
		<select name="zf_eq_xcontainersizeid" /><option></option>
		{foreach from=$containersize key=key item=item}
			<option value="{$key}" {if $zf_eq_xcontainersizeid eq $key}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
	<td>
		<select name="zf_eq_xown" /><option></option>
		{foreach from=$own key=key item=item}
			<option value="{$item}" {if $zf_eq_xown eq $item}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
	<td>Owner:</td><td><input name="zf_like_xcarrier" value="{$zf_like_xcarrier}" type="text" /></td>
  </tr>
{elseif $module eq 'container-lend-list'}
  <tr>
	<td>Container No:</td><td><input name="zf_like_xcontainerno" value="{$zf_like_xcontainerno}" type="text" /></td>
    <td>Party Account:</td><td><input name="zf_like_xpartyaccount" value="{$zf_like_xpartyaccount}" type="text" /></td>
    <td>Lend Date:</td><td><input name="zf_eq_xlenddate" value="{$zf_eq_xlenddate}" type="text" id="zf_eq_xlenddate" />
	<a href="javascript:void(0)" onClick="return showCalendar('zf_eq_xlenddate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>
	</td>
  </tr>
{elseif $module eq 'office-list'}
  <tr>
  	<td>Username:</td><td><input name="zf_like_xusername" value="{$zf_like_xusername}" type="text" /></td>
    <td>Office:</td><td><input name="zf_like_xoffice" value="{$zf_like_xoffice}" type="text" /></td>
  </tr>
{elseif $module eq 'user-list'}
  <tr>
  	<td>Username:</td><td><input name="zf_like_xusername" value="{$zf_like_xusername}" type="text" /></td>
    <td>Group:</td><td>
		<select name="zf_like_xgroup" /><option></option>
		{foreach from=$group key=key item=item}
			<option value="{$item}" {if $zf_like_xgroup eq $item}selected{/if}>{$item}</option>
		{/foreach}
		</select>
	</td>
	<td>Name:</td><td><input name="zf_like_xname" value="{$zf_like_xname}" type="text" /></td>
	<td>Family:</td><td><input name="zf_like_xfamily" value="{$zf_like_xfamily}" type="text" /></td>
  </tr>
{elseif $module eq 'container-status-all'}
  <tr>
  	<td>Proj No:</td><td><input name="zf_like_xtransportcode" value="{$zf_like_xtransportcode}" type="text" /></td>
	<td>Container No:</td><td><input name="zf_like_xcontainernumber" value="{$zf_like_xcontainernumber}" type="text" /></td>
  </tr>
{/if}
  <tr>
  	<td colspan="10" style="text-align: left">
	 <table>
	 	<tr>
		 <td>
			<input style="width: 20px" type="radio" name="zcond" value="AND" {if !$zcond or $zcond eq 'AND'}checked="checked"{/if}>And
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input style="width: 20px" type="radio" name="zcond" value="OR" {if $zcond eq 'OR'}checked="checked"{/if}>Or</option>
		 </td>
		 <td>&nbsp;&nbsp;</td>
		 <td>
			<input type="submit" style="display: none;" />
			<div class="button-ex-gray" style="margin-right: 2px; float: none; height: 16px; width:82px; margin-left: 8px;"><a title="Show Results" href="#" onclick="findObject('searchform').submit();">
			<img border="0" src="../images/admin/find.png" width="80" height="16" alt="Show Results" /></a></div>
		</td>
  	   </tr>
	 </table>
	</td>
   </tr>
 </table>
