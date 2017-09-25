<?php
//Include XOOPS Global Includes
error_reporting(0); //THIS SHOULD ALWAYS BE SET TO 0 OTHERWISE PAYPAL GET BROKEN
$xoopsOption['nocommon'] = 1;

if (defined('XOOPS_TEST_ROOT_PATH')) {
    require XOOPS_TEST_ROOT_PATH . '/mainfile.php';
} else {
    require_once __DIR__ . '/../../mainfile.php';
}

require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/criteria.php';
require_once XOOPS_ROOT_PATH . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/logger.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';
require_once XOOPS_ROOT_PATH . '/kernel/user.php';

define('XOOPS_CACHE_PATH', XOOPS_ROOT_PATH . '/cache');
define('XOOPS_UPLOAD_PATH', XOOPS_ROOT_PATH . '/uploads');
define('XOOPS_THEME_PATH', XOOPS_ROOT_PATH . '/themes');
define('XOOPS_COMPILE_PATH', XOOPS_ROOT_PATH . '/templates_c');
define('XOOPS_THEME_URL', XOOPS_URL . '/themes');
define('XOOPS_UPLOAD_URL', XOOPS_URL . '/uploads');
define('XASSET_BASE_PATH', XOOPS_ROOT_PATH . '/modules/xasset');
define('XASSET_CLASS_PATH', XASSET_BASE_PATH . '/class');

//Initialize XOOPS Logger
$xoopsLogger = XoopsLogger::getInstance();
$xoopsLogger->startTime();

//Initialize DB Connection
require_once XOOPS_ROOT_PATH . '/class/database/databasefactory.php';
$xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();
//
/** @var XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$xoopsModule   = $moduleHandler->getByDirname('xasset');
$module        =& $moduleHandler;
//
$configHandler   = xoops_getHandler('config');
$xoopsConfig     = $configHandler->getConfigsByCat(XOOPS_CONF);
$xoopsConfigUser = $configHandler->getConfigsByCat(XOOPS_CONF_USER);
//

if (1 == $xoopsModule->getVar('hasconfig') || 1 == $xoopsModule->getVar('hascomments')
    || 1 == $xoopsModule->getVar('hasnotification')) {
    $xoopsModuleConfig = $configHandler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
}

//Include XOOPS Language Files
if (file_exists(XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/global.php')) {
    require_once XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/global.php';
} else {
    require_once XOOPS_ROOT_PATH . '/language/english/global.php';
}

if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/main.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/main.php';
} else {
    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/english/main.php';
}
