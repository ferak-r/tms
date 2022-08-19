{if $btn.send}
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Send Message" href="{$btn.send}">
	<img border="0" src="../images/icons/48x48/senden.png" width="48" height="48" alt="Send Message" /></a>
</div>
{/if}
{if $btn.replay}
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Replay to Message" href="{$btn.replay}">
	<img border="0" src="../images/icons/48x48/replayen.png" width="48" height="48" alt="Replay to Message" /></a>
</div>
{/if}
{if $btn.forward}
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Forward Message" href="{$btn.forward}">
	<img border="0" src="../images/icons/48x48/forwarden.png" width="48" height="48" alt="Forward Message" /></a>
</div>
{/if}
{if $btn.savetodraft}
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Save Message" href="{$btn.savetodraft}">
	<img border="0" src="../images/icons/48x48/save.png" width="48" height="48" alt="Save Message" /></a>
</div>
{/if}
{if $btn.delete}
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Delete Message" href="{$btn.delete}">
	<img border="0" src="../images/icons/48x48/delete.png" width="48" height="48" alt="Delete Message" /></a>
</div>
{/if}
{if $btn.nav}
<div class="button-ex-gray" style="margin: 3px; float:right;">
	<a title="Newer Message" href="{$btn.up}">
	<img border="0" src="../images/icons/other/up.png" width="48" height="23" alt="Newer Message" /></a>
	<a title="Older Message" href="{$btn.down}">
	<img border="0" src="../images/icons/other/down.png" width="48" height="23" alt="Older Message" /></a>
</div>
{/if}