<form name="Apps" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan='2'><{$xasset_app_operation}> Application</th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Application Name</td>
            <td class='even'><input type='text' name='name' id='name' size='50' maxlength='50'
                                    value="<{$xasset_app.name}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Application Description<b></td>
            <td class='even'><input type='text' name='description' id='description' size='50' maxlength='250'
                                    value="<{$xasset_app.description}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Platform</td>
            <td class='even'><input type='text' name='platform' id='platform' size='50' maxlength='50'
                                    value="<{$xasset_app.platform}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Version</td>
            <td class='even'><input type='text' name='version' id='version' size='10' maxlength='10'
                                    value="<{$xasset_app.version}>"></td>
        </tr>
        <!--<tr valign='top' align='left'>
          <td class='head'>Requires License? </td>
          <td class='even'><input name="requiresLicense" type="checkbox" value="checkbox"  <{if $xasset_app.requiresLicense}>checked<{/if}>></td>
        </tr>
        <tr valign='top' align='left'>
          <td class='head'>List in Evaluation Section? </td>
          <td class='even'><input name="listInEval" type="checkbox" value="checkbox"  <{if $xasset_app.listInEval}>checked<{/if}>></td>
        </tr> -->
        <tr valign='top' align='left'>
            <td class='head'>Has Sample Products?</td>
            <td class='even'><input name="hasSamples" type="checkbox" value="checkbox" <{if
                $xasset_app.hasSamples}>checked<{/if}> >
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>List in Main Menu?</td>
            <td class='even'><input name="mainMenu" type="checkbox" value="checkbox" <{if
                $xasset_app.mainMenu}>checked<{/if}> >
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Main Menu Name</td>
            <td class='even'><input type='text' name='menuItem' id='menuItem' size='50' maxlength='20'
                                    value='<{$xasset_app.menuItem}>'></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Application Image</td>
            <td class='even'><input type='text' name='image' id='image' size='50' maxlength='250'
                                    value='<{$xasset_app.image}>'></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Xoops User Group Access</td>
            <td class='even'><{$xasset_app.permission_cbs}></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>HTML Description</td>
            <td class='even'><{$xasset_app_memo_field}></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>List all products?</td>
            <td class='even'><input name="productsVisible" type="checkbox" value="checkbox" <{if
                $xasset_app.productsVisible}>checked<{/if}> >
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Product List Template<b>
                    <small>Leave blank for default template</small>
            </td>
            <td class='even'><textarea name="product_list_template" cols="80"
                                       rows="6"><{$xasset_app.product_list_template}></textarea>
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="bCreate" value="<{$xasset_app_operation_short}>">
                <input type="reset" name="bCancel" value="cancel">
                <input type="hidden" name="appid" value="<{$xasset_app.id}>">
                <input type="hidden" name="op" value="addApplication"></td>
        </tr>
    </table>
</form>
