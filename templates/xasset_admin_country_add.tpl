<form name="Apps" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan='2'><{$xasset_operation}> Country</th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Country Name</td>
            <td class='even'><input type='text' name='name' id='name' size='50' maxlength='50'
                                    value="<{$xasset_country.name}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>ISO2 Code</td>
            <td class='even'><input type='text' name='iso2' size='4' maxlength='2' value="<{$xasset_country.iso2}>">
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>ISO3 Code</td>
            <td class='even'><input type='text' name='iso3' size='4' maxlength='3' value="<{$xasset_country.iso3}>">
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="bCreate" value="<{$xasset_operation_short}>">
                <input type="reset" name="bCancel" value="cancel">
                <input type="hidden" name="countryid" value="<{$xasset_country.id}>">
                <input type="hidden" name="op" value="addCountry"></td>
        </tr>
    </table>
</form>
