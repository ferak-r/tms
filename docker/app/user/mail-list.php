
<?php
//### fetch variable
$prefix		= $section."/".$module;
$sortby		= @$_COOKIE[$prefix."_sortby"];
$sortorder	= @$_COOKIE[$prefix."_order"];
$filter = '';
$cmd = @empty($_REQUEST['cmd'])? 'inbox' : $_REQUEST['cmd'];

//### sort
$sortorder = (@$sortorder == "asc") ? "ASC" : "DESC";
$sort = '';
if(!empty($sortby) and preg_match('/^[-a-z0-9_]+$/i', $sortby) and is_int(array_search($sortby, $field))){
	$sort = "x$sortby";
}

//### rowset columns
$btn = array();
switch($cmd){
	case 'inbox':
		$btn = array('view'			=> "index.php?section=$section&module=mail-admin&cmd=view&frm_id=",
					 'delete'		=> "index.php?section=$section&module=mail-admin&cmd=delete&frm_id=",
					 );
		$col[] = array('{xfrom}', 	'15%',	'msgfrom',	'from');
		break;
	case 'sent':
		$btn = array('view'			=> "index.php?section=$section&module=mail-admin&cmd=view&frm_id=",
			 		'delete'		=> "index.php?section=$section&module=mail-admin&cmd=delete&frm_id=",
			 );
		$col[] = array('<div dir="ltr" align="left">{xto|truncate:20:"...":false}</div>', 	'15%',	'msgto',	'to');
		break;
	case 'draft':
		$btn = array('view'			=> "index.php?section=$section&module=mail-admin&cmd=edit&frm_id=",
			 		'delete'		=> "index.php?section=$section&module=mail-admin&cmd=delete&frm_id=",
			 );	
		$col[] = array('<div dir="ltr" align="left">{xto|truncate:20:"...":false}</div>', 	'15%',	'msgto',	'to');
		break;
}
$col[] = array('<a href="'.$btn['view'].'{xuserbodyid}">{xsubject} - <span style=color:#999999>{xbody}</span></a>', '68%', 'msgbody', 'subject');
$col[] = array('<span dir="ltr" >{xtime}</span>', 	'17%',	'msgtime',	'time');

foreach($col as $val){
	if(!empty($val[3]))
		$field[] = $val[3];
}
$res = $mail->$cmd(1);
$numrow  = $res['numrow'];
$maxpage = $res['maxpage'];
$curpage = (!empty($_REQUEST['page'])) ? min(intval($_REQUEST['page']),$maxpage) : 1;
$page = ($curpage - 1) * $mailconfig['maxrow'];

//### fetch list
$list = $mail->$cmd(0, $sort, $sortorder, $page);

if(!empty($list)){
	foreach($list as $key => $val){
		//$list[$key]['xtime'] = @fa_normalize_jdate($val['xtime'])." ".fa_normalize(date("H:i:s", strtotime($val['xtime'])),true);
		$list[$key]['xsubject'] = ($val['xuserbodystatus']=='unread')? "<b>".$val['xsubject']."</b>": $val['xsubject'];
	}
}
//### row set
$rowset->reset($list, 'xuserbodyid', $prefix, $sortby, $sortorder, "sortASC", "sortDESC", array_flip($btn), true);
foreach($col as $key=>$val){
	@$rowset->addCol($msg['filed'][$val[2]], $val[0], $val[1], $val[3]);
}
$smarty->assign('dataset', $rowset->renderDataset());

$tplModule = "mail-list.tpl";
//### smarty
$smarty->assign_by_ref('title2', $cmd);
$smarty->assign_by_ref('page', $curpage);
$smarty->assign_by_ref('maxpage', $maxpage);
$smarty->assign('hideSearchButton', 1);
trace($smarty->_tpl_vars);
?>