<{$xasset_navigation}> <br> <br>
<table width='100%' cellspacing='1' class='outer'>
    <tr>
        <th colspan='4'><{$xasset_lic_appname}> Application Licenses</th>
    </tr>
    <tr>
        <td class='head'>UID</td>
        <td class='head'>Client Name</td>
        <td class='head'>Licenses</td>
        <td class='head'>Action</td>
    </tr>
    <{section name=i loop=$xasset_lic_list}>
        <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
            <td class='head'><{$xasset_lic_list[i].uid}></td>
            <td><{$xasset_lic_list[i].uname}></td>
            <td><{$xasset_lic_list[i].licenses}></td>
            <td><{$xasset_lic_list[i].actions}></td>
        </tr>
    <{/section}>
</table>
<br>
<br>
<{include file="db:xasset_admin_license_add.tpl" xasset_appid=$xasset_appid}>

