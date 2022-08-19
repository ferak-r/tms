<?php
error_reporting(0);
function showhelp()
{
?>
<p align="center"><br>
<font face="Courier New" color="#800000">Mail Sender help system</font><br>
&nbsp;</p>
<p align="left"><font size="2" color="#333333" face="Courier New">This php file 
was written to send web forms via email.<br>
<br>
To send forms just set <b>_to</b> hidden field to your email address.<br>
<br>
( eg.: </font><font size="2" color="#000080" face="Courier New">&lt;input 
type=&quot;hidden&quot; name=&quot;_to&quot; value=&quot;you@yourserver.com&quot;&gt;</font><font size="2" color="#333333" face="Courier New"> 
)<br>
<br>
Already you can set other parameters like _to field such as:</font></p>
<ul>
	<li>
<font face="Courier New" size="2" color="#333333">_cc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	# to set cc value</font></li>
	<li>
<font face="Courier New" size="2" color="#333333">_bcc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	# to set bcc value</font></li>
	<li>
	<p align="left"><font face="Courier New" size="2" color="#333333">_subject&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	# to set subject</font></li>
	<li>
<font face="Courier New" size="2" color="#333333">Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	# this is the senders email address (input field)</font></li>
	<li>
<font face="Courier New" size="2" color="#333333">_form_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	# form name ( eg. Inquiry )</font></li>
	<li>
<font face="Courier New" size="2" color="#333333">_echo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	# set this value to true to see the result of sendmail.php</font></li>
	<li>
<font face="Courier New" size="2" color="#333333">
	_redirect&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; # set _redirect hidden field to the 
	page that you<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	# want to redirect there. If you do not set the _redirect<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	# option, the sendmail.php redirects to your form</font></li>
</ul>

<p><font face="Courier New" size="2" color="#FF0000">* </font><font face="Courier New" size="2" color="#333333">
Note that the program is case sensitive and there is difference between Email 
and email.<br>
<br>
&nbsp; Please just use the correct case.<br>
<br>
</font><font face="Courier New" size="2" color="#FF0000">* </font><font face="Courier New" size="2" color="#333333">You can send your form by GET or POST method but we recommend the POST method.</font></p>

<p><font face="Courier New" size="2" color="#333333">This is a sample html code 
to use this php mail sender:</font></p>
<table border="0" cellpadding="8" cellspacing="0" width="100%" bgcolor="#FFFFCC">
	<tr>
		<td><font face="Courier New" size="2"><font color="#000080">
		&lt;html&gt;</font><br>
		<br>
		<font color="#000080">&lt;head&gt;</font><br>
		<font color="#000080">&lt;title&gt;</font>form<font color="#000080">&lt;/title&gt;</font><br>
		<font color="#000080">&lt;/head&gt;</font><br>
		<br>
		<font color="#000080">&lt;body&gt;</font><br>
		<font color="#000080">&lt;form <b>method</b>=&quot;POST&quot; <b>action</b>=&quot;http://aryaweb.com/sendmail.php&quot;&gt;<br>
		&lt;p&gt;<br>
		</font>Name:<font color="#000080">&nbsp;&nbsp;&nbsp; &lt;input <b>type</b>=&quot;text&quot;
		<b>name</b>=&quot;Name&quot;&gt;&lt;br&gt;</font><br>
		Family:<font color="#000080">&nbsp; &lt;input <b>type</b>=&quot;text&quot; <b>name</b>=&quot;Family&quot;&gt;&lt;br&gt;</font><br>
		Email:<font color="#000080">&nbsp;&nbsp; &lt;input <b>type</b>=&quot;text&quot; <b>
		name</b>=&quot;Email&quot;&gt;&lt;br&gt;</font><br>
		Comments:<font color="#000080">&lt;textarea <b>rows</b>=&quot;4&quot; <b>name</b>=&quot;Comments&quot;
		<b>cols</b>=&quot;20&quot;&gt;&lt;/textarea&gt;<br>
		&lt;input <b>type</b>=&quot;submit&quot; <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		value</b>=&quot;Submit&quot;&gt;&lt;/p&gt;<br>
		&lt;input <b>type</b>=&quot;hidden&quot; <b>name</b>=&quot;_to&quot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b>value</b>=&quot;info@aryaweb.com&quot;&gt;<br>
		&lt;input <b>type</b>=&quot;hidden&quot; <b>name</b>=&quot;_subject&quot; <b>&nbsp;value</b>=&quot;contact 
		data ( form.htm )&quot;&gt;<br>
		&lt;input <b>type</b>=&quot;hidden&quot; <b>name</b>=&quot;_redirect&quot; <b>value</b>=&quot;http://www.aryaweb.com&quot;&gt;<br>
		&lt;/form&gt;<br>
		&lt;/body&gt;<br>
		<br>
		&lt;/html&gt;</font></font></td>
	</tr>
</table>


<p><font face="Courier New" size="2">This is the PHP source code (I've test it 
with PHP 4.3.2 in Apachi server 1.3.27):</font></p>
<table border="0" cellpadding="8" cellspacing="0" width="100%" bgcolor="#FFFFCC">
	<tr>
		<td><?show_source($_SERVER["PATH_TRANSLATED"])?></td>
	</tr>
</table>


<p><i><font face="Courier New" size="2">By:
<a href="mailto:webmaster@aryaweb.com">Mahdy Molayee</a></font></i></p>



<?
}

function utf8ToUnicodeEntities ($source) {
// array used to figure what number to decrement from character order value 
// according to number of characters used to map unicode to ascii by utf-8
$decrement[4] = 240;
$decrement[3] = 224;
$decrement[2] = 192;
$decrement[1] = 0;

// the number of bits to shift each charNum by
$shift[1][0] = 0;
$shift[2][0] = 6;
$shift[2][1] = 0;
$shift[3][0] = 12;
$shift[3][1] = 6;
$shift[3][2] = 0;
$shift[4][0] = 18;
$shift[4][1] = 12;
$shift[4][2] = 6;
$shift[4][3] = 0;

$pos = 0;
$len = strlen ($source);
$encodedString = '';
while ($pos < $len) {
$asciiPos = ord (substr ($source, $pos, 1));
if (($asciiPos >= 240) && ($asciiPos <= 255)) {
// 4 chars representing one unicode character
$thisLetter = substr ($source, $pos, 4);
$pos += 4;
}
else if (($asciiPos >= 224) && ($asciiPos <= 239)) {
// 3 chars representing one unicode character
$thisLetter = substr ($source, $pos, 3);
$pos += 3;
}
else if (($asciiPos >= 192) && ($asciiPos <= 223)) {
// 2 chars representing one unicode character
$thisLetter = substr ($source, $pos, 2);
$pos += 2;
}
else {
// 1 char (lower ascii)
$thisLetter = substr ($source, $pos, 1);
$pos += 1;
}
// process the string representing the letter to a unicode entity
$thisLen = strlen ($thisLetter);
$thisPos = 0;
$decimalCode = 0;
while ($thisPos < $thisLen) {
$thisCharOrd = ord (substr ($thisLetter, $thisPos, 1));
if ($thisPos == 0) {
$charNum = intval ($thisCharOrd - $decrement[$thisLen]);
$decimalCode += ($charNum << $shift[$thisLen][$thisPos]);
}
else {
$charNum = intval ($thisCharOrd - 128);
$decimalCode += ($charNum << $shift[$thisLen][$thisPos]);
}
$thisPos++;
}
if ($thisLen == 1)
$encodedLetter = "&#". str_pad($decimalCode, 3, "0", STR_PAD_LEFT) . ';';
else
$encodedLetter = "&#". str_pad($decimalCode, 5, "0", STR_PAD_LEFT) . ';';
$encodedString .= $encodedLetter;
}
return $encodedString;
}

/*   ----------------- main body of program --------------------     */


$body = '
<font face="Courier New" size="2">'.$_REQUEST["_form_name"].' form sent by: '.((isset($_REQUEST["email"])) ? '<a href="mailto:'.$_REQUEST["email"].'">'.$_REQUEST["email"].'</a>' : 'form_mailer@'.$_SERVER["SERVER_NAME"]).'<br>
Time: '.gmdate("D j M Y G:i:s").' GMD<br>
Sender : '.$_ENV["REMOTE_HOST"].'<br>
&nbsp;</font><hr noshade color="#808080" width="80%" size="1">
<div align="center">
<table border="0" cellpadding="5" cellspacing="0" width="80%" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" style="border: 1px dotted #800000; padding-left: 4px; padding-right: 4px; padding-top: 1px; padding-bottom: 1px">
	<tr>
		<td width="20%" bgcolor="#FF9900" nowrap><b>
		<font face="Courier New" size="2" color="#FFFFFF">Field</font></b></td>
		<td width="80%" bgcolor="#FF9900"><b>
		<font face="Courier New" size="2" color="#FFFFFF">Value</font></b></td>
	</tr>
';
foreach($_REQUEST as $key => $val)
if ($key[0] != "_")
{
  $i++;
  $body .='
  	<tr>
		<td width="20%" bgcolor="#'.(($i % 2)==1?FFF5EC:FEFFF0).'" nowrap>
		<font face="Courier New" size="2" color="#333333">'.$key.'</font></td>
		<td width="80%" bgcolor="#'.(($i % 2)==1?FFF5EC:FEFFF0).'">
		<font face="Courier New" size="2" color="#333333">'.utf8ToUnicodeEntities($val).'</font></td>
	</tr>
	';
}

$body .= '
</table>
</div>
<hr noshade color="#808080" width="80%" size="1">
';

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";

/* additional headers */
if (isset($_REQUEST["Email"]))$headers .= "From: ".$_REQUEST["Email"]     ."\r\n";
else      $headers .= "From: form_mailer@".        $_SERVER["SERVER_NAME"]."\r\n";
if (isset($_REQUEST["_cc"]))  $headers .= "Cc: "  .$_REQUEST["_cc"]       ."\r\n";
if (isset($_REQUEST["_bcc"])) $headers .= "Bcc: " .$_REQUEST["_bcc"]      ."\r\n";

/* and now mail it */
mail($_REQUEST["_to"], $_REQUEST["_subject"], $body, $headers);

if (isset($_REQUEST["_redirect"])) $redir=$_REQUEST["_redirect"];
if (isset($_REQUEST["_redir"   ])) $redir=$_REQUEST["_redir"];

if (isset($_REQUEST["_echo"]))
{
  echo $body;
  echo "<br><br><p> Form sent successfully. <a href='".(isset($redir) ? $redir : $_SERVER["HTTP_REFERER"])."'>Click here to continue.</a></p>";
}
else
  header("Location: ".(isset($redir) ? $redir : $_SERVER["HTTP_REFERER"]));
  
?>