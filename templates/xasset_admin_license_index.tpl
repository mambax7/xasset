<table width='100%' cellspacing='1' class='outer'>
    <tr>
        <th colspan='3'>Licenses</th>
    </tr>
    <tr>
        <td class='head'>Application</td>
        <td class='head'>Licensed Users</td>
        <td class='head'>Action</td>
    </tr>
    <{section name=i loop=$xasset_lic_list}>
        <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
            <td class='head'><{$xasset_lic_list[i].name}></td>
            <td><{$xasset_lic_list[i].licenses}></td>
            <td><{$xasset_lic_list[i].actions}></td>
        </tr>
    <{/section}>
</table>
<br>
<br>
<{include file="db:xasset_admin_license_add.tpl"}>

