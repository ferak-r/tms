<?php /* Smarty version 2.6.18, created on 2008-12-11 09:32:31
         compiled from loading.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'loading.tpl', 186, false),)), $this); ?>
<html>
<head>
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
</head>
<body>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="left">
				Cargo List: From <?php echo $this->_tpl_vars['from']; ?>
 To <?php echo $this->_tpl_vars['to']; ?>

			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="30%" align="center">Commodity</td>
						<td width="25%" align="center">Carrier</td>
						<td width="25%" align="center">Vehicle</td>
						<td width="25%" align="center">Loading Date</td>
						<td width="1px">&nbsp;</td>
					</tr>
<?php unset($this->_sections['listID']);
$this->_sections['listID']['name'] = 'listID';
$this->_sections['listID']['loop'] = is_array($_loop=$this->_tpl_vars['loadinglist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<td width="30%" class="list-box" style="padding: 2px;"><?php echo $this->_tpl_vars['loadinglist'][$this->_sections['listID']['index']]['xcommodity']; ?>
&nbsp;</td>
						<td width="25%" class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['loadinglist'][$this->_sections['listID']['index']]['xcarrier']; ?>
&nbsp;</td>
						<td width="25%" class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['loadinglist'][$this->_sections['listID']['index']]['xequipment']; ?>
&nbsp;</td>
						<td width="25%" class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['loadinglist'][$this->_sections['listID']['index']]['xloadingdate']; ?>
&nbsp;</td>
						<td width="1px">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Cargo" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=loading-admin&step=loading&frm_id=<?php echo $this->_tpl_vars['loadinglist'][$this->_sections['listID']['index']]['xloadingid']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&pathid=<?php echo $this->_tpl_vars['pathid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Cargo" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=loading-admin&step=loading&frm_id=<?php echo $this->_tpl_vars['loadinglist'][$this->_sections['listID']['index']]['xloadingid']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&pathid=<?php echo $this->_tpl_vars['pathid']; ?>
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
	 <td colspan="7">
	 <hr style="color: #000000;"/>
	 <br />
	 <form name="form1" id="form1" method="post" action="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=loading-admin&step=loading&cmd=<?php if ($this->_tpl_vars['id']): ?>update<?php else: ?>add<?php endif; ?>&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&pathid=<?php echo $this->_tpl_vars['pathid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
">
	  <table align="center" style="width: 100%">
	   <tr>
	   	<td width="20%" class="list-box" style="font-weight: 600">Rail </td>
	   	<td width="30%" class="list-box"><input id='israil'  <?php if ($this->_tpl_vars['default']['xisrail']): ?>checked="checked"<?php endif; ?> type="checkbox" name="frm_israil" value="1" onClick="
<?php echo '
$(\'frm_carrierid\').value = 33;
setSub(\'frm_carrierid\', \'frm_equipmentid\', optEquipment, 0);
$(\'frm_equipmentid\').value = 1;
$$(\'.rail\').each(function(el){
	if($(\'israil\').checked)
		el.removeClass(\'hidden\');
	else 
		el.addClass(\'hidden\');
});
$$(\'.nonrail\').each(function(el){
	if($(\'israil\').checked)
		el.addClass(\'hidden\');
	else 
		el.removeClass(\'hidden\');
});
'; ?>
		
		">
	   		Yes</td>
	   	<td width="20%" class="list-box" style="font-weight: 600">&nbsp;</td>
	   	<td width="30%" class="list-box">&nbsp;</td>
   	</tr>
	   	   <tr class="rail <?php if (! $this->_tpl_vars['default']['xisrail']): ?>hidden<?php endif; ?>">
	   	<td class="list-box" style="font-weight: 600">Date of Rail Code </td>
	   	<td class="list-box"><input type="text" name="frm_railcodedate" value="<?php echo $this->_tpl_vars['default']['xrailcodedate']; ?>
" id="frm_railcodedate" />
			<a href="javascript:void(0)" onClick="return showCalendar('frm_railcodedate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt=" " /></a></td>
	   	<td class="list-box" style="font-weight: 600">Wg No</td>
	   	<td class="list-box"><input type="text" name="frm_wgno" value="<?php if ($this->_tpl_vars['default']['xequipmentcat'] == 'Rail'): ?><?php echo $this->_tpl_vars['default']['xequipmentno']; ?>
<?php endif; ?>" id="frm_wgno" /></td>
   	</tr>
	   <tr class="nonrail <?php if ($this->_tpl_vars['default']['xisrail']): ?>hidden<?php endif; ?>">
		<td class="list-box" style="font-weight: 600">Carrier</td>
		<td class="list-box">
			<select name="frm_carrierid" id="frm_carrierid" style="width: 150px" onChange="setSub('frm_carrierid', 'frm_equipmentid', optEquipment, 0);">
<?php $_from = $this->_tpl_vars['carrierlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<?php if ($this->_tpl_vars['item']['xtruck'] != $this->_tpl_vars['preitem']): ?><optgroup label="<?php echo $this->_tpl_vars['item']['xtruck']; ?>
"><?php endif; ?>
	<?php $this->assign('preitem', $this->_tpl_vars['item']['xtruck']); ?>
					<option value="<?php echo $this->_tpl_vars['item']['xcarrierid']; ?>
" <?php if ($this->_tpl_vars['item']['xcarrierid'] == $this->_tpl_vars['default']['xcarrierid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']['xcarrier']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
			</select>
			<a href="javascript:void(0)" onClick="openNewWindow('index.php?section=admin&module=carrier-admin&popup=1&object=frm_carrierid')">New Carrier</a>		</td>
		<td class="list-box" style="font-weight: 600">Vehicle</td>
		<td class="list-box">
			<select name="frm_equipmentid" id="frm_equipmentid" style="width: 150px">
				<?php $_from = $this->_tpl_vars['equipmentlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xequipmentid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
			<a href="javascript:void(0)" onClick="openNewWindow('index.php?section=admin&module=equipment-admin&object=frm_equipmentid&carrierid='+$('frm_carrierid').value)">New Equipment</a>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Start Date<span style="font-weight: normal; font-size: 10px">&nbsp;(&nbsp;for carrier&nbsp;)</span></td>
		<td class="list-box">
		 <input type="text" name="frm_carrierstartdate" value="<?php echo $this->_tpl_vars['default']['xcarrierstartdate']; ?>
" id="frm_carrierstartdate" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_carrierstartdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">Free Time<span style="font-weight: normal; font-size: 10px">&nbsp;(&nbsp;for carrier&nbsp;)</span></td>
		<td class="list-box">
		 <input type="text" name="frm_carrierfreetime" value="<?php echo $this->_tpl_vars['default']['xcarrierfreetime']; ?>
" id="frm_carrierfreetime" />		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Loading Date</td>
		<td class="list-box">
		 <input type="text" name="frm_loadingdate" value="<?php echo $this->_tpl_vars['default']['xloadingdate']; ?>
" id="frm_loadingdate" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_loadingdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">Penalty</td>
		<td class="list-box">
			<select name="frm_penalty" style="width: 150px">
				<?php $_from = $this->_tpl_vars['penalty']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xpenalty']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">ATD From Arrival Port/Border</span></td>
		<td class="list-box">
		 <input type="text" name="frm_atdarrivalport" value="<?php echo $this->_tpl_vars['default']['xatdarrivalport']; ?>
" id="frm_atdarrivalport" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_atdarrivalport', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">Receiving Arrival Notice</td>
		<td class="list-box">
		 <input type="text" name="frm_etaarrivalport" value="<?php echo $this->_tpl_vars['default']['xetaarrivalport']; ?>
" id="frm_etaarrivalport" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_etaarrivalport', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">ATD From Exit Port/Border</td>
		<td class="list-box">
		 <input type="text" name="frm_atdexitport" value="<?php echo $this->_tpl_vars['default']['xatdexitport']; ?>
" id="frm_atdexitport" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_atdexitport', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">ATA Exit Port/Border</span></td>
		<td class="list-box">
		 <input type="text" name="frm_etaexitport" value="<?php echo $this->_tpl_vars['default']['xetaexitport']; ?>
" id="frm_etaexitport" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_etaexitport', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">ATD Final Destination</td>
		<td class="list-box">
		 <input type="text" name="frm_atddestination" value="<?php echo $this->_tpl_vars['default']['xatddestination']; ?>
" id="frm_atddestination" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_atddestination', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
		<td class="list-box" style="font-weight: 600">ATA Final Destination</span></td>
		<td class="list-box">
		 <input type="text" name="frm_etadestination" value="<?php echo $this->_tpl_vars['default']['xetadestination']; ?>
" id="frm_etadestination" />
		 <a href="javascript:void(0)" onClick="return showCalendar('frm_etadestination', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Last Status</td>
		<td class="list-box" colspan="3">
		 <textarea name="frm_laststatus" style="width: 500px; height: 100px" /><?php echo $this->_tpl_vars['default']['xlaststatus']; ?>
</textarea>		</td>
	   </tr>
	   <tr>
	    <td class="list-box" colspan="6">
		 <table style="width: 50%; border: 1px solid #000000;" align="right">
		  <th style="font-size: 12px">Container List</th>
		  <tr class="row-box-head">
		   <td>Container</td>
		   <td>Weight <span style="font-size: 10px">(Kg)</span></td>
		   <td>Real Weight <span style="font-size: 10px">(Kg)</span></td>
		   <td><input type="checkbox" onClick="$$('.cntr').each(function(el){el.checked=form1.checkAllCntr.checked})" name="checkAllCntr"/></td>
		  </tr>
		  <?php unset($this->_sections['listID']);
$this->_sections['listID']['name'] = 'listID';
$this->_sections['listID']['loop'] = is_array($_loop=$this->_tpl_vars['containerlist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			 <td class="list-box"><?php echo ((is_array($_tmp=@$this->_tpl_vars['containerlist'][$this->_sections['listID']['index']]['xcommodity'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
			 <td class="list-box"><?php echo ((is_array($_tmp=@$this->_tpl_vars['containerlist'][$this->_sections['listID']['index']]['xcargoweight'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</td>
			 <td class="list-box"><?php $this->assign('x', $this->_tpl_vars['containerlist'][$this->_sections['listID']['index']]['xtransportcontainerid']); ?><input type="text" name="frm_extraweight<?php echo $this->_tpl_vars['x']; ?>
" value="<?php if ($this->_tpl_vars['default'][$this->_tpl_vars['x']]['containerid']): ?><?php echo $this->_tpl_vars['default'][$this->_tpl_vars['x']]['extraweight']; ?>
<?php else: ?><?php echo $this->_tpl_vars['containerlist'][$this->_sections['listID']['index']]['xcargoweight']; ?>
<?php endif; ?>" style="width: 50px" onKeyPress="document.getElementById('frm_container'+<?php echo $this->_tpl_vars['containerlist'][$this->_sections['listID']['index']]['xtransportcontainerid']; ?>
).checked='checked'" ></td>
			 <td class="list-box" align="center">
			  <?php $this->assign('x', $this->_tpl_vars['containerlist'][$this->_sections['listID']['index']]['xtransportcontainerid']); ?>
			  <input type="checkbox" name="frm_container[]" id="frm_container<?php echo $this->_tpl_vars['containerlist'][$this->_sections['listID']['index']]['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['containerlist'][$this->_sections['listID']['index']]['xtransportcontainerid']; ?>
" class="cntr" <?php if ($this->_tpl_vars['default'][$this->_tpl_vars['x']]['containerid']): ?>checked="checked"<?php endif; ?>/></td>
			</tr>
		  <?php endfor; else: ?>
		  	<tr><td colspan="6">There is not any unloaded container.</td></tr>
		  <?php endif; ?>
		 </table>
		 <table style="width: 50%; border: 1px solid #000000;" align="left">
		  <th style="font-size: 12px;">Bulk List</th>
		  <tr class="row-box-head">
		   <td>Commodity</td>
		   <td nowrap="nowrap">Wheight <span style="font-size: 10px">(Kg)</span></td>
		   <td><input type="checkbox" onClick="$$('.blk').each(function(el){el.checked=form1.checkAllBlk.checked})"  name="checkAllBlk" /></td>
		  </tr>
		  <?php unset($this->_sections['listID']);
$this->_sections['listID']['name'] = 'listID';
$this->_sections['listID']['loop'] = is_array($_loop=$this->_tpl_vars['bulklist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			 <td class="list-box"><?php echo ((is_array($_tmp=@$this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xcommodity'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
			 <td class="list-box" nowrap="nowrap"><?php $this->assign('x', $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xtransportcontainerid']); ?><input type="text" name="frm_weight<?php echo $this->_tpl_vars['x']; ?>
" value="<?php if ($this->_tpl_vars['default'][$this->_tpl_vars['x']]['containerid']): ?><?php echo $this->_tpl_vars['default'][$this->_tpl_vars['x']]['weight']; ?>
<?php else: ?><?php echo $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xunloadedcargoweight']; ?>
<?php endif; ?>" style="width: 50px; float: left;" onKeyPress="document.getElementById('frm_bulk'+<?php echo $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xtransportcontainerid']; ?>
).checked='checked'" onKeyUp="if(!this.value.match(/^[0-9,.]+$/))this.value=''; <?php if ($this->_tpl_vars['default'][$this->_tpl_vars['x']]['containerid']): ?>if(this.value><?php echo $this->_tpl_vars['default'][$this->_tpl_vars['x']]['weight']+$this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xunloadedcargoweight']; ?>
)this.value=<?php echo $this->_tpl_vars['default'][$this->_tpl_vars['x']]['weight']+$this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xunloadedcargoweight']; ?>
<?php else: ?>if(this.value><?php echo $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xunloadedcargoweight']; ?>
)this.value=<?php echo $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xunloadedcargoweight']; ?>
<?php endif; ?>"/>
			  <span style="font-size: 10px; vertical-align: middle">&nbsp;(&nbsp;total: <?php echo $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xcargoweight']; ?>
&nbsp;)&nbsp;</span>
			  <span style="font-size: 10px; vertical-align: middle">(&nbsp;Real Weight: <input type="text" name="frm_extraweight<?php echo $this->_tpl_vars['x']; ?>
" value="<?php if ($this->_tpl_vars['default'][$this->_tpl_vars['x']]['extraweight']): ?><?php echo $this->_tpl_vars['default'][$this->_tpl_vars['x']]['extraweight']; ?>
<?php else: ?><?php echo $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xcargoweight']; ?>
<?php endif; ?>" style="width: 50px; height: 15px; font-size: 10px; vertical-align: middle" onKeyPress="document.getElementById('frm_bulk'+<?php echo $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xtransportcontainerid']; ?>
).checked='checked'" />&nbsp;)</span>			 </td>
			 <td class="list-box" align="center"><input type="checkbox" name="frm_bulk[]" id="frm_bulk<?php echo $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xtransportcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['bulklist'][$this->_sections['listID']['index']]['xtransportcontainerid']; ?>
" class="blk" <?php if ($this->_tpl_vars['default'][$this->_tpl_vars['x']]['containerid']): ?>checked="checked"<?php endif; ?>/></td>
			</tr>
		  <?php endfor; else: ?>
		  	<tr><td colspan="6">There is not any unloaded bulk.</td></tr>
		  <?php endif; ?>
		 </table>		</td>
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
<script type="text/javascript">
setSub('frm_carrierid', 'frm_equipmentid', optEquipment, 0, <?php if ($this->_tpl_vars['default']['xequipmentid']): ?><?php echo $this->_tpl_vars['default']['xequipmentid']; ?>
<?php else: ?>null<?php endif; ?>);
</script>
</body>
</html>

