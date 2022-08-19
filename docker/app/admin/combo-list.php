<?PHP
# JUST CHANGE THE FOLLOWING ARRAY 
$combolist['port'] 				= 'Ports';
$combolist['city']	    		= 'Cities';
$combolist['document'] 			= 'Cargo Documents';
$combolist['document2']			= 'Transport Documents';
$combolist['containertype'] 	= 'Container Type';
$combolist['containersize'] 	= 'Container Size';
$combolist['packagetype'] 		= 'Package Type';
$combolist['equipmenttype'] 	= 'Equipment Type';
$combolist['equipmentquantity'] = 'Equipment Quantity';
$combolist['bondtype'] 			= 'Bond Type';

$tplModule = "combo-list.tpl";
//###samarty
$smarty->assign_by_ref('combolist', $combolist);
?>