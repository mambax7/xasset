<?php

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       XOOPS Development Team
 * @package      xAsset
 */

use XoopsModules\Xasset;

// require_once  dirname(__DIR__) . '/class/Helper.php';
//require_once  dirname(__DIR__) . '/include/common.php';
/** @var Xasset\Helper $helper */
$helper = Xasset\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
    ];

    //$adminmenu[] = [
    //'title' =>  _MI_XASSET_MENU_HOME,
    //'link' =>  "admin/main.php",
    //$adminmenu[$i]["icon"]  = $pathIcon32 . '/manage.png';
    //];

    $adminmenu[] = [
        'title' => _MI_XASSET_MENU_MANAGE_APPLICATIONS,
        'link'  => 'admin/main.php?op=manageApplications',
        'icon'  => $pathIcon32 . '/exec.png',
    ];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_LICENSES,
    'link'  => 'admin/main.php?op=manageLicenses',
    'icon'  => $pathIcon32 . '/folder_txt.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_LINKS,
    'link'  => 'admin/main.php?op=manageLinks',
    'icon'  => $pathIcon32 . '/addlink.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_PACKAGES,
    'link'  => 'admin/main.php?op=managePackages',
    'icon'  => $pathIcon32 . '/block.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_STATS,
    'link'  => 'admin/main.php?op=viewDownloadStats',
    'icon'  => $pathIcon32 . '/stats.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_REGIONS,
    'link'  => 'admin/main.php?op=manageRegion',
    'icon'  => $pathIcon32 . '/groupmod.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_COUNTRIES,
    'link'  => 'admin/main.php?op=manageCountries',
    'icon'  => $pathIcon32 . '/languages.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_ZONES,
    'link'  => 'admin/main.php?op=manageZones',
    'icon'  => $pathIcon32 . '/globe.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_TAXES,
    'link'  => 'admin/main.php?op=manageTaxes',
    'icon'  => $pathIcon32 . '/calculator.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_CURRENCIES,
    'link'  => 'admin/main.php?op=manageCurrencies',
    'icon'  => $pathIcon32 . '/cash_stack.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_GATEWAYS,
    'link'  => 'admin/main.php?op=manageGateways',
    'icon'  => $pathIcon32 . '/delivery.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_ORDERS,
    'link'  => 'admin/main.php?op=orderTracking',
    'icon'  => $pathIcon32 . '/cart_add.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_GATE_LOGS,
    'link'  => 'admin/main.php?op=gatewayLogs',
    'icon'  => $pathIcon32 . '/index.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_MANAGE_MEMBERSHIP,
    'link'  => 'admin/main.php?op=membership',
    'icon'  => $pathIcon32 . '/identity.png',
];

$adminmenu[] = [
    'title' => _MI_XASSET_MENU_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
