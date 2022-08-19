<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<span id='doc_span'>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td width="32">
					<div class="button-ex-gray" style="width: 32px; height: 32px; float: none;"><a title="New Document" href="#" onclick='{if not $id}form1.action=form1.action+"&newdoc=1";form1.submit();{else}openNewWindow("index.php?section={$section}&module=transport-admin&step=document&transportid={$id}", 500, 420);{/if}'>
				<img border="0" src="../images/icons/32x32/newen.png" width="32" height="32" alt="" /></a></div>
					</td>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="right">
				Document List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="50%" align="center">Document</td>
						<td width="20%" align="center" nowrap="nowrap">Document No</td>
						<td width="20%" align="center">Date</td>
						<td align="center" style="padding: 0px"><a href="javascript:void(0)" onclick='javascript:openNewWindow("index.php?section={$section}&module=transport-admin&step=documentcomment&transportid={$id}&type=Transportdoc&popup=1")'><img border="0px" src="../images/icons/16x16/comment.png" title="Add Comment"/></a></td>
					</tr>
{section name=listID loop=$documentlist}					
					<tr>
						<td width="30%" class="list-box" style="padding: 2px;">{$documentlist[listID].xdocument}&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{$documentlist[listID].xdocumentnumber}&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{$documentlist[listID].xdocumentdate}&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Document" href="javascript:void(0)" onclick='openNewWindow("index.php?section={$section}&module=transport-admin&step=document&frm_id={$documentlist[listID].xtransportdocumentid}&transportid={$id}", 500, 420);'>
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Document" href="javascript:void(0)" onclick="if(confirm('Are you sure?')){ldelim}document.location.href='index.php?section={$section}&module=transport-admin&step=document&cmd=delete&popup={$popup}&transportid={$id}&frm_id={$documentlist[listID].xtransportdocumentid}';{rdelim}">
									<img border="0" src="../images/icons/16x16/delete.png" width="20" height="16" alt="" /></a></div></td>
							</tr>
						</table>						</td>
					</tr>
{sectionelse}
	<tr>
		<td colspan="4" height="16">&nbsp;</td>
	</tr>	
{/section}	
	{if $user->group.document || $user->group.admin}
		<tr>
			<td colspan="4" height="16" align="center">
			<div  id="finished_div" style="float: left; margin: 4px; width: 16px;"></div>
				<input type="button" id="cargodocument_finished" value="{if $default.frm_cargodocumentfinished eq 1}Cargo Documents Closed{else}Cargo Documents Not Closed{/if}" class="{if $default.frm_cargodocumentfinished eq 1}btn-finished{else}btn-notfinished{/if}" onclick="new ajax('index.php?section=operation&module=transport-admin&step=finished&cmd=cargodocument&transportid={$id}', {ldelim}update: 'finished_div', evalScripts: true{rdelim}).request();" /></td>
		</tr>
	{/if}
				</table>
			</div>
</div>
</span>