<?php

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
    $hPackage = xoops_getModuleHandler('package', 'xasset');
    $hCommon  = xoops_getModuleHandler('common', 'xasset');
    //
    $objResponse = new xajaxResponse();
    //
    if ($hCommon->keyMatches($packageID, $packageKey, $hPackage->_weight)) {
        $oPackage =& $hPackage->get($packageID);
        //
        $objResponse->addAssign('movie_player', 'innerHTML', '');
        $objResponse->addScriptCall('renderPlayer', $packageID, $oPackage->fileSize(), $xoopsUser ? $hCommon->pspEncrypt($xoopsUser->uid()) : $hCommon->pspEncrypt(0));
    } else {
        $objResponse->addAssign('movie_player', 'innerHTML', '');
    }

    //
    return $objResponse;
}

$hAjax = xoops_getModuleHandler('ajax', 'xasset');
$oAjax = $hAjax->create();
//
$oAjax->registerFunction('onSampleClick');
$oAjax->processRequests();
