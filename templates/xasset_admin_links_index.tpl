<table width='100%' cellspacing='1' class='outer'>
    <tr>
        <th colspan='5'> Links</th>
    </tr>
    <tr>
        <td class='head'>ID</td>
        <td class='head'>Application</td>
        <td class='head'>Link</td>
        <td class='head'>Action</td>
    </tr>
    <{section name=i loop=$xasset_links}>
        <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
            <td class='head'><{$xasset_links[i].id}></td>
            <td><{$xasset_links[i].appname}></td>
            <td><{$xasset_links[i].link}></td>
            <td><{$xasset_links[i].actions}></td>
        </tr>
    <{/section}>
</table><br><br><{include file="db:xasset_admin_links_add.tpl"}>

