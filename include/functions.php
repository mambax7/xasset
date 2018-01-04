<?php

use XoopsModules\Xasset;

///////////////////////////////////////////////////
/**
 * @param $body
 * @param $moduleName
 *
 * @return mixed
 */
function parseConstants($body, $moduleName)
{
    global $xoopsConfig;
    //
    $hModule = xoops_getHandler('module');
    $module  = $hModule->getByDirname($moduleName);
    //
    $tags                 = [];
    $tags['X_MODULE']     = $module->getVar('name');
    $tags['X_SITEURL']    = XOOPS_URL;
    $tags['X_DOCROOT']    = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/files/';
    $tags['X_SITENAME']   = $xoopsConfig['sitename'];
    $tags['X_ADMINMAIL']  = $xoopsConfig['adminmail'];
    $tags['X_MODULE_URL'] = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/';
    //
    foreach ($tags as $k => $v) {
        $body = preg_replace('/{' . $k . '}/', $v, $body);
    }

    return $body;
}

///////////////////////////////////////////////////
/**
 * @return array
 */
function getGroupClients()
{
    global $xoopsOption;
    //
    $hConfig = new Xasset\ConfigHandler($GLOBALS['xoopsDB']);
    $gid     = $hConfig->getGroup();
    //
    $hMember = xoops_getHandler('member');
    $users   = $hMember->getUsersByGroup($gid, true);
    //
    $ar = [];
    foreach ($users as $user) {
        $ar[$user->getVar('uid')] = $user->getVar('name');
    }

    //
    return $ar;
}

//////////////////////////////////////////////////////////
/**
 * @param      $name
 * @param null $date
 *
 * @return string
 */
function getDateField($name, $date = null)
{
    if (!isset($date)) {
        $date = time();
    }
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    //
    if (class_exists('XoopsFormCalendar')) {
        $cal = new \XoopsFormCalendar($name, $name, $date, [], ['value' => date('Y-m-d', $date)]);

        return $cal->render();
    } else {
        //    require_once XOOPS_ROOT_PATH.'/include/calendarjs.php';
        require_once XOOPS_ROOT_PATH . '/modules/xasset/include/calendarjs.php';

        return "<input type='text' name='$name' id='$name' size='11' maxlength='11' value='" . date('Y-m-d', $date) . "'><input type='reset' value=' ... ' onclick='return showCalendar(\"" . $name . "\");'>";
    }
}

/////////////////////////////////////////
/**
 * @param $id
 * @param $key
 * @param $weight
 * @param $error
 *
 * @return bool
 */
function keyMatches($id, $key, $weight, $error)
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $xasset_module_header;
    //
    $crypt = new Xasset\Crypt();
    //
    if ($crypt->keyMatches($id + $weight, $key)) {
        return true;
    } else {
        $GLOBALS['xoopsOption']['template_main'] = 'xasset_error.tpl';
        require_once XOOPS_ROOT_PATH . '/header.php';
        $xoopsTpl->assign('xasset_error', $error);
        include XOOPS_ROOT_PATH . '/footer.php';

        return false;
    }
}

///////////////////////////////////////////////
/**
 * @param $id
 * @param $weight
 *
 * @return string
 */
function getKey($id, $weight)
{
    $crypt = new Xasset\Crypt();

    return $crypt->cryptValue($id, $weight);
}

/////////////////////////////////////////
/**
 * @return mixed
 */
function insertHeaderCountriesJavaScript()
{
    $hCommon = new Xasset\CommonHandler($GLOBALS['xoopsDB']);

    return $hCommon->insertHeaderCountriesJavaScript();
}

/////////////////////////////////////////
/**
 * @return mixed
 */
function insertHeaderCountriesJavaScriptNoAllZones()
{
    $hCommon = new Xasset\CommonHandler($GLOBALS['xoopsDB']);

    return $hCommon->insertHeaderCountriesJavaScriptNoAllZones();
}
