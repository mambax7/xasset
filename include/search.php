<?php

/**
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 *
 * @return array
 */
function xasset_search($queryarray, $andor, $limit, $offset, $userid)
{
    $hApp     = xoops_getModuleHandler('application', 'xasset');
    $hAppProd = xoops_getModuleHandler('applicationProduct', 'xasset');
    $hCommon  = xoops_getModuleHandler('common', 'xasset');
    //
    $aApps  =& $hApp->seachApplication($queryarray, $andor, $limit, $offset, $userid);
    $aProds =& $hAppProd->searchApplicationProduct($queryarray, $andor, $limit, $offset, $userid);
    //first the apps
    $ret = [];
    $i   = 0;
    if (count($aApps) > 0 && isset($oApp)) {
        foreach ($aApps as $key => $oApp) {
            $ret[$i]['image'] = 'assets/images/main.png';
            $ret[$i]['link']  = 'index.php?op=product&id=' . $oApp->ID() . '&key=' . $oApp->getKey();
            $ret[$i]['title'] = $oApp->name();
            $ret[$i]['time']  = null;
            $ret[$i]['uid']   = 0;
            ++$i;
        }
    }
    //next the products
    if (count($aProds) > 0) {
        foreach ($aProds as $key => $oProduct) {
            $ret[$i]['image'] = 'assets/images/claimOwner.png';
            $ret[$i]['link']  = 'index.php?op=product&id=' . $oProduct->applicationID() . '&key=' . $hCommon->cryptValue($oProduct->applicationID(), $hApp->_weight);
            $ret[$i]['title'] = $oProduct->itemDescription();
            $ret[$i]['time']  = null;
            $ret[$i]['uid']   = 0;
            ++$i;
        }
    }

    //
    return $ret;
}
