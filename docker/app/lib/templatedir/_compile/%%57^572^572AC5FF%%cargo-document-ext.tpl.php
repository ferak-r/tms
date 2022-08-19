<?php /* Smarty version 2.6.18, created on 2008-12-09 19:25:55
         compiled from cargo-document-ext.tpl */ ?>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<span id='doc_span'>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td width="32">
					<div class="button-ex-gray" style="width: 32px; height: 32px; float: none;"><a title="New Document" href="#" onclick='openNewWindow("index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=cargodocument-admin&transportid=<?php echo $this->_tpl_vars['id']; ?>
", 700, 450)'>
				<img border="0" src="../images/icons/32x32/newen.png" width="32" height="32" alt="" /></a></div>
					</td>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="right">
				Transport Document
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="20%" align="center" nowrap="nowrap">Document</td>
						<td width="50%" align="center">Carrier</td>
						<td width="50%" align="center">Path</td>
						<td width="16"><a href="javascript:void(0)" onclick='javascript:openNewWindow("index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=transport-admin&step=documentcomment&transportid=<?php echo $this->_tpl_vars['id']; ?>
&type=Cargodoc&popup=1")'><img border="0px" src="../images/icons/16x16/comment.png" title="Add Comment"/></a></td>
					</tr>
<?php unset($this->_sections['listID']);
$this->_sections['listID']['name'] = 'listID';
$this->_sections['listID']['loop'] = is_array($_loop=$this->_tpl_vars['documentlist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<td width="30%" class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xdocument2']; ?>
&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xcarrier']; ?>
&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;"><?php echo $this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xpath']; ?>
&nbsp;</td>
						<td width="16">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
				
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Path" href="javascript:void(0)" onclick='openNewWindow("index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=cargodocument-admin&frm_id=<?php echo $this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xloadingdocumentid']; ?>
&transportid=<?php echo $this->_tpl_vars['id']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
", 700, 450);'>
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Path" href="javascript:void(0)" onclick="if(confirm('Are you sure?')){document.location.href='index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=cargodocument-admin&frm_id=<?php echo $this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xloadingdocumentid']; ?>
&transportid=<?php echo $this->_tpl_vars['id']; ?>
&cmd=delete&popup=<?php echo $this->_tpl_vars['popup']; ?>
'}">
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
<?php if ($this->_tpl_vars['user']->group['document'] || $this->_tpl_vars['user']->group['admin']): ?>
	<tr>
		<td colspan="4" height="16" align="center">
			<div  id="finished_div" style="float: left; margin: 4px; width: 16px;"></div>
			<input type="button" id="transportdocument_finished" value="<?php if ($this->_tpl_vars['default']['frm_transportdocumentfinished'] == 1): ?>Transport Documents Closed<?php else: ?>Transport Documents Not Closed<?php endif; ?>" class="<?php if ($this->_tpl_vars['default']['frm_transportdocumentfinished'] == 1): ?>btn-finished<?php else: ?>btn-notfinished<?php endif; ?>" onclick="new ajax('index.php?section=operation&module=transport-admin&step=finished&cmd=transportdocument&transportid=<?php echo $this->_tpl_vars['id']; ?>
', {update: 'finished_div', evalScripts: true}).request();" /></td>
	</tr>
<?php endif; ?>
				</table>
			</div>
</div>
</span>
