<form name="Apps" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan='2'><{$xasset_operation}> Region</th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Region</td>
            <td class='even'><input type='text' name='region' size='20' maxlength='30'
                                    value="<{$xasset_region.region}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Description</td>
            <td class='even'><input name="description" type="text" value="<{$xasset_region.description}>" size="80"
                                    maxlength="200"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="bCreate" value="<{$xasset_operation_short}>">
                <input type="reset" name="bCancel" value="cancel">
                <input type="hidden" name="regionid" value="<{$xasset_region.id}>">
                <input type="hidden" name="op" value="addRegion"></td>
        </tr>
    </table>
</form>
