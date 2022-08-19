<?php /* Smarty version 2.6.18, created on 2008-12-08 03:11:41
         compiled from admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'admin.tpl', 100, false),)), $this); ?>
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
<?php if ($this->_tpl_vars['object']): ?>
<script language="javascript" type="text/javascript">
<!--
	<?php if ($this->_tpl_vars['newcustomer']['xcustomerid']): ?>
		window.opener.window.setTimeout('idx=$("<?php echo $this->_tpl_vars['object']; ?>
").options.length; $("frm_shipperid").options[idx] = new Option("<?php echo $this->_tpl_vars['newcustomer']['xname']; ?>
 <?php echo $this->_tpl_vars['newcustomer']['xfamily']; ?>
", "<?php echo $this->_tpl_vars['newcustomer']['xcustomerid']; ?>
"); $("frm_consigneeid").options[idx] = new Option("<?php echo $this->_tpl_vars['newcustomer']['xname']; ?>
 <?php echo $this->_tpl_vars['newcustomer']['xfamily']; ?>
", "<?php echo $this->_tpl_vars['newcustomer']['xcustomerid']; ?>
"); $("<?php echo $this->_tpl_vars['object']; ?>
").selectedIndex = idx;', 100);
	<?php elseif ($this->_tpl_vars['newoffice']['xofficeid']): ?>
		window.opener.window.setTimeout('idx=$("<?php echo $this->_tpl_vars['object']; ?>
").options.length; $("frm_senderofficeid").options[idx] = new Option("<?php echo $this->_tpl_vars['newoffice']['xoffice']; ?>
", "<?php echo $this->_tpl_vars['newoffice']['xofficeid']; ?>
"); $("frm_receiverofficeid").options[idx] = new Option("<?php echo $this->_tpl_vars['newoffice']['xoffice']; ?>
", "<?php echo $this->_tpl_vars['newoffice']['xofficeid']; ?>
"); $("<?php echo $this->_tpl_vars['object']; ?>
").selectedIndex = idx;', 100);
	<?php elseif ($this->_tpl_vars['newcarrier']['xcarrierid']): ?>
		window.opener.window.setTimeout('idx=$("<?php echo $this->_tpl_vars['object']; ?>
").options.length; $("frm_carrierid").options[idx] = new Option("<?php echo $this->_tpl_vars['newcarrier']['xcarrier']; ?>
", "<?php echo $this->_tpl_vars['newcarrier']['xcarrierid']; ?>
"); $("<?php echo $this->_tpl_vars['object']; ?>
").selectedIndex = idx;', 100);
	<?php elseif ($this->_tpl_vars['newequipment']['xequipmentid']): ?>
		//optEquipment[<?php echo $this->_tpl_vars['newequipment']['xcarrierid']; ?>
][optEquipment[<?php echo $this->_tpl_vars['newequipment']['xcarrierid']; ?>
].length-1] = "<?php echo $this->_tpl_vars['newequipment']['xequipmentid']; ?>
*:-)<?php echo $this->_tpl_vars['newequipment']['xequipment']; ?>
";
		if(window.opener.$('frm_carrierid').value == <?php echo $this->_tpl_vars['newequipment']['xcarrierid']; ?>
)
			{
				window.opener.window.setTimeout('idx=$("<?php echo $this->_tpl_vars['object']; ?>
").options.length; $("frm_equipmentid").options[idx] = new Option("<?php echo $this->_tpl_vars['newequipment']['xequipment']; ?>
", "<?php echo $this->_tpl_vars['newequipment']['xequipmentid']; ?>
"); $("<?php echo $this->_tpl_vars['object']; ?>
").selectedIndex = idx;', 100);
			}
	<?php endif; ?>	
	window.close();
-->
</script>
<div align="center" style="padding:50px;">
	<input type="button" value=" Exit " onclick="window.close();" />
</div>
<?php endif; ?>
<script type="text/javascript">
<?php if ($_GET['refreshparent'] == 'doc'): ?>
	window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=transport-admin&step=document&cmd=docoutput&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
', { update:'doc_span' , method:'get', evalScripts:true }).request();", 100);
<?php else: ?>
	<?php if ($_GET['refreshparent'] == 'cargo'): ?>
		window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=transport-admin&step=document&cmd=cargooutput&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
', { update:'cargo_span' , method:'get', evalScripts:true }).request();", 100);
	<?php else: ?>
		<?php if ($_GET['refreshparent'] == 'equipment'): ?>
			window.opener.window.setTimeout("new Ajax('index.php?section=admin&module=carrier-admin&step=equipment&cmd=equipmentoutput&carrierid=<?php echo $this->_tpl_vars['carrierid']; ?>
', { update:'equipment_span' , method:'get', evalScripts:true }).request();", 100);
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
</script>

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
function getRowNumber(obj) // return row number of an object in admin rows 
{
	obj = findObject(obj);
	if(typeof(obj)==\'object\'){
		var p = obj;
		while(p = p.parentNode){
			if(p.id && p.id.match(/adminRow_.+/ig)) {
				return p.id.replace(/adminRow_/ig, \'\');
			}	
		}
	}	
	return false;
}

function doNew(){
	document.location = newHref;
}
'; ?>

//-->
</script>
<form <?php echo $this->_tpl_vars['formData']['attributes']; ?>
>
<?php echo $this->_tpl_vars['formData']['hidden']; ?>

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
	
<?php $_from = $this->_tpl_vars['formData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>	
<?php if ($this->_tpl_vars['item']['type'] == 'text' || $this->_tpl_vars['item']['type'] == 'textarea' || $this->_tpl_vars['item']['type'] == 'radio' || $this->_tpl_vars['item']['type'] == 'checkbox' || $this->_tpl_vars['item']['type'] == 'select' || $this->_tpl_vars['item']['type'] == 'group' || $this->_tpl_vars['item']['type'] == 'file' || $this->_tpl_vars['item']['type'] == 'image' || $this->_tpl_vars['item']['type'] == 'password' || $this->_tpl_vars['item']['type'] == 'link' || $this->_tpl_vars['item']['type'] == 'static'): ?>
  <?php if ($this->_tpl_vars['item']['type'] == 'static' && $this->_tpl_vars['item']['label'] == '[tpl]'): ?>
	<tr id="adminRow_<?php echo smarty_function_counter(array('name' => 'adminRow'), $this);?>
">
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap></td>
		<td class="list-box" width="90%" dir="ltr"><div class="form-input"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['item']['html'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div></td>
	</tr>	
  <?php else: ?>	 
	<tr id="adminRow_<?php echo smarty_function_counter(array('name' => 'adminRow'), $this);?>
">
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap><div class="form-title"><?php echo $this->_tpl_vars['item']['label']; ?>
&nbsp;</div></td>
		<td class="list-box" width="90%" dir="ltr"><div class="form-input"><?php echo $this->_tpl_vars['item']['html']; ?>
</div></td>
	</tr>
  <?php endif; ?>	
<?php endif; ?>	
<?php endforeach; endif; unset($_from); ?>
<?php echo $this->_smarty_vars['capture']['buttons']; ?>

	</table>
		</td>
<?php if (! $this->_tpl_vars['popup']): ?>		
		<td width="319px" class="list-box" style="background-color: #fff; padding: 3px;" valign="top" align="center">&nbsp;
<?php $_from = $this->_tpl_vars['extModule']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ext'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ext']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['ext']['iteration']++;
?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['item'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if (! ($this->_foreach['ext']['iteration'] == $this->_foreach['ext']['total'])): ?>
		<hr style="color: #000000"/>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
	  </td>
<?php endif; ?>	
	</tr>
</table>
<input type="submit" style="display: none;" />
</form>	
<script  language="javascript" type="text/javascript">
<?php if ($_GET['popupwin']): ?>
openNewWindow("index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=<?php echo $this->_tpl_vars['module']; ?>
&step=<?php echo $_GET['popupwin']; ?>
&transportid=<?php echo $this->_tpl_vars['id']; ?>
&carrierid=<?php echo $this->_tpl_vars['id']; ?>
&popup=1", 500, 520);
<?php endif; ?>
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
<script language="javascript" type="text/javascript">
<?php $_from = $this->_tpl_vars['P']['js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
//--------
<?php echo $this->_tpl_vars['item']; ?>
;
//--------
<?php endforeach; endif; unset($_from); ?>
</script>
</body>
</html>
<!-- <?php endif; ?> -->