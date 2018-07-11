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

/**
 * @param null|array $options
 *
 * @return array
 */
function b_xasset_currencies($options=null)
{
    $hCurrency = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
    //
    $blocks                = [];
    $blocks['select']      = $hCurrency->getSelectArray();
    $blocks['current']     = \Xmf\Request::getInt('currency_id', 0, $_SESSION);
    $blocks['application'] = \Xmf\Request::getInt('application_id', 0, $_SESSION);

    //
    return $blocks;
}

//////////////////////////////////////
/**
 * @param $options
 *
 * @return array
 */
function b_xasset_downloads($options)
{
    $hStats = new Xasset\UserPackageStatsHandler($GLOBALS['xoopsDB']);
    //
    $block              = [];
    $block['downloads'] = $hStats->getTopDownloads('' <> $options[0] ? $options[0] : null);
    $block['showDowns'] = isset($options[1]) ? $options[1] : 0;

    //
    return $block;
}

//////////////////////////////////////
/**
 * @param $options
 *
 * @return array
 */
function b_xasset_pics($options)
{
    $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    //
    $block            = [];
    $block['columns'] = (isset($options[0]) && ('' <> $options[0])) ? $options[0] : 3;
    $block['rows']    = (isset($options[1]) && ('' <> $options[1])) ? $options[1] : 3;
    $block['images']  = $hApp->getAppImages();

    //
    return $block;
}

/////////////////////////////////////
/**
 * @param $options
 *
 * @return array
 */
function b_xasset_apps($options)
{
    $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    //
    $aApps = $hApp->getUserApplications();
    //
    $i     = 0;
    $block = [];
    foreach ($aApps as $key => $oApp) {
        $block[$i]['id']   = $oApp->ID();
        $block[$i]['key']  = $oApp->getKey();
        $block[$i]['name'] = $oApp->name();
    }
    print_r($block);

    return $block;
}

///////////////////////////// options function //////////////////////////////////
/**
 * @param $options
 *
 * @return mixed
 */
function b_xasset_downloads_opt($options)
{
    $hCommon = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
    //
    $ary['xasset_block_top'] = [
        'count'     => (isset($options[0]) && ('' <> $options[0])) ? $options[0] : 10,
        'show_down' => (isset($options[1]) && ('' <> $options[1])) ? $options[1] : 0
    ];

    return $hCommon->fetchTemplate('xasset_block_download_option', $ary);
}

//////////////////////////////////////////
/**
 * @param $options
 *
 * @return mixed
 */
function b_xasset_pics_opt($options)
{
    $hCommon = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
    //
    $ary['xasset_block_pic'] = [
        'columns' => (isset($options[0]) && ('' <> $options[0])) ? $options[0] : 3,
        'rows'    => (isset($options[1]) && ('' <> $options[1])) ? $options[1] : 3
    ];

    return $hCommon->fetchTemplate('xasset_block_pics_option', $ary);
}
