<html>
<head>
{include file="_head.tpl"}
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<script type="text/javascript" language="javascript">
{if $smarty.get.refreshparent eq 'cargo'}
window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=transport-admin&step=document&cmd=cargooutput&transportid={$transportid}', {ldelim} update:'cargo_span' , method:'get', evalScripts:true {rdelim}).request();", 100);
{/if}
</script>
</head>
<body>

<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
<!--				<td width="32">
					<div class="button-ex-gray" style="width: 32px; height: 32px; float: none;"><a title="New Cargo" href="index.php?section=admin&module=transport-admin&step=containercargo&transportid={$transportid}&containerid={$containerid}&popup={$popup}">
				<img border="0" src="../images/icons/32x32/newen.png" width="32" height="32" alt="" /></a></div>
				</td>-->
				
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="right">
				Cargo List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="30%" align="center">Commodity</td>
						<td width="20%" align="center">Packing Type</td>
						<td width="20%" align="center" nowrap="nowrap">Number of Packages</td>
						<td width="20%" align="center" nowrap="nowrap">Weight<small>&nbsp;(kg)&nbsp;</small></td>
						<td width="16">&nbsp;</td>
					</tr>
{section name=listID loop=$cargolist}					
					<tr>
						<td class="list-box" style="padding: 2px;">{$cargolist[listID].xcommodity}&nbsp;</td>
						<td class="list-box" style="padding: 2px;" {* *}nowrap>{$cargolist[listID].xpackagetype}&nbsp;</td>
						<td class="list-box" style="padding: 2px;" {* *}nowrap>{$cargolist[listID].xpackagenumber}&nbsp;</td>
						<td class="list-box" style="padding: 2px;" {* *}nowrap>{$cargolist[listID].xcargoweight}&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Cargo" href="index.php?section={$section}&module=transport-admin&step=containercargo&frm_id={$cargolist[listID].xtransportcargoid}&transportid={$transportid}&containerid={$containerid}&popup={$popup}">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Cargo" href="index.php?section={$section}&module=transport-admin&step=containercargo&frm_id={$cargolist[listID].xtransportcargoid}&transportid={$transportid}&containerid={$containerid}&cmd=delete&popup={$popup}&transportid={$transportid}&delcontainercargo=1">
									<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="" /></a></div></td>
							</tr>
						</table>
						</td>
					</tr>
{sectionelse}
	<tr>
		<td colspan="4" height="16">&nbsp;</td>
	</tr>	
{/section}	
	<tr>
	 <td colspan="5">
	 <hr style="color: #000000"/>
	 <form name="form1" id="form1" method="post" action="index.php?section={$section}&module=transport-admin&step=containercargo&cmd={if $id}update{else}add{/if}&frm_id={$id}&transportid={$transportid}&containerid={$containerid}&popup={$popup}&carrytype=Bulk&addcontainercargo=1">
	  <table align="center">
	   <tr>
		<td class="list-box" style="font-weight: 600">Packing Type</td>
		<td class="list-box">
			<select name="frm_packagetypeid" style="width: 150px">
				{foreach from=$packagetype key=key item=item}
					<option value="{$key}" {if $key eq $default.xpackagetypeid}selected{/if}>{$item}</option>
				{/foreach}
			</select>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Number of Packages</td>
		<td class="list-box"><input type="text" name="frm_packagenumber" value="{$default.xpackagenumber}" /></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Commodity</td>
		<td class="list-box"><input type="text" name="frm_commodity" value="{$default.xcommodity}" /></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Kind</td>
		<td class="list-box">
			<select name="frm_cargokind" style="width: 150px">
				{foreach from=$cargokind key=key item=item}
					<option value="{$key}" {if $key eq $default.xcargokind}selected{/if}>{$item}</option>
				{/foreach}
			</select>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Size</td>
		<td class="list-box">
			<select name="frm_cargosize" style="width: 150px">
				{foreach from=$cargosize key=key item=item}
					<option value="{$key}" {if $key eq $default.xcargosize}selected{/if}>{$item}</option>
				{/foreach}
			</select>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Danger Level</td>
		<td class="list-box">
			<select name="frm_cargodanger" style="width: 150px">
				{foreach from=$cargodanger key=key item=item}
					<option value="{$key}" {if $key eq $default.xcargodanger}selected{/if}>{$item}</option>
				{/foreach}
			</select>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">IMO</td>
		<td class="list-box"><input type="text" name="frm_imo" value="{$default.ximo}" /></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Cargo Weight</td>
		<td class="list-box"><input type="text" name="frm_cargoweight" value="{$default.xcargoweight}" /> Kg</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Cargo Volume</td>
		<td class="list-box"><input type="text" name="frm_cargovolume"  value="{$default.xcargovolume}" /> M<sup>3</sup></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Cargo Dimension (L*W*H)</td>
		<td class="list-box"><input type="text" name="frm_cargodimension"  value="{$default.xcargodimension}" /></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Description</td>
		<td class="list-box"><textarea name="frm_cargodescription" style="width: 200px" />{$default.xcargodescription}</textarea></td>
	   </tr>


	   <tr>
		<td width="90%" class="list-box" style="padding-bottom: 3px;" colspan="2">	
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
{if $smarty.get.loadformvalues}
loadForm('form1', '{$section}/{$module}/{$step}/{$carrytype}');
{/if}
</script>
</body>
</html>


