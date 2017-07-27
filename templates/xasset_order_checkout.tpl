<table border="0" align="center" cellpadding="0" cellspacing="0" style="width:95%;">
    <tr>
        <td>
            <p><{$smarty.const._LANG_YOUHAVE}> <{$xasset_basket_count}> <{$smarty.const._LANG_IN_YOUR_CART}>.</p>

            <P><br></P>
            <{if $xasset_basket_count gt 0}>
            <form name="form1" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/order.php">
                <{securityToken}><{*//mb*}>
                <table align="center" class="mainTable" style="width:100%;">
                    <tr>
                        <th><{$smarty.const._LANG_ITEM_NUMBER}></th>
                        <th><{$smarty.const._LANG_ITEM}></th>
                        <th><{$smarty.const._LANG_CODE}></th>
                        <th><{$smarty.const._LANG_UNIT_PRICE}></th>
                        <th><{$smarty.const._LANG_QUANTITY}></th>
                        <th><{$smarty.const._LANG_TOTAL_PRICE}></th>
                    </tr>
                    <{section name=i loop=$xasset_basket_items}>
                        <tr class="<{cycle values=" odd,even"}>">
                            <td><{$smarty.section.i.iteration}></td>
                            <td><{$xasset_basket_items[i].prodDescription}></td>
                            <td><{$xasset_basket_items[i].item_code}></td>
                            <td><{$xasset_basket_items[i].fmtUnitPrice}></td>
                            <td><{$xasset_basket_items[i].qty}></td>
                            <td><{$xasset_basket_items[i].fmtTotPrice}></td>
                        </tr>
                    <{/section}>
                    <{section name=i loop=$xasset_tax}>
                        <tr>
                            <td colspan="4" class="head">&nbsp;</td>
                            <td class="head"><{$xasset_tax[i].name}></td>
                            <td class="head"><{$xasset_tax[i].fmtAmount}></td>
                        </tr>
                    <{/section}>
                    <tr>
                        <td colspan="4" class="head">&nbsp;</td>
                        <td class="head"><strong><{$smarty.const._LANG_TOTAL_PRICE}></strong></td>
                        <td class="head"><strong><{$xasset_total_price}></strong></td>
                    </tr>
                </table>
                <{if $xasset_gateway_count gt 0}>
                    <p><br></p>
                    <table width="80%" border="0" class="mainTable" style="width:100%;">
                        <tr>
                            <th colspan="2"><{$smarty.const._LANG_PAYMENT_METHOD}></th>
                        </tr>
                        <{section name=i loop=$xasset_gateway}>
                            <tr>
                                <td width="5%" class="head"><input name="gateway" type="radio"
                                                                   value="<{$xasset_gateway[i].id}>"
                                                                   <{if $smarty.section.i.index eq 0}>checked<{/if}>>
                                </td>
                                <td width="95%" class="even"><{$xasset_gateway[i].description}></td>
                            </tr>
                        <{/section}>
                    </table>
                <{/if}>
                <{/if}>
                <p><br></p>

                <div align="right">
                    <input type="submit" name="checkout" value="Process Payment">
                    <input type="hidden" name="op" value="processPayment">
                </div>
                <p>&nbsp;</p>
            </form>
        </td>
    </tr>
</table>
