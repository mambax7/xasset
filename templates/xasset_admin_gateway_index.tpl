<form name="gateway" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php" class='outer'>
    <{securityToken}><{*//mb*}>
    <table width='100%' cellspacing='1' class='outer'>
        <tr>
            <th colspan='5'>Payment Gateways</th>
        </tr>
        <tr>
            <td class='head'>&nbsp;</td>
            <td class='head'>Gateway</td>
            <td class='head'>Description</td>
            <td class='head'>Installed</td>
            <td class='head'>Enabled</td>
        </tr>
        <{section name=i loop=$xasset_gateway}>
            <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
                <td><input name="gateway[]" type="checkbox" value="<{$xasset_gateway[i].class}>"></td>
                <td><{$xasset_gateway[i].class}></td>
                <td><{$xasset_gateway[i].shortDesc}></td>
                <td><{if $xasset_gateway[i].installed}>True<{else}>False<{/if}></td>
                <td><{if $xasset_gateway[i].enabled}>True<{else}>False<{/if}></td>
            </tr>
        <{/section}>
    </table>
    <p><br></p>

    <div align="center">
        <input type="submit" name="bEnable" value="enable">
        <input type="submit" name="bDisable" value="disable">
        <input type="reset" name="cancel" value="cancel">
        <input type="hidden" name="op" value="toggleGateway">
    </div>
    <br>
</form>
<{if $xasset_gateway_count gt 0}>
    <table width="100%" border="0" class="outer">
        <tr>
            <th colspan="2">Gateway Configuration</th>
        </tr>
        <tr>
            <th width="20%">Gateway Module</th>
            <th width="80%"><{$xasset_gateway_name}> Gateway Configuration Values</th>
        </tr>
        <tr>
            <td valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="outer">
                    <{section name=i loop=$xasset_installed_gateway}>
                        <tr class="<{cycle values=" odd,even"}>">
                            <{if $xasset_gateway_id neq $xasset_installed_gateway[i].id}>
                                <td>
                                    <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=manageGateways&id=<{$xasset_installed_gateway[i].id}>"><{$xasset_installed_gateway[i].code}></a>
                                </td>
                            <{else}>
                                <td><b><{$xasset_installed_gateway[i].code}></b></td>
                            <{/if}>
                        </tr>
                    <{/section}>
                </table>
            </td>
            <td valign="top">
                <form name="config" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="outer">
                        <tr>
                            <td class="head">Description</td>
                            <td class="head">Value</td>
                        </tr>
                        <{section name=i loop=$xasset_config}>
                            <tr>
                                <td class="even"><{$xasset_config[i].description}></td>
                                <td class="odd"><{$xasset_config[i].htmlField}></td>
                            </tr>
                        <{/section}>
                    </table>
                    <p align="center" class="head">
                        <input type="submit" name="Submit" value="modify">
                        <input type="reset" name="Submit2" value="cancel">
                        <input type="hidden" name="gateway_id" value="<{$xasset_gateway_id}>">
                        <input type="hidden" name="op" value="updateGatewayValues">
                    </p>
                </form>
            </td>
        </tr>
    </table>
<{/if}>
<p>&nbsp;</p>
