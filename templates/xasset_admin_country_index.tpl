<{if $xasset_country_count > 0}>
    <table width='100%' cellspacing='1' class='outer'>
        <tr>
            <th colspan='5'> Countries</th>
        </tr>
        <tr>
            <td class='head'>ID</td>
            <td class='head'>Country</td>
            <td class='head'>ISO2</td>
            <td class='head'>ISO3</td>
            <td class='head'>Action</td>
        </tr>
        <{section name=i loop=$xasset_countries}>
            <tr class="<{cycle values=" odd, even"}>" valign='top' align='left'>
                <td class='head'><{$xasset_countries[i].id}></td>
                <td>
                    <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=editCountry&id=<{$xasset_countries[i].id}>"><{$xasset_countries[i].name}></a>
                </td>
                <td><{$xasset_countries[i].iso2}></td>
                <td><{$xasset_countries[i].iso3}></td>
                <td><{$xasset_countries[i].actions}></td>
            </tr>
        <{/section}>
    </table>
<{/if}>
<br>
<br>
<{include file="db:xasset_admin_country_add.tpl"}>
