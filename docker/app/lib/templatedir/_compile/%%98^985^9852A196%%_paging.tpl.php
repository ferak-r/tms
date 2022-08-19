<?php /* Smarty version 2.6.18, created on 2008-12-09 11:06:18
         compiled from _paging.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', '_paging.tpl', 6, false),array('modifier', 'regex_replace', '_paging.tpl', 12, false),)), $this); ?>
<!-- Paging : Begin -->
<?php $this->assign('zpage', $this->_tpl_vars['page']); ?>
<?php echo smarty_function_math(array('equation' => "x - 1",'x' => $this->_tpl_vars['zpage'],'assign' => 'prev'), $this);?>

<?php echo smarty_function_math(array('equation' => "x + 1",'x' => $this->_tpl_vars['zpage'],'assign' => 'next'), $this);?>

<table border="0" cellspacing="0" cellpadding="0" style="width: auto">
          <tr>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
				<?php if ($this->_tpl_vars['zpage'] != 1): ?>
				<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['href'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, '/((&amp;)|(&))page=[^&]*/', '') : smarty_modifier_regex_replace($_tmp, '/((&amp;)|(&))page=[^&]*/', '')); ?>
&page=1" title="First Page"><img alt="" src="../images/nav-first-on.gif" width="7" height="9" border="0" /></a>
				<?php else: ?>
				<img alt="" src="../images/nav-first-off.gif" width="7" height="9" border="0" />
				<?php endif; ?>
			</td>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
				<?php if ($this->_tpl_vars['zpage'] != 1): ?>
				<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['href'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, '/((&amp;)|(&))page=[^&]*/', '') : smarty_modifier_regex_replace($_tmp, '/((&amp;)|(&))page=[^&]*/', '')); ?>
&page=<?php echo $this->_tpl_vars['prev']; ?>
" title="Previews Page"><img alt="" src="../images/nav-prev-on.gif" width="7" height="9" border="0" /></a>
				<?php else: ?>
				<img alt="" src="../images/nav-prev-off.gif" width="7" height="9" border="0" />
				<?php endif; ?>
			</td>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
			<select name="page" class="orderCombo" style="width: 50px; height: 15px" onchange="document.location.href='<?php echo ((is_array($_tmp=$this->_tpl_vars['href'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, '/((&amp;)|(&))page=[^&]*/', '') : smarty_modifier_regex_replace($_tmp, '/((&amp;)|(&))page=[^&]*/', '')); ?>
&page='+this.options[this.selectedIndex].value;">
<?php unset($this->_sections['cpage']);
$this->_sections['cpage']['name'] = 'cpage';
$this->_sections['cpage']['loop'] = is_array($_loop=$this->_tpl_vars['maxpage']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cpage']['show'] = true;
$this->_sections['cpage']['max'] = $this->_sections['cpage']['loop'];
$this->_sections['cpage']['step'] = 1;
$this->_sections['cpage']['start'] = $this->_sections['cpage']['step'] > 0 ? 0 : $this->_sections['cpage']['loop']-1;
if ($this->_sections['cpage']['show']) {
    $this->_sections['cpage']['total'] = $this->_sections['cpage']['loop'];
    if ($this->_sections['cpage']['total'] == 0)
        $this->_sections['cpage']['show'] = false;
} else
    $this->_sections['cpage']['total'] = 0;
if ($this->_sections['cpage']['show']):

            for ($this->_sections['cpage']['index'] = $this->_sections['cpage']['start'], $this->_sections['cpage']['iteration'] = 1;
                 $this->_sections['cpage']['iteration'] <= $this->_sections['cpage']['total'];
                 $this->_sections['cpage']['index'] += $this->_sections['cpage']['step'], $this->_sections['cpage']['iteration']++):
$this->_sections['cpage']['rownum'] = $this->_sections['cpage']['iteration'];
$this->_sections['cpage']['index_prev'] = $this->_sections['cpage']['index'] - $this->_sections['cpage']['step'];
$this->_sections['cpage']['index_next'] = $this->_sections['cpage']['index'] + $this->_sections['cpage']['step'];
$this->_sections['cpage']['first']      = ($this->_sections['cpage']['iteration'] == 1);
$this->_sections['cpage']['last']       = ($this->_sections['cpage']['iteration'] == $this->_sections['cpage']['total']);
?>
			  <option value="<?php echo $this->_sections['cpage']['iteration']; ?>
" <?php if ($this->_sections['cpage']['iteration'] == $this->_tpl_vars['zpage']): ?>selected="selected"<?php endif; ?>><?php echo $this->_sections['cpage']['iteration']; ?>
</option>
<?php endfor; endif; ?>
            </select></td>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
				<?php if ($this->_tpl_vars['zpage'] != $this->_tpl_vars['maxpage']): ?>
				<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['href'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, '/((&amp;)|(&))page=[^&]*/', '') : smarty_modifier_regex_replace($_tmp, '/((&amp;)|(&))page=[^&]*/', '')); ?>
&page=<?php echo $this->_tpl_vars['next']; ?>
" title="Next Page"><img alt="" src="../images/nav-next-on.gif" width="7" height="9" border="0" /></a>
				<?php else: ?>
				<img alt="" src="../images/nav-next-off.gif" width="7" height="9" border="0" />
				<?php endif; ?>
			</td>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
				<?php if ($this->_tpl_vars['zpage'] != $this->_tpl_vars['maxpage']): ?>
				<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['href'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, '/((&amp;)|(&))page=[^&]*/', '') : smarty_modifier_regex_replace($_tmp, '/((&amp;)|(&))page=[^&]*/', '')); ?>
&page=<?php echo $this->_tpl_vars['maxpage']; ?>
" title="Last Page"><img alt="" src="../images/nav-last-on.gif" width="7" height="9" border="0" /></a>
				<?php else: ?>
				<img alt="" src="../images/nav-last-off.gif" width="7" height="9" border="0" />
				<?php endif; ?>
			</td>
          </tr>
        </table>
<!-- Paging : End -->