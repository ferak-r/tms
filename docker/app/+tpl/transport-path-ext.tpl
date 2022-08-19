<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<span id="path_span">
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td width="32">
					<div class="button-ex-gray" style="width: 32px; height: 32px; float: none;"><a title="New Path" href="#" onclick='openNewWindow("index.php?section=carrier&module=loading-admin&step=path&transportid={$id}", 900, 700)'>
				<img border="0" src="../images/icons/32x32/newen.png" width="32" height="32" alt="" /></a></div>
					</td>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="right">
				Route List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="50%" align="center" nowrap="nowrap">From</td>
						<td width="50%" align="center">To</td>
						<td width="16">&nbsp;</td>
					</tr>
{section name=listID loop=$pathlist}					
					<tr>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{$pathlist[listID].xfrom}&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{$pathlist[listID].xto}&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
				
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Path" href="javascript:void(0)" onclick='openNewWindow("index.php?section=carrier&module=loading-admin&step=path&frm_id={$pathlist[listID].xtransportpathid}&transportid={$id}&popup={$popup}", 900, 700);'>
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Path" href="javascript:void(0)" onclick="if(confirm('Are you sure?')){ldelim}document.location.href='index.php?section=carrier&module=loading-admin&step=path&cmd=delete&popup={$popup}&transportid={$id}&frm_id={$pathlist[listID].xtransportpathid}'{rdelim}">
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

