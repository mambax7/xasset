<form name="Apps" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan='2'><{$xasset_operation}> Application License</th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>User ID</td>
            <td class='even'>
                <select name=userid>
                    <{html_options options=$xasset_users selected=$xasset_license.uid}>
                </select>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Application<b></td>
            <td class='even'>
                <select name=appid>
                    <{html_options options=$xasset_lic_select selected=$xasset_license.applicationid}>
                </select>
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Key</td>
            <td class='even'><input type='text' name='key' id='key' size='50' maxlength='50'
                                    value="<{$xasset_license.authKey}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Authorising ID</td>
            <td class='even'><input type='text' name='authCode' id='authCode' size='50' maxlength='100'
                                    value="<{$xasset_license.authCode}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Expires</td>
            <td class='even'><{$xasset_date_field}></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="bCreate" value="<{$xasset_operation_short}>">
                <input type="reset" name="bCancel" value="cancel">
                <input type="hidden" name="op" value="addLicense">
                <input type="hidden" name="id" value="<{$xasset_license.id}>">
                <input type="hidden" name="adminop" value="<{$adminop}>"></td>
        </tr>
    </table>
</form>
