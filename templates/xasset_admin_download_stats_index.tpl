<{if $xasset_application_count gt 0}>
    <table width='50%' cellspacing='1' class='outer'>
        <tr class="head">
            <td class="head">Application</td>
            <td class="head">Downloads</td>
        </tr>
        <{section name=i loop=$xasset_application_list}>
            <tr class="<{cycle values=" odd,even"}>">
                <td>
                    <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=viewDownloadStats&appid=<{$xasset_application_list[i].id}>"><{$xasset_application_list[i].name}></a>
                </td>
                <td><{$xasset_application_list[i].downloads}></td>
            </tr>
        <{/section}>
    </table>
<{/if}>
<p><br></p>
<table width='100%' cellspacing='1' class='outer'>
    <tr>
        <th colspan='2'> Download Stats for <{$xasset_application}></th>
    </tr>
    <{section name=i loop=$xasset_stats}>
        <tr>
            <td class='head'><{$xasset_stats[i].name}></td>
            <td>
                <{section name=j loop=$xasset_stats[i].packages}>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class='head'><{$xasset_stats[i].packages[j].filename}></td>
                            <td>
                                <{if $xasset_stats[i].packages[j].count gt 0}>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class='head'>User</td>
                                            <td class='head'>IP</td>
                                            <td class='head'>Date</td>
                                            <td class='head'>Actions</td>
                                        </tr>
                                        <{section name=k loop=$xasset_stats[i].packages[j].downloads}>
                                            <tr class="<{cycle values=" odd,even"}>">
                                                <td><{$xasset_stats[i].packages[j].downloads[k].uname}></td>
                                                <td><{$xasset_stats[i].packages[j].downloads[k].ip}></td>
                                                <td><{$xasset_stats[i].packages[j].downloads[k].date}></td>
                                                <td><{$xasset_stats[i].packages[j].downloads[k].actions}></td>
                                            </tr>
                                        <{/section}>
                                    </table>
                                <{/if}>
                            </td>
                        </tr>
                    </table>
                <{/section}>
            </td>
        </tr>
    <{/section}>
</table>
