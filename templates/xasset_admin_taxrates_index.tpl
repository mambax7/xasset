<{if $xasset_tax_zone_count gt 0}>
    <table width='100%' cellspacing='1' class='outer'>
        <tr>
            <th colspan='5'> Tax Zones</th>
        </tr>
        <tr>
            <td class='head'>ID</td>
            <td class='head'>Region</td>
            <td class='head'>Country</td>
            <td class='head'>Zone</td>
            <td class='head'>Action</td>
        </tr>
        <{section name=i loop=$xasset_tax_zones}>
            <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
                <td class='head'><{$xasset_tax_zones[i].id}></td>
                <td><{$xasset_tax_zones[i].region}></td>
                <td><{$xasset_tax_zones[i].country}></td>
                <td><{$xasset_tax_zones[i].zone}></td>
                <td><{$xasset_tax_zones[i].actions}></td>
            </tr>
        <{/section}>
    </table>
<{/if}>
<{if $xasset_class_count gt 0}>
    <br>
    <br>
    <table width='100%' cellspacing='1' class='outer'>
        <tr>
            <th colspan='4'> Tax Classes</th>
        </tr>
        <tr>
            <td class='head'>ID</td>
            <td class='head'>Code</td>
            <td class='head'>Description</td>
            <td class='head'>Action</td>
        </tr>
        <{section name=i loop=$xasset_classes}>
            <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
                <td class='head'><{$xasset_classes[i].id}></td>
                <td><{$xasset_classes[i].code}></td>
                <td><{$xasset_classes[i].description}></td>
                <td><{$xasset_classes[i].actions}></td>
            </tr>
        <{/section}>
    </table>
<{/if}>
<{if $xasset_rates_count gt 0}>
    <br>
    <br>
    <table width='100%' cellspacing='1' class='outer'>
        <tr>
            <th colspan='7'> Tax Rates</th>
        </tr>
        <tr>
            <td class='head'>ID</td>
            <td class='head'>Region</td>
            <td class='head'>Tax Class</td>
            <td class='head'>Rate</td>
            <td class='head'>Priority</td>
            <td class='head'>Description</td>
            <td class='head'>Action</td>
        </tr>
        <{section name=i loop=$xasset_rates}>
            <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
                <td class='head'><{$xasset_rates[i].id}></td>
                <td>
                    <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=editZone&id=<{$xasset_rates[i].region_id}>"><{$xasset_rates[i].region}></a>
                </td>
                <td>
                    <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=editTaxClass&id=<{$xasset_rates[i].tax_class_id}>"><{$xasset_rates[i].class_code}></a>
                </td>
                <td><{$xasset_rates[i].rate}></td>
                <td><{$xasset_rates[i].priority}></td>
                <td><{$xasset_rates[i].description}></td>
                <td><{$xasset_rates[i].actions}></td>
            </tr>
        <{/section}>
    </table>
<{/if}>
<br>
<{if $xasset_show_region gt 0}>
    <br>
    <br>
    <br>
    <{include file="db:xasset_admin_tax_region_zone.tpl"}>
<{/if}>
<br>
<{if $xasset_show_class gt 0}>
    <br>
    <{include file="db:xasset_admin_tax_class_add.tpl"}>
<{/if}>
<br>
<br>
<{if $xasset_tax_classes_count gt 0}>
    <{include file="db:xasset_admin_tax_rate_add.tpl"}>
<{/if}>
