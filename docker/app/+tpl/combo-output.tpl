<select name="{$smarty.get.comboname}" {if $combowidth}style="width: {$combowidth}px"{/if}>
{foreach from=$list key=key item=item name=i}
	<option value="{$item.xid}" {if $smarty.foreach.i.last}selected="selected"{/if}>{$item.xname}</option>
{/foreach}	
</select>
<script type="text/javascript" language="javascript">
$$('.cl_{$smarty.get.table}').each(function(el){ldelim}if(el.name != "{$smarty.get.comboname}"){ldelim}el.options[el.options.length] = new Option('{$item.xname}', '{$item.xid}'){rdelim}{rdelim});
</script>
