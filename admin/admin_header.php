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

use XoopsModules\Xasset;

$path = dirname(dirname(dirname(__DIR__)));
require_once $path . '/include/cp_header.php';

require_once dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName = basename(dirname(__DIR__));
/** @var Xasset\Helper $helper */
$helper = Xasset\Helper::getInstance();
$adminObject = \Xmf\Module\Admin::getInstance();

$pathIcon16    = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32    = \Xmf\Module\Admin::iconUrl('', 32);
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
//$helper->loadLanguage('main');
$helper->loadLanguage('common');

$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    require_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new \XoopsTpl();
}

define('XASSET_BASE_PATH', XOOPS_ROOT_PATH . '/modules/xasset');
define('XASSET_CLASS_PATH', XASSET_BASE_PATH . '/class');
define('XASSET_ADMIN_PATH', XASSET_BASE_PATH . '/admin');

require_once XASSET_BASE_PATH . '/admin/AdminButtons.php';
require_once XASSET_BASE_PATH . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/template.php';

require_once  dirname(__DIR__) . '/include/images.php';

//global $xoopsModule;
$module_id = $helper->getModule()->getVar('mid');
