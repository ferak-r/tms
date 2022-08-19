{include file="_head.tpl"}
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<div class="main-title1">
Change Status
</div>
<div class="main-title2">
Project No: {$transportcode}
</div> 
<div>
<div>
<form name="form1" id="form1" method="post" action="index.php?section={$section}&module=status-admin&cmd=update&id={$smarty.get.id}&popup={$popup}" enctype="multipart/form-data">
<table border="0" cellpadding="0" width="100%">
	<tr>
	 <td colspan="7">
	  <table align="center" style="width: 100%">
	   <tr>
		<td class="list-box" style="font-weight: 600">Status</td>
		<td class="list-box">
			<table><tr>
			{foreach from=$color key=key item=item}
				<td style='background-color: {$item.xcolornumber}' title='{$item.xstatus}'>
					<input type='checkbox' style='width: 20px' name='frm_statuscolorid[]' value='{$item.xstatuscolorid}' {if $default[$item.xstatuscolorid]}checked=checked{/if}></td>
			{/foreach}
			</tr></table>
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
	 </td>
	</tr>
</table>
 </form>
</div>
</div>

