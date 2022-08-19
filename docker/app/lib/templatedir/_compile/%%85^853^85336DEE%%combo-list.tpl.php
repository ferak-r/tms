<?php /* Smarty version 2.6.18, created on 2012-05-07 11:52:10
         compiled from combo-list.tpl */ ?>
<!--  -->
<style>
<?php echo '
#comboList INPUT.cbtn{
	background:#CCCCCC;
	border:1px solid #666666;
	width: 50px;
	font-family: Tahoma;
	font-size: 11px;
	font-weight: 600;
}
#comboList INPUT.cinput{
	border-color:#999999 #DDDDDD #DDDDDD #999999;
	border-style:solid;
	border-width:1px;
	background-color: #EFF5FF;
	color:#333333;
	font-family:Tahoma,Arial;
	font-size:9pt;
	font-weight:normal;
}
'; ?>

</style>
<div style="background-color: #FFFFFF; padding-top: 5px; border: 1px solid #F2EDE1;" id="comboList">
	<ul>
	<?php $_from = $this->_tpl_vars['combolist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	  <li><a href="javascript:void(0);" onclick="copen(this, '<?php echo $this->_tpl_vars['key']; ?>
');"><?php echo $this->_tpl_vars['item']; ?>
</a><br/></li>
	<?php endforeach; endif; unset($_from); ?>  
	</ul>
	<img src="../images/loading.gif" width="1" height="1" border="0" style="visibility: hidden;" alt="" />
</div>
<script language="javascript" type="text/javascript">
<?php echo '
var curTbl = \'\';
var oldid = 0;
function copen(obj, tbl)
{
	if(curTbl == tbl) return;
	if(curTbl){
		var preDiv = $(curTbl+\'div\');
		if(preDiv) {
			preDiv.parentNode.removeChild(preDiv);
		}
	}
	curTbl = tbl;
	divid = tbl+\'div\';
	var div = $(divid);
	if(!div) {
		var div = document.createElement(\'DIV\');
		div.id=divid;
		div.style.height = \'50px\';
		obj.parentNode.appendChild(div);
	}
	new Ajax(\'index.php?section=admin&module=combo-admin&table=\'+curTbl, { update:divid, method:\'get\', evalScripts:true } ).request();
	$(divid).innerHTML = \'<img src="../images/loading.gif" width="16" height="16" border="0" alt="loading" style="margin-right: 100px;" />\';
}

function cswap(show)
{
	if(show==\'clist\') {
		$(\'clist\').style.display=\'\';
		$(\'cadmin\').style.display=\'none\';
	} else {
		$(\'cadmin\').style.display=\'\';
		$(\'clist\').style.display=\'none\';
	}
}

function cedit()
{
	ccmd = \'update\';
	cswap(\'cadmin\');
	if($(\'cselect\').selectedIndex >= 0 ) {
		oldid = $(\'cid\').value = $(\'cselect\').value;
		$(\'cname\').value = $(\'cselect\').options[$(\'cselect\').selectedIndex].text.replace(/^[0-9]+:/ig,\'\').trim();
		$(\'cname\').focus();
	} else {
		cnew();
	}
}

function cdelete()
{
	if($(\'cselect\').selectedIndex >= 0 && confirm(\'Do you want to delete this record?\')) {
		new Ajax(\'index.php?section=admin&module=combo-admin&table=\'+curTbl+\'&cmd=delete&frm_id=\'+$(\'cselect\').value, { onComplete:creload, method:\'get\', evalScripts:true } ).request();
		$(divid).innerHTML = \'<img src="../images/loading.gif" width="16" height="16" border="0" alt="loading" style="margin-right: 100px;" />\';		
	}
}

function cnew()
{
	ccmd = \'add\';
	var maxid = 0; 
	for(var i=0; i<$(\'cselect\').options.length; i++) {
		maxid = ($(\'cselect\').options[i].value*1 > maxid) ? $(\'cselect\').options[i].value*1 : maxid;
	}
	$(\'cid\').value = maxid+1;
	$(\'cname\').value = \'\';
	cswap(\'cadmin\');
	$(\'cname\').focus();
}

function csave()
{
	if(!$(\'cid\').value.test(/^[0-9]+$/) || $(\'cid\').value*1 <= 0) {
		alert(\'Please enter correct code.\');
		$(\'cid\').focus();
		return;
	}
	new Ajax(\'index.php?section=admin&module=combo-admin&table=\'+curTbl+\'&cmd=\'+ccmd+\'&frm_id=\'+$(\'cid\').value+\'&frm_name=\'+encodeURI($(\'cname\').value)+\'&frm_oldid=\'+oldid, { onComplete:creload, method:\'get\', evalScripts:true } ).request();
	$(divid).innerHTML = \'<img src="../images/loading.gif" width="16" height="16" border="0" alt="loading" style="margin-right: 100px;" />\';	
}

function ccancel()
{
	cswap(\'clist\');
}

function creload()
{
	new Ajax(\'index.php?section=admin&module=combo-admin&table=\'+curTbl, { update:curTbl+\'div\', method:\'get\' } ).request();
}
'; ?>

</script>
<div id="debug"></div>