<{if $xasset_downloads|@count gt 0}>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="mainTable">
        <tr>
            <th colspan="8" class="head">My Downloads</th>
        </tr>
        <tr>
            <td class="head">Product</td>
            <td class="head">Date</td>
            <td class="head">Filename</td>
            <td class="head">Action</td>
            <td class="head">Downloaded</td>
            <td class="head">Expires</td>
            <td class="head">Max Downloads</td>
            <td class="head">Status</td>
        </tr>
        <{section name=i loop=$xasset_downloads}>
            <tr class="<{cycle values=" odd,even"}>">
                <{if $xasset_downloads[i].status eq 5}>
                    <td>
                        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?op=downloadLicPack&id=<{$xasset_downloads[i].packageID}>&key=<{$xasset_downloads[i].packageKey}>"><{$xasset_downloads[i].item_description}></a>
                    </td>
                <{else}>
                    <td><{$xasset_downloads[i].item_description}></td>
                <{/if}>
                <td><{$xasset_downloads[i].datePurchase}></td>
                <{if $xasset_downloads[i].status eq 5}> <!-- Filename column-->
                    <td>
                        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?op=downloadLicPack&id=<{$xasset_downloads[i].packageID}>&key=<{$xasset_downloads[i].packageKey}>"><{$xasset_downloads[i].filename}></a>
                    </td>
                <{else}>
                    <td><{$xasset_downloads[i].filename}></td>
                <{/if}>
                <td>
                    <{if $xasset_downloads[i].status eq 5}> <!-- Action column -->
                    <{if $xasset_downloads[i].isVideo eq 1}>
                    <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=ViewVideoLic&id=<{$xasset_downloads[i].packageID}>&key=<{$xasset_downloads[i].packageKey}>">View</a>
                </td>
                <{else}>
                <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?op=downloadLicPack&id=<{$xasset_downloads[i].packageID}>&key=<{$xasset_downloads[i].packageKey}>">Download</a></td>
                <{/if}>
                <{/if}>
                </td>
                <td><{$xasset_downloads[i].downloaded}></td>
                <td><{$xasset_downloads[i].expiresFmt}></td>
                <td><{$xasset_downloads[i].max_access}></td>
                <td><{$xasset_downloads[i].statusFmt}></td>
            </tr>
        <{/section}>
    </table>
<{else}>
    <div align="center">
        <h1><strong><span style="color: #FF0000; ">No Downloads Found.</span></strong></h1>
    </div>
<{/if}>
