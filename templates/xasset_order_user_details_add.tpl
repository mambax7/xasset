<table style="border:0;" width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="mainTable">
    <tr>
        <td>Please note that all fields marked * are required. Please note that we require this information to pass onto
            the payment gateway. Your data will be stored here for no other purpose and we will not be forwarding this
            information to any third parties.
        </td>
    </tr>
</table><b>
    <form name="form2" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/order.php">
        <{securityToken}><{*//mb*}>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="mainTable">
            <tr>
                <th colspan="2"><{$xasset_operation}> <{$smarty.const._LANG_USER_DETAILS}><br></th>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_FIRST_NAME}></td>
                <td class='even'><input name="first_name" type="text" size="32" maxlength="255"
                                        value="<{$xasset_customer.first_name}>">
                </td>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_LAST_NAME}></td>
                <td class='even'><input name="last_name" type="text" size="32" maxlength="255"
                                        value="<{$xasset_customer.last_name}>"></td>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_ADDRESS1}> *</td>
                <td class='even'><input name="street_address1" type="text" size="32" maxlength="255"
                                        value="<{$xasset_customer.street_address1}>">
                    <span class="error"><{$xasset_error.street_address1}></span>
                </td>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_ADDRESS2}></td>
                <td class='even'><input name="street_address2" type="text" size="32" maxlength="255"
                                        value="<{$xasset_customer.street_address2}>"></td>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_TOWNCITY}> *</td>
                <td class='even'><input name="town" type="text" size="32" maxlength="255"
                                        value="<{$xasset_customer.town}>">
                    <span class="error"><{$xasset_error.town}></span>
                </td>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_POST_CODE}> *</td>
                <td class='even'><input name="zip" type="text" size="32" maxlength="255"
                                        value="<{$xasset_customer.zip}>">
                    <span class="error"><{$xasset_error.zip}></span>
                </td>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_STATE}> *</td>
                <td class='even'>
                    <input name="state" type="text" size="32" maxlength="255" value="<{$xasset_customer.state}>"
                           style="<{$xasset_state_style}>">
                    <select name=zone_id style="<{$xasset_zone_style}>">
                        <{html_options options=$xasset_zone_select selected=$xasset_customer.zone_id}>
                    </select>
                    <span class="error"><{$xasset_error.state}></span>
                </td>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_COUNTRY}> *</td>
                <td class='even'><select name=country_id onChange="update_zones(this.form);">
                        <{html_options options=$xasset_country_select selected=$xasset_customer.country_id}>
                    </select>
                    <span class="error"><{$xasset_error.country_id}></span>
                </td>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_TELEPHONE}></td>
                <td class='even'><input name="tel_no" type="text" size="32" maxlength="255"
                                        value="<{$xasset_customer.tel_no}>"></td>
            </tr>
            <tr>
                <td class='head'><{$smarty.const._LANG_FAX}></td>
                <td class='even'><input name="fax_no" type="text" size="32" maxlength="255"
                                        value="<{$xasset_customer.fax_no}>"></td>
            </tr>
            <{$xasset_email_row}>
            <tr>
                <td class='head'>&nbsp;</td>
                <td class='even'><input type="submit" name="Submit3" value="<{$xasset_operation_short}>">
                    <input type="reset" name="Submit4" value="cancel">
                    <input type="hidden" name="op" value="addCustomer">
                    <input type="hidden" name="id" value="<{$xasset_customer.id}>">
                </td>
            </tr>
        </table>
    </form>
