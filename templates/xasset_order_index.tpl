<p align="center"><{$xasset_order_navigation}></p>
<p><br></p>
<p><br></p>
<{if $xasset_order_stage eq 0}>
    <p><{include file="db:xasset_order_user_details_add.tpl"}></p>
<{elseif $xasset_order_stage eq 1}>
    <p><{include file="db:xasset_order_cart.tpl"}></p>
<{elseif $xasset_order_stage eq 2}>
    <p><{include file="db:xasset_order_checkout.tpl"}></p>
<{elseif $xasset_order_stage eq 3}>
    <p><{include file="db:xasset_order_extra.tpl"}></p>
<{/if}>
