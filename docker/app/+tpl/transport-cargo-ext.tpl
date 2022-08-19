<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<span id="cargo_span">
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td width="32">
					<div class="button-ex-gray" style="width: 32px; height: 32px; float: none;"><a title="New Cargo" href="#" onclick='{if not $id}form1.action=form1.action+"&newcargo=1"; form1.submit();{else}openNewWindow("index.php?section={$section}&module=transport-admin&step=cargo&transportid={$id}", 500, 520);{/if}'>
				<img border="0" src="../images/icons/32x32/newen.png" width="32" height="32" alt="" /></a></div>
					</td>
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
						<td width="50%" align="center">Commodity</td>
						<td width="20%" align="center" nowrap="nowrap">Carrying Type</td>
						<td width="16">&nbsp;</td>
					</tr>
{section name=listID loop=$cargolist}					
					<tr>
						<td width="30%" class="list-box" style="padding: 2px;">{$cargolist[listID].xcommodity}&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{if $cargolist[listID].xcarrytype eq 'Container'}{"`$cargolist[listID].xcarrytype`(`$cargolist[listID].xcontainernumber`)"}{else}{$cargolist[listID].xcarrytype}{/if}&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
				
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Cargo" href="javascript:void(0)" onclick='openNewWindow("index.php?section={$section}&module=transport-admin&step=cargo&frm_id={$cargolist[listID].xtransportcontainerid}&transportid={$id}&popup={$popup}&carrytype={$cargolist[listID].xcarrytype}", 500, 520);'>
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Cargo" href="javascript:void(0)" onclick="if(confirm('Are you sure?')){ldelim}document.location.href='index.php?section={$section}&module=transport-admin&step=cargo&cmd=delete&popup={$popup}&transportid={$id}&frm_id={$cargolist[listID].xtransportcontainerid}&carrytype=Container'{rdelim}">
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

