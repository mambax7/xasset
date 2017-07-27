<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <th>Active Application : <{$xasset_active_appname}></th>
    </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr>
        <td valign="top">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class='outer'>
                <tr>
                    <th>Applications</th>
                </tr>
                <{section name=i loop=$xasset_applications}>
                    <tr class="<{cycle values=" odd,even"}>">
                        <{if $xasset_active_appid eq $xasset_applications[i].id}>
                            <td><b><{$xasset_applications[i].name}></b></td>
                        <{else}>
                            <td>
                                <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=managePackages&appid=<{$xasset_applications[i].id}>"><{$xasset_applications[i].name}></a>
                            </td>
                        <{/if}>
                    </tr>
                <{/section}>
            </table>
        </td>
        <td valign="top">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class='outer'>
                <tr>
                    <th>Groups &amp; Packages</th>
                </tr>
                <{section name=i loop=$xasset_app_packagesgroups}>
                    <tr class="<{cycle values=" odd,even"}>">
                        <td>
                            <b><{$xasset_app_packagesgroups[i].name}></b>&nbsp;&nbsp;|&nbsp;&nbsp;|<{$xasset_app_packagesgroups[i].actions}>
                            <ul>
                                <{section name=j loop=$xasset_app_packagesgroups[i].packages}>
                                    <li><{$xasset_app_packagesgroups[i].packages[j].filename}>&nbsp;&nbsp;|&nbsp;File ID
                                        :
                                        <{$xasset_app_packagesgroups[i].packages[j].id}>
                                        &nbsp;|&nbsp;&nbsp;<{$xasset_app_packagesgroups[i].packages[j].actions}>
                                    </li>
                                <{/section}>
                            </ul>
                        </td>
                    </tr>
                <{/section}>
            </table>
        </td>
    </tr>
</table>
<p><br></p>
<{include file="db:xasset_admin_packagegroup_add.tpl"}>
<p><br></p>
<{include file="db:xasset_admin_package_add.tpl"}>
