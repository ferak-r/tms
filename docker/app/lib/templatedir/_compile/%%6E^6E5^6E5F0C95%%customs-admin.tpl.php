<?php /* Smarty version 2.6.18, created on 2008-12-09 19:28:01
         compiled from customs-admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'customs-admin.tpl', 43, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<div class="main-title1">
Project No: <?php echo $this->_tpl_vars['transportcode']; ?>

</div>
<div class="main-title2">
Customs Section
</div> 
<?php $this->assign('g', "account&customs"); ?>
<?php if ($this->_tpl_vars['user']->group[$this->_tpl_vars['g']] || $this->_tpl_vars['user']->group['admin']): ?>
<div align="center">
<span  id="finished_div" style="margin: 4px; width: 16px;"></span>
<input type="button" id="customs_finished" value="<?php if ($this->_tpl_vars['default']['xcustomsfinished'] == 1): ?>Customs Closed<?php else: ?>Customs Not Closed<?php endif; ?>" class="<?php if ($this->_tpl_vars['default']['xcustomsfinished'] == 1): ?>btn-finished<?php else: ?>btn-notfinished<?php endif; ?>" onclick="new ajax('index.php?section=operation&module=transport-admin&step=finished&cmd=customs&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
', {update: 'finished_div', evalScripts: true}).request();" /></div>
<?php endif; ?>
<br>
<div>
<div>
<form name="form1" id="form1" method="post" action="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=customs-admin&page=<?php echo $this->_tpl_vars['page']; ?>
&cmd=update&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
" enctype="multipart/form-data">
<table border="0" cellpadding="0" width="100%">
<?php unset($this->_sections['listID']);
$this->_sections['listID']['name'] = 'listID';
$this->_sections['listID']['loop'] = is_array($_loop=$this->_tpl_vars['list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<tr  class="list_row">
		<td class="list-box">		
			<div class="list-title" onmouseover="this.className='list-title-over'" onmouseout="this.className='list-title'" onclick="swapView('<?php echo $this->_tpl_vars['list'][$this->_sections['listID']['index']]['xloadingid']; ?>
')">					
<?php if ($this->_tpl_vars['list'][$this->_sections['listID']['index']]['load']): ?>
					<a href="javascript:void(0);" style="float: left; margin: 4px;"><img src="../images/btn-more.png" id="icon<?php echo $this->_tpl_vars['list'][$this->_sections['listID']['index']]['xloadingid']; ?>
" width="24" height="24" border="0" alt="" /></a>
<?php else: ?>
					<div style="display: inline; float: left; margin: 4px; width: 24px; height: 24px;"></div>
<?php endif; ?>
					<a href="javascript:void(0);" onclick=" swapView('<?php echo $this->_tpl_vars['list'][$this->_sections['listID']['index']]['xloadingid']; ?>
'); showDetail('carrier', 'loading-equipment', '<?php echo $this->_tpl_vars['list'][$this->_sections['listID']['index']]['xloadingid']; ?>
', this)" style="margin-top: 8px; float: left;"><?php echo $this->_tpl_vars['list'][$this->_sections['listID']['index']]['xequipment']; ?>
 : <?php echo $this->_tpl_vars['list'][$this->_sections['listID']['index']]['xfromcity']; ?>
- <?php echo $this->_tpl_vars['list'][$this->_sections['listID']['index']]['xtocity']; ?>
</a>
			</div>
			<div id="sub<?php echo $this->_tpl_vars['list'][$this->_sections['listID']['index']]['xloadingid']; ?>
" class="list-sub">
<?php if ($this->_tpl_vars['list'][$this->_sections['listID']['index']]['load']): ?>				
					<table border="0" cellpadding="2" cellspacing="0" width="100%">
						<tr class="row-box-head">
							<td width="40%">
						<b>Commodity</b></td>
							<td width="20%">
						<b>Weight <span style="font-size: 10px">( Kg )</span></b></td>
							<td width="20%">
						<b>Extra Weight <span style="font-size: 10px">( Kg )</span></b></td>
						</tr>
<?php $_from = $this->_tpl_vars['list'][$this->_sections['listID']['index']]['load']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>			
						<tr bgcolor="<?php echo smarty_function_cycle(array('values' => '#F7FAEE,#F1F7FE'), $this);?>
" style="height: 32px;" class="transport_row">
							<td dir="ltr" align="left"><?php echo $this->_tpl_vars['item']['xcommodity']; ?>
</td>
							<td dir="ltr" align="left"><?php echo $this->_tpl_vars['item']['xweight']; ?>
&nbsp;<?php if ($this->_tpl_vars['item']['xcarrytype'] == 'Bulk'): ?><span style="font-size: 10px">( total: <?php echo $this->_tpl_vars['item']['xcargoweight']; ?>
 )<?php endif; ?></td>
							<td dir="ltr" align="left"><input type="text" name="frm_extraweight<?php echo $this->_tpl_vars['item']['xloadingcontainerid']; ?>
" value="<?php echo $this->_tpl_vars['item']['xextraweight']; ?>
" style="width: 100px" /></td>
						</tr>
<?php endforeach; endif; unset($_from); ?>
					</table>
<?php endif; ?>						
			</div>		
		</td>
	</tr>
<?php endfor; endif; ?>
	<tr>
	 <td colspan="7">
	 <hr style="color: #000000;"/>
	 <br />
	  <table align="center" style="width: 100%">
	   <tr>
		<td class="list-box" style="font-weight: 600">Transit License No</td>
		<td class="list-box">
			<input type="text" name="frm_tlno" value="<?php echo $this->_tpl_vars['default']['xtlno']; ?>
" />
		</td>
		<td class="list-box" style="font-weight: 600">Transit License Date</td>
		<td class="list-box">
		 <input type="text" name="frm_tldate" value="<?php echo $this->_tpl_vars['default']['xtldate']; ?>
" id="frm_tldate" />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_tldate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Border Row  No</td>
		<td class="list-box">
		 <input type="text" name="frm_cotazhno" value="<?php echo $this->_tpl_vars['default']['xcotazhno']; ?>
" />
		</td>
		<td class="list-box" style="font-weight: 600">Bonds No</td>
		<td class="list-box">
		 <textarea name="frm_insuranceno"/><?php echo $this->_tpl_vars['default']['xinsuranceno']; ?>
</textarea>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Declaration Date</td>
		<td class="list-box">
		 <input type="text" name="frm_declarationdate" value="<?php echo $this->_tpl_vars['default']['xdeclarationdate']; ?>
" id="frm_declarationdate" />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_declarationdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		
		</td>
		<td class="list-box" style="font-weight: 600">RCVBL ANCMNT</td>
		<td class="list-box">
		 <select name="frm_receipt" onchange="<?php echo 'if(this.value==\'No\'){$(\'frm_receiptdate\').disabled=true;$(\'frm_receiptdate_link\').style.display=\'none\';}else{$(\'frm_receiptdate\').disabled=false;$(\'frm_receiptdate_link\').style.display=\'inline\';}'; ?>
"/>
		 <?php $_from = $this->_tpl_vars['receipt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		 	<option value="<?php echo $this->_tpl_vars['item']; ?>
" <?php if ($this->_tpl_vars['item'] == $this->_tpl_vars['default']['xreceipt']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		 <?php endforeach; endif; unset($_from); ?>
		 </select>
		</td>
	   </tr>  
	   <tr>
		<td class="list-box" style="font-weight: 600">Declaration No</td>
		<td class="list-box">
		 <input type="text" name="frm_declarationno" value="<?php echo $this->_tpl_vars['default']['xdeclarationno']; ?>
" />
		</td>
		<td class="list-box" style="font-weight: 600">RCVBL ANCMNT Date</td>
		<td class="list-box">
		 <input type="text" name="frm_receiptdate" value="<?php echo $this->_tpl_vars['default']['xreceiptdate']; ?>
" id="frm_receiptdate" <?php if ($this->_tpl_vars['default']['xreceipt'] == 'No'): ?>disabled<?php elseif (! $this->_tpl_vars['default']['xcustomsid']): ?>disabled<?php endif; ?> />
		 <a href="javascript:void(0)" onclick="return showCalendar('frm_receiptdate', 'y-mm-dd');" id="frm_receiptdate_link" <?php if ($this->_tpl_vars['default']['xreceipt'] == 'No'): ?>style='display:none'<?php elseif (! $this->_tpl_vars['default']['xcustomsid']): ?>style='display:none'<?php endif; ?>><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Origin</td>
		<td class="list-box">
		<span id="frm_origincityid_span">
		<select name="frm_origincityid" style="width: 150px" class="cl_city">
			<?php $_from = $this->_tpl_vars['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
				<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xorigincityid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
		</span>
		<input type="text" name="frm_origincity_new" dir="ltr" style="display: none" id="frm_origincityid_new" />
		<a id='frm_origincityid_ok' href="javascript:void(0)" onclick="swapLinkDisplay(form1.frm_origincityid, 'city', 1, 150)">New City</a>
		<a href="javascript:void(0)" id='frm_origincityid_cancle' onclick="swapLinkDisplay(form1.frm_origincityid, 'city', 0)" style="display: none">
			<img src="../images/icons/16x16/delete.png" border="0px"></a>
		</td>
		<td class="list-box" style="font-weight: 600">Destination</td>
		<td class="list-box">
		<span id="frm_destinationcityid_span">
		<select name="frm_destinationcityid" style="width: 150px" class="cl_city">
			<?php $_from = $this->_tpl_vars['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
				<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xdestinationcityid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
		</span>
		<input type="text" name="frm_destinationcity_new" id="frm_destinationcityid_new" dir="ltr" style="display: none" />
		<a href="javascript:void(0)" id="frm_destinationcityid_ok" onclick="swapLinkDisplay(form1.frm_destinationcityid, 'city', 1, 150)">New City</a>
		<a href="javascript:void(0)" id='frm_destinationcityid_cancle' onclick="swapLinkDisplay(form1.frm_destinationcityid, 'city', 0)" style="display: none">
			<img src="../images/icons/16x16/delete.png" border="0px"></a>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Exit Border</td>
		<td class="list-box">
		<span id="frm_viaportid_span">
		<select name="frm_viaportid" style="width: 150px">
			<?php $_from = $this->_tpl_vars['port']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
				<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xviaportid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
		</span>
		<input type="text" name="frm_viaport_new" id="frm_viaportid_new" dir="ltr" style="display: none" />
		<a href="javascript:void(0)" id="frm_viaportid_ok" onclick="swapLinkDisplay(form1.frm_viaportid, 'port', 1, 150)">New Port</a>
		<a href="javascript:void(0)" id='frm_viaportid_cancle' onclick="swapLinkDisplay(form1.frm_viaportid, 'port', 0)" style="display: none">
			<img src="../images/icons/16x16/delete.png" border="0px"></a>
		</td>
		<td class="list-box" style="font-weight: 600">Bond Type 
		</td>
		<td class="list-box">
		<select name="frm_bondtypeid" style="width: 150px" class="cl_bondtype">
			<?php $_from = $this->_tpl_vars['bondtype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
				<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xbondtypeid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>		
		</td>
	   </tr>
	   <tr>
		<td class="list-box" style="font-weight: 600">Transit Licence 1</td>
		<td class="list-box">
			<input type="file" name="frm_tlimage1" />
		</td>
		<td class="list-box" style="font-weight: 600">Transit Licence 2</td>
		<td class="list-box">
			<input type="file" name="frm_tlimage2" />
		</td>
	   </tr>
	   <?php if ($this->_tpl_vars['default']['tl1'] || $this->_tpl_vars['default']['tl2']): ?>
	   		<tr>
			<td class="list-box" align="center" colspan="2">
		   <?php if ($this->_tpl_vars['default']['tl1']): ?>
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=customs1&pic=<?php echo $this->_tpl_vars['transportid']; ?>
" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=customs1&pic=<?php echo $this->_tpl_vars['transportid']; ?>
', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&img=1">Delete</a>
			<?php endif; ?>
			</td>
			<td class="list-box" align="center" colspan="2">
		   <?php if ($this->_tpl_vars['default']['tl2']): ?>
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=customs2&pic=<?php echo $this->_tpl_vars['transportid']; ?>
" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=customs2&pic=<?php echo $this->_tpl_vars['transportid']; ?>
', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&img=2">Delete</a>
			<?php endif; ?>
			</td> 
			</tr>
	   <?php endif; ?>
	   <tr>
		<td class="list-box" style="font-weight: 600">Transit Licence 3</td>
		<td class="list-box">
			<input type="file" name="frm_tlimage3" />
		</td>
		<td class="list-box" style="font-weight: 600">Transit Licence 4</td>
		<td class="list-box">
			<input type="file" name="frm_tlimage4" />
		</td>
	   </tr>
	   <?php if ($this->_tpl_vars['default']['tl3'] || $this->_tpl_vars['default']['tl4']): ?>
		   <tr>
			<td class="list-box" align="center" colspan="2">
		   <?php if ($this->_tpl_vars['default']['tl3']): ?>
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=customs3&pic=<?php echo $this->_tpl_vars['transportid']; ?>
" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=customs3&pic=<?php echo $this->_tpl_vars['transportid']; ?>
', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&img=3">Delete</a>
			<?php endif; ?>
			</td>
			<td class="list-box" align="center" colspan="2">
		   <?php if ($this->_tpl_vars['default']['tl4']): ?>
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=customs4&pic=<?php echo $this->_tpl_vars['transportid']; ?>
" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=customs4&pic=<?php echo $this->_tpl_vars['transportid']; ?>
', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&img=4">Delete</a>
			<?php endif; ?>
			</td>
		   </tr>
	   <?php endif; ?>
	   <tr>
		<td class="list-box" style="font-weight: 600">Declaration Image</td>
		<td class="list-box">
			<input type="file" name="frm_declarationimage" />
		</td>
	   </tr>
	   <?php if ($this->_tpl_vars['default']['declaration_img']): ?>
	   <tr>
			<td class="list-box" align="center" colspan="2">
				   <img style="cursor: pointer" src="showpic.php?w=50&mh=50&module=declaration&pic=<?php echo $this->_tpl_vars['transportid']; ?>
" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&module=declaration&pic=<?php echo $this->_tpl_vars['transportid']; ?>
', 640, 480, 'noscroll'); return false;"  />
					<br />	   
				   <a href="index.php?section=account&module=customs-admin&cmd=del_img&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
&declaration=1">Delete</a>
			</td>
	   </tr>
	   <?php endif; ?>  
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
	 </td>
	</tr>
</table>
 </form>
			</div>
</div>
