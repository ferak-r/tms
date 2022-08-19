<?php /* Smarty version 2.6.18, created on 2008-12-09 19:23:17
         compiled from transport-path.tpl */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<script type="text/javascript" language="javascript">
<?php if ($_GET['refreshparent'] == 'path'): ?>
window.opener.window.setTimeout("new Ajax('index.php?section=carrier&module=loading-admin&step=path&cmd=pathoutput&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
', { update:'path_span' , method:'get', evalScripts:true }).request();", 100);
<?php endif; ?>
</script>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="left">
				Path List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="50%" align="center">From</td>
						<td width="50%" align="center">To</td>
						<td width="16">&nbsp;</td>
					</tr>
<?php unset($this->_sections['listID']);
$this->_sections['listID']['name'] = 'listID';
$this->_sections['listID']['loop'] = is_array($_loop=$this->_tpl_vars['pathlist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<td width="50%" class="list-box" style="padding: 2px;"><?php echo $this->_tpl_vars['pathlist'][$this->_sections['listID']['index']]['xfrom']; ?>
&nbsp;</td>
						<td width="50%" class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['pathlist'][$this->_sections['listID']['index']]['xto']; ?>
&nbsp;</td>
						<td width="1%">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Path" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=loading-admin&step=path&frm_id=<?php echo $this->_tpl_vars['pathlist'][$this->_sections['listID']['index']]['xtransportpathid']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Path" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=loading-admin&step=path&frm_id=<?php echo $this->_tpl_vars['pathlist'][$this->_sections['listID']['index']]['xtransportpathid']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&cmd=delete&popup=<?php echo $this->_tpl_vars['popup']; ?>
">
									<img border="0" src="../images/icons/16x16/delete.png" width="16" height="16" alt="" /></a></div></td>
							</tr>
						</table>
						</td>
					</tr>
<?php endfor; else: ?>
	<tr>
		<td colspan="6" height="16" align="center">There is no record to display.</td>
	</tr>	
<?php endif; ?>	
	<tr>
	 <td colspan="6">
	 <hr style="color: #000000"/>
	 <br />
	 <form name="form1" id="form1" method="post" action="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=loading-admin&step=path&cmd=<?php if ($this->_tpl_vars['id']): ?>update<?php else: ?>add<?php endif; ?>&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
">
	  <table align="center" style="width: 100%">
	   <tr>
		<td class="list-box" style="font-weight: 600">From</td>
		<td class="list-box">
			<select name="frm_fromcityid" style="width: 150px">
				<?php $_from = $this->_tpl_vars['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xfromcityid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	  </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">To</td>
		<td class="list-box">
			<select name="frm_tocityid" style="width: 150px">
				<?php $_from = $this->_tpl_vars['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xtocityid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
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
	  </form>
	 </td>
	 
	</tr>
</table>
			</div>
</div>

