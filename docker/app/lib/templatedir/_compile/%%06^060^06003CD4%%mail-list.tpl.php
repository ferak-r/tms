<?php /* Smarty version 2.6.18, created on 2011-02-20 11:05:02
         compiled from mail-list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'mail-list.tpl', 48, false),array('modifier', 'default', 'mail-list.tpl', 92, false),array('function', 'eval', 'mail-list.tpl', 92, false),)), $this); ?>
<!-- <?php if ($this->_tpl_vars['popup']): ?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="fa">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="fa" />
<link rel="stylesheet" href="../+script/style-en.css" type="text/css" />
<link rel="stylesheet" href="../+script/calendar-mos.css" type="text/css" />
<link rel="stylesheet" href="../+script/cpanel.css" type="text/css" />
<link rel="stylesheet" href="../+script/theme.css" type="text/css" />
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../+script/tabpane.css" />
</head>
<body style="margin:10px" dir="rtl">
<!-- <?php endif; ?> -->
<script language="javascript" type="text/javascript">
<!--
var adminModule		= String('<?php echo $this->_tpl_vars['module']; ?>
').replace(/-list/, '-admin');
var deleteHref		= 'index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module='+adminModule+'&cmd=delete&frm_id=';

<?php echo '
function doDelete(id, obj)
{
	if(confirm(\'Do you want to delete this record?\')) {
		ajaxDelete(deleteHref+id, \'row-box\', obj);
	}
}

function doFilter()
{
	var cmd = findObject(\'cmd\');
	var url = document.location.href.replace(/&cmd=[^&]*/, \'\');
	if(cmd && cmd.selectedIndex > 0)
		url = url + \'&cmd=\' + cmd.options[cmd.selectedIndex].value;
	document.location = url;
}
'; ?>

//-->
</script>
<table cellpadding="0" cellspacing="3" width="100%">
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 4px; margin-right: 1px;">
	<tr>
		<td width="100%">
		<div class="button-ex-gray"><a title="New" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=<?php echo ((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('replace', true, $_tmp, '-list', '-admin') : smarty_modifier_replace($_tmp, '-list', '-admin')); ?>
">
		<img border="0" src="../images/icons/48x48/newen.png" width="48" height="48" alt="New" /></a></div>
		<div class="button-ex-gray" style="margin-right: 2px; width:500px; text-align:center; margin-top: 20px; height: 20px;">
		<select name="cmd" style="width: 140px;">
			<option value="inbox" <?php if ($_REQUEST['cmd'] == 'inbox'): ?>selected="selected"<?php endif; ?>>Received Messages</option>
			<option value="sent" <?php if ($_REQUEST['cmd'] == 'sent'): ?>selected="selected"<?php endif; ?>>Sent Messages</option>
			<option value="draft" <?php if ($_REQUEST['cmd'] == 'draft'): ?>selected="selected"<?php endif; ?>>Draft</option>
		</select>							  
		<input type="button" onclick="doFilter();" value="Show" style="height: 20px; font-size: 10px; font-family:Tahoma, Verdana; width: 50px;" />
		</div>
		</td>
		<td align="center">
			<div dir="ltr" style="margin-top: 18px;"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_paging.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
		</td>
		</tr>
</table>
<div class="form-input" id="searchbox" style="display: none; padding-right: 42px; border: 1px solid #999; margin: 4px; background-color: #FFFFEE">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_search.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<form action="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=<?php echo ((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('replace', true, $_tmp, '-list', '-admin') : smarty_modifier_replace($_tmp, '-list', '-admin')); ?>
&cmd=delete&page=<?php echo $this->_tpl_vars['page']; ?>
" method="post" name="form1" id="form1">
<table border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
	<tr class="row-box-head">
<?php if ($this->_tpl_vars['dataset']['showcheckbox']): ?>	
	  	<td width="10" height="34"><input type="checkbox" name="allbox" onclick="checkAll(document.forms['form1'])" /></td>
<?php endif; ?>
		<td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?php $_from = $this->_tpl_vars['dataset']['header']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
		<td class="<?php echo $this->_tpl_vars['item']['class']; ?>
" width="<?php echo $this->_tpl_vars['item']['width']; ?>
" <?php echo $this->_tpl_vars['item']['property']; ?>
><?php echo $this->_tpl_vars['item']['text']; ?>
</td>
<?php endforeach; endif; unset($_from); ?>
<?php if ($this->_tpl_vars['dataset']['button']): ?>
		<td style="vertical-align:middle" width="10">&nbsp;</td>
<?php endif; ?>		
	</tr>
<?php $_from = $this->_tpl_vars['dataset']['result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<tr class="row-box" id="rowId<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
">
	<?php if ($this->_tpl_vars['dataset']['showcheckbox']): ?>
		<td><input type="checkbox" value="<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
" name="frm_listid[]" onClick="checkCheckedAll(document.forms['form1'])" /></td>
	<?php endif; ?>
		<td>
			<img src="../images/icons/16x16/<?php if ($this->_tpl_vars['item']['xpriority'] == 'normal'): ?>spacer.gif<?php elseif ($this->_tpl_vars['item']['xpriority'] == 'high'): ?>mail-priority-high.png<?php else: ?>mail-priority-low.png<?php endif; ?>" width="16" height="16" alt="" border="0" align="right" />
			<img src="../images/icons/16x16/<?php if ($this->_tpl_vars['item']['xattachment']): ?>mail-attach.png<?php else: ?>spacer.gif<?php endif; ?>" width="16" height="16" alt="" border="0" align="right" />
			<img src="../images/icons/16x16/<?php if ($this->_tpl_vars['item']['xuserbodystatus'] == 'read'): ?>mail-read.png<?php else: ?>mail-unread.png<?php endif; ?>" width="16" height="16" alt="" border="0" align="right" />
		</td>
	<?php $_from = $this->_tpl_vars['dataset']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['item2']):
?>		
		<td class="<?php echo $this->_tpl_vars['item2']['class']; ?>
" <?php echo $this->_tpl_vars['item2']['property']; ?>
><?php echo smarty_function_eval(array('var' => $this->_tpl_vars['item2']['text'],'assign' => 'result'), $this);?>
<?php echo ((is_array($_tmp=@$this->_tpl_vars['result'])) ? $this->_run_mod_handler('default', true, $_tmp, '--') : smarty_modifier_default($_tmp, '--')); ?>
</td>
	<?php endforeach; endif; unset($_from); ?>
	<?php if ($this->_tpl_vars['dataset']['button']): ?>
		<td style="vertical-align: middle; padding: 0; border: 0; width: 10px; height: 19px;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
		<?php if ($this->_tpl_vars['dataset']['button']['delete']): ?>				
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray" style="height: 18px; width: 18px; float: right;">
					<a title="Delete" href="javascript:void(0);" onclick="doDelete('<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
', this);">
						<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="Delete" /></a></div></td>
		<?php endif; ?>
			</tr>
		</table></td>
	<?php endif; ?>	
	</tr>
<?php endforeach; else: ?>
	<tr>
		<td colspan="70" height="48" align="center" style="vertical-align: middle">There is no message to display. &nbsp;</td>
	</tr>	
<?php endif; unset($_from); ?>
</table>
</form>
</td>
</tr>
</table>
<?php if ($this->_tpl_vars['dataset']['showcheckbox']): ?>	
	<div dir="ltr" style="float: right">
		<div class="button-ex-gray"><a title="Delete selected items." href="javascript:void(0)" onclick="if(checkCheckedAll(document.forms['form1'])==0) { alert('Please select an item to delete.'); return false; } if(confirm('Do you want to delete this messages?')) document.forms['form1'].submit()">
			<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="Delete selected items." /></a>					
		</div>
	</div>
<?php endif; ?>
<div dir="ltr" align="left">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_paging.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- <?php if ($this->_tpl_vars['popup']): ?> -->
</div>
</body>
</html>
<!-- <?php endif; ?> -->