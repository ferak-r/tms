<?php /* Smarty version 2.6.18, created on 2008-12-26 23:58:35
         compiled from _list-search.tpl */ ?>
<table border="0" cellspacing="0" cellpadding="3" class="search-input"> <!---->
<?php if ($this->_tpl_vars['module'] == 'transport-list'): ?>
  <tr>
    <td>Project No:</td><td><input name="zf_like_xtransportcode" value="<?php echo $this->_tpl_vars['zf_like_xtransportcode']; ?>
" type="text" /></td>
    <td>From:</td><td>
		<select name="zf_eq_xfromcityid" /><option></option>
		<?php $_from = $this->_tpl_vars['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xfromcityid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
    <td>To:</td><td>
		<select name="zf_eq_xtocityid" /><option></option>
		<?php $_from = $this->_tpl_vars['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xtocityid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
    <td>Exit Border:</td><td>
		<select name="zf_eq_xviaportid" /><option></option>
		<?php $_from = $this->_tpl_vars['port']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xviaportid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>	
  </tr>
  <tr>
  	<td>Shipping Line/Carrier:</td><td>
		<select name="zf_eq_xcarrierid" /><option></option>
		<?php $_from = $this->_tpl_vars['carrier']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xcarrierid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>	
  	<td>Transport Type:</td><td>
		<select name="zf_eq_xtransporttype" /><option></option>
		<?php $_from = $this->_tpl_vars['transporttype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['item']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xtransporttype'] == $this->_tpl_vars['item']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>	
  	<td>Kind Of Transport:</td><td>
		<select name="zf_like_xtransportmethod" /><option></option>
		<?php $_from = $this->_tpl_vars['transportmethod']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['item']; ?>
" <?php if ($this->_tpl_vars['zf_like_xtransportmethod'] == $this->_tpl_vars['item']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
  	<td>Arrival Port/Border:</td><td>
		<select name="zf_eq_xarrivalportid" /><option></option>
		<?php $_from = $this->_tpl_vars['port']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xarrivalportid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
  </tr>
  <tr>
  	<td>Shipper:</td><td>
		<select name="zf_eq_xshipperid" /><option></option>
		<?php $_from = $this->_tpl_vars['customer']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xshipperid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
  	<td>Consignee:</td><td>
		<select name="zf_eq_xconsigneeid" /><option></option>
		<?php $_from = $this->_tpl_vars['customer']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xconsigneeid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
  	<td>Sender Office:</td><td>
		<select name="zf_eq_xsenderofficeid" /><option></option>
		<?php $_from = $this->_tpl_vars['office']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xsenderofficeid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
  	<td>Reciever Office:</td><td>
		<select name="zf_eq_xreceiverofficeid" /><option></option>
		<?php $_from = $this->_tpl_vars['office']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xreceiverofficeid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
  </tr>
  <tr>
   	<td>Transit License No:</td><td><input name="zf_like_xtlno" value="<?php echo $this->_tpl_vars['zf_like_xtlno']; ?>
" type="text" /></td>
  	<td>Border Row No:</td><td><input name="zf_like_xcotazhno" value="<?php echo $this->_tpl_vars['zf_like_xcotazhno']; ?>
" type="text" /></td>
  	<td>Bond No:</td><td><input name="zf_like_xinsuranceno" value="<?php echo $this->_tpl_vars['zf_like_xinsuranceno']; ?>
" type="text" /></td>
	<td>Container No:</td><td><input name="zf_like_xcontainerno" value="<?php echo $this->_tpl_vars['zf_like_xcontainerno']; ?>
" type="text" /></td>
  </tr>
  <tr>
  	<td>BL No:</td><td><input name="zf_like_xdocumentnumber" value="<?php echo $this->_tpl_vars['zf_like_xdocumentnumber']; ?>
" type="text" /></td>
  </tr>
<?php elseif ($this->_tpl_vars['module'] == 'customer-list'): ?>
  <tr>
    <td>Name:</td><td><input name="zf_like_xname" value="<?php echo $this->_tpl_vars['zf_like_xname']; ?>
" type="text" /></td>
    <td>Family:</td><td><input name="zf_like_xfamily" value="<?php echo $this->_tpl_vars['zf_like_xfamily']; ?>
" type="text" /></td>
	<td>Company:</td><td><input name="zf_like_xcompany" value="<?php echo $this->_tpl_vars['zf_like_xcompany']; ?>
" type="text" /></td>
    <td>Country:</td><td>
		<select name="zf_eq_xcountryid" /><option></option>
		<?php $_from = $this->_tpl_vars['country']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xcountryid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
    <td>City:</td><td><input name="zf_like_xcity" value="<?php echo $this->_tpl_vars['zf_like_xcity']; ?>
" type="text" /></td>	
  </tr>
<?php elseif ($this->_tpl_vars['module'] == 'carrier-list'): ?>
  <tr>
    <td>Company Name:</td><td><input name="zf_like_xcarrier" value="<?php echo $this->_tpl_vars['zf_like_xcarrier']; ?>
" type="text" /></td>
    <td>Company Manager:</td><td><input name="zf_like_xmanager" value="<?php echo $this->_tpl_vars['zf_like_xmanager']; ?>
" type="text" /></td>
	<td>Responsible:</td><td><input name="zf_like_xresponsible" value="<?php echo $this->_tpl_vars['zf_like_xresponsible']; ?>
" type="text" /></td>
  </tr>
<?php elseif ($this->_tpl_vars['module'] == 'equipment-list'): ?>
  <tr>
    <td>Equipment Name:</td><td><input name="zf_like_xequipment" value="<?php echo $this->_tpl_vars['zf_like_xequipment']; ?>
" type="text" /></td>
    <td>Equipment No:</td><td><input name="zf_eq_xequipmentno" value="<?php echo $this->_tpl_vars['zf_eq_xequipmentno']; ?>
" type="text" /></td>
	<td>Category:</td><td>
		<select name="zf_eq_xequipmentcat" /><option></option>
		<?php $_from = $this->_tpl_vars['equipmentcat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['item']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xequipmentcat'] == $this->_tpl_vars['item']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
	<td>Owner:</td><td><input name="zf_like_xcarrier" value="<?php echo $this->_tpl_vars['zf_like_xcarrier']; ?>
" type="text" /></td>
  </tr>
<?php elseif ($this->_tpl_vars['module'] == 'container-list'): ?>
  <tr>
    <td>Container Number:</td><td><input name="zf_eq_xcontainernumber" value="<?php echo $this->_tpl_vars['zf_eq_xcontainernumber']; ?>
" type="text" /></td>
    <td>Container Type:</td><td>
		<select name="zf_eq_xcontainertypeid" /><option></option>
		<?php $_from = $this->_tpl_vars['containertype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xcontainertypeid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
	<td>Container Size:</td><td>
		<select name="zf_eq_xcontainersizeid" /><option></option>
		<?php $_from = $this->_tpl_vars['containersize']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xcontainersizeid'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
	<td>
		<select name="zf_eq_xown" /><option></option>
		<?php $_from = $this->_tpl_vars['own']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['item']; ?>
" <?php if ($this->_tpl_vars['zf_eq_xown'] == $this->_tpl_vars['item']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
	<td>Owner:</td><td><input name="zf_like_xcarrier" value="<?php echo $this->_tpl_vars['zf_like_xcarrier']; ?>
" type="text" /></td>
  </tr>
<?php elseif ($this->_tpl_vars['module'] == 'container-lend-list'): ?>
  <tr>
	<td>Container No:</td><td><input name="zf_like_xcontainerno" value="<?php echo $this->_tpl_vars['zf_like_xcontainerno']; ?>
" type="text" /></td>
    <td>Party Account:</td><td><input name="zf_like_xpartyaccount" value="<?php echo $this->_tpl_vars['zf_like_xpartyaccount']; ?>
" type="text" /></td>
    <td>Lend Date:</td><td><input name="zf_eq_xlenddate" value="<?php echo $this->_tpl_vars['zf_eq_xlenddate']; ?>
" type="text" id="zf_eq_xlenddate" />
	<a href="javascript:void(0)" onClick="return showCalendar('zf_eq_xlenddate', 'y-mm-dd');"><img border="0" src="../images/calendar.png" width="16" height="16" alt="" /></a>
	</td>
  </tr>
<?php elseif ($this->_tpl_vars['module'] == 'office-list'): ?>
  <tr>
  	<td>Username:</td><td><input name="zf_like_xusername" value="<?php echo $this->_tpl_vars['zf_like_xusername']; ?>
" type="text" /></td>
    <td>Office:</td><td><input name="zf_like_xoffice" value="<?php echo $this->_tpl_vars['zf_like_xoffice']; ?>
" type="text" /></td>
  </tr>
<?php elseif ($this->_tpl_vars['module'] == 'user-list'): ?>
  <tr>
  	<td>Username:</td><td><input name="zf_like_xusername" value="<?php echo $this->_tpl_vars['zf_like_xusername']; ?>
" type="text" /></td>
    <td>Group:</td><td>
		<select name="zf_like_xgroup" /><option></option>
		<?php $_from = $this->_tpl_vars['group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['item']; ?>
" <?php if ($this->_tpl_vars['zf_like_xgroup'] == $this->_tpl_vars['item']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
	<td>Name:</td><td><input name="zf_like_xname" value="<?php echo $this->_tpl_vars['zf_like_xname']; ?>
" type="text" /></td>
	<td>Family:</td><td><input name="zf_like_xfamily" value="<?php echo $this->_tpl_vars['zf_like_xfamily']; ?>
" type="text" /></td>
  </tr>
<?php elseif ($this->_tpl_vars['module'] == 'container-status-all'): ?>
  <tr>
  	<td>Proj No:</td><td><input name="zf_like_xtransportcode" value="<?php echo $this->_tpl_vars['zf_like_xtransportcode']; ?>
" type="text" /></td>
	<td>Container No:</td><td><input name="zf_like_xcontainernumber" value="<?php echo $this->_tpl_vars['zf_like_xcontainernumber']; ?>
" type="text" /></td>
  </tr>
<?php endif; ?>
  <tr>
  	<td colspan="10" style="text-align: left">
	 <table>
	 	<tr>
		 <td>
			<input style="width: 20px" type="radio" name="zcond" value="AND" <?php if (! $this->_tpl_vars['zcond'] || $this->_tpl_vars['zcond'] == 'AND'): ?>checked="checked"<?php endif; ?>>And
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input style="width: 20px" type="radio" name="zcond" value="OR" <?php if ($this->_tpl_vars['zcond'] == 'OR'): ?>checked="checked"<?php endif; ?>>Or</option>
		 </td>
		 <td>&nbsp;&nbsp;</td>
		 <td>
			<input type="submit" style="display: none;" />
			<div class="button-ex-gray" style="margin-right: 2px; float: none; height: 16px; width:82px; margin-left: 8px;"><a title="Show Results" href="#" onclick="findObject('searchform').submit();">
			<img border="0" src="../images/admin/find.png" width="80" height="16" alt="Show Results" /></a></div>
		</td>
  	   </tr>
	 </table>
	</td>
   </tr>
 </table>