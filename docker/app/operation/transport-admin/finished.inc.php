<?php
switch($cmd){
	case 'transportdocument':
		$sql = "SELECT xtransportdocumentfinished
				FROM xxtransport
				WHERE xtransportid = '$transportid'";
		$value = $db->getOne($sql);
		if($value == 1){
			$value = 0;
			$title = "Transport Documents Not Closed";
			$class = "btn-notfinished";
		}else{
			$value = 1;
			$title = "Transport Documents Closed";
			$class = "btn-finished";
		}
		$sql = "UPDATE xxtransport SET xtransportdocumentfinished = '$value' WHERE xtransportid = '$transportid'";
		$res = $db->query($sql);
		echo "<script>
				$('transportdocument_finished').value='$title';
				$('transportdocument_finished').className='$class';
			  </script>";
		die();
	break;
	case 'cargodocument':
		$sql = "SELECT xcargodocumentfinished
				FROM xxtransport
				WHERE xtransportid = '$transportid'";
		$value = $db->getOne($sql);
		if($value == 1){
			$value = 0;
			$title = "Cargo Documents Not Closed";
			$class = "btn-notfinished";
		}else{
			$value = 1;
			$title = "Cargo Documents Closed";
			$class = "btn-finished";
		}
		$sql = "UPDATE xxtransport SET xcargodocumentfinished = '$value' WHERE xtransportid = '$transportid'";
		$res = $db->query($sql);
		echo "<script>
				$('cargodocument_finished').value='$title';
				$('cargodocument_finished').className='$class';
			  </script>";
		die();
	break;
	case 'accounting':
		$sql = "SELECT xaccountingfinished
				FROM xxtransport
				WHERE xtransportid = '$transportid'";
		$value = $db->getOne($sql);
		if($value == 1){
			$value = 0;
			$title = "Accountings Not Closed";
			$class = "btn-notfinished";
		}else{
			$value = 1;
			$title = "Accountings Closed";
			$class = "btn-finished";
		}
		$sql = "UPDATE xxtransport SET xaccountingfinished = '$value' WHERE xtransportid = '$transportid'";
		$res = $db->query($sql);
		echo "<script>
				$('accounting_finished').value='$title';
				$('accounting_finished').className='$class';
			  </script>";
		die();
	break;
	case 'customs':
		$sql = "SELECT xcustomsfinished
				FROM xxtransport
				WHERE xtransportid = '$transportid'";
		$value = $db->getOne($sql);
		if($value == 1){
			$value = 0;
			$title = "Customs Not Closed";
			$class = "btn-notfinished";
		}else{
			$value = 1;
			$title = "Customs Closed";
			$class = "btn-finished";
		}
		$sql = "UPDATE xxtransport SET xcustomsfinished = '$value' WHERE xtransportid = '$transportid'";
		$res = $db->query($sql);
		echo "<script>
				$('customs_finished').value='$title';
				$('customs_finished').className='$class';
			  </script>";
		die();
	break;
	case 'operation':
		$sql = "SELECT xoperationfinished
				FROM xxtransport
				WHERE xtransportid = '$transportid'";
		$value = $db->getOne($sql);
		if($value == 1){
			$value = 0;
			$title = "Operations Not Closed";
			$class = "btn-notfinished";
		}else{
			$value = 1;
			$title = "Operations Closed";
			$class = "btn-finished";
		}
		$sql = "UPDATE xxtransport SET xoperationfinished = '$value' WHERE xtransportid = '$transportid'";
		$res = $db->query($sql);
		echo "<script>
				$('operation_finished').value='$title';
				$('operation_finished').className='$class';
			  </script>";
		die();
	break;
	case 'documentation':
		$sql = "SELECT xdocumentationfinished
				FROM xxtransport
				WHERE xtransportid = '$transportid'";
		$value = $db->getOne($sql);
		if($value == 1){
			$value = 0;
			$title = "Documentation Not Closed";
			$class = "btn-notfinished";
		}else{
			$value = 1;
			$title = "Documentation Closed";
			$class = "btn-finished";
		}
		$sql = "UPDATE xxtransport SET xdocumentationfinished = '$value' WHERE xtransportid = '$transportid'";
		$res = $db->query($sql);
		echo "<script>
				$('documentation_finished').value='$title';
				$('documentation_finished').className='$class';
			  </script>";
		die();
	break;
}
?>