<?php /* Smarty version 2.6.18, created on 2008-12-09 19:15:17
         compiled from transport-document-comment.tpl */ ?>
<html>
<head>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
</head>
<body>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="right">
				Comment List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="100%" align="center">Comment</td>
						<td width="16">&nbsp;</td>
					</tr>
<?php unset($this->_sections['listID']);
$this->_sections['listID']['name'] = 'listID';
$this->_sections['listID']['loop'] = is_array($_loop=$this->_tpl_vars['commentlist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<td width="30%" class="list-box" style="padding: 2px;"><?php echo $this->_tpl_vars['commentlist'][$this->_sections['listID']['index']]['xtransportcomment']; ?>
&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Comment" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=documentcomment&frm_id=<?php echo $this->_tpl_vars['commentlist'][$this->_sections['listID']['index']]['xtransportcommentid']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&type=<?php echo $_GET['type']; ?>
">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Comment" href="javascript:void(0)" onClick="if(confirm('Are you sure?')){document.location.href='index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=documentcomment&cmd=delete&frm_id=<?php echo $this->_tpl_vars['commentlist'][$this->_sections['listID']['index']]['xtransportcommentid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&type=<?php echo $_GET['type']; ?>
'}">
									<img border="0" src="../images/icons/16x16/delete.png" width="17" height="16" alt="" /></a></div></td>
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
	 <td colspan="4">
	 <hr style="color: #000000"/>
	 <form name="form1" method="post" action="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=documentcomment&cmd=<?php if ($this->_tpl_vars['id']): ?>update<?php else: ?>add<?php endif; ?>&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&cargoid=<?php echo $this->_tpl_vars['cargoid']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&type=<?php echo $_GET['type']; ?>
">
	  <table align="center">
	   <tr>
		<td class="list-box" style="font-weight: 600; vertical-align: middle">Comment</td><td class="list-box"><textarea name="frm_transportcomment" /><?php echo $this->_tpl_vars['default']['xtransportcomment']; ?>
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
				<div class="button-ex-gray" style="margin: 3px;"><a title="Set Defaults" href="javascript:<?php if ($this->_tpl_vars['reloadonreset']): ?>document.location.reload()<?php else: ?>document.forms['form1'].reset()<?php endif; ?>;" onClick="return confirm('Do you want to load default values?');">
			<img border="0" src="../images/icons/48x48/refreshen.png" width="48" height="48" alt="Set Defaults" /></a>			</div>
				<div class="button-ex-gray" style="margin: 3px;"><a title="Save and Continue" href="#" onClick="<?php if ($this->_tpl_vars['id']): ?>form1.cmd.value='update';<?php endif; ?>if(event.ctrlKey) document.forms['form1'].target='_blank'; document.forms['form1'].submit();">
			<img border="0" src="../images/icons/48x48/oken.png" width="48" height="48" alt="Save and Continue" /></a>			</div>
<!-- <?php endif; ?> -->			</td>
	   </tr>
	  </table>
	  </form>
	 </td>
	 
	</tr>
</table>
			</div>
</div>
</body>
</html>