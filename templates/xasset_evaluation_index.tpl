<br>
<table align="center" class="mainTable">
    <tr>
        <td colspan="4" class="head">Evaluation Applications</td>
    </tr>
    <tr>
        <td class="head">Application Name</td>
        <td class="head">Date Published</td>
    </tr>
    <{section name=i loop=$xasset_applications}>
        <tr class="<{cycle values=" odd,even"}>">
            <td>
                <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?op=evaluation&appid=<{$xasset_applications[i].appid}>&key=<{$xasset_applications[i].cryptKey}>"><{$xasset_applications[i].appname}></a>
            </td>
            <td><{$xasset_applications[i].datePublished}></td>
        </tr>
    <{/section}>
</table>
<p><br></p>
<table align="center" class="mainTable">

    <tr>
        <td colspan="2" align="center" valign="top"><br>
            <table style="width:95%;">
                <tr>
                    <td>
                        <table style="width:95%;"><br>
                            <tr>
                                <td class="head" colspan="2">Application <{$xasset_user_application.name}> Details
                                </th>
                            </tr>
                            <tr>
                                <td class='even'>Description</td>
                                <td class='odd'><{$xasset_application.description}></td>
                            </tr>
                            <tr>
                                <td class='even'>Platform</td>
                                <td class='odd'><{$xasset_application.platform}></td>
                            </tr>
                            <tr>
                                <td class='even'>Version</td>
                                <td class='odd'><{$xasset_application.version}></td>
                            </tr>
                            <tr>
                                <td class='even'>Date Published</td>
                                <td class='odd'><{$xasset_application.datePublished}></td>
                            </tr>
                        </table>
                        <br>
                    </td>
                    <td>
                        <table
                        "width:95%"><br>
                <tr>
                    <td class="head" colspan="2">Application Packages</td>
                </tr>
                <{section name=i loop=$xasset_application_groups}>
                    <tr class="<{cycle values=" odd,even"}>">
                        <td>
                            <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?op=viewAppGroups&groupid=<{$xasset_application_groups[i].id}>&key=<{$xasset_application_groups[i].cryptKey}>"><{$xasset_application_groups[i].name}></a>
                            <ul>
                                <{section name=j loop=$xasset_application_groups[i].packages}>
                                    <li>
                                        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?op=downloadPack&packid=<{$xasset_application_groups[i].packages[j].id}>&key=<{$xasset_application_groups[i].packages[j].cryptKey}>"><{$xasset_application_groups[i].packages[j].filename}></a>
                                    </li>
                                <{/section}>
                            </ul>
                        </td>
                    </tr>
                <{/section}>
            </table>
            <br>
        </td>
    </tr>
</table><br>        </td>
</tr>
<tr align="center">
    <td colspan="2" valign="top">
        <table style="width:95%;">
            <tr>
                <td><p><{$xasset_application.richDescription}></p></td>
            </tr>
        </table>
    </td>
</tr>
<tr align="center">
    <td colspan="2" valign="top">&nbsp;</td>
</tr>
<tr>
    <td colspan="2" align="center" valign="top"><{if $xasset_links_count gt 0}>
        <table
        "width:95%">
<tr>
    <td class="head">Extra Links</td>
</tr>
<{section name=i loop=$xasset_application_links}>
    <tr class="<{cycle values=" odd,even"}>">
        <td><{$xasset_application_links[i].link}></td>
    </tr>
<{/section}>
</table>
<{/if}></td>
</tr>
<tr>
    <td colspan="2" align="center" valign="top">
        <{if $xasset_currency_count gt 0}>
            <table class="mainTable" style="width:95%;">
                <tr>
                    <td class="head">
                        <form name="form1" method="post"
                              action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=updateCurrency">
                            <{securityToken}><{*//mb*}>
                            <p>Base Currency : <select name=currency_id>
                                    <{html_options options=$xasset_currencies selected=$xasset_basecurrency_id}>
                                </select>
                                <input type="submit" name="Submit" value="Refresh">
                                <input type="hidden" name="type" value="<{$xasset_evaluation_type}>">
                                <input type="hidden" name="app_id" value="<{$xasset_application.id}>">
                            </p>
                        </form>
                    </td>
                </tr>
            </table>
        <{/if}>
    </td>
</tr>
<tr>
    <td colspan="2" align="center" valign="top">&nbsp;</td>
</tr>
<{if $xasset_application_packages_count gt 0}>
    <tr>
        <td colspan="2" valign="top">
            <table style="width:95%;" align="center" class="mainTable">
                <tr>
                    <td class="head">Price</td>
                    <td class="head">Description</td>
                    <{if $xasset_show_minlic}>
                        <td class="head">Minimum Licenses</td>
                    <{/if}>
                    <{if $xasset_show_maxdowns}>
                        <td class="head">Max Downloads</td>
                    <{/if}>
                    <{if $xasset_show_maxdays}>
                        <td class="head">Max Days</td>
                    <{/if}>
                    <{if $xasset_show_expires}>
                        <td class="head">Offer Expires</td>
                    <{/if}>
                    <td class="head"></td>
                </tr>
                <{section name=i loop=$xasset_application_packages}>
                    <tr class="<{cycle values=" odd,even"}>">
                        <td>
                            <{section name=j loop=$xasset_application_packages[i].prices}>
                                <!--<{if $xasset_application_packages[i].base_currency_id neq $xasset_application_packages[i].prices[j].currency_id}>
                  <em><{$xasset_application_packages[i].prices[j].fmtUnit}></em><br>
                  <{else}>
                  <{/if}> -->
                                <{$xasset_application_packages[i].prices[j].fmtUnit}>
                                <br>
                            <{/section}>
                        </td>
                        <td><{$xasset_application_packages[i].item_description}></td>
                        <{if $xasset_show_minlic}>
                            <td><{$xasset_application_packages[i].min_unit_count}></td>
                        <{/if}>
                        <{if $xasset_show_maxdowns}>
                            <td><{$xasset_application_packages[i].max_access}></td>
                        <{/if}>
                        <{if $xasset_show_maxdays}>
                            <td><{$xasset_application_packages[i].max_days}></td>
                        <{/if}>
                        <{if $xasset_show_expires}>
                            <td><{$xasset_application_packages[i].expiresDate}></td>
                        <{/if}>
                        <td>
                            <form method="post"
                                  action="<{$xoops_url}>/modules/<{$xoops_dirname}>/order.php?id=<{$xasset_application_packages[i].id}>&amp;key=<{$xasset_application_packages[i].key}>&amp;op=addToCart"
                                  style="height:10px;">
                                <input type="image"
                                       src="<{$xoops_url}>/modules/<{$xoops_dirname}>/assets/images/buyNow.png"
                                       title="Buy Now" name="buyNow"
                                       style="border:0;background:transparent;">
                            </form>
                        </td>
                    </tr>
                <{/section}>
            </table>
            <br><br>
        </td>
    </tr>
<{/if}>
</table>
