<?php

use Xoopsmodules\xasset;

require_once __DIR__ . '/../../../mainfile.php';

/**
 * @param $packageID
 * @param $packageKey
 *
 * @return xajaxResponse
 */
function onSampleClick($packageID, $packageKey)
{
    global $xoopsUser;
    //
    $hPackage = new xasset\PackageHandler($GLOBALS['xoopsDB']);
    $hCommon  = new xasset\CommonHandler($GLOBALS['xoopsDB']);
    //
    $objResponse = new \XajaxResponse();
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

$hAjax = new xasset\AjaxHandler($GLOBALS['xoopsDB']);
$oAjax = $hAjax->create();
//
$oAjax->registerFunction('onSampleClick');
$oAjax->processRequests();
