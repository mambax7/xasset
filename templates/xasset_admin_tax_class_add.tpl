<form name="Apps" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan='2'><{$xasset_operation}> Tax Class</th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Code</td>
            <td class='even'>
                <input type='text' name='code' size='30' maxlength='30' value="<{$xasset_tax_class.code}>">
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Description</td>
            <td class='even'><input type='text' name='description' size='30' maxlength='30'
                                    value="<{$xasset_tax_class.description}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="bCreate" value="<{$xasset_operation_short}>">
                <input type="reset" name="bCancel" value="cancel">
                <input type="hidden" name="taxclassid" value="<{$xasset_tax_class.id}>">
                <input type="hidden" name="op" value="addTaxClass"></td>
        </tr>
    </table>
</form>
