<form name="Apps" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php">
    <{securityToken}><{*//mb*}>
    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan='2'><{$xasset_operation}> Application Product</th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Enabled</td>
            <td class='even'><input name="enabled" type="checkbox" value="" <{if
                $xasset_app_product.enabled}>checked<{/if}>>
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Application</td>
            <td class='even'>
                <select name=application_id>
                    <{html_options options=$xasset_applications selected=$xasset_app_product.application_id}>
                </select></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Tax Class</td>
            <td class='even'><select name=tax_class_id>
                    <{html_options options=$xasset_tax_classes selected=$xasset_app_product.taxclassid}>
                </select></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Display Order</td>
            <td class='even'><input type='text' name='display_order' size='5' maxlength='2'
                                    value="<{$xasset_app_product.display_order}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Base Currency</td>
            <td class='even'><select name=base_currency_id>
                    <{html_options options=$xasset_currencies selected=$xasset_app_product.base_currency_id}>
                </select></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Product Code</td>
            <td class='even'><input type='text' name='item_code' size='15' maxlength='10'
                                    value="<{$xasset_app_product.item_code}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Product Description</td>
            <td class='even'><input type='text' name='item_description' size='70' maxlength='100'
                                    value="<{$xasset_app_product.item_description}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Unit Price</td>
            <td class='even'><input type='text' name='unit_price' size='15' maxlength='10'
                                    value="<{$xasset_app_product.unit_price}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Old Unit Price</td>
            <td class='even'><input type='text' name='old_unit_price' size='15' maxlength='10'
                                    value="<{$xasset_app_product.old_unit_price}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Minimum Sales Units</td>
            <td class='even'><input type='text' name='min_unit_count' size='15' maxlength='10'
                                    value="<{$xasset_app_product.min_unit_count}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Max Access</td>
            <td class='even'><input type='text' name='max_access' size='15' maxlength='10'
                                    value="<{$xasset_app_product.max_access}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Max Days Access</td>
            <td class='even'><input type='text' name='max_days' size='15' maxlength='10'
                                    value="<{$xasset_app_product.max_days}>"></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Expiry Date</td>
            <td class='even'><{$xasset_date_field}></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>HTML Description</td>
            <td class='even'><{$xasset_appprod_memo_field}></td>
        </tr>
        <tr valign='top' align='left'>
            <th colspan='2'>Application Product Download Files</th>
        </tr>
        <tr>
            <td class='head'>Purchase Package Group</td>
            <td class='even'>
                <select name=package_group_id>
                    <{html_options options=$xasset_xoops_packages selected=$xasset_app_product.package_group_id}>
                </select></td>
        </tr>
        <tr>
            <td class='head'>Sample Package Group</td>
            <td class='even'>
                <select name=sample_package_group_id>
                    <{html_options options=$xasset_xoops_packages selected=$xasset_app_product.sample_package_group_id}>
                </select></td>
        </tr>
        <tr valign='top' align='left'>
            <th colspan='2'>On Purchase</th>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Add to Xoops User Group</td>
            <td class='even'><select name=add_to_group>
                    <{html_options options=$xasset_xoops_groups selected=$xasset_app_product.add_to_group}>
                </select></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Group Membership Expires</td>
            <td class='even'>
                <label><input name="rbGrpExpire" type="radio" value="0" <{if $xasset_app_product.group_expire_date eq 0
                    }> checked="checked"<{/if}>>Never</label>
                <label><input name="rbGrpExpire" type="radio" value="7" <{if $xasset_app_product.group_expire_date eq 7
                            }> checked="checked"<{/if}>> One Week</label>
                <label><input name="rbGrpExpire" type="radio" value="30" <{if $xasset_app_product.group_expire_date eq
                    30 }> checked="checked"<{/if}>> One Month</label>
                <label><input name="rbGrpExpire" type="radio" value="360" <{if $xasset_app_product.group_expire_date eq
                    360 }> checked="checked"<{/if}>>One Year</label>
                <label><input name="rbGrpExpire" type="radio" value="-1" <{if ($xasset_app_product.group_expire_date neq
                    0) and ($xasset_app_product.group_expire_date neq 7) and ($xasset_app_product.group_expire_date neq
                    30) and ($xasset_app_product.group_expire_date neq 360) }> checked="checked"<{/if}>> <input
                            name="expire_days" type="text" value="<{$xasset_app_product.group_expire_date}>" size="4"
                            maxlength="4"> Days</label>
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Add to Xoops User Group</td>
            <td class='even'><select name=add_to_group2>
                    <{html_options options=$xasset_xoops_groups selected=$xasset_app_product.add_to_group2}>
                </select></td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Group Membership Expires</td>
            <td class='even'>
                <label><input name="rbGrpExpire2" type="radio" value="0" <{if $xasset_app_product.group_expire_date2 eq
                    0 }> checked="checked"<{/if}>>Never</label>
                <label><input name="rbGrpExpire2" type="radio" value="7" <{if $xasset_app_product.group_expire_date2 eq
                    7 }> checked="checked"<{/if}>> One Week</label>
                <label><input name="rbGrpExpire2" type="radio" value="30" <{if $xasset_app_product.group_expire_date2 eq
                    30 }> checked="checked"<{/if}>> One Month</label>
                <label><input name="rbGrpExpire2" type="radio" value="360" <{if $xasset_app_product.group_expire_date2
                    eq 360 }> checked="checked"<{/if}>>One Year</label>
                <label><input name="rbGrpExpire2" type="radio" value="-1" <{if ($xasset_app_product.group_expire_date2
                    neq 0) and ($xasset_app_product.group_expire_date2 neq 7) and
                    ($xasset_app_product.group_expire_date2 neq 30) and ($xasset_app_product.group_expire_date2 neq 360)
                    }> checked="checked"<{/if}>> <input name="expire_days2" type="text"
                                                          value="<{$xasset_app_product.group_expire_date2}>" size="4"
                                                          maxlength="4"> Days</label>
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>Extra Instructions to email to client on purchase</td>
            <td class='even'><textarea name="extra_instructions" cols="80"
                                       rows="5"><{$xasset_app_product.extra_instructions}></textarea>
            </td>
        </tr>
        <tr valign='top' align='left'>
            <td class='head'>&nbsp;</td>
            <td class='even'><input type="submit" name="bCreate" value="<{$xasset_operation_short}>">
                <input type="reset" name="bCancel" value="cancel">
                <input type="hidden" name="appprodid" value="<{$xasset_app_product.id}>">
                <input type="hidden" name="op" value="addAppProduct"></td>
        </tr>
        <tr valign='top' align='left'>
            <th colspan='2'>Other</th>
        </tr>
        <tr>
            <td class='head'>Buy Now link for this Product</td>
            <td><textarea name="textarea" cols="60" rows="5"><{$xasset_app_product.product_link}></textarea>

                <p>
                    <small>Copy this text to paste it in a block if you wish to display a Buy Now button for this
                        Application Product anywhere on your website.
                        <small>
                </p>
            </td>
        </tr>
    </table>
</form>
