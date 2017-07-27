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
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

require_once __DIR__ . '/../../../include/cp_header.php';
require_once __DIR__ . '/admin_header.php';

xoops_cp_header();

$adminObject = \Xmf\Module\Admin::getInstance();

//----------------------------------

global $xoopsTpl;
//
$hApp   = xoops_getModuleHandler('application', 'xasset');
$hLic   = xoops_getModuleHandler('license', 'xasset');
$hPack  = xoops_getModuleHandler('package', 'xasset');
$hStat  = xoops_getModuleHandler('userPackageStats', 'xasset');
$hLinks = xoops_getModuleHandler('link', 'xasset');
//
$applicationsCount = $hApp->getAllApplicationsCount();
$licensesCount     = $hLic->getAllLicensesCount();
$filesCount        = $hPack->getAllPackagesCount();
$linksCount        = $hLinks->getAllLinksCount();
$downloadsCount    = $hStat->getAllDownloadStats();
//test SSL connectivity
$fp = fsockopen('ssl://www.paypal.com', 443, $errnum, $errstr, 30);
if (!$fp) {
    $test = ['pass' => false, 'errnum' => $errnum, 'errstr' => $errstr];
} else {
    $test = ['pass' => true];
}

//$statistics = calculateStatistics();

$adminObject->addInfoBox(_MI_XASSET_DASHBBOARD);

$adminObject->addInfoBoxLine(_MI_XASSET_DASHBBOARD, _MI_XASSET_APPLICATIONS, $hApp->getAllApplicationsCount(), 'Green');
$adminObject->addInfoBoxLine(_MI_XASSET_DASHBBOARD, _MI_XASSET_LICENSES, $hLic->getAllLicensesCount(), 'Green');
$adminObject->addInfoBoxLine(_MI_XASSET_DASHBBOARD, _MI_XASSET_FILES, $hPack->getAllPackagesCount(), 'Green');
$adminObject->addInfoBoxLine(_MI_XASSET_DASHBBOARD, _MI_XASSET_LINKS, $hLinks->getAllLinksCount(), 'Green');
$adminObject->addInfoBoxLine(_MI_XASSET_DASHBBOARD, _MI_XASSET_DOWNLOADS, $hStat->getAllDownloadStats(), 'Green');
if ($test) {
    $adminObject->addInfoBoxLine(_MI_XASSET_DASHBBOARD, '<br>Outgoing SSL Support? Yes', 'Green');
} else {
    $adminObject->addInfoBoxLine(_MI_XASSET_DASHBBOARD, '<br>Outgoing SSL Support? Failed with codes errnum: ' . $errnum . ' and errstr: ' . $errstr, 'Green');
}

$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayIndex();

require_once __DIR__ . '/admin_footer.php';
