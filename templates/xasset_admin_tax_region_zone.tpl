<form name="Apps" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan='2'><{$xasset_operation}> Tax Zone</th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Region</td>
            <td class='even'><select name=region_id>
                    <{html_options options=$xasset_region_select selected=$xasset_tax_zone.region_id}>
                </select></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Country</td>
            <td class='even'><select name=country_id onChange="update_zones(this.form);">
                    <{html_options options=$xasset_countries_select selected=$xasset_tax_zone.country_id}>
                </select></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Zone</td>
            <td class='even'><select name=zone_id>
                    <{html_options options=$xasset_zone_select selected=$xasset_tax_zone.zone_id}>
                </select></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="bCreate" value="<{$xasset_operation_short}>">
                <input type="reset" name="bCancel" value="cancel">
                <input type="hidden" name="taxzoneid" value="<{$xasset_tax_zone.id}>">
                <input type="hidden" name="op" value="addTaxZone"></td>
        </tr>
    </table>
</form>
