<?php

/**
 * @param $options
 *
 * @return array
 */
function b_xasset_currencies($options)
{
    $hCurrency = xoops_getModuleHandler('currency', 'xasset');
    //
    $blocks                = [];
    $blocks['select']      =& $hCurrency->getSelectArray();
    $blocks['current']     = isset($_SESSION['currency_id']) ? $_SESSION['currency_id'] : 0;
    $blocks['application'] = isset($_SESSION['application_id']) ? $_SESSION['application_id'] : 0;

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
    $hStats = xoops_getModuleHandler('userPackageStats', 'xasset');
    //
    $block              = [];
    $block['downloads'] =& $hStats->getTopDownloads('' <> $options[0] ? $options[0] : null);
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
    $hApp = xoops_getModuleHandler('application', 'xasset');
    //
    $block            = [];
    $block['columns'] = (isset($options[0]) and ('' <> $options[0])) ? $options[0] : 3;
    $block['rows']    = (isset($options[1]) and ('' <> $options[1])) ? $options[1] : 3;
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
    $hApp = xoops_getModuleHandler('application', 'xasset');
    //
    $aApps =& $hApp->getUserApplications();
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
    $hCommon = xoops_getModuleHandler('common', 'xasset');
    //
    $ary['xasset_block_top'] = [
        'count'     => (isset($options[0]) and ('' <> $options[0])) ? $options[0] : 10,
        'show_down' => (isset($options[1]) and ('' <> $options[1])) ? $options[1] : 0
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
    $hCommon = xoops_getModuleHandler('common', 'xasset');
    //
    $ary['xasset_block_pic'] = [
        'columns' => (isset($options[0]) and ('' <> $options[0])) ? $options[0] : 3,
        'rows'    => (isset($options[1]) and ('' <> $options[1])) ? $options[1] : 3
    ];

    return $hCommon->fetchTemplate('xasset_block_pics_option', $ary);
}
