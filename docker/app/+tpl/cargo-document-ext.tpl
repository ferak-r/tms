<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<span id='doc_span'>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td width="32">
					<div class="button-ex-gray" style="width: 32px; height: 32px; float: none;"><a title="New Document" href="#" onclick='openNewWindow("index.php?section={$section}&module=cargodocument-admin&transportid={$id}", 700, 450)'>
				<img border="0" src="../images/icons/32x32/newen.png" width="32" height="32" alt="" /></a></div>
					</td>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="right">
				Transport Document
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="20%" align="center" nowrap="nowrap">Document</td>
						<td width="50%" align="center">Carrier</td>
						<td width="50%" align="center">Path</td>
						<td width="16"><a href="javascript:void(0)" onclick='javascript:openNewWindow("index.php?section={$section}&module=transport-admin&step=documentcomment&transportid={$id}&type=Cargodoc&popup=1")'><img border="0px" src="../images/icons/16x16/comment.png" title="Add Comment"/></a></td>
					</tr>
{section name=listID loop=$documentlist}					
					<tr>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{$documentlist[listID].xdocument2}&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" {* *}nowrap>{$documentlist[listID].xcarrier}&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;">{$documentlist[listID].xpath}&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
				
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Path" href="javascript:void(0)" onclick='openNewWindow("index.php?section={$section}&module=cargodocument-admin&frm_id={$documentlist[listID].xloadingdocumentid}&transportid={$id}&popup={$popup}", 700, 450);'>
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Path" href="javascript:void(0)" onclick="if(confirm('Are you sure?')){ldelim}document.location.href='index.php?section={$section}&module=cargodocument-admin&frm_id={$documentlist[listID].xloadingdocumentid}&transportid={$id}&cmd=delete&popup={$popup}'{rdelim}">
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
{if $user->group.document || $user->group.admin}
	<tr>
		<td colspan="4" height="16" align="center">
			<div  id="finished_div" style="float: left; margin: 4px; width: 16px;"></div>
			<input type="button" id="transportdocument_finished" value="{if $default.frm_transportdocumentfinished eq 1}Transport Documents Closed{else}Transport Documents Not Closed{/if}" class="{if $default.frm_transportdocumentfinished eq 1}btn-finished{else}btn-notfinished{/if}" onclick="new ajax('index.php?section=operation&module=transport-admin&step=finished&cmd=transportdocument&transportid={$id}', {ldelim}update: 'finished_div', evalScripts: true{rdelim}).request();" /></td>
	</tr>
{/if}
				</table>
			</div>
</div>
</span>

