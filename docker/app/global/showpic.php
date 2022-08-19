<?PHP

//Sort*****************************************************************************************************************************
	$Sasc	=	"R0lGODlhCAAJAIAAAIu//0RERCH5BAAAAAAALAAAAAAIAAkAAAINjI8GqRzL4AGUohodKgA7";
	$Sdesc	=	"R0lGODlhCAAJAIAAAP/Ni0RERCH5BAAAAAAALAAAAAAIAAkAAAINjI8GGeDoYlqMTtYwKgA7";
	$Snone	=	"R0lGODlhCAAJAIAAAMfHx0RERCH5BAAAAAAALAAAAAAIAAkAAAIOjI8GGeDoYlowUvUmSwUAOw==";
	
	$SascW	=	"R0lGODlhCAAJAIABAIu//////yH5BAEAAAEALAAAAAAIAAkAAAINjI8GqRzL4AGUohodKgA7";
	$SdescW	=	"R0lGODlhCAAJAIABAPeuTv///yH5BAEAAAEALAAAAAAIAAkAAAINjI8GGeDoYlqMTtYwKgA7";
	$SnoneW	=	"R0lGODlhCAAJAIABADg4OP///yH5BAEAAAEALAAAAAAIAAkAAAIOjI8GGeDoYlowUvUmSwUAOw==";
	
	if(isset($_REQUEST["sortfieldicon"])){
		if(@$_REQUEST["bgcolor"]=='white'){
			$Sasc  = $SascW;
			$Sdesc = $SdescW;
			$Snone = $SnoneW;
			}
		$page = trim($_REQUEST["page"]);
		$field = trim($_REQUEST["sortfieldicon"]);
		$SortBy = ($SortBy = @$_COOKIE[str_replace(array('.', '/'), '',$page)."SortBy"])?$SortBy:"fld_id";
		$OrderForm = ($OrderForm=@$_COOKIE[str_replace(array('.', '/'), '',$page)."OrderForm"])?$OrderForm:"ASC";
	    header ('Content-Type: image/gif');
		if($SortBy == $field)
		 if($OrderForm == "ASC")	
			echo base64_decode($Sasc);
		 else	
			echo base64_decode($Sdesc);
		else
			echo base64_decode($Snone);
		die();
		
	}
	
//ICONS****************************************************************************************************************************
	$icon["edit"]	="R0lGODlhEAAQAOYAAAAAAP///9TJ0Iam6i9iyDFlzTly4j5240B240Z75Ep9406B5FaG5ViH5WWV82KO5mqZ9XGd9WyU526X53ei9n2n+Hab6Hqf6YSr+X+h6Yuw+oSl6Za5/Iuq6pSlx5qqyqCvzZqnwqa0z6KvyLG91KOnr6CkrJC1+5q9/Z/A/qLC/6u50rXB1rrF2NLX4KO0z73I2tvn+sDK2+Ps+8rS3+zy/KOyyKe2zKy4yrbB0cPO3/P3/TVJY5Oit5alup6uw5qpvm5xdWh1hW55hpums5ido7i9w9jc4ZihqlFUV8nQ1/n7/WNqb3B1d4aGff7+/e7gjLuwfdnEbOLOdLmsc7OcTde/YrWgV7emZbKaSamTUce3iJ+ck5iWkRYSDt+PcL6yrtB2XtGFc61sXqaQjZA1Nf7+/v///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAGcALAAAAAAQABAAQAfEgB2CHQMZFhIPDQsJBwcGZz1mLCQrOyAfHkpUUFJOZWQ2ZjIyMJKUlh8jOUKQPK48Q0VbU1leTa9ngxsXEw8MCggGwgYEZ0BmMC0sZisiIDMeJWNfYWORzc8hJldQVrVIPGfi42dBSQBd5OIdKikoHCcaGBUUERAODgVnN2b9/v1LdtSoMSPcj38ABc6IIWDMGDA+/gUkGENJFBxixpSJZGbiQiVYutViAmnJERc0dBipItILkRfh1J0p8kSLFy4yc+oMBAA7";


	$icon["delete"]	="R0lGODlhEgASANQPAFZQWnZ7iJ4iPq+uwahCXNsFLcbO5K6KntMqT6Jyht46Xs4XOnpWZsisxGVpdM/Y791aepKXp9qatqRcdM681rnB1bsrSdhujoBoeL5YdKqittpSdn6FkdbS6qaesgAAACH5BAEAAB8ALAAAAAASABIAAAV04CeOZGmeaKp+BUKt5FJY8NjIhHkVTflosolB1FEUJoGKbyBLGCgLBMYReZyYhUwLExioBoWZI/CxpjbhAkOpQlsAsoP55AZwPPE5CVJY2JVYciUSYQAObB8DFllDIzsCAF4lBAVVJBEOHI0kFREBmzAPjSEAOw==";
//	$icon[""]		="";
	$icon["bmp"]	="R0lGODlhEAAQAKIEAMDAwAAA/////wAAAP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAQABAAAAM9SDrcPioOQWsdIJJpbZNd+IxkYJ4oygSUKbjsG6xvXbE4Le+xSeM82WzQwwFPq5TSR2pCFqHOcxP1SJyNBAA7";
	$icon["gif"]	="R0lGODlhEAAQAKIEAMDAwACAAP///wAAAP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAQABAAAAM8SDrcPioOQWsdIJJpbZNd+IxkYJ4oypgU23pDIKSzfK5zbcstzv67wIrnyt1iqaSJxGSAQp4nlAJZNBsJADs=";
	$icon["iff"]	="R0lGODlhEAAQAKIEAMDAwP8AAP///wAAAP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAQABAAAAM7SDrcPioOQWsdIJJpbZNd+IxkYJ4oygSCabFVsLYsSpuzS+l0Xp832eAXDK5SSBxpCVmEOs3N0yNhNhIAOw==";
	$icon["jpg"]	="R0lGODlhEAAQAKIEAMDAwICAAP///wAAAP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAQABAAAAM8SDrcPioOQWsdIJJpbZNd+IxkYJ4oygQVK5yUubLma6tDXb80P/M8Gm0VE+5kuZQSSWqCQp4nlAJZNB0JADs=";
	$icon["jpeg"]	= $icon["jpg"];
	$icon["png"]	="R0lGODlhEAAQAKIEAMDAwIAAAP///wAAAP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAQABAAAAM8SDrcPioOQWsdIJJpbZNd+IxkYJ4oygSUKbjuu740zZ7ze7f2fOo2lg92Y8kGqSSOxIQsQh3nBuqRNBsJADs=";
	$icon["psd"]	="R0lGODlhEAAQAKIFAICAAMDAwP//////AAAAAP///wAAAAAAACH5BAEAAAUALAAAAAAQABAAAAM8WErcTioSQWslIZZpbZNd+IzkYJ4oygwMMAArS5jrbNNsXhOujNs3nE4XpPF8yJRSRmqCQp4nlAJZNB0JADs=";
	$icon["swc"]	="R0lGODlhEAAQAPfGAHNzc0Ngkfv7+5CSktvb22Gb7eCtcct9JvHBeTaKNKOjo5iamtHc8pudnd/m9NLk++np6b6/vqytreru+MLCwurq6r29vebx++Pq9ekYATWKMuAXAdzr/LgVBZ6Wq9LZ5rYbDsbb+IWFhnaXynh4eaVzc/nivOieM/n5+qUhFzJ7Nfb4+tCJPCgoOBo2T319fuUhA9YMARotP9zp+kiuNawuHYRfXI2NjYhUULq7vOzt7eXw/bu7u7vl//VJAZ2YqJAkIdWPUvJBBXt7fPfw4TYjL093tb/Z+s0UB6KjpNbg3b5yLbhqJ9zh5riVm69oNba4vLeXjYa08q6YmUa1M0pqnKiqqsbF3Elml8rh8vD//6zH6sfHyJWWltLX465aGPr7/MVkN42r35KkwaxZGPf393t7e5SWl6tJJEstOdLT1Judn8LjzYqMjLloHoGCgvb29ssNAdsVBOvr8vj6/qG75G2Dq6S95CxvNbkeEMO+vjArPJtBP5mbm+20YNfb5+8rAUiSSnElLJu/8cTDw1aEyuzw8BxtH5laWKJLQtLn79HR0f1gAc7P0M7Z8UVjlaaZo6JiRZqcnd7d6oim5LgrF8Tf6v714q2ur3d4eM0eCPbWopOTk8ALAkVjljU4R5626LO2vHitgMwcCcbd+/X7/v1KAejw+pWXmH+gjXp7e+Xk7+ihOM25orhnHunu+plCD9IQAeHn9dHb8UKzL4o3MtPX3vDy86AtKR5wIGaYbtjY2PlQAbhnHXl6evD4+M7Jyautrl13orGysqO95v///////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAMYALAAAAAAQABAAAAj/AI0JHEiAgoQkwXIMXEggwrA1UP7M2qFGEiYdA630CeXFgaM6dzCsENAIVRuBZ2zJYgBKzKsPY+ygAHNLlcAGdCbMoFQghLAAAZQYKmVG4IJTD0gVKjDI0yMsbET9eiOwywUOR6QYGVElgKJAKrIMEThAS49NJi4RaWWAVi4NlnyRdRLFDwIEBpYwoXIowRYSxkqAiNXhSZATZFz1ooFHF7FMUzSZEvIpTRhWX9wc8JBqFRwAfHgxQuMiTxwWsA78mCRg1w0LuAD5kLEnRYxIkK7MqaCAUxljiJAUaQFjQycbTYrxeMFlIDAggkZlkFMLgHURC40V05OoUg0chIpBBViU3VhAADs=";
	$icon["swf"]	="R0lGODlhEAAQAPeHAL6+vuPj4+3t7erq6unp6bu7u8fHx+fn52B1h////5GRkcfO1fb29uzs7HGDlcXFxVxxhK+6x9XV1Uxid4mZqe/v77m5ucPDw8LCwsTExOLm67W1te7u7oOSouXl5fX19Zajsbi4uJqntcDAwPv7+8/V3cnQ2l9zh9/f39ra2oaVpeHh4a24xNrg5NjY2GSBla+vr7PAymaFm9PT07/I0JWVlfT09Kurqxs9Wr29vfj4+vn5+X+MmMnR2+Dm6sHJ0Ly8vPLy8lpugrvFzgU2WKGhoQQxUrC5wSRVdM3NzWiFmsPL0svLy5qamuvu8HiCjPr6+iJVdba/ye7w83eGln2Mm4ybqdbW1oqitM7V3d7i5q+4wRBEZra/yI+Pj4mTndvb2+vr67KysrnCyre3tzBefQQzVQQwUoqZpxQ5V+jo6Ons8NTb4ff393CIm6ysrO/y9Ak9YNrf5NXb4pWhrVp+lq2trX+XqXaGlZKSkgQuTtXb4+bm5uDg4Ki5x7/Hz19zheTk5C1efK22vllugdnZ2YCQn////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAIcALAAAAAAQABAAAAjmAA8dKgCkgAUyBQD0EciQYY4AAVDMuLAhRJKGDAF48BBohYQMbxgYwHgIwIGTfAJcgZFAJMYRYQYMIKCmUIgaXpqkaIiBAwcBAhoMkADgRhE7PLdQmTABz6AGLpgY2NCQBwQKESJQgEBHAAEwFhiOQcCihwksgsogOFKBAACGhkTsmeMnChIZIqoEqTCCoZASGjTU4aKETRZCH2xcYHiixRQfcYgYiSEHUJsPGRhakaLjjhk3Q9Z0QQNlxwOGSzq8OJMGTgItHX6QIHGa4Rc9OGg4+aPiiYI8CsRgXADCgQMQC0geCggAOw==";
	$icon["tif"]	="R0lGODlhEAAQAKIEAMDAwAAAgP///wAAAP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAQABAAAAM7SDrcPioOQWsdIJJpbZNd+IxkYJ4oygQVS7nvyp6CWZ/yPcNmTtuqAZCnC8hSSCNpCVmEOs3N0yNhNhIAOw==";
	$icon["tiff"]	= $icon["tif"];
	$icon["unkown"]	="R0lGODlhEAAQAMQQAIAAAACAAP//AP8AAAD////MM8vLywgICOfn1lVVVYaGhgAA/5mZmczMzAAAmf///////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAABAALAAAAAAQABAAAAVeIKSMZMlAKKogbNsySSo+dF0zT6zaPJzoikdpeDAAhY6CY8k85HYKptThPAZ5D0QV+hAAaIvsdhYEDB4LwkL7JNO+j0CAbXW5xsGDfs9vX7E2QA2DhIWDOj+JiosQIQA7";

	if(isset($_REQUEST["icon"])){
	    header ('Content-Type: image/gif');
		if (array_key_exists($_REQUEST["icon"], $icon))
			echo  base64_decode($icon[$_REQUEST["icon"]]);
		else	
			echo  base64_decode($icon["unkown"]);
		die;
	}
	
	
//FUNCTIONS*********************************************  *********************************************************
	function ImageStringAlignAndWrap($image, $font, $text, $color, $maxwidth, $alignment, $y = 0)
	{
	   $fontwidth = ImageFontWidth($font);
	   $fontheight = ImageFontHeight($font);
	   if ($maxwidth != NULL) {
	   $maxcharsperline = floor($maxwidth / $fontwidth);
	   $text = wordwrap($text, $maxcharsperline, "\n", 1);
	   }
	   
	   $lines = explode("\n", $text);
	   	   
	   if ($alignment == "right") {
		   while (list($numl, $line) = each($lines)) {
				 ImageString($image, $font, imagesx($image) - $fontwidth*strlen($line), $y, $line, $color);
				 $y += $fontheight;
		   }
	   } elseif ($alignment == "center") {
		   while (list($numl, $line) = each($lines)) {
				 ImageString($image, $font, floor((imagesx($image) - $fontwidth*strlen($line))/2), $y, $line, $color);
				 $y += $fontheight;
		   }
	   } else {
		   while (list($numl, $line) = each($lines)) {
				 ImageString($image, $font, 0, $y, $line, $color);
				 $y += $fontheight;
		   }
	   }
	}
//---------------------------------------------------------------------------------------------------
	function create_thumb_wfixed ($file_name_src, $width = -1, $height = -1, $quality, $type)
	{
		if(intval($quality) <= 0) $quality = 85;
		if (file_exists ($file_name_src))
		{
			$est_src = pathinfo (strtolower ($file_name_src));
			$size = getimagesize ($file_name_src);
			if ($width != -1 || $height != -1)
			{
				if ($width == -1)
				{
					$h = number_format ($height, 0, ',', '');
					$w = number_format (($size [0] / $size [1]) * $height, 0, ',' ,'');
				}
				else
					$w = number_format ($width, 0, ',', '');
				if ($height == -1)
				{
					$w = number_format ($width, 0, ',', '');
					$h = number_format (($size [1] / $size [0]) * $width, 0, ',', '');
				}
				else
					$h = number_format ($height, 0, ',', '');
			}
			else
			{
				$w = $size [0];
				$h = $size [1];
			}
			
			if(@$type == "jpg" or @$type == "jpeg") $size [2] = 2;
			else if(@$type == "gif") $size [2] = 1;

			switch ($size [2])
			{
				case 1:       //GIF
					$src = imagecreatefromgif ($file_name_src);
					$dest = imagecreate ($w, $h);
					break;
				case 2:       //JPEG
					$src = imagecreatefromjpeg ($file_name_src);
					$dest= imagecreatetruecolor ($w, $h);
					break;
				case 3:       //PNG
					$src = imagecreatefrompng ($file_name_src);
					$dest= imagecreatetruecolor ($w, $h);
					break;
				default:		//Others
					$src = imagecreatefromjpeg ($file_name_src);
					$dest= imagecreatetruecolor ($w, $h);
					break;
			}
			
			imagecopyresampled ($dest, $src, 0, 0, 0, 0, $w, $h, $size [0], $size [1]);

			switch ($size [2])
			{
				case 1:
					if (function_exists ('imagegif'))
						imagegif ($dest);
					else
						imagejpeg ($dest, null, $quality);
					break;
				case 2:
					imagejpeg ($dest, null, $quality);
					break;
				case 3:
					imagepng ($dest);
			}
			
			ImageDestroy ($dest);
			ImageDestroy ($src);
			return TRUE;
		}
	
		return FALSE;
	}

//	define upload path
$module = @$_REQUEST['module'];
switch($module) {
	case 'transport':
		$path = "../images/upload/document/$_GET[folder]/";
		break;
	case 'cargodocument':
		$folder = @$_GET['folder'];
		$path = "../images/upload/document2/$folder/";
		break;
	case 'customs1':
		$path = '../images/upload/tl1/';
		break;
	case 'customs2':
		$path = '../images/upload/tl2/';
		break;
	case 'customs3':
		$path = '../images/upload/tl3/';
		break;
	case 'customs4':
		$path = '../images/upload/tl4/';
		break;	
	case 'declaration':
		$path = '../images/upload/declaration/';
		break;
	case 'account':
		$path = "../images/upload/accounting/";
		break;
}
$id 		= strtr(trim(@$_REQUEST ['pic']), '/\\', '__');
$folder		= @$_GET['folder'];
$image 		= realpath($path . "$id");

$message	= ($message = trim(@$_REQUEST ['mesasge']) > 0)?$message:"";
$quality	= ($quality = intval(@$_REQUEST ['quality']) > 0)?$quality:85;
$type		= trim(strtolower(@$_REQUEST['type']));
$output		= trim(strtolower(@$_REQUEST ['output']));
$force		= (@strtolower(trim($_REQUEST ['force'])) == 'yes')?true:false;
$maxW		= intval(@$_REQUEST ['mw']);
$maxH		= intval(@$_REQUEST ['mh']);
$W 			= intval(@$_REQUEST ['w']);
$H			= intval(@$_REQUEST ['h']);
//---------------------------------------------------------------------------------------------------

//if (file_exists($image))

if((!file_exists($image) or is_dir($image)) and $output!="html"){				//فايل موجود نيست
	$W = ($maxW)?$maxW:(($W)?$W:0);
	$H = ($maxH)?$maxH:(($H)?$H:0);
	$W = ($W)?$W:$H;
	$H = ($H)?$H:$W;
	if(!$W) $W = $H = 100;
	header ("Content-type: image/gif"); 
	$im = @imagecreate ($W, $H) 
	   or die ("Cannot Initialize new GD image stream"); 
	$bg_color 	= imagecolorallocate ($im, 240, 240, 240); 
	$color 		= imagecolorallocate ($im, 88, 88, 88); 
	ImageStringAlignAndWrap($im, 2, $message, $color, round($W*9/10), "center", 15);
	imagegif($im);
	die($message);
}	


if (file_exists($image) and !is_dir($image)){
	$dlloaded = function_exists ('imagecreatefromjpeg');	//لود نشده است gd2
	if(!$dlloaded and $output!="html"){											
		header ('Content-Type: image/jpg');
		echo file_get_contents ($image);
		die();
	}	
	
	
	
	$FT			= @getimagesize($image);
	$FT["mime"] = explode('/', $FT["mime"], 2);	$FT["mime"]	= @$FT["mime"][1];
	$FT["w"] 	= @$FT[0];
	$FT["h"] 	= @$FT[1];
	
	if($W and $H and $force)					//ارتفاع و عرض بدون در نظر گرفتن نسبت دقيقاً مانند ورودی باشد
		$RES = array('w'=>$W, 'h'=>$H);		
	else if($W and !$H and !$maxH)					//عرض مانند ورودی باشد و ارتفاع مهم نيست
		$RES = array('w'=>$W, 'h'=>-1);
	else if(!$W and $H and !$maxW)					//ارتفاع مانند ورودی باشد و عرض مهم نيست
		$RES = array('w'=>-1, 'h'=>$H);
	else if($W and !$H and $maxH){					//در حد امکان عرض مانند ورودی باشد و ارتفاع از حدی بيشتر نباشد
		if(round($W*$FT["h"]/$FT["w"]) <= $maxH)		//عرض مانند ورودی و طول محدود به حد ورودی
			$RES = array('w'=>$W, 'h'=>-1);
		else if(round($W*$FT["h"]/$FT["w"]) > $maxH)	//ارتفاع محدود به حد ورودی و عرض کمتر از اندازه تعيين شده
			$RES = array('w'=>-1, 'h'=>$maxH);			
	}	
	else if(!$W and $H and $maxH){					//در حد امکان ارتفاع مانند ورودی و عرض از حدی بيشتر نباشد
		if(round($H*$FT["w"]/$FT["h"]) <= $maxW)		//ارتفاع مانند ورودی و عرض محدود به حد ورودی
			$RES = array('w'=>-1, 'h'=>$H);
		else if(round($H*$FT["w"]/$FT["h"]) > $maxH)	//ارتفاع محدود به حد ورودی و عرض کمتر از اندازه تعيين شده
			$RES = array('w'=>$maxW, 'h'=>-1);			
	}	
	else if(!$W and !$H and $maxW and $maxH){
		if(round($FT["h"]*$maxW/$FT["w"]) <= $maxH)	//عرض برابر حداکثر و ارتفاع کمتر از حداکثر
			$RES = array('w'=>$maxW, 'h'=>-1);
		else
			$RES = array('w'=>-1, 'h'=>$maxH);		//عرض کمتر از حداکثر و ارتفاع برابر با حداکثر
	}
	else if(!$W and !$H and !$maxW and $maxH)		//ارتفاع کمتر از حداکثر
		$RES = array('w'=>-1, 'h'=>$maxH);			
	else if(!$W and !$H and $maxW and !$maxH)		//عرض کمتر از حداکثر
		$RES = array('w'=>$maxW, 'h'=>-1);
	else	
		$RES = array('w'=>-1, 'h'=>-1);				//طول و عرض اصلی عکس
	
	if(!$force and (($W>$FT["w"] or $maxW>$FT["w"]) and ($H>$FT["h"] or $maxH>$FT["h"])))
		$RES = array('w'=>-1, 'h'=>-1);
}
if($output != 'html') {
	header ('Content-Type: image/' . $type);
	create_thumb_wfixed ($image, $RES["w"], $RES["h"], $quality, $type);
	die();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
<title></title>
</head>
<body style="margin: 5px" onLoad="maximize();">
<center>
<img id="img" alt="" width="100%" src="<?="showpic.php?pic=$id&amp;folder=$folder&amp;module=$module&amp;type=$type&amp;output=1"?>" />
</center>
</body>
<script language="javascript" type="text/javascript">
<!--
function maximize() {
    window.moveTo(0,0)
    window.resizeTo(screen.availWidth, screen.availHeight)
}

function resizeWindow(w,h)
{
	var img = document.getElementById('img');
	var body = document.body;
	if(!w){
		w = img.offsetWidth;
		h = img.offsetHeight;
	}
	if (parseInt(navigator.appVersion)>3) {
		if (navigator.appName=="Netscape") {
			top.outerWidth=w;
			top.outerHeight=h;
		} else {
			top.resizeTo(w,h);
		}
	}
	if(body.scrollHeight > body.clientHeight || body.scrollWidth > body.clientWidth) { 
		resizeWindow(w + 30, h + 30);
		return;
	}
	top.moveTo((screen.width - w)/2, (screen.height - h)/2);
}
// resizeWindow('<?= $FT["w"]+40 ?>', '<?= $FT["h"]+70 ?>');

-->
</script>
</html>