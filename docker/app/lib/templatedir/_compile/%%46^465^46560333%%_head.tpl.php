<?php /* Smarty version 2.6.18, created on 2008-12-08 03:11:40
         compiled from _head.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '_head.tpl', 30, false),)), $this); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="fa" />

<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
<link rel="stylesheet" href="../+script/cpanel/cpanel.css" type="text/css" />
<link rel="stylesheet" href="../+script/cpanel/tabpane.css" type="text/css" id="luna-tab-style-sheet" />
<link rel="stylesheet" href="../+script/menu/theme-en.css" type="text/css" />
<link rel="stylesheet" href="../+script/calendar/calendar-mos.css" type="text/css" />

<link rel="icon" href="../images/icon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../images/icon.ico" type="image/x-icon" />
<script type="text/javascript" src="../+script/menu/JSCookMenu_mini.js"></script>
<script type="text/javascript" src="../+script/menu/theme.js"></script>
<script type="text/javascript" src="../+script/cpanel/tabpane_mini.js"></script>
<script type="text/javascript" src="../+script/class.big.js"></script>
<script type="text/javascript" src="../+script/ajax.js"></script>
<script type="text/javascript" src="../+script/global-script.js"></script>
<script type="text/javascript" src="../+script/site-script.js"></script>
<script type="text/javascript" src="../+script/calendar/calendar-mini.js"></script>
<script type="text/javascript" src="../+script/calendar/calendar-en.js"></script>
<script type="text/javascript" src="../+script/dbs.js.php?transportid=<?php echo $this->_tpl_vars['transportid']; ?>
"></script>
<title><?php echo $this->_tpl_vars['title']; ?>
</title>

<!-- messaging system -->
<link rel="stylesheet" type="text/css" href="../+script/message/message.css" />
<script language="javascript" type="text/javascript" src="../+script/message/message.js"></script>

<script language="javascript" type="text/javascript">
<!--
msg.text = '<?php echo ((is_array($_tmp=$this->_tpl_vars['msg']['text'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
';
msg.type = '<?php echo ((is_array($_tmp=$this->_tpl_vars['msg']['type'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
';
msg.title= '<?php echo ((is_array($_tmp=$this->_tpl_vars['msg']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
';
msg.cmd  = '<?php echo ((is_array($_tmp=$this->_tpl_vars['msg']['cmd'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
';

<?php echo '

function loader()
{
	if(msg.text){
	  msg.display(msg.text, msg.type, msg.title, msg.cmd);
	}
}

'; ?>

//-->
</script>
<!-- end of messaging system -->