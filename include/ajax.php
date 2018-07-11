<?php

use XoopsModules\Xasset;
use XoopsModules\Xasset\Xajax;

require_once  dirname(dirname(dirname(__DIR__))) . '/mainfile.php';

/**
 * @param $packageID
 * @param $packageKey
 *
 * @return Xajax\XajaxResponse
 */
function onSampleClick($packageID, $packageKey)
{
    global $xoopsUser;
    //
    $hPackage = new Xasset\PackageHandler($GLOBALS['xoopsDB']);
    $hCommon  = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
    //
    $objResponse = new Xajax\XajaxResponse();
    //
    if ($hCommon->keyMatches($packageID, $packageKey, $hPackage->_weight)) {
        $oPackage = $hPackage->get($packageID);
        //
        $objResponse->addAssign('movie_player', 'innerHTML', '');
        $objResponse->addScriptCall('renderPlayer', $packageID, $oPackage->fileSize(), $xoopsUser ? $hCommon->pspEncrypt($xoopsUser->uid()) : $hCommon->pspEncrypt(0));
    } else {
        $objResponse->addAssign('movie_player', 'innerHTML', '');
    }

    //
    return $objResponse;
}

$hAjax = new Xasset\AjaxHandler($GLOBALS['xoopsDB']);
$oAjax = $hAjax->create();
//
$oAjax->registerFunction('onSampleClick');
$oAjax->processRequests();
