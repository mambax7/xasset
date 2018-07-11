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
 * @author       Nazar Aziz (www.panthersoftware.com)
 * @author       XOOPS Development Team
 * @package      xAsset
 */

use XoopsModules\Xasset;

//hack to kill referrer check..we don't want this as it comes from gateway and not xoops
define('XOOPS_XMLRPC', 1);
require_once __DIR__ . '/servicemain.php';

//scan through members and:
//1. generate expiry warning emails
//2. remove expired members from groups
//first get members who are about to expire
$hMembers = new Xasset\ApplicationProductMembHandler($GLOBALS['xoopsDB']);
$hCommon  = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
$hNotify  = new Xasset\NotificationServiceHandler($GLOBALS['xoopsDB']);
//
$days = $hCommon->getModuleOption('memExpireDaysWarn');
$days = 30;
$crit = new \CriteriaCompo(new \Criteria('expiry_date', time() + ($days * 60 * 60 * 24), '<'));
$crit->add(new \Criteria('expiry_date', time(), '>'));
//
$aMembers = $hMembers->getObjects($crit);
//
if ((is_array($aMembers) > 0) && count($aMembers)) {
    echo 'Notifying ' . count($aMembers) . ' user(s) of pending membership expiry.<br>';
}
//
foreach ($aMembers as $id => $oMember) {
    //warn members once a day as we don't want them spammed if the cron runs every minute!!
    if ($oMember->sentOverADayAgo()) {
        $hNotify->expire_warning($oMember);
        $oMember->setSentWarning();
        $hMembers->insert($oMember, true);
    }
}

//next expire any members who have not renewed

$crit     = new \Criteria('expiry_date', time(), '<');
$aMembers = $hMembers->getMembers($crit);
//
if ((is_array($aMembers) > 0) && count($aMembers)) {
    echo 'Expiring ' . count($aMembers) . ' member accounts.<br>';
}
//
foreach ($aMembers as $id => $aMember) {
    $hNotify->expire_account($aMember);
    $hMembers->removeFromGroup($aMember['id'], true);
}
