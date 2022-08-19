<?php /* Smarty version 2.6.18, created on 2008-12-09 18:31:29
         compiled from cargo-document.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'cargo-document.tpl', 29, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<script type="text/javascript" language="javascript">
<?php if ($_GET['refreshparent'] == 'doc'): ?>
window.opener.window.setTimeout("new Ajax('index.php?section=operation&module=cargodocument-admin&cmd=docoutput&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
', { update:'doc_span' , method:'get', evalScripts:true }).request();", 100);
<?php endif; ?>
</script>
<div>
			<table border="0" cellpadding="0" cellspacing="4" width="100%">
				<tr>
					<td style="vertical-align: bottom">
			<div style="font-weight: 600; padding: 4px;" align="left">
				Document List
			</div>
					</td>
				</tr>
			</table>
			<div>
				<table border="0" cellpadding="0" width="100%">
					<tr class="row-box-head">
						<td width="30%" align="center">Document</td>
						<td width="30%" align="center">Carrier</td>
						<td width="30%" align="center">Path</td>
						<td width="16">&nbsp;</td>
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
						<td width="30%" class="list-box" style="padding: 2px;"><?php echo $this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xdocument2']; ?>
&nbsp;</td>
						<td width="30%" class="list-box" style="padding: 2px;" nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xcarrier'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Rah Ahan') : smarty_modifier_default($_tmp, 'Rah Ahan')); ?>
</td>
						<td width="30%" class="list-box" style="padding: 2px;" nowrap><?php echo $this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xpath']; ?>
&nbsp;</td>
						<td width="1%">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px; margin-left: 2px;"><a title="Edit Document" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=cargodocument-admin&frm_id=<?php echo $this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xloadingdocumentid']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
">
									<img border="0" src="../images/icons/16x16/edit.png" width="16" height="16" alt="" /></a></div></td>
								<td>	<div class="button-ex-gray" style="width: 16px; height: 16px;"><a title="Delete Document" href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=cargodocument-admin&frm_id=<?php echo $this->_tpl_vars['documentlist'][$this->_sections['listID']['index']]['xloadingdocumentid']; ?>
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
&module=cargodocument-admin&cmd=<?php if ($this->_tpl_vars['id']): ?>update<?php else: ?>add<?php endif; ?>&frm_id=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
" enctype="multipart/form-data">
	  <table align="center" style="width: 100%">
	   <tr>
		<td class="list-box" style="font-weight: 600">Document</td>
		<td class="list-box">
			<select name="frm_document2id" style="width: 150px" onchange="
<?php echo '
var israil = this.value==4;
$(\'frm_carrierid\').value = 33;
setSub(\'frm_carrierid\', \'frm_loadingid\', optPathEquipment, 0);
$$(\'.rail\').each(function(el){
	if(israil)
		el.removeClass(\'hidden\');
	else 
		el.addClass(\'hidden\');
});
$$(\'.nonrail\').each(function(el){
	if(israil)
		el.addClass(\'hidden\');
	else 
		el.removeClass(\'hidden\');
});
'; ?>
				
			">
				<?php $_from = $this->_tpl_vars['documents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xdocument2id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>		</td>
		<td class="list-box" style="font-weight: 600" nowrap="nowrap">Document No.</td>
		<td class="list-box"><input type="text" name="frm_documentno" value="<?php echo $this->_tpl_vars['default']['xdocumentno']; ?>
" /></td>
	   </tr>
	   <tr>
		<td class="list-box nonrail <?php if ($this->_tpl_vars['default']['xdocument2id'] == 4): ?>hidden<?php endif; ?>" style="font-weight: 600">Carrier</td>
		<td class="list-box nonrail <?php if ($this->_tpl_vars['default']['xdocument2id'] == 4): ?>hidden<?php endif; ?>">
			<select id="frm_carrierid" name="frm_carrierid" style="width: 150px" onchange="setSub('frm_carrierid', 'frm_loadingid', optPathEquipment, 0);">
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
			</select>		</td>
		<td class="list-box" style="font-weight: 600">Vehicle</td>
		<td class="list-box">
			<select id="frm_loadingid" name="frm_loadingid" style="width: 250px">
				<?php $_from = $this->_tpl_vars['equipmentlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['default']['xequipmentid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>		</td>
	   </tr>
<!--	   <tr class="rail <?php if ($this->_tpl_vars['default']['xdocument2id'] != 4): ?>hidden<?php endif; ?>">
	   	<td class="list-box" style="font-weight: 600">Wg No. </td>
	   	<td width="30%" class="list-box"><input type="text" name="frm_wgno" value="<?php echo $this->_tpl_vars['default']['xwgno']; ?>
" id="frm_wgno" /></td>
	   	<td width="20%" class="list-box" style="font-weight: 600">SMGS No. </td>
	   	<td width="30%" class="list-box"><input type="text" name="frm_smgsno" value="<?php echo $this->_tpl_vars['default']['xsmgsno']; ?>
" id="frm_smgsno" /></td>
   	</tr>
	   <tr class="rail <?php if ($this->_tpl_vars['default']['xdocument2id'] != 4): ?>hidden<?php endif; ?>">
	     <td class="list-box" style="font-weight: 600">Path</td>
	     <td class="list-box">
			<select id="frm_documenttransportpathid" name="frm_documenttransportpathid" style="width: 150px" >
					<option value="<?php echo $this->_tpl_vars['item']['xtransportpathid']; ?>
" <?php if ($this->_tpl_vars['item']['xtransportpathid'] == $this->_tpl_vars['default']['xdocumenttransportpathid']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']['xfrom']; ?>
 to <?php echo $this->_tpl_vars['item']['xto']; ?>
</option>
			</select></td>
	     <td class="list-box" style="font-weight: 600">&nbsp;</td>
	     <td class="list-box">&nbsp;</td>
	     </tr>-->
	   <tr>
	   	<td class="list-box" style="font-weight: 600">Send Date</td>
	   	<td class="list-box"> <input type="text" name="frm_documentdate" id="frm_documentdate" value="<?php echo $this->_tpl_vars['default']['xdocumentdate']; ?>
" />
		 <a href="javascript:void(0);" onclick="return showCalendar('frm_documentdate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>		 </td>
	   	<td class="list-box" style="font-weight: 600">Receive Date</td>
		<td class="list-box"><input type="text" name="frm_documentdate2" id="frm_documentdate2" value="<?php echo $this->_tpl_vars['default']['xdocumentdate2']; ?>
" />
	   		<a href="javascript:void(0);" onclick="return showCalendar('frm_documentdate2', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" />		</td>
   	</tr>
	   <tr>
		<td rowspan="2" class="list-box" style="font-weight: 600">Comment</td>
		<td rowspan="2" class="list-box">
				<textarea name="frm_documentcomment" ><?php echo $this->_tpl_vars['default']['xdocumentcomment']; ?>
</textarea>		</td>
		<td class="list-box" style="font-weight: 600">Image</td>
		<td class="list-box">
			<table id="image_tbl">
				<tr><td><input type="file" name="frm_img[]" /></td></tr>
				<tr><td><a href="javascript:addrow()">More Images</a></td></tr>
			</table>
		</td>
	   </tr>
	   <tr>
		<td class="list-box" colspan="2" align="center">
		 <?php if ($this->_tpl_vars['id'] && $this->_tpl_vars['default']['img']): ?>
		 	<table><tr>
		 	<?php $_from = $this->_tpl_vars['default']['img']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
				<td>
					<?php if ($this->_tpl_vars['item']['ext'] != 'pdf'): ?>
						<img style="cursor: pointer" src="showpic.php?w=80&mh=80&module=cargodocument&pic=<?php echo $this->_tpl_vars['item']['xloadingdocumentimgid']; ?>
&folder=<?php echo $this->_tpl_vars['id']; ?>
" onclick="openNewWindow('../global/showpic.php?mw=600&mh=400&output=html&&module=cargodocument&pic=<?php echo $this->_tpl_vars['item']['xloadingdocumentimgid']; ?>
&folder=<?php echo $this->_tpl_vars['id']; ?>
', 640, 480, 'noscroll'); return false;"  />
					<?php else: ?>
						<a href="download.php?module=loadingdocument&id=<?php echo $this->_tpl_vars['item']['xloadingdocumentimgid']; ?>
&dir=document2&folder=<?php echo $this->_tpl_vars['id']; ?>
"><img src="../images/symbol-pdf.gif" style="border: 0px" /></a>
					<?php endif; ?>
				   <br />	   
				   <a href="index.php?section=<?php echo $this->_tpl_vars['section']; ?>
&module=cargodocument-admin&cmd=del_img&frm_id=<?php echo $this->_tpl_vars['item']['xloadingdocumentimgid']; ?>
&folder=<?php echo $this->_tpl_vars['id']; ?>
&transportid=<?php echo $this->_tpl_vars['transportid']; ?>
&popup=<?php echo $this->_tpl_vars['popup']; ?>
">Delete</a>
				 </td>
			<?php endforeach; endif; unset($_from); ?>
			</tr></table>
			
		 <?php endif; ?>		</td>
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
setSub('frm_carrierid', 'frm_loadingid', optPathEquipment, 0, <?php if ($this->_tpl_vars['default']['xloadingid']): ?><?php echo $this->_tpl_vars['default']['xloadingid']; ?>
<?php else: ?>null<?php endif; ?>);
</script>

<?php echo '
<Script Language="JavaScript">

function addrow(){
	var tbl = document.getElementById(\'image_tbl\');
	var lastrow = tbl.rows.length - 1;
	var row = tbl.insertRow(lastrow);

	var cell0 = row.insertCell(0);
	var el = document.createElement(\'input\');
	el.type = \'file\';
	el.name = \'frm_img[]\';
	
	cell0.appendChild(el);
}
</Script>
'; ?>

