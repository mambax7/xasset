<table border="0">
    <{assign var="counter" value=0}>
    <{section name=i start=0 loop=$block.rows}>
        <tr>
            <{section name=j start=0 loop=$block.columns}>
                <{if $block.images[$counter].image != ''}>
                    <td><a href="<{$xoops_url}>/modules/xasset/index.php"><img src="<{$block.images[$counter].image}>"></a>
                    </td>
                <{/if}>
                <{assign var="counter" value=$counter+1}>
            <{/section}>
        </tr>
    <{/section}>
</table>
