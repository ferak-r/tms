<?php /* Smarty version 2.6.18, created on 2008-12-27 00:42:46
         compiled from transport-container-cargo.tpl */ ?>
<html>
<head>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<script type="text/javascript" language="javascript">
<?php if ($_GET['refreshparent'] == 'cargo'): ?>
window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=transport-admin&step=document&cmd=cargooutput&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
', { update:'cargo_span' , method:'get', evalScripts:true }).request();", 100);
<?php endif; ?>
</script>
</head>
<body>

<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
<!--				<td width="32">
					<div class="button-ex-gray" style="width: 32px; height: 32px; float: none;"><a title="New Cargo" href="index.php?section=admin&module=transport-admin&step=containercargo&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&containerid=<?php echo $this->_tpl_vars['containerid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
">
				<img border="0" src="../images/icons/32x32/newen.png" width="32" height="32" alt="" /></a></div>
				</td>-->
				
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="right">
				Cargo List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="30%" align="center">Commodity</td>
						<td width="20%" align="center">Packing Type</td>
						<td width="20%" align="center" nowrap="nowrap">Number of Packages</td>
						<td width="20%" align="center" nowrap="nowrap">Weight<small>&nbsp;(kg)&nbsp;</small></td>
						<td width="16">&nbsp;</td>
					</tr>
<?php unset($this->_sections['listID']);
$this->_sections['listID']['name'] = 'listID';
$this->_sections['listID']['loop'] = is_array($_loop=$this->_tpl_vars['cargolist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['listID']['show'] = true;
$this->_sections['listID']['max'] = $this->_sections['listID']['loop'];
$this->_sections['listID']['step'] = 1;
$this->_sections['listID']['start'] = $this->_sections['listID']['step'] > 0 ? 0 : $this->_sections['listID']['loop']-1;
if ($this->_sections['listID']['show']) {
    $this->_sections['listID']['total'] = $this->_sections['listID']['loop'];
    if ($this->_sections['listID']['total'] == 0)
        $this->_sections['listID']['show'] = false;
} else
    $this->_sections['listID']['total'] = 0;
if ($this->_sections['listID']['show']):

            for ($this->_sections['listID']['index'] = $this->_sections['listID']['start'], $this->_sections['listID']['iteration'] = 1;
                 $this->_sections['listID']['iteration'] <= $this->_sections['listID']['total'];
                 $this->_sections['listID']['index'] += $this->_sections['listID']['step'], $this->_sections['listID']['iteration']++):
$this->_sections['listID']['rownum'] = $this->_sections['listID']['iteration'];
$this->_sections['listID']['index_prev'] = $this->_sections['listID']['index'] - $this->_sections['listID']['step'];
$this->_sections['listID']['index_next'] = $this->_sections['listID']['index'] + $this->_sections['listID']['step'];
$this->_sections['listID']['first']      = ($this->_sections['listID']['iteration'] == 1);
$this->_sections['listID']['last']       = ($this->_sections['listID']['iteration'] == $this->_sections['listID']['total']);
?>					
					<tr>
						<td class="list-box" style="padding: 2px;"><?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xcommodity']; ?>
&nbsp;</td>
						<td class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xpackagetype']; ?>
&nbsp;</td>
						<td class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xpackagenumber']; ?>
&nbsp;</td>
						<td class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xcargoweight']; ?>
&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Cargo" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=containercargo&frm_id=<?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xtransportcargoid']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&containerid=<?php echo $this->_tpl_vars['containerid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Cargo" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=containercargo&frm_id=<?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xtransportcargoid']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&containerid=<?php echo $this->_tpl_vars['containerid']; ?>
&cmd=delete&popup=<?php echo $this->_tpl_vars['popup']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&delcontainercargo=1">
									<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="" /></a></div></td>
							</tr>
						</table>
						</td>
					</tr>
<?php endfor; else: ?>
	<tr>
		<td colspan="4" height="16">&nbsp;</td>
	</tr>	
<?php endif; ?>	
	<tr>
	 <td colspan="5">
	 <hr style="color: #000000"/>
	 <form name="form1" id="form1" method="post" action="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=containercargo&cmd=<?php if ($this->_tpl_vars['id']): ?>update<?php else: ?>add<?php endif; ?>&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&containerid=<?php echo $this->_tpl_vars['containerid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&carrytype=Bulk&addcontainercargo=1">
	  <table align="center">
	   <tr>
		<td class="list-box" style="font-weight: 600">Packing Type</td>
		<td class="list-box">
			<select name="frm_packagetypeid" style="width: 150px">
				<?php $_from = $this->_tpl_vars['packagetype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xpackagetypeid']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Number of Packages</td>
		<td class="list-box"><input type="text" name="frm_packagenumber" value="<?php echo $this->_tpl_vars['default']['xpackagenumber']; ?>
" /></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Commodity</td>
		<td class="list-box"><input type="text" name="frm_commodity" value="<?php echo $this->_tpl_vars['default']['xcommodity']; ?>
" /></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Kind</td>
		<td class="list-box">
			<select name="frm_cargokind" style="width: 150px">
				<?php $_from = $this->_tpl_vars['cargokind']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xcargokind']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Size</td>
		<td class="list-box">
			<select name="frm_cargosize" style="width: 150px">
				<?php $_from = $this->_tpl_vars['cargosize']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xcargosize']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Danger Level</td>
		<td class="list-box">
			<select name="frm_cargodanger" style="width: 150px">
				<?php $_from = $this->_tpl_vars['cargodanger']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xcargodanger']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">IMO</td>
		<td class="list-box"><input type="text" name="frm_imo" value="<?php echo $this->_tpl_vars['default']['ximo']; ?>
" /></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Cargo Weight</td>
		<td class="list-box"><input type="text" name="frm_cargoweight" value="<?php echo $this->_tpl_vars['default']['xcargoweight']; ?>
" /> Kg</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Cargo Volume</td>
		<td class="list-box"><input type="text" name="frm_cargovolume"  value="<?php echo $this->_tpl_vars['default']['xcargovolume']; ?>
" /> M<sup>3</sup></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Cargo Dimension (L*W*H)</td>
		<td class="list-box"><input type="text" name="frm_cargodimension"  value="<?php echo $this->_tpl_vars['default']['xcargodimension']; ?>
" /></td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Description</td>
		<td class="list-box"><textarea name="frm_cargodescription" style="width: 200px" /><?php echo $this->_tpl_vars['default']['xcargodescription']; ?>
</textarea></td>
	   </tr>


	   <tr>
		<td width="90%" class="list-box" style="padding-bottom: 3px;" colspan="2">	
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
	  </form>
	 </td>
	 
	</tr>
</table>
			</div>
</div>
<script type="text/javascript">
<?php if ($_GET['loadformvalues']): ?>
loadForm('form1', '<?php echo $this->_tpl_vars['section']; ?>
/<?php echo $this->_tpl_vars['module']; ?>
/<?php echo $this->_tpl_vars['step']; ?>
/<?php echo $this->_tpl_vars['carrytype']; ?>
');
<?php endif; ?>
</script>
</body>
</html>

