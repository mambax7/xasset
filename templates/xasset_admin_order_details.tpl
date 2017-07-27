<{$xasset_navigation}> <br>
<br>
<table width='100%' class='outer' cellspacing='1'>
    <tr>
        <th colspan='2'>Order ID Details</th>
    </tr>
    <tr valign='top' align='left'>
        <td class='head'>ID</td>
        <td class='even'><{$xasset_order.id}></td>
    </tr>
    <tr valign='top' align='left'>
        <td class='head'>Order Date</td>
        <td class='even'><{$xasset_order.dateFmt}></td>
    </tr>
    <tr valign='top' align='left'>
        <td class='head'>Order Status</td>
        <td class='even'><{$xasset_order.statusFmt}></td>
    </tr>
    <tr valign='top' align='left'>
        <td class='head'>Gateway Transaction ID</td>
        <td class='even'><{$xasset_order.trans_id}></td>
    </tr>
    <tr valign='top' align='left'>
        <td class='head'>Currency</td>
        <td class='even'><{$xasset_order.currencyFmt}></td>
    </tr>
    <tr valign='top' align='left'>
        <td class='head'>Total Gateway Order Value</td>
        <td class='even'><{$xasset_order.value}></td>
    </tr>
    <tr valign='top' align='left'>
        <td class='head'>Gateway Commission Fee</td>
        <td class='even'><{$xasset_order.fee}></td>
    </tr>
</table> <b>
    <table width='100%' class='outer' cellspacing='1'>
        <tr>
            <th colspan="5">Order Items</th>
        </tr>
        <tr>
            <td class="head">Product Code</td>
            <td class="head">Product Description</td>
            <td class="head">Quantity Ordered</td>
            <td class="head">Item Price</td>
            <td class="head">Total Price</td>
        </tr>
        <{section name=i loop=$xasset_order_detail}>
            <tr class="<{cycle values=" odd,even"}>">
                <td><{$xasset_order_detail[i].item_code}></td>
                <td><{$xasset_order_detail[i].name}></td>
                <td><{$xasset_order_detail[i].qty}></td>
                <td><{$xasset_order_detail[i].fmtUnitPrice}></td>
                <td><{$xasset_order_detail[i].fmtTotPrice}></td>
            </tr>
        <{/section}>
    </table>
    <b>
        <table width='100%' cellspacing='1' class='outer'>
            <tr>
                <th colspan='6'> Gateway Logs</th>
            </tr>
            <tr>
                <td class='head'>ID</td>
                <td class='head'>Date</td>
                <td class='head'>Gateway</td>
                <td class='head'>Order Stage</td>
                <td class='head'>UID</td>
                <td class='head'>Action</td>
            </tr>
            <{section name=i loop=$xasset_logs}>
                <tr class="<{cycle values=" odd,even"}>" valign='top' align='left'>
                    <td class='head'><a
                                href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=showLogDetail&id=<{$xasset_logs[i].id}>"><{$xasset_logs[i].id}></a>
                    </td>
                    <td><{$xasset_logs[i].formatDate}></td>
                    <td><{$xasset_logs[i].code}></td>
                    <td><{$xasset_logs[i].order_stage}></td>
                    <td><{$xasset_logs[i].uid}></td>
                    <td><{$xasset_logs[i].actions}></td>
                </tr>
            <{/section}>
        </table>
