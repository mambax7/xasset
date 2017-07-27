<table border="0" align="center" cellpadding="0" cellspacing="0" style="width:95%;">
    <tr>
        <td>
            <p><{$smarty.const._LANG_YOUHAVE}> <{$xasset_basket_count}> <{$smarty.const._LANG_IN_YOUR_CART}>.</p>

            <P><br></P>
            <{if $xasset_basket_count gt 0}>
            <form name="form1" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/order.php?op=checkout"
                  class="width:90%">
                <table align="center" class="mainTable" style="width:100%;">
                    <tr>
                        <th><{$smarty.const._LANG_ITEM_NUMBER}></th>
                        <th><{$smarty.const._LANG_ITEM}></th>
                        <th><{$smarty.const._LANG_CODE}></th>
                        <th><{$smarty.const._LANG_UNIT_PRICE}></th>
                        <th><{$smarty.const._LANG_QUANTITY}></th>
                        <th><{$smarty.const._LANG_TOTAL_PRICE}></th>
                        <th><{$smarty.const._LANG_ACTION}></th>
                    </tr>
                    <{section name=i loop=$xasset_basket_items}>
                        <tr class="<{cycle values=" odd,even"}>">
                            <td><{$smarty.section.i.iteration}></td>
                            <td><{$xasset_basket_items[i].prodDescription}></td>
                            <td><{$xasset_basket_items[i].item_code}></td>
                            <td><{$xasset_basket_items[i].fmtUnitPrice}></td>
                            <td><input name="qty[<{$xasset_basket_items[i].id}>]" type="text"
                                       value="<{$xasset_basket_items[i].qty}>" size="3" maxlength="3"></td>
                            <td><{$xasset_basket_items[i].fmtTotPrice}></td>
                            <td><{$xasset_basket_items[i].actions}></td>
                        </tr>
                    <{/section}>
                    <{section name=i loop=$xasset_tax}>
                        <tr>
                            <td colspan="4" class="odd">&nbsp;</td>
                            <td class="head"><{$xasset_tax[i].name}></td>
                            <td class="head"><{$xasset_tax[i].fmtAmount}></td>
                            <td class="odd">&nbsp;</td>
                        </tr>
                    <{/section}>
                    <tr>
                        <td colspan="4" class="odd">&nbsp;</td>
                        <td class="head"><strong>Total Price</strong></td>
                        <td class="head"><strong><{$xasset_total_price}></strong></td>
                        <td class="odd">&nbsp;</td>
                    </tr>
                </table>
                <p><{/if}></p>

                <div align="right">
                    <input type="submit" name="updateCart" value="Update Quantities">
                    <input type="submit" name="checkout" value="Checkout">
                </div>
            </form>
            <p>&nbsp;</p>
        </td>
    </tr>
</table>
