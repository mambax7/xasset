<form name="form2" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="outer">
        <tr>
            <th colspan="2"><{$xasset_operation}> Package</th>
        </tr>
        <tr>
            <td class='head'>Package Group</td>
            <td class='even'>
                <select name=groupid>
                    <{html_options options=$xasset_app_apppackagesselect selected=$xasset_package.packagegroupid}>
                </select>
            </td>
        </tr>
        <tr>
            <td class='head'>Display Filename</td>
            <td class='even'><input name="filename" type="text" size="32" maxlength="70"
                                    value="<{$xasset_package.filename}>"></td>
        </tr>
        <tr>
            <td class='head'>Actual File Path</td>
            <td class='even'><input name="serverFilePath" type="text" size="90" maxlength="255"
                                    value="<{$xasset_package.serverFilePath}>"></td>
        </tr>
        <tr>
            <td class='head'>File Size</td>
            <td class='even'><input type="text" name="filesize" value="<{$xasset_package.filesize}>">
                bytes
            </td>
        </tr>
        <tr>
            <td class='head'>File Type</td>
            <td class='even'><input name="filetype" type="text" size="10" maxlength="10"
                                    value="<{$xasset_package.filetype}>"></td>
        </tr>
        <tr>
            <td class='head'>This is a Video File</td>
            <td class='even'><input name="isVideo" type="checkbox" value="<{$xasset_package.isVideo}>" <{if
                $xasset_package.isVideo}>checked="checked"<{/if}>">
                <small>Support for FLV video only.</small>
            </td>
        </tr>
        <tr>
            <td class='head'>Protected</td>
            <td class='even'><input name="protected" type="checkbox" value="checkbox" <{if $xasset_package.protected eq
                1}>checked=checked<{/if}>>
            </td>
        </tr>
        <tr>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="Submit3" value="<{$xasset_operation_short}>">
                <input type="reset" name="Submit4" value="cancel">
                <input type="hidden" name="op" value="addPackage">
                <input type="hidden" name="appid" value="<{$xasset_active_appid}>">
                <input type="hidden" name="id" value="<{$xasset_package.id}>">
            </td>
        </tr>
    </table>
</form>
