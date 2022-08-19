<?
require_once('../lib/site.module.php');

$id 	= intval(@$_GET['id']);
$module = @$_GET['module'];
$dir	= @$_GET['dir'];
$field  = @$_GET['field'] ? $_GET['field'] : 'filename';
$primary= @$_GET['primary'] ? $_GET['primary'] : $module;

if(@$id && @$module && @$dir) {
	switch($module){
		case 'transportdocument':
			$sql     = "SELECT xfilename FROM xxtransportdocumentfile WHERE xtransportdocumentfileid = $id";   
			$filePath= '../' . $config['upload']["$dir"] . "/$_GET[folder]/$id";
			break;
		case 'loadingdocument':
			$sql 	  = "SELECT xloadingdocumentimg FROM xxloadingdocumentimg WHERE xloadingdocumentimgid = $id";
			$filePath = '../' . $config['upload']["$dir"] . "/$_GET[folder]/$id";
			break;
		default:	
			$sql 	  = "SELECT x{$field} FROM xx$module WHERE x{$primary}id = $id";
			$filePath = '../' . $config['upload']["$dir"] . "/$id";
	}

	$fileName 	= $db->_getOne($sql);
	$fileExt	= strtolower(substr(strrchr($fileName, '.'), 1));

	if(ini_get('zlib.output_compression')) {
		ini_set('zlib.output_compression', 'Off');
	}
}
if(file_exists($filePath)) {
	switch($fileExt) {
		case 'pdf' : $ctype = 'application/pdf'; break;
		case 'exe' : $ctype = 'application/octet-stream'; break;
		case 'zip' : $ctype = 'application/zip'; break;
		case 'rar' : $ctype = 'application/zip'; break;
		case 'doc' : $ctype = 'application/msword'; break;
		case 'xls' : $ctype = 'application/vnd.ms-excel'; break;
		case 'ppt' : $ctype = 'application/vnd.ms-powerpoint'; break;
		case 'gif' : $ctype = 'image/gif'; break;
		case 'png' : $ctype = 'image/png'; break;
		case 'jpeg':
		case 'jpg' : $ctype = 'image/jpg'; break;
		default: $ctype = 'application/force-download';
	}
	
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Cache-Control: private', false); // required for certain browsers 
	header("Content-Type: $ctype");
	header('Content-Disposition: attachment; filename="' . $fileName . '";');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($filePath));
	readfile($filePath);
	die();
} else {
	msg('فایلی موجود نمیباشد', 'error');
	redirect($_SERVER['HTTP_REFERER']);
}
?>