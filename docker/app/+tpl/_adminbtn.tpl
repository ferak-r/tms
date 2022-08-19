{if $backurl and !$hideback}
				<div class="button-ex-gray" style="margin: 3px;"><a title="Cancle and Return" href="{$backurl}">
			<img border="0" src="../images/icons/48x48/returnen.png" width="48" height="48" alt="Cancle and Return" /></a>			</div>
{/if}
				<div class="button-ex-gray" style="margin: 3px;"><a title="Set Defaults" href="#" onclick="var href=document.location.href; href=href.replace(/&loadformvalues=[^&]*/,''); href=href.replace(/&frm_id=[^&]*/,''); document.location.href=href; ">
			<img border="0" src="../images/icons/48x48/refreshen.png" width="48" height="48" alt="Set Defaults" /></a>			</div>
				<div class="button-ex-gray" style="margin: 3px;"><a title="Save and Continue" href="#" onclick="if(event.ctrlKey) document.forms['form1'].target='_blank'; document.forms['form1'].action = document.forms['form1'].action.replace(/&loadformvalues=[^&]*/,''); document.forms['form1'].submit();">
			<img border="0" src="../images/icons/48x48/oken.png" width="48" height="48" alt="Save and Continue" /></a>			</div>
{if $showsavebtn}
				<div class="button-ex-gray" style="margin: 3px;"><a title="Save and Load Form" href="#" onclick="if(event.ctrlKey) document.forms['form1'].target='_blank'; saveForm($('form1'), '{$section}/{$module}/{$step}/{$carrytype}'); document.forms['form1'].action = document.forms['form1'].action.replace(/&frm_id=[^&]*/,''); document.forms['form1'].action = document.forms['form1'].action.replace(/&loadformvalues=[^&]*/,'')+'&loadformvalues=1'; document.forms['form1'].submit();">
			<img border="0" src="../images/icons/48x48/saveen.png" width="48" height="48" alt="Save and Load Form" /></a>			</div>
{/if}