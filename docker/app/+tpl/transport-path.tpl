
{include file="_head.tpl"}
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<script type="text/javascript" language="javascript">
{if $smarty.get.refreshparent eq 'path'}
window.opener.window.setTimeout("new Ajax('index.php?section=carrier&module=loading-admin&step=path&cmd=pathoutput&transportid={$transportid}', {ldelim} update:'path_span' , method:'get', evalScripts:true {rdelim}).request();", 100);
{/if}
</script>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="left">
				Path List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="50%" align="center">From</td>
						<td width="50%" align="center">To</td>
						<td width="16">&nbsp;</td>
					</tr>
{section name=listID loop=$pathlist}					
					<tr>
						<td width="50%" class="list-box" style="padding: 2px;">{$pathlist[listID].xfrom}&nbsp;</td>
						<td width="50%" class="list-box" style="padding: 2px;" {* *}nowrap>{$pathlist[listID].xto}&nbsp;</td>
						<td width="1%">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Path" href="index.php?section={$section}&module=loading-admin&step=path&frm_id={$pathlist[listID].xtransportpathid}&transportid={$transportid}&popup={$popup}">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Path" href="index.php?section={$section}&module=loading-admin&step=path&frm_id={$pathlist[listID].xtransportpathid}&transportid={$transportid}&cmd=delete&popup={$popup}">
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
	 <form name="form1" id="form1" method="post" action="index.php?section={$section}&module=loading-admin&step=path&cmd={if $id}update{else}add{/if}&frm_id={$id}&transportid={$transportid}&popup={$popup}">
	  <table align="center" style="width: 100%">
	   <tr>
		<td class="list-box" style="font-weight: 600">From</td>
		<td class="list-box">
			<select name="frm_fromcityid" style="width: 150px">
				{foreach from=$city key=key item=item}
					<option value="{$key}" {if $key eq $default.xfromcityid}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>
		</td>
	  </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">To</td>
		<td class="list-box">
			<select name="frm_tocityid" style="width: 150px">
				{foreach from=$city key=key item=item}
					<option value="{$key}" {if $key eq $default.xtocityid}selected="selected"{/if}>{$item}</option>
				{/foreach}
			</select>
		</td>
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


