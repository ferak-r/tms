<?php /* Smarty version 2.6.18, created on 2011-02-20 11:05:08
         compiled from mail-btn.tpl */ ?>
<?php if ($this->_tpl_vars['btn']['send']): ?>
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Send Message" href="<?php echo $this->_tpl_vars['btn']['send']; ?>
">
	<img border="0" src="../images/icons/48x48/senden.png" width="48" height="48" alt="Send Message" /></a>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['btn']['replay']): ?>
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Replay to Message" href="<?php echo $this->_tpl_vars['btn']['replay']; ?>
">
	<img border="0" src="../images/icons/48x48/replayen.png" width="48" height="48" alt="Replay to Message" /></a>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['btn']['forward']): ?>
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Forward Message" href="<?php echo $this->_tpl_vars['btn']['forward']; ?>
">
	<img border="0" src="../images/icons/48x48/forwarden.png" width="48" height="48" alt="Forward Message" /></a>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['btn']['savetodraft']): ?>
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Save Message" href="<?php echo $this->_tpl_vars['btn']['savetodraft']; ?>
">
	<img border="0" src="../images/icons/48x48/save.png" width="48" height="48" alt="Save Message" /></a>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['btn']['delete']): ?>
<div class="button-ex-gray" style="margin: 3px;">
	<a title="Delete Message" href="<?php echo $this->_tpl_vars['btn']['delete']; ?>
">
	<img border="0" src="../images/icons/48x48/delete.png" width="48" height="48" alt="Delete Message" /></a>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['btn']['nav']): ?>
<div class="button-ex-gray" style="margin: 3px; float:right;">
	<a title="Newer Message" href="<?php echo $this->_tpl_vars['btn']['up']; ?>
">
	<img border="0" src="../images/icons/other/up.png" width="48" height="23" alt="Newer Message" /></a>
	<a title="Older Message" href="<?php echo $this->_tpl_vars['btn']['down']; ?>
">
	<img border="0" src="../images/icons/other/down.png" width="48" height="23" alt="Older Message" /></a>
</div>
<?php endif; ?>