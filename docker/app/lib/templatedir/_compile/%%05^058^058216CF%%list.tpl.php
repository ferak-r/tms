<?php /* Smarty version 2.6.18, created on 2008-12-09 11:06:18
         compiled from list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'regex_replace', 'list.tpl', 50, false),array('modifier', 'replace', 'list.tpl', 64, false),array('modifier', 'cat', 'list.tpl', 112, false),array('function', 'eval', 'list.tpl', 84, false),)), $this); ?>
<!-- <?php if ($this->_tpl_vars['popup']): ?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body style="margin:10px" dir="rtl">
<!-- <?php endif; ?> -->
<script language="javascript" type="text/javascript">
<!--
var adminModule		= String('<?php echo $this->_tpl_vars['module']; ?>
').replace(/\-list/ig, '-admin');
var editHref		= 'index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module='+adminModule+'&page=<?php echo $this->_tpl_vars['page']; ?>
&step=<?php echo $_REQUEST['step']; ?>
&filter=<?php echo $_REQUEST['filter']; ?>
&query=<?php echo $_REQUEST['query']; ?>
&frm_id=';
var deleteHref		= 'index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module='+adminModule+'&step=<?php echo $_REQUEST['step']; ?>
&cmd=delete&page=<?php echo $this->_tpl_vars['page']; ?>
&transportid=<?php echo $_REQUEST['transportid']; ?>
&companycontainer=<?php echo $_GET['companycontainer']; ?>
&frm_id=';
var newHref			= 'index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module='+adminModule+'&step=<?php echo $_REQUEST['step']; ?>
&filter=<?php echo $_REQUEST['filter']; ?>
&query=<?php echo $_REQUEST['query']; ?>
&transportid=<?php echo $_REQUEST['transportid']; ?>
&popup=<?php echo $_REQUEST['popup']; ?>
&companycontainer=<?php echo $_GET['companycontainer']; ?>
';
<?php echo '
function doEdit(id)
{
	document.location.href = editHref+id;
}

function doDelete(id, obj)
{
	if(confirm(\'Do you want to delete this record?\')) {
		ajaxDelete(deleteHref+id, \'row-box\', obj);
	}
}

function doNew()
{
	document.location = newHref;
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
<?php if (! $this->_tpl_vars['dataset']['hidenew']): ?>		
		<div class="button-ex-gray"><a title="New" href="javascript:doNew()">
		<img border="0" src="../images/icons/48x48/newen.png" width="48" height="48" alt="New" /></a></div>
<?php endif; ?>		
<?php if (! $this->_tpl_vars['hideSearchButton']): ?>
		<div class="button-ex-gray" style="margin-right: 2px;"><a title="Search" href="javascript:swapDisplay('searchbox');">
		<img border="0" src="../images/icons/48x48/searchen.png" width="48" height="48" alt="Search" /></a></div>
		<div class="button-ex-gray" style="margin-right: 2px;"><a title="Show All" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['href'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, '/&amp;query=[^&]*/', '') : smarty_modifier_regex_replace($_tmp, '/&amp;query=[^&]*/', '')); ?>
">
		<img border="0" src="../images/icons/48x48/showallen.png" width="48" height="48" alt="Show all records" /></a></div>	
<?php endif; ?>
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
<div id="searchbox" style="display: none;">
	<form action="<?php echo $this->_tpl_vars['href']; ?>
" method="post" name="searchform" id="searchform">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_list-search.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</form>
</div>
<form action="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&amp;module=<?php echo ((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('replace', true, $_tmp, '-list', '-admin') : smarty_modifier_replace($_tmp, '-list', '-admin')); ?>
&amp;cmd=delete&amp;page=<?php echo $this->_tpl_vars['cpage_num']; ?>
&amp;step=<?php echo $_GET['step']; ?>
" method="post" name="form1" id="form1">
<table border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
	<tr class="row-box-head">
<?php if ($this->_tpl_vars['dataset']['showcheckbox']): ?>	
	  	<td width="10" height="34"><input type="checkbox" name="allbox" onclick="checkAll(document.forms['form1'])" /></td>

	  	<?php endif; ?>
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
" name="frm_id[]" onClick="checkCheckedAll(document.forms['form1'])" /></td>
	<?php endif; ?>	
	<?php $_from = $this->_tpl_vars['dataset']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['item2']):
?>		
		<td class="<?php echo $this->_tpl_vars['item2']['class']; ?>
" <?php echo $this->_tpl_vars['item2']['property']; ?>
><?php echo smarty_function_eval(array('var' => $this->_tpl_vars['item2']['text'],'assign' => 'result'), $this);?>
<?php if ($this->_tpl_vars['result']): ?><?php echo $this->_tpl_vars['result']; ?>
<?php else: ?>&nbsp;<?php endif; ?></td>
	<?php endforeach; endif; unset($_from); ?>
	<?php if ($this->_tpl_vars['dataset']['button']): ?>
		<td style="vertical-align: middle; padding: 0; border: 0; width: 10px; height: 51px;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
<?php if ($this->_tpl_vars['module'] != 'transport-list'): ?>
			<tr>
		<?php if ($this->_tpl_vars['dataset']['button']['view']): ?>				
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray" style="float: right;">
					<a title="View" target="_blank" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=<?php echo ((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('replace', true, $_tmp, '-list', '-admin') : smarty_modifier_replace($_tmp, '-list', '-admin')); ?>
&cmd=favorresult&frm_id=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
">
						<img border="0" src="../images/icons/48x48/view.png" width="48" height="48" alt="View" /></a></div></td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dataset']['button']['edit']): ?>				
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray" style="float: right;">
					<a title="Edit" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=<?php echo ((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('replace', true, $_tmp, '-list', '-admin') : smarty_modifier_replace($_tmp, '-list', '-admin')); ?>
&page=<?php echo $this->_tpl_vars['page']; ?>
&step=<?php echo $_REQUEST['step']; ?>
&filter=<?php echo $_REQUEST['filter']; ?>
&query=<?php echo $_REQUEST['query']; ?>
&frm_id=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
&transportid=<?php echo $_REQUEST['transportid']; ?>
&popup=<?php echo $_REQUEST['popup']; ?>
&archive=<?php echo $_REQUEST['archive']; ?>
&companycontainer=<?php echo $_GET['companycontainer']; ?>
">
						<img border="0" src="../images/icons/48x48/edit.png" width="48" height="48" alt="Edit" /></a></div></td>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['dataset']['button']['delete']): ?>				
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray" style="float: right;">
					<a title="Delete" href="javascript:void(0);" onclick="doDelete('<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
', this);">
						<img border="0" src="../images/icons/48x48/delete.png" width="48" height="48" alt="Delete" /></a></div></td>
		<?php endif; ?>
			</tr>
<?php else: ?>
			<tr>				
			<?php $this->assign('tr', ((is_array($_tmp='tr')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]) : smarty_modifier_cat($_tmp, $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]))); ?>
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray2" style="float: right;">
					<a title="Edit" href="index.php?section=operation&module=transport-admin&page=<?php echo $this->_tpl_vars['page']; ?>
&step=<?php echo $_REQUEST['step']; ?>
&query=<?php echo $_REQUEST['query']; ?>
&frm_id=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
&transportid=<?php echo $_REQUEST['transportid']; ?>
">
						<img border="0" src="../images/icons/32x32/edit.png" width="32" height="32" alt="Edit" /></a></div></td>

				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="button-ex-gray2" style="float: right;">
					<a title="Delete" href="javascript: void(0)" onclick="if(confirm('Do you want to delete this record?')){ ajaxDelete('index.php?section=operation&module=transport-admin&step=<?php echo $_REQUEST['step']; ?>
&cmd=delete&page=<?php echo $this->_tpl_vars['page']; ?>
&transportid=<?php echo $_REQUEST['transportid']; ?>
&frm_id=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
', 'row-box', this);}">
						<img border="0" src="../images/icons/32x32/delete.png" width="32" height="32" alt="Delete" /></a></div></td>

			</tr>
			<tr>
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="<?php if ($this->_tpl_vars['finished']['container'][$this->_tpl_vars['tr']] == 1): ?>button-ex-green<?php else: ?>button-ex-gray2<?php endif; ?>" style="float: right;">
					<a title="Containers" href="#" onclick="openNewWindow('index.php?section=admin&module=container-status&frm_id=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
&popup=1', 1000, 500)">
						<img border="0" src="../images/icons/32x32/container.png" width="32" height="32" alt="Containers" /></a></div></td>

				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="<?php if ($this->_tpl_vars['finished']['operation'][$this->_tpl_vars['tr']] == 1): ?>button-ex-green<?php else: ?>button-ex-gray2<?php endif; ?>" style="float: right;">
					<a title="Operations" href="index.php?section=operation&module=operation-admin&frm_id=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
">
						<img border="0" src="../images/icons/32x32/operation.png" width="32" height="32" alt="Operations" /></a></div></td>
			</tr>
		<tr>
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="<?php if ($this->_tpl_vars['finished']['customs'][$this->_tpl_vars['tr']] == 1): ?>button-ex-green<?php else: ?>button-ex-gray2<?php endif; ?>" style="float: right;">
					<a title="Customs" href="#" onclick="openNewWindow('index.php?section=account&module=customs-admin&transportid=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
&popup=1', 800, 600)">
						<img border="0" src="../images/icons/32x32/customs.png" width="32" height="32" alt="Customs" /></a></div></td>

				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="<?php if ($this->_tpl_vars['finished']['accounting'][$this->_tpl_vars['tr']] == 1): ?>button-ex-green<?php else: ?>button-ex-gray2<?php endif; ?>" style="float: right;">
					<a title="Accounting" href="#" onclick="openNewWindow('index.php?section=account&module=account-list&transportid=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
&popup=1', 750, 500)">
						<img border="0" src="../images/icons/32x32/accounting.png" width="32" height="32" alt="Accounting" /></a></div></td>

			</tr>	
		<tr>
				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="<?php if ($this->_tpl_vars['finished']['cargodocument'][$this->_tpl_vars['tr']] == 1 && $this->_tpl_vars['finished']['documentation'][$this->_tpl_vars['tr']] == 1): ?>button-ex-green<?php else: ?>button-ex-gray2<?php endif; ?>" style="float: right;">
					<a title="Cargo Documents" href="index.php?section=operation&module=transport-admin&page=<?php echo $this->_tpl_vars['page']; ?>
&step=<?php echo $_REQUEST['step']; ?>
&query=<?php echo $_REQUEST['query']; ?>
&frm_id=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
&transportid=<?php echo $_REQUEST['transportid']; ?>
">
						<img border="0" src="../images/icons/32x32/cargo-docs.png" width="32" height="32" alt="Cargo Documents" /></a></div></td>

				<td style="padding: 0 1px 0 -1px; border: 0;">
					<div class="<?php if ($this->_tpl_vars['finished']['transportdocument'][$this->_tpl_vars['tr']] == 1): ?>button-ex-green<?php else: ?>button-ex-gray2<?php endif; ?>" style="float: right;">
					<a title="Transport Documents" href="index.php?section=operation&module=operation-admin&frm_id=<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['dataset']['id']]; ?>
">
						<img border="0" src="../images/icons/32x32/transport-docs.png" width="32" height="32" alt="Transport Documents" /></a></div></td>
			</tr>	

<?php endif; ?>
		</table></td>
	<?php endif; ?>	
	</tr>
<?php endforeach; else: ?>
	<tr>
		<td colspan="70" height="48" align="center" style="vertical-align: middle">There is no record to display. &nbsp;</td>
	</tr>	
<?php endif; unset($_from); ?>
<?php if ($this->_tpl_vars['module'] == 'account-list'): ?>
<tr>
	<td></td><td></td><td></td>
	<td style="height: 20px; vertical-align: middle"><span style="color:#000033">Sum:</span>&nbsp;<?php echo $this->_tpl_vars['amount']; ?>
</td>
</tr>	
<?php endif; ?>
</table>
</form>
</td>
</tr>
</table>
<?php if ($this->_tpl_vars['dataset']['showcheckbox']): ?>	
	<div dir="ltr" style="float: left">
		<div class="button-ex-gray"><a title="Delete Selected Items" href="javascript:void(0)" onclick="if(checkCheckedAll(document.forms['form1'])==0) { msg.info('Please select an item to delete.'); return false; } if(confirm('Do you want to delete this records?')) document.forms['form1'].submit()">
			<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="Delete Selected Items" /></a>					
		</div>
	</div>
<?php endif; ?>
<div dir="ltr" align="right">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_paging.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['module'] == 'account-list'): ?>
<div align="center">
<span  id="finished_div" style="margin: 4px; width: 16px;"></span>
<input type="button" id="accounting_finished" value="<?php if ($this->_tpl_vars['accountingfinished'] == 1): ?>Accountings Closed<?php else: ?>Accountings Not Closed<?php endif; ?>" class="<?php if ($this->_tpl_vars['accountingfinished'] == 1): ?>btn-finished<?php else: ?>btn-notfinished<?php endif; ?>" onclick="new ajax('index.php?section=operation&module=transport-admin&step=finished&cmd=accounting&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
', {update: 'finished_div', evalScripts: true}).request();" /></div>
<?php endif; ?>

<!-- <?php if ($this->_tpl_vars['popup']): ?> -->
</div>
</body>
</html>
<!-- <?php endif; ?> -->