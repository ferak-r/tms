<!-- Paging : Begin{* --><head>
<link rel="stylesheet" href="../+style/style-en.css" type="text/css" />
</head>
<!-- *} -->
{assign var=zpage value=$page}
{math equation="x - 1" x=$zpage assign=prev}
{math equation="x + 1" x=$zpage assign=next}
<table border="0" cellspacing="0" cellpadding="0" style="width: auto">
          <tr>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
				{if $zpage ne 1}
				<a href="{$href|regex_replace:'/((&amp;)|(&))page=[^&]*/':''}&page=1" title="First Page"><img alt="" src="../images/nav-first-on.gif" width="7" height="9" border="0" /></a>
				{else}
				<img alt="" src="../images/nav-first-off.gif" width="7" height="9" border="0" />
				{/if}
			</td>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
				{if $zpage ne 1}
				<a href="{$href|regex_replace:'/((&amp;)|(&))page=[^&]*/':''}&page={$prev}" title="Previews Page"><img alt="" src="../images/nav-prev-on.gif" width="7" height="9" border="0" /></a>
				{else}
				<img alt="" src="../images/nav-prev-off.gif" width="7" height="9" border="0" />
				{/if}
			</td>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
			<select name="page" class="orderCombo" style="width: 50px; height: 15px" onchange="document.location.href='{$href|regex_replace:'/((&amp;)|(&))page=[^&]*/':''}&page='+this.options[this.selectedIndex].value;">
{section name=cpage loop=$maxpage}
			  <option value="{$smarty.section.cpage.iteration}" {if $smarty.section.cpage.iteration==$zpage}selected="selected"{/if}>{$smarty.section.cpage.iteration}</option>
{/section}
            </select></td>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
				{if $zpage ne $maxpage}
				<a href="{$href|regex_replace:'/((&amp;)|(&))page=[^&]*/':''}&page={$next}" title="Next Page"><img alt="" src="../images/nav-next-on.gif" width="7" height="9" border="0" /></a>
				{else}
				<img alt="" src="../images/nav-next-off.gif" width="7" height="9" border="0" />
				{/if}
			</td>
            <td style="padding-left: 8px; padding-right: 8px; vertical-align:middle">
				{if $zpage ne $maxpage}
				<a href="{$href|regex_replace:'/((&amp;)|(&))page=[^&]*/':''}&page={$maxpage}" title="Last Page"><img alt="" src="../images/nav-last-on.gif" width="7" height="9" border="0" /></a>
				{else}
				<img alt="" src="../images/nav-last-off.gif" width="7" height="9" border="0" />
				{/if}
			</td>
          </tr>
        </table>
<!-- Paging : End -->