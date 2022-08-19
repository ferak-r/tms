<?php /* Smarty version 2.6.18, created on 2008-12-09 19:08:24
         compiled from transport-cargo-ext.tpl */ ?>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<span id="cargo_span">
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td width="32">
					<div class="button-ex-gray" style="width: 32px; height: 32px; float: none;"><a title="New Cargo" href="#" onclick='<?php if (! $this->_tpl_vars['id']): ?>form1.action=form1.action+"&newcargo=1"; form1.submit();<?php else: ?>openNewWindow("index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=cargo&transportid=<?php echo $this->_tpl_vars['id']; ?>
", 500, 520);<?php endif; ?>'>
				<img border="0" src="../images/icons/32x32/newen.png" width="32" height="32" alt="" /></a></div>
					</td>
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
						<td width="50%" align="center">Commodity</td>
						<td width="20%" align="center" nowrap="nowrap">Carrying Type</td>
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
						<td width="30%" class="list-box" style="padding: 2px;"><?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xcommodity']; ?>
&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" nowrap><?php if ($this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xcarrytype'] == 'Container'): ?><?php echo ($this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xcarrytype'])."(".($this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xcontainernumber']).")"; ?>
<?php else: ?><?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xcarrytype']; ?>
<?php endif; ?>&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
				
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Cargo" href="javascript:void(0)" onclick='openNewWindow("index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=cargo&frm_id=<?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xtransportcontainerid']; ?>
&transportid=<?php echo $this->_tpl_vars['id']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&carrytype=<?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xcarrytype']; ?>
", 500, 520);'>
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Cargo" href="javascript:void(0)" onclick="if(confirm('Are you sure?')){document.location.href='index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=cargo&cmd=delete&popup=<?php echo $this->_tpl_vars['popup']; ?>
&transportid=<?php echo $this->_tpl_vars['id']; ?>
&frm_id=<?php echo $this->_tpl_vars['cargolist'][$this->_sections['listID']['index']]['xtransportcontainerid']; ?>
&carrytype=Container'}">
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
				</table>
			</div>
</div>
</span>
