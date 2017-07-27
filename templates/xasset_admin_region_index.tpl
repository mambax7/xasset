<{if $xasset_region_count gt 0}>
    <table width='100%' cellspacing='1' class='outer'>
        <tr>
            <th colspan='4'>Regions</th>
        </tr>
        <tr>
            <td class='head'>ID</td>
            <td class='head'>Region</td>
            <td class='head'>Description</td>
            <td class='head'>Action</td>
        </tr>
        <{section name=i loop=$xasset_regions}>
            <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
                <td class='head'><{$xasset_regions[i].id}></td>
                <td><{$xasset_regions[i].region}></td>
                <td><{$xasset_regions[i].description}></td>
                <td><{$xasset_regions[i].actions}></td>
            </tr>
        <{/section}>
    </table>
<{/if}>
<br>
<br>
<{include file="db:xasset_admin_region_add.tpl"}>
