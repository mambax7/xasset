<table width='100%' cellspacing='1' class='outer'>
    <tr>
        <th colspan='6'>Membership Expiry View</th>
    </tr>
    <tr>
        <td class='head'>ID</td>
        <td class='head'>UID</td>
        <td class='head'>Group</td>
        <td class='head'>Expires</td>
        <td class='head'>Action</td>
    </tr>
    <{section name=i loop=$xasset_members}>
        <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
            <td class='head'><{$xasset_members[i].id}></td>
            <td><{$xasset_members[i].uname}></td>
            <td><{$xasset_members[i].name}></td>
            <td><{if $xasset_members[i].expired}>
                    <b><{$xasset_members[i].formatExpiryDate}></b><{else}><{$xasset_members[i].formatExpiryDate}><{/if}>
            </td>
            <td><{$xasset_members[i].actions}></td>
        </tr>
    <{/section}>
</table>
