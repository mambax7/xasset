<form name="form2" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="outer">
        <tr>
            <th colspan="2"><{$xasset_link_function}> Link</th>
        </tr>
        <tr>
            <td class='head'>Application</td>
            <td class='even'>
                <select name=appid>
                    <{html_options options=$xasset_app_apppackagesselect selected=$xasset_link.appid}>
                </select>
            </td>
        </tr>
        <tr>
            <td class='head'>Display Name</td>
            <td class='even'><input name="name" type="text" size="32" maxlength="255" value="<{$xasset_link.name}>">
            </td>
        </tr>
        <tr>
            <td class='head'>Link</td>
            <td class='even'><input name="link" type="text" size="50" maxlength="255" value="<{$xasset_link.link}>">
            </td>
        </tr>
        <tr>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="Submit3" value="create">
                <input type="reset" name="Submit4" value="cancel">
                <input type="hidden" name="op" value="addLink">
                <input type="hidden" name="id" value="<{$xasset_link.id}>">
            </td>
        </tr>
    </table>
</form>
