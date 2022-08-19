<?php /* Smarty version 2.6.18, created on 2008-12-09 20:12:31
         compiled from transport-container.tpl */ ?>
<!-- <?php if ($this->_tpl_vars['popup']): ?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body style="margin:10px;">

<div dir="ltr">
<!-- <?php endif; ?> -->
<script language="javascript" type="text/javascript">
<!--
var newHref = 'index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=<?php echo $this->_tpl_vars['module']; ?>
&step=<?php echo $this->_tpl_vars['step']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&containerid=<?php echo $this->_tpl_vars['containerid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&carrytype=<?php echo $this->_tpl_vars['carrytype']; ?>
';
<?php echo '
function doNew(){
	document.location = newHref;
}
'; ?>

<?php if ($_GET['refreshparent'] == 'cargo'): ?>
window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=transport-admin&step=document&cmd=cargooutput&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
', { update:'cargo_span' , method:'get', evalScripts:true }).request();", 100);
<?php endif; ?>
//-->
</script>
<form name="form1" id="form1" method="post" action="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&page=<?php echo $this->_tpl_vars['page']; ?>
&step=cargo&cmd=<?php if ($this->_tpl_vars['id']): ?>update<?php else: ?>add<?php endif; ?>&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&carrytype=Container">
<table border="0" cellpadding="0" cellspacing="3" width="100%" name="uuu">
	<tr>
		<td>
		<table border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF" dir="ltr">
<?php ob_start(); ?>
	<tr>
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td nowrap class="list-box">
		</td>
		<td width="90%" class="list-box" style="padding-bottom: 3px;">	
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
<?php $this->_smarty_vars['capture']['buttons'] = ob_get_contents(); ob_end_clean(); ?>
<?php echo $this->_smarty_vars['capture']['buttons']; ?>
	
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Carrying Type</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_carrytype" onchange="var href=document.location.href; document.location.href=(href.indexOf('carrytype')!='-1'?href.substr(0, href.indexOf('carrytype'))+href.substr(href.indexOf('carrytype')+20, href.length):href)+'&carrytype=Bulk'">
				<?php $_from = $this->_tpl_vars['carryingtype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xcarrytype']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
	</div></td>
</tr>
<tr id="containerCombo" style="display: table-row">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Container</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_containerid" id="frm_containerid">
				<?php $_from = $this->_tpl_vars['container']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xcontainerid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>&nbsp;<a href="#" onclick="$$('.newContainerItem').each(function(el){el.style.display='table-row';}); $('containerCombo').style.display='none'; $('frm_containerid').disabled='disabled'; ">New Container</a>
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;</td>
	<td class="list-box" nowrap><div class="form-title">&nbsp;</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		<a href="#" onclick="$$('.newContainerItem').each(function(el){el.style.display='none';}); $('containerCombo').style.display='table-row'; $('frm_containerid').disabled=false;"/>Container List</a>
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Container No</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		<input type="text" name="frm_containernumber" value="<?php echo $this->_tpl_vars['default']['xcontainernumber']; ?>
" />
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Container Type</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_containertypeid">
				<?php $_from = $this->_tpl_vars['containertype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xcontainertypeid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Container Size</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_containersizeid">
				<?php $_from = $this->_tpl_vars['containersize']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xcontainersize']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
	</div></td>
</tr>
<tr class="newContainerItem" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Type</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
			<select name="frm_own" onchange='if(this.options[selectedIndex].innerHTML == "COC")$("ownerRow").style.display="table-row";else $("ownerRow").style.display="none";'>
				<?php $_from = $this->_tpl_vars['own']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xown']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
	</div></td>
</tr>
<tr id="ownerRow" style="display: none">
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Owner</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">


			<select name="frm_carrierid" style="display: none">
				<?php $_from = $this->_tpl_vars['carrier']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xcarrierid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
			<input type="text" name="frm_carrier" />
			<a href="#" onclick="form1.frm_carrierid.disabled=false; form1.frm_carrier.disabled=false; if(form1.frm_carrierid.style.display == 'none'){ this.innerHTML = 'A Person'; form1.frm_carrierid.style.display = 'inline'; form1.frm_carrier.disabled='disabled'; form1.frm_carrier.style.display='none';}else{ this.innerHTML = 'A Company'; form1.frm_carrierid.disabled='disabled'; form1.frm_carrierid.style.display = 'none'; form1.frm_carrier.style.display='inline'; }">A Company</a>
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Start Date <br /><span style="font-weight: normal; font-size: 10px">(&nbsp;for shipping&nbsp;)</span></div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		 <input type="text" name="frm_shippingstartdate" value="<?php echo $this->_tpl_vars['default']['xshippingstartdate']; ?>
" id="frm_shippingstartdate" />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_shippingstartdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Free Time <br /><span style="font-weight: normal; font-size: 10px">(&nbsp;for shipping&nbsp;)</span></div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		 <input type="text" name="frm_shippingfreetime" value="<?php echo $this->_tpl_vars['default']['xshippingfreetime']; ?>
" id="frm_shippingfreetime" />
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Start Date <br /><span style="font-weight: normal; font-size: 10px">(&nbsp;for customer&nbsp;)</span></div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		 <input type="text" name="frm_customerstartdate" value="<?php echo $this->_tpl_vars['default']['xcustomerstartdate']; ?>
" id="frm_customerstartdate" />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_customerstartdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">Free Time <br /><span style="font-weight: normal; font-size: 10px">(&nbsp;for customer&nbsp;)</span></div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		 <input type="text" name="frm_customerfreetime" value="<?php echo $this->_tpl_vars['default']['xcustomerfreetime']; ?>
" id="frm_customerfreetime" />
	</div></td>
</tr>
<tr>
	<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
	<td class="list-box" nowrap><div class="form-title">&nbsp;</div></td>
	<td class="list-box" width="90%" dir="ltr"><div class="form-input">
		<a href="#" onclick="form1.action=form1.action+'&addcontainercargo=1'; form1.submit();"><?php if ($this->_tpl_vars['id']): ?>View Cargo<?php else: ?>Add Cargo<?php endif; ?></a>
	</div></td>
</tr>
<?php echo $this->_smarty_vars['capture']['buttons']; ?>

	</table>
		</td>
	</tr>
</table>
<input type="submit" style="display: none;" />
</form>	
<script  language="javascript" type="text/javascript">
<?php if ($_GET['loadformvalues']): ?>
loadForm('form1', '<?php echo $this->_tpl_vars['section']; ?>
/<?php echo $this->_tpl_vars['module']; ?>
/<?php echo $this->_tpl_vars['step']; ?>
/<?php echo $this->_tpl_vars['carrytype']; ?>
');
<?php endif; ?>
</script>

<!-- <?php if ($this->_tpl_vars['popup']): ?> -->
</div>
</body>
</html>
<!-- <?php endif; ?> -->