<form name="form1" method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=updateCurrency">
    <{securityToken}><{*//mb*}>
    <p>
        Currency : <select name=currency_id>
            <{html_options options=$block.select selected=$block.current}>
        </select>
        <input type="submit" name="Submit" value="Refresh">
        <input type="hidden" name="app_id" value="<{$block.application}>">
    </p>
</form>
