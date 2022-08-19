<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<span id="equipment_span">
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td width="32">
					<div class="button-ex-gray" style="width: 32px; height: 32px; float: none;"><a title="New Cargo" href="#" onclick='{if not $id}form1.action=form1.action+"&newequipment=1"; form1.submit();{else}openNewWindow("index.php?section={$section}&module=carrier-admin&step=equipment&carrierid={$id}", 500, 430);{/if}'>
				<img border="0" src="../images/icons/32x32/newen.png" width="32" height="32" alt="" /></a></div>
					</td>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="right">
				Equipment List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="50%" align="center">Equipment No/Name</td>
						<td width="20%" align="center" nowrap="nowrap">Category</td>
						<td width="16">&nbsp;</td>
					</tr>
{section name=listID loop=$equipmentlist}					
					<tr>
						<td width="30%" class="list-box" style="padding: 2px;">{if $equipmentlist[listID].xequipmentcat eq 'VSL'}{$equipmentlist[listID].xequipment}{else}{$equipmentlist[listID].xequipmentno}{/if}&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{$equipmentlist[listID].xequipmentcat}&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
				
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Equipment" href="javascript:void(0)" onclick='openNewWindow("index.php?section={$section}&module=carrier-admin&step=equipment&frm_id={$equipmentlist[listID].xequipmentid}&carrierid={$id}&popup={$popup}", 500, 430);'>
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Equipment" href="index.php?section={$section}&module=carrier-admin&step=equipment&cmd=delete&popup={$popup}&frm_id={$equipmentlist[listID].xequipmentid}&carrierid={$id}&popup={$popup}">
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
				</table>
			</div>
</div>
</span>

