<?php
error_reporting(0);
mb_http_input("utf-8");
mb_internal_encoding("utf-8");

function showhelp(){
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

/*   ----------------- main body of program --------------------     */
//$mailInformation = array ('Email','_to','_cc','bcc','_subject')
//$mailContent = array ('Name','Family','Company','Email','Telephone','Fax','Address','Comment')	
function sendmail($mailInformation,$mailContent){

	$body = '
	<font face="Courier New" size="2">'.$_REQUEST["_form_name"].' form sent by: '.((isset($mailInformation["Email"])) ? '<a href="mailto:'.$mailInformation["Email"].'">'.$mailInformation["Email"].'</a>' : 'form_mailer@'.$_SERVER["SERVER_NAME"]).'<br>
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
	foreach($mailContent as $key => $val)
	if ($key[0] != "_")
	{
	  $i++;
	  $body .='
			  <tr>
					<td width="20%" bgcolor="#'.(($i % 2)==1?FFF5EC:FEFFF0).'" nowrap>
					<font face="Courier New" size="2" color="#333333">'.$key.'</font></td>
					<td width="80%" bgcolor="#'.(($i % 2)==1?FFF5EC:FEFFF0).'">
					<font face="Courier New" size="2" color="#333333">'.$val.'</font></td>
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
	if (isset($mailInformation["Email"]))$headers .= "From: ".$mailInformation["Email"]     ."\r\n";
	else      $headers .= "From: form_mailer@".        $_SERVER["SERVER_NAME"]."\r\n";
	if (isset($mailInformation["_cc"]))  $headers .= "Cc: "  .$mailInformation["_cc"]       ."\r\n";
	if (isset($mailInformation["_bcc"])) $headers .= "Bcc: " .$mailInformation["_bcc"]      ."\r\n";
	
	/* and now mail it */
	mb_send_mail($mailInformation["_to"], $mailInformation["_subject"], $body, $headers);
	
}
?>