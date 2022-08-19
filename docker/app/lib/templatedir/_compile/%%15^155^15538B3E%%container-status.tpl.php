<?php /* Smarty version 2.6.18, created on 2008-12-09 22:41:22
         compiled from container-status.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'regex_replace', 'container-status.tpl', 11, false),array('modifier', 'default', 'container-status.tpl', 22, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="main-title1">
Container List
</div>
<div class="main-title2">
</div> 
<div>
<form name="form1" id="form1" method="post" action="index.php?section=admin&module=container-status&cmd=update&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
" enctype="multipart/form-data">
<table border="0" cellpadding="0" width="100%">
<tr>
<td colspan="3"><input type="checkbox" <?php if ($_GET['reached'] == 'true'): ?>checked=checked<?php endif; ?> onclick="document.location.href='<?php echo ((is_array($_tmp=$this->_tpl_vars['href'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, '/&amp;reached=[^&]*/', '') : smarty_modifier_regex_replace($_tmp, '/&amp;reached=[^&]*/', '')); ?>
&reached='+this.checked">&nbsp;Display reached containers</td>
</tr>
<tr class="row-box-head">
<td>Container No / Proj No</td>
<td>Customer</td>
<td>Shipping</td>
<td>Truck</td>
</tr>
<?php $_from = $this->_tpl_vars['containerlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
<tr>
<td class="list-box" style="vertical-align: middle; width: 1px" nowrap="nowrap">
	<?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['xprojectcontainer'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

	<input type="hidden" name="frm_transportcontainerid[]" value="<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
">
</td>
<td class="list-box" style="vertical-align: middle; width: 33%">
	<table style="background-color: <?php echo $this->_tpl_vars['item']['xcustomercolor']; ?>
; width: 100%">
	 <tr>
	  <td>Start Date:</td>
	  <td><input type="text" name="frm_customerstartdate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="frm_customerstartdate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xcustomerstartdate']; ?>
" style="width: 70px" />
		<a href="javascript:void(0)" onClick="return showCalendar('frm_customerstartdate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
	 </tr>
	 <tr>
	  <td>Free Time:</td>
	  <td><input type="text" name="frm_customerfreetime<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="frm_customerfreetime<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xcustomerfreetime']; ?>
" style="width: 70px;" /></td>
	 </tr>
	 <tr>
	  <td>Status:</td><td><?php echo $this->_tpl_vars['item']['xcustomerstatus']; ?>
</td>
	 </tr> 
	 <tr>
	  <td>Reached:</td><td><input type="checkbox" <?php if ($this->_tpl_vars['item']['xcustomerreached']): ?>checked="checked"<?php endif; ?> value="1" name="frm_customerreached<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" class="cl_reached<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" onChange="if(this.checked){$$('.cl_returndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
').each(function(el){el.style.display='table-row'}); $$('.cl_reached<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
').each(function(el){el.checked='checked'})}else{$('customerreturndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
').style.display='none'}" /></td>
	 </tr>  
	 <tr style="<?php if (! $this->_tpl_vars['item']['xcustomerreached']): ?>display: none<?php endif; ?>" class="cl_returndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="customerreturndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
">
	  <td>Return Date:</td>
	  <td><input type="text" name="frm_customerreturndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="frm_customerreturndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" class="cl_returndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xcustomerrejectdate']; ?>
" style="width: 70px" />
		<a href="javascript:void(0)" onClick="return showCalendar('frm_customerreturndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
	 </tr>
	</table>
</td>

<td class="list-box" style="vertical-align: middle; width: 33%">
	<table style="background-color: <?php echo $this->_tpl_vars['item']['xshippingcolor']; ?>
; width: 100%">
	 <tr>
	  <td>Start Date:</td>
	  <td><input type="text" name="frm_shippingstartdate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="frm_shippingstartdate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xshippingstartdate']; ?>
" style="width: 70px" />
		<a href="javascript:void(0)" onClick="return showCalendar('frm_shippingstartdate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
	 </tr>
	 <tr>
	  <td>Free Time:</td>
	  <td><input type="text" name="frm_shippingfreetime<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="frm_shippingfreetime<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xshippingfreetime']; ?>
" style="width: 70px" /></td>
	 </tr>
	 <tr>
	  <td>Status:</td><td><?php echo $this->_tpl_vars['item']['xshippingstatus']; ?>
</td>
	 </tr>
	 <tr>
	  <td>Reached:</td><td><input type="checkbox" <?php if ($this->_tpl_vars['item']['xshippingreached']): ?>checked="checked"<?php endif; ?> value="1" name="frm_shippingreached<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
"  class="cl_reached<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
"  onchange="if(this.checked){$$('.cl_returndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
').each(function(el){el.style.display='table-row'}); $$('.cl_reached<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
').each(function(el){el.checked='checked'})}else{$('shippingreturndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
').style.display='none'}"/></td>
	 </tr> 
	 <tr style="<?php if (! $this->_tpl_vars['item']['xshippingreached']): ?>display: none<?php endif; ?>" class="cl_returndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="shippingreturndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
">
	  <td>Return Date:</td>
	  <td><input type="text" name="frm_shippingreturndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="frm_shippingreturndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" class="cl_returndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xshippingrejectdate']; ?>
" style="width: 70px" />
		<a href="javascript:void(0)" onClick="return showCalendar('frm_shippingreturndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
	 </tr>
	</table>
</td>
<td class="list-box" style="vertical-align: middle; width: 33%">
	<table style="background-color: <?php echo $this->_tpl_vars['item']['xtruckcolor']; ?>
; width: 100%">
	 <tr>
	  <td>Start Date:</td>
	  <td><input type="text" name="frm_truckstartdate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="frm_truckstartdate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xtruckstartdate']; ?>
" style="width: 70px" />
		<a href="javascript:void(0)" onClick="return showCalendar('frm_truckstartdate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
	 </tr>
	 <tr>
	  <td>Free Time:</td>
	  <td><input type="text" name="frm_truckfreetime<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="frm_truckfreetime<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xtruckfreetime']; ?>
" style="width: 70px" /></td>
	 </tr>
	 <tr>
	  <td>Status:</td><td><?php echo $this->_tpl_vars['item']['xtruckstatus']; ?>
</td>
	 </tr>
	 <tr>
	  <td>Reached:</td><td><input type="checkbox" <?php if ($this->_tpl_vars['item']['xtruckreached']): ?>checked="checked"<?php endif; ?> value="1" name="frm_truckreached<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
"  class="cl_reached<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
"  onchange="if(this.checked){$$('.cl_returndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
').each(function(el){el.style.display='table-row'}); $$('.cl_reached<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
').each(function(el){el.checked='checked'})}else{$('truckreturndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
').style.display='none'}"/></td>
	 </tr> 
	 <tr style="<?php if (! $this->_tpl_vars['item']['xtruckreached']): ?>display: none<?php endif; ?>" class="cl_returndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="truckreturndate_row<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
">
	  <td>Return Date:</td>
	  <td><input type="text" name="frm_truckreturndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" id="frm_truckreturndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" class="cl_returndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xtruckrejectdate']; ?>
" style="width: 70px" />
		<a href="javascript:void(0)" onClick="return showCalendar('frm_truckreturndate<?php echo $this->_tpl_vars['item']['xtransportcontainerid']; ?>
', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a></td>
	 </tr>
	</table>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<tr>
<td colspan="10">
<!-- <?php if ($this->_tpl_vars['btnModule']): ?> -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['btnModule'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- <?php else: ?> -->			
<!-- <?php endif; ?> -->
</td>
</tr>
</table>	 
</td>
</tr>
</table>
</form>
</div>
</div>