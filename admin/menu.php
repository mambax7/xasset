<?php
// defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

$moduleDirName = basename(dirname(__DIR__));

if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}


$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
//$pathModIcon32 = $moduleHelper->getModule()->getInfo('modicons32');

$moduleHelper->loadLanguage('modinfo');

$adminmenu            = [];
$i                      = 0;
'title' =>  _AM_MODULEADMIN_HOME,
'link' =>  'admin/index.php',
'icon' =>  $pathIcon32 . '/home.png',
//++$i;
//'title' =>  _AM_MODULEADMIN_HOME,
//'link' =>  "admin/main.php",
//$adminmenu[$i]["icon"]  = $pathIcon32 . '/manage.png';

++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_APPLICATIONS,
'link' => manageApplications',
'icon' =>  $pathIcon32 . '/exec.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_LICENSES,
'link' => manageLicenses',
'icon' =>  $pathIcon32 . '/folder_txt.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_LINKS,
'link' => manageLinks',
'icon' =>  $pathIcon32 . '/addlink.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_PACKAGES,
'link' => managePackages',
'icon' =>  $pathIcon32 . '/block.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_STATS,
'link' => viewDownloadStats',
'icon' =>  $pathIcon32 . '/stats.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_REGIONS,
'link' => manageRegion',
'icon' =>  $pathIcon32 . '/groupmod.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_COUNTRIES,
'link' => manageCountries',
'icon' =>  $pathIcon32 . '/languages.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_ZONES,
'link' => manageZones',
'icon' =>  $pathIcon32 . '/globe.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_TAXES,
'link' => manageTaxes',
'icon' =>  $pathIcon32 . '/calculator.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_CURRENCIES,
'link' => manageCurrencies',
'icon' =>  $pathIcon32 . '/cash_stack.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_GATEWAYS,
'link' => manageGateways',
'icon' =>  $pathIcon32 . '/delivery.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_ORDERS,
'link' => orderTracking',
'icon' =>  $pathIcon32 . '/cart_add.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_GATE_LOGS,
'link' => gatewayLogs',
'icon' =>  $pathIcon32 . '/index.png',
++$i;
'title' =>  _MI_XASSET_MENU_MANAGE_MEMBERSHIP,
'link' => membership',
'icon' =>  $pathIcon32 . '/identity.png',
++$i;
'title' =>  _AM_MODULEADMIN_ABOUT,
'link' =>  'admin/about.php',
'icon' =>  $pathIcon32 . '/about.png',
