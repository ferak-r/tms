<?php /* Smarty version 2.6.18, created on 2008-12-08 03:11:40
         compiled from index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</head>
<body>
<div id="container" dir="ltr">
<?php if (! $_REQUEST['popup']): ?>
	<div id="header">
		<div id="logo">
			<div class="navigation" style="visibility: hidden;">
				<a href="javascript:void(0);">تیتر اصلی</a> /
				<a href="javascript:void(0);">تیتر فرعی</a> / تیتر 2</div>
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="main_menu">
							<div id="myMenuID">
							</div>
<script type="text/javascript" src="../+script/menu/menu-items.js.php"></script>
					</td>
				</tr>
			</table>
		</div>	
	</div>
		<table border="0" cellpadding="0" cellspacing="5" width="100%" style="height: 40px">
			<tr>
				<td style="vertical-align: middle">
<?php if ($this->_tpl_vars['title1']): ?>
					<div class="main-title1">
						<?php echo $this->_tpl_vars['title1']; ?>
			
					</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['title2']): ?>
					<div class="main-title2">
						<?php echo $this->_tpl_vars['title2']; ?>
</div>
<?php endif; ?>&nbsp;
				</td>
				
				<td width="345">
					<div id="top_info">
																		Username: <span class="gray-val"><?php echo $this->_tpl_vars['user']->info['username']; ?>
</span><br />
									User Level: <span class="gray-val"><?php echo $this->_tpl_vars['groupname']; ?>
</span><br />
									New Mails: <span class="gray-val"><?php echo $this->_tpl_vars['mail']->newmail; ?>
</span>
					</div>
				</td>
			</tr>
		</table>
<?php endif; ?>		
	<table id="main" cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td>
	<table border="0" cellpadding="10" cellspacing="0" width="100%" id="main_body">
<?php if (! $this->_tpl_vars['user']->id): ?>
<?php $this->assign('tplModule', "login.tpl"); ?>
<?php endif; ?>	
<?php if ($this->_tpl_vars['tplModule']): ?>
		<tr>
			<td>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['tplModule'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>			
			</td>
		</tr>	
<?php else: ?>		
		<tr>
			<td><div id="cpanel">
		<div style="float:left;">
			<div class="icon">
				<a href="index.php?section=guest&module=login&logincmd=logout">
					<div class="iconimage" title="Logout">
							<img src="../images/icons/48x48/shutdown.png"  align="middle" name="image" border="0" width="48" height="48" alt="" />
					</div>
					Logout
				</a>
			</div>
		</div>
	</div>
			</td>
			<td width="320" nowrap>
			</td>
		</tr>
<?php endif; ?>		
	</table>
	</td>
	</tr>
	</table>
</div>
<?php if (! $_REQUEST['popup']): ?>
	<div id="footer" dir="ltr">
		© <a href="http://www.aryaweb.com" target="_blank">Aryaweb.com</a> Inc. 2006<br />
		All rights reserved.
	</div>
<?php endif; ?>
<script language="javascript" type="text/javascript" src="../+script/final-script.js"></script>
<script type="text/javascript">
<?php echo '
function checkReminder(){
	/*var sec = parseInt(new Date()/1000%60);	
	if(sec > 10) {
		checkReminder.delay(9000);
		return;
	}*/
	var d = Number(new Date());
	d = parseInt(d/10000);
	for(i=0; i<reminder.length; i++){
		if(d >= reminder[i][\'time\'] && reminder[i][\'view\'] != 1){
			var r=new Ajax("index.php?section=user&module=reminder-admin&cmd=alert&reminderid="+reminder[i][\'id\']+"&reminderindex="+i, {method: \'get\', evalScripts:true, onComplete: function(){checkReminder.delay(10000)}}).request();
			reminder[i][\'view\'] = 1;
		}
	}
	
	//check mail
	//new Ajax("index.php?section=user&module=mail-admin&cmd=newmail", {method: \'get\', evalScripts:true}).request();
	
	setTimeout(\'checkReminder()\', 10000);
}
'; ?>

<?php if ($this->_tpl_vars['user']->id): ?>
checkReminder();
<?php endif; ?>
<?php $_from = $this->_tpl_vars['P']['js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
//--------
<?php echo $this->_tpl_vars['item']; ?>
;
//--------
<?php endforeach; endif; unset($_from); ?>
</script>
</body>
</html>
