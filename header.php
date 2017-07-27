<?php
//need to catch processOptionForm as this needs special processing
if (isset($_GET['op']) && ($_GET['op'] === 'processOptionForm') && isset($_GET['ssl']) && isset($_GET['url'])) {
    $xoopsOption['nocommon'] = 1;
    require_once __DIR__ . '/../../mainfile.php';
    runkit_constant_redefine('XOOPS_URL', base64_decode(urldecode($_GET['url'])));
    unset($xoopsOption['nocommon']);
    require XOOPS_ROOT_PATH . '/include/common.php';
} else {
    require_once __DIR__ . '/../../mainfile.php';
}

require_once __DIR__ . '/include/images.php';
require_once __DIR__ . '/include/functions.php';

define('XASSET_BASE_PATH', XOOPS_ROOT_PATH . '/modules/xasset');
define('XASSET_CLASS_PATH', XASSET_BASE_PATH . '/class');

$xassetCSS            = XOOPS_URL . '/modules/xasset/assets/css/xasset.css';
$xasset_module_header = '<link rel="stylesheet" type="text/css" media="all" href="' . $xassetCSS . '"><!--[if lt IE 7]><script src="/assets/js/iepngfix.js" language="JavaScript" type="text/javascript"></script><![endif]-->';
