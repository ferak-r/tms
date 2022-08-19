<html>
<head>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
</head>
<body>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="right">
				Comment List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="100%" align="center">Comment</td>
						<td width="16">&nbsp;</td>
					</tr>
{section name=listID loop=$commentlist}					
					<tr>
						<td width="30%" class="list-box" style="padding: 2px;">{$commentlist[listID].xtransportcomment}&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Comment" href="index.php?section={$section}&module=transport-admin&step=documentcomment&frm_id={$commentlist[listID].xtransportcommentid}&transportid={$transportid}&popup={$popup}&type={$smarty.get.type}">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Comment" href="javascript:void(0)" onClick="if(confirm('Are you sure?')){ldelim}document.location.href='index.php?section={$section}&module=transport-admin&step=documentcomment&cmd=delete&frm_id={$commentlist[listID].xtransportcommentid}&popup={$popup}&transportid={$transportid}&type={$smarty.get.type}'{rdelim}">
									<img border="0" src="../images/icons/16x16/delete.png" width="17" height="16" alt="" /></a></div></td>
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
	 <td colspan="4">
	 <hr style="color: #000000"/>
	 <form name="form1" method="post" action="index.php?section={$section}&module=transport-admin&step=documentcomment&cmd={if $id}update{else}add{/if}&frm_id={$id}&cargoid={$cargoid}&transportid={$transportid}&popup={$popup}&type={$smarty.get.type}">
	  <table align="center">
	   <tr>
		<td class="list-box" style="font-weight: 600; vertical-align: middle">Comment</td><td class="list-box"><textarea name="frm_transportcomment" />{$default.xtransportcomment}</textarea></td>
	   </tr>
	   <tr>
		<td width="90%" class="list-box" style="padding-bottom: 3px;" colspan="2">	
<!-- {if $btnModule} -->
{include file=$btnModule}
<!-- {else} -->		
				<div class="button-ex-gray" style="margin: 3px;"><a title="Set Defaults" href="javascript:{if $reloadonreset}document.location.reload(){else}document.forms['form1'].reset(){/if};" onClick="return confirm('Do you want to load default values?');">
			<img border="0" src="../images/icons/48x48/refreshen.png" width="48" height="48" alt="Set Defaults" /></a>			</div>
				<div class="button-ex-gray" style="margin: 3px;"><a title="Save and Continue" href="#" onClick="{if $id}form1.cmd.value='update';{/if}if(event.ctrlKey) document.forms['form1'].target='_blank'; document.forms['form1'].submit();">
			<img border="0" src="../images/icons/48x48/oken.png" width="48" height="48" alt="Save and Continue" /></a>			</div>
<!-- {/if} -->			</td>
	   </tr>
	  </table>
	  </form>
	 </td>
	 
	</tr>
</table>
			</div>
</div>
</body>
</html>