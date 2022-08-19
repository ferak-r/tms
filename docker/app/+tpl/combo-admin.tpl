<div id="combo_admin">
	<div id="clist">
		<select name="frm_select" id="cselect" class="cinput">
{foreach from=$list key=key item=item}
			<option value="{$item.xid}">{$item.xid}: {$item.xname}</option>
{/foreach}	
		</select>
		<input type="button" value="Edit" onclick="cedit();" class="cbtn" />
		<input type="button" value="Delete" onclick="cdelete();" class="cbtn" />
		<input type="button" value="New" onclick="cnew();" class="cbtn" />
	</div>
	<div id="cadmin" style="display: none;">
		<table>
			<tr><td>Code</td><td>Title</tr>
			<tr>
				<td><input type="text" name="frm_id" id="cid" size="4" class="cinput" /></td>
				<td><input type="text" name="frm_name" id="cname" size="20" class="cinput" /></td>
			</tr>
			<tr><td colspan="3" align="center">
				<input type="button" value="Save" onclick="csave();" class="cbtn"/>
				<input type="button" value="Cancle" onclick="ccancel();" class="cbtn" />
			</td></tr>
		</table>
	</div>
</div>
<script language="javascript" type="text/javascript">
{literal}
ccmd = 'add';
$('cselect').focus();
{/literal}
</script>