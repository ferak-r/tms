<!-- {* --><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="fa">
<link rel="stylesheet" href="../+assets/style-en.css" type="text/css">
<link rel="stylesheet" href="../+assets/cpanel/cpanel.css" type="text/css">
</head>
<body style="margin:10px;" dir="rtl">
<!-- *} -->
<form action="index.php?section=admin&amp;module=importdb&amp;cmd=import" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table border="0" cellpadding="0" cellspacing="3" width="100%">
	<tr>
		<td>
		<table border="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
{capture name=buttons}	
	<tr>
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap>&nbsp;				</td>
		<td class="list-box" width="90%" style="padding-bottom: 3px;">		
<div class="button-ex-gray" style="margin: 3px;"><a title="Cancle and Return" href="javascript:window.back(1);">
			<img border="0" src="../images/icons/48x48/cancelen.png" width="48" height="48" alt="" /></a>			</div>
				<div class="button-ex-gray" style="margin: 3px;"><a title="Save and Continue" href="javascript:document.forms['form1'].submit();">
			<img border="0" src="../images/icons/48x48/oken.png" width="48" height="48" alt="" /></a>			</div>
			    		</td>
	</tr>
{/capture}
{$smarty.capture.buttons}
	<tr>
		<td width="22" class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;		</td>
		<td class="list-box" nowrap><div class="form-title">File Name:</div></td>
		<td class="list-box" width="90%"><div class="form-input">
			<input type="file" name="importfile" size="32" dir="ltr"></div></td>
	</tr>
	<tr>
	  <td class="list-box" style="border-right: 5px solid #F2EDE1" nowrap>&nbsp;</td>
	  <td class="list-box" nowrap>&nbsp;</td>
	  <td class="list-box"><br />
	    <br />
	    <br />
	    <br />
	    <br />
	    <br />
	    <br />
	    <br />
	    <br />
	    <br /></td>
	  </tr>
	</table>	  </td>
	  <td width="319" class="list-box" style="background-color: #fff; padding: 3px;" align="center"><p align="left"><span style="	color: #FF0000;	font-weight: bold; font-size: 20pt; font-family: Arial, Times;">WARNING:</span><br />
	  This process may cause database damage or loss of previous data. Please create a backup file before this process. </p>
	</td>
	</tr>
</table>
<input type="hidden" name="combineid_frm" value="{$combineid}" />
<input type="submit" style="display: none;" />
</form>	
<!-- {* -->
</body>
</html>
<!-- *} -->