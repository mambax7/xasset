<form name="form1" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="outer">
        <tr>
            <th colspan="2"><{$xasset_operation}> Package Group</th>
        </tr>
        <tr>
            <td class='head'>Group Name</td>
            <td class='even'>
                <input name="name" type="text" size="50" maxlength="50" value="<{$xasset_group.name}>">
            </td>
        </tr>
        <tr>
            <td class='head'>Description</td>
            <td class='even'><textarea name="grpDesc" cols="50" rows="5"><{$xasset_group.desc}></textarea></td>
        </tr>
        <tr>
            <td class='head'>Version</td>
            <td class='even'><input name="version" type="text" size="10" maxlength="10"
                                    value="<{$xasset_group.version}>"></td>
        </tr>
        <tr>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="Submit" value="<{$xasset_operation_short}>">
                <input type="reset" name="Submit2" value="cancel">
                <input type="hidden" name="op" value="addPackageGroup">
                <input type="hidden" name="appid" value="<{$xasset_active_appid}>">
                <input type="hidden" name="id" value="<{$xasset_group.id}>">
            </td>
        </tr>
    </table>
</form>
