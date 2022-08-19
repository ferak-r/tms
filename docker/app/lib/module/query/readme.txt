/*****************************************************
**	name:				SMARTY_DATASET				**
**	version:			1.0							**
**	kind:				CLASS Implementation		**
**	author:				M.Molayee					**
**	edit date:			26 Aug 2006					**
**	PHP Ver.:			5+							**
******************************************************/

//	minimum system example
//	$result = $db->getall("select * from xxcity limit 21, 5 ");
//	$myset = new SMARTY_DATASET($result /* db result set */, 'xcityid' /* default id name */, array('edit','delete') /* visible btns */, true /* show checkbaxes */);
//	$myset->addCol('نام شهر' /* title */, '<a href="">{xcityid}: {xcity}</a>' /* value */, '40%' /* width */, 'headerclass', '' /* header additional */, 'rowclass', '' /* row additional */);
//	$smarty->assign('dataset', $myset->renderDataset()); // use exactly as left

//	make sql where condition =>      $where = $qobject->makeWhere('or');    //result= AND (con1 or con2 or ...)