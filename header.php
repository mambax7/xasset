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

//need to catch processOptionForm as this needs special processing
if (\Xmf\Request::hasVar('op', 'GET') && ('processOptionForm' === $_GET['op']) && isset($_GET['ssl']) && isset($_GET['url'])) {
    $xoopsOption['nocommon'] = 1;
    require_once  dirname(dirname(__DIR__)) . '/mainfile.php';
    runkit_constant_redefine('XOOPS_URL', base64_decode(urldecode($_GET['url'])));
    unset($xoopsOption['nocommon']);
    require_once XOOPS_ROOT_PATH . '/include/common.php';
} else {
    require_once  dirname(dirname(__DIR__)) . '/mainfile.php';
}

require_once __DIR__ . '/include/images.php';
require_once __DIR__ . '/include/functions.php';

define('XASSET_BASE_PATH', XOOPS_ROOT_PATH . '/modules/xasset');
define('XASSET_CLASS_PATH', XASSET_BASE_PATH . '/class');

$xassetCSS            = XOOPS_URL . '/modules/xasset/assets/css/xasset.css';
$xasset_module_header = '<link rel="stylesheet" type="text/css" media="all" href="' . $xassetCSS . '"><!--[if lt IE 7]><script src="/assets/js/iepngfix.js" language="JavaScript" type="text/javascript"></script><![endif]-->';
