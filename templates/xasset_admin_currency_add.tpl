<form name="Apps" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan='2'><{$xasset_operation}> Currency</th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Currency Name</td>
            <td class='even'><input type='text' name='name' size='30' maxlength='30' value="<{$xasset_currency.name}>">
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Code</td>
            <td class='even'><input type='text' name='code' size='5' maxlength='3' value="<{$xasset_currency.code}>">
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Decimal Places</td>
            <td class='even'><input type='text' name='decimal_places' size='5' maxlength='3'
                                    value="<{$xasset_currency.decimal_places}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Symbol Left</td>
            <td class='even'><input type='text' name='symbol_left' size='10' maxlength='10'
                                    value="<{$xasset_currency.symbol_left}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Symbol Right</td>
            <td class='even'><input type='text' name='symbol_right' size='10' maxlength='10'
                                    value="<{$xasset_currency.symbol_right}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Decimal Symbol</td>
            <td class='even'><input type='text' name='decimal_point' size='5' maxlength='1'
                                    value="<{$xasset_currency.decimal_point}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Thousand Seperator</td>
            <td class='even'><input type='text' name='thousands_point' size='5' maxlength='1'
                                    value="<{$xasset_currency.thousands_point}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Exchange Rate</td>
            <td class='even'><input type='text' name='value' size='20' maxlength='20'
                                    value="<{$xasset_currency.value}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="bCreate" value="<{$xasset_operation_short}>">
                <input type="reset" name="bCancel" value="cancel">
                <input type="hidden" name="currencyid" value="<{$xasset_currency.id}>">
                <input type="hidden" name="op" value="addCurrency"></td>
        </tr>
    </table>
</form>
