<{if $block|@count gt 0}>
    <ul>
        <{section name=i loop=$block}>
            <li>
                <a href="<{$xoops_url}>/modules/xasset/index.php?op=product&id=<{$block[i].id}>&key=<{$block[i].key}>"><{$block[i].name}></a>
            </li>
        <{/section}>
    </ul>
<{/if}>
