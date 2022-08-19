<div>
<form action="" method="post" name="msgForm">
<div class="tab-page" id="modules-cpanel">
<script type="text/javascript">
	var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
</script>

{foreach from=$mail->unread key=key item=item}

	<div class="tab-page" id="module{$key}">
		<h2 class="tab">
{$item.xsubject|truncate:24:""}
		</h2>
	<script type="text/javascript">
	  tabPane1.addTabPage( document.getElementById( "module{$key}" ) );
	</script>
<b>{$item.xfrom}</b>: {$item.xbody|truncate:1000|replace:"\n":"<br/>"}
<br>
<br>
	<a href="index.php?section=user&amp;module=mail-admin&amp;cmd=view&amp;frm_id={$item.xuserbodyid}">[View]</a>	
	</div>
{/foreach}
</div>
</form>
</div>