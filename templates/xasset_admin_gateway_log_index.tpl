<{$xasset_navigation}>
<p><br></p>
<table width='100%' cellspacing='1' class='outer'>
    <tr>
        <th colspan='6'> Gateway Logs</th>
    </tr>
    <tr>
        <td class='head'>ID</td>
        <td class='head'>Date</td>
        <td class='head'>Gateway</td>
        <td class='head'>Order Stage</td>
        <td class='head'>UID</td>
        <td class='head'>Action</td>
    </tr>
    <{section name=i loop=$xasset_logs}>
        <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
            <td class='head'><a
                        href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=showLogDetail&id=<{$xasset_logs[i].id}>"><{$xasset_logs[i].id}></a>
            </td>
            <td><{$xasset_logs[i].formatDate}></td>
            <td><{$xasset_logs[i].code}></td>
            <td><{$xasset_logs[i].order_stage}></td>
            <td><{$xasset_logs[i].uid}></td>
            <td><{$xasset_logs[i].actions}></td>
        </tr>
    <{/section}>
</table>
