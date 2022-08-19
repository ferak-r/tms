<?php /* Smarty version 2.6.18, created on 2008-12-09 20:07:19
         compiled from report-result.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'report-result.tpl', 25, false),array('function', 'cycle', 'report-result.tpl', 27, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="fa">
<title>Tirtash</title>
<link rel="stylesheet" type="text/css" href="../guest/script/style.css">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>

<body style="background: #FFFFFF;">
<table width="100%" border="0" bordercolor="#CCCCCC" dir="ltr" cellpadding="2">
<?php ob_start(); ?>
	<tr>
		<td width="1%" style="background-color:#000066; color:#FFFFFF; font-weight: 600; height:18px; vertical-align:middle; ">&nbsp;No&nbsp;</td>
<?php $_from = $this->_tpl_vars['showfield']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>	
		<td style="background-color:#000066; color:#FFFFFF; font-weight: 600; height:18px; vertical-align:middle; ">
			<?php echo $this->_tpl_vars['item']; ?>

		</td>
<?php endforeach; endif; unset($_from); ?>		
	</tr>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('head', ob_get_contents());ob_end_clean(); ?>	
<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>	
<?php echo smarty_function_counter(array('name' => 'rowcnt','assign' => 'cnt'), $this);?>

<?php if ($this->_tpl_vars['cnt'] == 1): ?><?php echo $this->_tpl_vars['head']; ?>
<?php endif; ?>	
	<tr style="background-color: <?php echo smarty_function_cycle(array('values' => '#FFFFFF,#F3F3F3'), $this);?>
; <?php if ($this->_tpl_vars['cnt'] == $this->_tpl_vars['maxrow']): ?><?php echo smarty_function_counter(array('name' => 'rowcnt','assign' => 'cnt','start' => 0), $this);?>
 page-break-after : always;<?php endif; ?>">
		<td>
<?php echo smarty_function_counter(array('name' => 'totalcnt'), $this);?>
			
		</td>
	<?php $_from = $this->_tpl_vars['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['item2']):
?>	
		<td>
			<?php echo $this->_tpl_vars['item2']; ?>

		</td>
	<?php endforeach; endif; unset($_from); ?>		
	</tr>	
<?php endforeach; else: ?>
	<tr>
		<td style="padding: 30px;" colspan="100" align="center"> رکوردی جهت نمایش یافت نشد.
		</td>
	</tr>
<?php endif; unset($_from); ?>
</table>
</body>
</html>