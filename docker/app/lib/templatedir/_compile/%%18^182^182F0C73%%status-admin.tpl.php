<?php /* Smarty version 2.6.18, created on 2011-02-20 10:38:49
         compiled from status-admin.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<div class="main-title1">
Change Status
</div>
<div class="main-title2">
Project No: <?php echo $this->_tpl_vars['transportcode']; ?>

</div> 
<div>
<div>
<form name="form1" id="form1" method="post" action="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=status-admin&cmd=update&id=<?php echo $_GET['id']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
" enctype="multipart/form-data">
<table border="0" cellpadding="0" width="100%">
	<tr>
	 <td colspan="7">
	  <table align="center" style="width: 100%">
	   <tr>
		<td class="list-box" style="font-weight: 600">Status</td>
		<td class="list-box">
			<table><tr>
			<?php $_from = $this->_tpl_vars['color']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
				<td style='background-color: <?php echo $this->_tpl_vars['item']['xcolornumber']; ?>
' title='<?php echo $this->_tpl_vars['item']['xstatus']; ?>
'>
					<input type='checkbox' style='width: 20px' name='frm_statuscolorid[]' value='<?php echo $this->_tpl_vars['item']['xstatuscolorid']; ?>
' <?php if ($this->_tpl_vars['default'][$this->_tpl_vars['item']['xstatuscolorid']]): ?>checked=checked<?php endif; ?>></td>
			<?php endforeach; endif; unset($_from); ?>
			</tr></table>
		</td>
	   </tr>
	   <tr>
		<td width="90%" class="list-box" style="padding-bottom: 3px;" colspan="6">	
<!-- <?php if ($this->_tpl_vars['btnModule']): ?> -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['btnModule'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- <?php else: ?> -->			
<!-- <?php endif; ?> -->			</td>
	   </tr>
	  </table>
	 </td>
	</tr>
</table>
 </form>
</div>
</div>
