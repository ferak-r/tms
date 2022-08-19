<?php /* Smarty version 2.6.18, created on 2012-05-07 11:52:13
         compiled from combo-admin.tpl */ ?>
<div id="combo_admin">
	<div id="clist">
		<select name="frm_select" id="cselect" class="cinput">
<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['item']['xid']; ?>
"><?php echo $this->_tpl_vars['item']['xid']; ?>
: <?php echo $this->_tpl_vars['item']['xname']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>	
		</select>
		<input type="button" value="Edit" onclick="cedit();" class="cbtn" />
		<input type="button" value="Delete" onclick="cdelete();" class="cbtn" />
		<input type="button" value="New" onclick="cnew();" class="cbtn" />
	</div>
	<div id="cadmin" style="display: none;">
		<table>
			<tr><td>Code</td><td>Title</tr>
			<tr>
				<td><input type="text" name="frm_id" id="cid" size="4" class="cinput" /></td>
				<td><input type="text" name="frm_name" id="cname" size="20" class="cinput" /></td>
			</tr>
			<tr><td colspan="3" align="center">
				<input type="button" value="Save" onclick="csave();" class="cbtn"/>
				<input type="button" value="Cancle" onclick="ccancel();" class="cbtn" />
			</td></tr>
		</table>
	</div>
</div>
<script language="javascript" type="text/javascript">
<?php echo '
ccmd = \'add\';
$(\'cselect\').focus();
'; ?>

</script>