<form name="form2" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="outer">
        <tr>
            <th colspan="2"><{$xasset_user_operation}> Licensed User</th>
        </tr>
        <tr>
            <td class='head'>User</td>
            <td class='even'>
                <select name=uid>
                    <{html_options options=$xasset_users selected=$xasset_user.uid}>
                </select>
            </td>
        </tr>
        <tr>
            <td class='head'>Application</td>
            <td class='even'>
                <select name=appid>
                    <{html_options options=$xasset_apps selected=$xasset_user.appid}>
                </select>
        </tr>
        <tr>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="Submit3" value="<{$xasset_user_operation_short}>">
                <input type="reset" name="Submit4" value="cancel">
                <input type="hidden" name="op" value="addUserApp">
                <input type="hidden" name="id" value="<{$xasset_user.id}>">
            </td>
        </tr>
    </table>
</form>
