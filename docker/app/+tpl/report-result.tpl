<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="fa">
<title>Tirtash</title>
<link rel="stylesheet" type="text/css" href="../guest/script/style.css">
{include file="_head.tpl"}
</head>

<body style="background: #FFFFFF;">
<table width="100%" border="0" bordercolor="#CCCCCC" dir="ltr" cellpadding="2">
{capture assign=head}
	<tr>
		<td width="1%" style="background-color:#000066; color:#FFFFFF; font-weight: 600; height:18px; vertical-align:middle; ">&nbsp;No&nbsp;</td>
{foreach from=$showfield key=key item=item}	
		<td style="background-color:#000066; color:#FFFFFF; font-weight: 600; height:18px; vertical-align:middle; ">
			{$item}
		</td>
{/foreach}		
	</tr>
{/capture}	
{foreach from=$list key=key item=item}	
{counter name=rowcnt assign=cnt}
{if $cnt eq 1}{$head}{/if}	
	<tr style="background-color: {cycle values='#FFFFFF,#F3F3F3'}; {if $cnt eq $maxrow}{counter name=rowcnt assign=cnt start=0} page-break-after : always;{/if}">
		<td>
{counter name=totalcnt}			
		</td>
	{foreach from=$item key=key2 item=item2}	
		<td>
			{$item2}
		</td>
	{/foreach}		
	</tr>	
{foreachelse}
	<tr>
		<td style="padding: 30px;" colspan="100" align="center"> رکوردی جهت نمایش یافت نشد.
		</td>
	</tr>
{/foreach}
</table>
</body>
</html>