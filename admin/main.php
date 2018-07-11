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

//require_once  dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once __DIR__ . '/admin_header.php';

//require(__DIR__ . '/../include/functions.php');

global $xoopsModule;
$module_id = $xoopsModule->getVar('mid');

$op    = \Xmf\Request::getCmd('op', 'default');

switch ($op) {
    case 'manageApplications':
        xoops_cp_header();
        manageApplications();
        break;
    //
    case 'addApplication':
        addApplication($_POST);
        break;
    //
    case 'deleteApplication':
        deleteApplication($_GET['id']);
        break;
    //
    case 'doDeleteApplication':
        doDeleteApplication($_POST['id']);
        break;
    //
    case 'editApplication':
        xoops_cp_header();
        editApplication($_GET['id']);
        break;
    //
    case 'manageLicenses':
        xoops_cp_header();
        manageLicenses();
        break;
    //
    case 'addLicense':
        addLicense($_POST);
        break;
    //
    case 'viewAppLicenses':
        xoops_cp_header();
        viewAppLicenses($_GET['id']);
        break;
    //
    case 'viewClientLicenses':
        xoops_cp_header();
        viewClientLicenses($_GET['id'], $_GET['appid']);
        break;
    //
    case 'editClientLicense':
        xoops_cp_header();
        editClientLicense($_GET['id']);
        break;
    //
    case 'deleteClientLicense':
        deleteClientLicense($_GET['id']);
        break;
    //
    case 'managePackages':
        if (\Xmf\Request::hasVar('appid', 'GET')) {
            $appid = $_GET['appid'];
        } else {
            $appid = 0;
        }
        xoops_cp_header();
        managePackages($appid);
        break;
    //
    case 'addPackageGroup':
        addPackageGroup($_POST);
        break;
    //
    case 'editPackageGroup':
        xoops_cp_header();
        editPackageGroup($_GET['id'], $_GET['appid']);
        break;
    //
    case 'deletePackageGroup':
        deletePackageGroup($_GET['id']);
        break;
    //
    case 'addPackage':
        addPackage($_POST);
        break;
    //
    case 'deletePackage':
        deletePackage($_GET['id']);
        break;
    //
    case 'doDeletePackage':
        doDeletePackage($_POST['id']);
        break;
    //
    case 'editPackage':
        xoops_cp_header();
        editPackage($_GET['id']);
        break;
    //
    case 'manageLinks':
        xoops_cp_header();
        isset($_GET['appid']) ? manageLinks($_GET['appid']) : manageLinks();
        break;
    //
    case 'addLink':
        addLink($_POST);
        break;
    //
    case 'deleteLink':
        deleteLink($_GET['id']);
        break;
    //
    case 'editLink':
        xoops_cp_header();
        editLink($_GET['id']);
        break;
    //
    case 'viewDownloadStats':
        xoops_cp_header();
        isset($_GET['appid']) ? viewDownloadStats($_GET['appid']) : viewDownloadStats();
        break;
    //
    case 'deleteStat':
        deleteStat($_GET['id']);
        break;
    //
    case 'manageCountries':
        xoops_cp_header();
        manageCountries();
        break;
    //
    case 'addCountry':
        addCountry($_POST);
        break;
    //
    case 'editCountry':
        xoops_cp_header();
        editCountry($_GET['id']);
        break;
    //
    case 'manageZones':
        xoops_cp_header();
        manageZones();
        break;
    //
    case 'addZone':
        addZone($_POST);
        break;
    //
    case 'editZone':
        xoops_cp_header();
        editZone($_GET['id']);
        break;
    //
    case 'deleteZone':
        deleteZone($_GET['id']);
        break;
    //
    case 'manageTaxes':
        xoops_cp_header();
        manageTaxes();
        break;
    //
    case 'addTaxClass':
        addTaxClass($_POST);
        break;
    //
    case 'addTaxRate':
        addTaxRate($_POST);
        break;
    //
    case 'addTaxZone':
        addTaxZone($_POST);
        break;
    //
    case 'editTaxZone':
        xoops_cp_header();
        editTaxZone($_GET['id']);
        break;
    //
    case 'deleteTaxZone':
        deleteTaxZone($_GET['id']);
        break;
    //
    case 'editTaxClass':
        xoops_cp_header();
        editTaxClass($_GET['id']);
        break;
    //
    case 'editTaxRate':
        xoops_cp_header();
        editTaxRate($_GET['id']);
        break;
    //
    case 'deleteTaxClass':
        deleteTaxClass($_GET['id']);
        break;
    //
    case 'deleteTaxRate':
        deleteTaxRate($_GET['id']);
        break;
    //
    case 'manageCurrencies':
        xoops_cp_header();
        manageCurrencies();
        break;
    //
    case 'addCurrency':
        addCurrency($_POST);
        break;
    //
    case 'editCurrency':
        xoops_cp_header();
        editCurrency($_GET['id']);
        break;
    //
    case 'deleteCurrency':
        deleteCurrency($_GET['id']);
        break;
    //
    case 'addAppProduct':
        addAppProduct($_POST);
        break;
    //
    case 'deleteAppProduct':
        deleteAppProduct($_GET['id']);
        break;
    //
    case 'doDeleteAppProduct':
        doDeleteAppProduct($_POST['id']);
        break;
    //
    case 'editAppProduct':
        xoops_cp_header();
        editAppProduct($_GET['id']);
        break;
    //
    case 'manageGateways':
        xoops_cp_header();
        isset($_GET['id']) ? manageGateways($_GET['id']) : manageGateways();
        break;
    //
    case 'toggleGateway':
        xoops_cp_header();
        toggleGateway($_POST);
        break;
    //
    case 'updateGatewayValues':
        xoops_cp_header();
        updateGatewayValues($_POST);
        break;
    //
    case 'gatewayLogs':
        xoops_cp_header();
        gatewayLogs();
        break;
    //
    case 'showLogDetail':
        xoops_cp_header();
        showLogDetail($_GET['id']);
        break;
    //
    case 'removeLogItem':
        removeLogItem($_GET['id']);
        break;
    //
    case 'config':
        xoops_cp_header();
        config();
        break;
    //
    case 'updateConfig':
        xoops_cp_header();
        updateConfig($_POST);
        break;
    //
    case 'manageRegion':
        xoops_cp_header();
        manageRegion();
        break;
    //
    case 'addRegion':
        addRegion($_POST);
        break;
    //
    case 'editRegion':
        xoops_cp_header();
        editRegion($_GET['id']);
        break;
    //
    case 'deleteRegion':
        deleteRegion($_GET['id']);
        break;
    //
    case 'orderTracking':
        orderTracking();
        break;
    //
    case 'showOrderLogDetail':
        showOrderLogDetail($_GET['id']);
        break;
    //
    case 'checkTables':
        checkTables();
        break;
    //
    case 'support':
        support();
        break;
    //
    case 'opCompOrder':
        opCompOrder($_POST);
        break;
    //
    case 'opDelOrder':
        opDelOrder($_POST);
        break;
    //
    case 'membership':
        membership();
        break;
    //
    case 'removeFromGroup':
        removeFromGroup($_GET['id']);
        break;
    //
    case 'doRemoveFromGroup':
        doRemoveFromGroup($_POST['id']);
        break;
    //
    case 'default':
    default:
        xoops_cp_header();
        loadIndex();
        break;
}

//////////////////////////////////////////////////////////////////////////////////////////////////

function loadIndex()
{
    /*
  global $oAdminButton, $xoopsTpl;
  $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_index.tpl';
  //
  $hApp       = xoops_getModuleHandler('application','xasset');
  $licenseHandler       = xoops_getModuleHandler('license','xasset');
  $hPack      = xoops_getModuleHandler('package','xasset');
  $hStat      = xoops_getModuleHandler('userPackageStats','xasset');
  $hLinks     = xoops_getModuleHandler('link','xasset');
  //
  $xasset_index['applications']     = $hApp->getAllApplicationsCount();
  $xasset_index['licenses']         = $licenseHandler->getAllLicensesCount();
  $xasset_index['files']            = $hPack->getAllPackagesCount();
  $xasset_index['links']            = $hLinks->getAllLinksCount();
  $xasset_index['downloads']        = $hStat->getAllDownloadStats();
  //test SSL connectivity
  $fp = fsockopen('ssl://www.paypal.com', 443,$errnum,$errstr,30);
  if (!$fp)
    $test = array('pass' => false, 'errnum' => $errnum, 'errstr' => $errstr);
  else
    $test = array('pass' => true);
  //
//  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('index'));
  $xoopsTpl->assign('xasset_index',$xasset_index);
  $xoopsTpl->assign('xasset_test',$test);
  //$xoopsTpl->assign('xasset_applications',$appsArray);
  //

    */
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
function manageApplications()
{
    global $xoopsTpl ;
    /** @var Xasset\Helper $helper */
    $helper = Xasset\Helper::getInstance();

    //    $adminObject = \Xmf\Module\Admin::getInstance();
    //    $adminObject->displayNavigation('main.php?op=manageApplications');

    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_application_index.tpl';
    //
    $hApps      =  Xasset\Helper::getInstance()->getHandler('Application');// xoops_getModuleHandler('application', 'xasset');
    $hTaxClass  =  Xasset\Helper::getInstance()->getHandler('TaxClass');// new Xasset\TaxClassHandler($GLOBALS['xoopsDB']);
    $hCurrency  =  Xasset\Helper::getInstance()->getHandler('Currency');//new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
    $hGroups    =  Xasset\Helper::getInstance()->getHandler('ApplicationGroup');//new Xasset\ApplicationGroupHandler($GLOBALS['xoopsDB']);
    $hPackGroup =  Xasset\Helper::getInstance()->getHandler('PackageGroup');//xoops_getModuleHandler('packageGroup', 'xasset');

    //  $hEditor    = xoops_getModuleHandler('editor','xasset');
    $hMember = xoops_getHandler('member');
    //
    $classArray = $hTaxClass->getSelectArray();
    $currArray  = $hCurrency->getSelectArray();
    $appsArray  = $hApps->getApplicationSelectArray();
    $aPackages  = $hPackGroup->getAllGroupsSelectArray();
    //
    $showProdBlock = (count($classArray) > 0) && (count($currArray) > 0) && (count($appsArray) > 0);
    //
    $criteria = new \CriteriaCompo();
    $criteria->setSort('name');
    //
    $ar                    = [];
    $ar['permission_cbs']  = $hGroups->getCBGroupString();
    $ar['productsVisible'] = true;
    //
    $aMembers   = $hMember->getGroups();
    $aGroups    = [];
    $aGroups[0] = 'No Action';
    foreach ($aMembers as $group) {
        $aGroups[$group->getVar('groupid')] = $group->getVar('name');
    }
    //
    //$dateField = getDateField('expires',time());
    //$xoopsTpl->assign('applications',$hApps->getApplicationsArray($criteria));
    $xoopsTpl->assign('applications', $hApps->getApplicationsSummaryArray($criteria));
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manApp'));
    $xoopsTpl->assign('xasset_app_operation', 'Create an');
    $xoopsTpl->assign('xasset_app_operation_short', 'create');
    $xoopsTpl->assign('xasset_applications', $appsArray);
    $xoopsTpl->assign('xasset_tax_classes', $classArray);
    $xoopsTpl->assign('xasset_currencies', $currArray);
    $xoopsTpl->assign('xasset_show_prod_block', $showProdBlock);
    $xoopsTpl->assign('xasset_operation', 'Add an');
    $xoopsTpl->assign('xasset_operation_short', 'create');
    $xoopsTpl->assign('xasset_date_field', getDateField('expires', time()));
    $xoopsTpl->assign('xasset_expdate_field', getDateField('group_expire_date', time()));
    $xoopsTpl->assign('xasset_app', $ar);
    $xoopsTpl->assign('xasset_xoops_groups', $aGroups);

    //  $xoopsTpl->assign('xasset_app_memo_field',$hEditor->slimEditorDraw('richDescription'));

    if (class_exists('XoopsFormEditor')) {
        $configs = [
            'name'   => 'richDescription',
            'value'  => '',
            'rows'   => 25,
            'cols'   => '100%',
            'width'  => '100%',
            'height' => '250px'
        ];
        $editor  = new \XoopsFormEditor('', $helper->getConfig('editor_options'), $configs, false, $onfailure = 'textarea');
    } else {
        $editor = new \XoopsFormDhtmlTextArea('', 'richDescription', $this->getVar('richDescription', 'e'), '100%', '100%');
    }

    $xoopsTpl->assign('xasset_app_memo_field', $editor->render());

    //  $xoopsTpl->assign('xasset_appprod_memo_field',$hEditor->slimEditorDraw('item_rich_description'));

    if (class_exists('XoopsFormEditor')) {
        $configs = [
            'name'   => 'item_rich_description',
            'value'  => '',
            'rows'   => 25,
            'cols'   => '100%',
            'width'  => '100%',
            'height' => '250px'
        ];
        $editor  = new \XoopsFormEditor('', $helper->getConfig('editor_options'), $configs, false, $onfailure = 'textarea');
    } else {
        $editor = new \XoopsFormDhtmlTextArea('', 'item_rich_descriptionn', $this->getVar('item_rich_description', 'e'), '100%', '100%');
    }

    $xoopsTpl->assign('xasset_appprod_memo_field', $editor->render());

    $xoopsTpl->assign('xasset_xoops_packages', $aPackages);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
/**
 * @param $post
 */
function addApplication($post)
{
    $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    $hGrp = new Xasset\ApplicationGroupHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['appid'])) {
        $app = $hApp->get($post['appid']);
    }
    if (!is_object($app)) {
        $app = $hApp->create();
        $app->setVar('datePublished', time());
    }
    $app->setVarsFromArray($post);
    $app->setVar('requiresLicense', isset($post['requiresLicense']));
    $app->setVar('listInEval', isset($post['listInEval']));
    $app->setVar('mainMenu', isset($post['mainMenu']));
    $app->setVar('hasSamples', isset($post['hasSamples']));
    $app->setVar('productsVisible', isset($post['productsVisible']));
    //
    if ($hApp->insert($app)) {
        //now save group permissions
        $hGrp->updateGroup($app->getVar('id'), isset($post['cb']) ? $post['cb'] : null);
        redirect_header('main.php?op=manageApplications', 3, 'Application Added.');
    }
}

//////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteApplication($id)
{
    xoops_cp_header();
    xoops_confirm(['id' => $id], 'main.php?op=doDeleteApplication', 'Are you sure you want to delete this Application?', '', true);
    xoops_cp_footer();
}

//////////////////////////////////////////////////
/**
 * @param $id
 */
function doDeleteApplication($id)
{
    $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    if ($hApp->deleteApplication($id)) {
        redirect_header('main.php?op=manageApplications', 3, 'Application Deleted.');
    }
}

//////////////////////////////////////////////////
/**
 * @param $appid
 */
function editApplication($appid)
{
    global $xoopsTpl;
    /** @var Xasset\Helper $helper */
    $helper = Xasset\Helper::getInstance();

    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_application_add.tpl';
    //
    $hApp    = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    $hGroups = new Xasset\ApplicationGroupHandler($GLOBALS['xoopsDB']);
    //  $hEditor = xoops_getModuleHandler('editor','xasset');
    //
    $app = $hApp->get($appid);
    //
    $ar                   =& $app->getArray();
    $ar['permission_cbs'] = $hGroups->getCBGroupString($appid);
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manApp'));
    $xoopsTpl->assign('xasset_app_operation', 'Edit an');
    $xoopsTpl->assign('xasset_app_operation_short', 'modify');
    $xoopsTpl->assign('xasset_app', $ar);
    //  $xoopsTpl->assign('xasset_app_memo_field',$hEditor->slimEditorDraw('richDescription',$ar['richDescription']));

    if (class_exists('XoopsFormEditor')) {
        $configs = [
            'name'   => 'richDescription',
            'value'  => $ar['richDescription'],
            'rows'   => 25,
            'cols'   => '100%',
            'width'  => '100%',
            'height' => '250px'
        ];
        $editor  = new \XoopsFormEditor('', $helper->getConfig('editor_options'), $configs, false, $onfailure = 'textarea');
    } else {
        $editor = new \XoopsFormDhtmlTextArea('', 'richDescription', $this->getVar('richDescription', 'e'), '100%', '100%');
    }

    $xoopsTpl->assign('xasset_app_memo_field', $editor->render());

    //$xoopsTpl->assign('xasset_appprod_memo_field',$hEditor->slimEditorDraw('item_rich_description'));
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
function manageLicenses()
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=manageLicenses');
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_license_index.tpl';
    //
    $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    $licenseHandler = new Xasset\LicenseHandler($GLOBALS['xoopsDB']);
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manLic'));
    $xoopsTpl->assign('xasset_lic_list', $licenseHandler->getLicenseSummary());
    $xoopsTpl->assign('xasset_lic_select', $hApp->getApplicationSelectArray());
    $xoopsTpl->assign('xasset_users', getGroupClients());
    $xoopsTpl->assign('xasset_date_field', getDateField('expires', time()));
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
/**
 * @param $post
 */
function addLicense($post)
{
    $licenseHandler = new Xasset\LicenseHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['id']) && ($post['id'] > 0)) {
        $lic = $licenseHandler->get($post['id']);
    } else {
        $lic = $licenseHandler->create();
    }
    $lic->setVar('uid', $post['userid']);
    $lic->setVar('applicationid', $post['appid']);
    $lic->setVar('authKey', $post['key']);
    $lic->setVar('authCode', $post['authCode']);
    $lic->setVar('expires', $post['expires']);
    $lic->setVar('dateIssued', time());
    //
    if ($licenseHandler->insert($lic)) {
        if (isset($post['adminop'])) {
            redirect_header('main.php?op=' . $post['adminop'], 3, 'License Added.');
        } else {
            redirect_header('main.php?op=manageLicenses ', 3, 'License Added.');
        }
    }
}

//////////////////////////////////////////////////
/**
 * @param $appid
 */
function viewAppLicenses($appid)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_license_application.tpl';
    //
    $licenseHandler = new Xasset\LicenseHandler($GLOBALS['xoopsDB']);
    $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    //
    $app = $hApp->get($appid);
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manLic'));
    $xoopsTpl->assign('xasset_appid', $appid);
    $xoopsTpl->assign('xasset_lic_appname', $app->getVar('name'));
    $xoopsTpl->assign('xasset_lic_list', $licenseHandler->getAppLicenses($appid));
    $xoopsTpl->assign('xasset_lic_select', $hApp->getApplicationSelectArray());
    $xoopsTpl->assign('xasset_users', getGroupClients());
    $xoopsTpl->assign('adminop', "viewAppLicenses&id=$appid");
    $xoopsTpl->assign('xasset_date_field', getDateField('expires', time()));
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
/**
 * @param $uid
 * @param $appid
 */
function viewClientLicenses($uid, $appid)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_license_client.tpl';
    //
    $licenseHandler          = new Xasset\LicenseHandler($GLOBALS['xoopsDB']);
    $hApp          = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    $memberHandler = xoops_getHandler('member');
    //
    $lics = $licenseHandler->getClientLicenses($appid, $uid);
    $user = $memberHandler->getUser($uid);
    $app  = $hApp->get($appid);
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manLic'));
    $xoopsTpl->assign('xasset_appid', $appid);
    $xoopsTpl->assign('xasset_userid', $uid);
    $xoopsTpl->assign('xasset_lic_list', $lics);
    $xoopsTpl->assign('xasset_lic_clientname', $user->name());
    $xoopsTpl->assign('xasset_lic_appname', $app->getVar('name'));
    $xoopsTpl->assign('xasset_lic_select', $hApp->getApplicationSelectArray());
    $xoopsTpl->assign('xasset_users', getGroupClients());
    $xoopsTpl->assign('adminop', "viewClientLicenses&id=$uid&appid=$appid");
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
/**
 * @param $id
 */
function editClientLicense($id)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_license_add.tpl';
    //
    $licenseHandler = new Xasset\LicenseHandler($GLOBALS['xoopsDB']);
    $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    //
    $lic = $licenseHandler->get($id);
    //
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    $xoopsTpl->assign('xasset_operation', 'Modify');
    $xoopsTpl->assign('xasset_users', getGroupClients());
    $xoopsTpl->assign('xasset_license', $lic->getArray());
    $xoopsTpl->assign('xasset_date_field', getDateField('expires', $lic->getVar('expires')));
    $xoopsTpl->assign('adminop', 'viewClientLicenses&id=' . $lic->getVar('uid') . '&appid=' . $lic->getVar('applicationid'));
    $xoopsTpl->assign('xasset_lic_select', $hApp->getApplicationSelectArray());
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteClientLicense($id)
{
    $licenseHandler = new Xasset\LicenseHandler($GLOBALS['xoopsDB']);
    //
    if ($licenseHandler->deleteByID($id, true)) {
        redirect_header('main.php?op=manageLicenses', 3, 'License Deleted.');
    }
}

//////////////////////////////////////////////////
/**
 * @param int $appid
 */
function managePackages($appid = 0)
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=managePackages');
    $activeAppID                             = 0;
    $activeAppName                           = '';
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_packages_index.tpl';
    //
    $hApp     = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    $hPackGrp = new Xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
    //
    $criteria = new \CriteriaCompo();
    $criteria->setSort('name');
    //
    $apps = $hApp->getApplicationsArray($criteria);
    //
    if (count($apps) > 0) {
        if ($appid > 0) {
            $cnt = 0;
            while ($apps[$cnt]['id'] <> $appid) {
                ++$cnt;
            }
            $activeAppID   = $apps[$cnt]['id'];
            $activeAppName = $apps[$cnt]['name'];
        } else {
            $activeAppID   = $apps[0]['id'];
            $activeAppName = $apps[0]['name'];
        }
    }
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manPack'));
    $xoopsTpl->assign('xasset_applications', $apps);
    $xoopsTpl->assign('xasset_active_appname', $activeAppName);
    $xoopsTpl->assign('xasset_active_appid', $activeAppID);
    $xoopsTpl->assign('xasset_app_packagesgroups', $hPackGrp->getApplicationGroupPackages($activeAppID));
    $xoopsTpl->assign('xasset_app_apppackagesselect', $hPackGrp->getApplicationGroupsSelect($activeAppID));
    $xoopsTpl->assign('xasset_operation', 'Create a');
    $xoopsTpl->assign('xasset_operation_short', 'create');
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
/**
 * @param $post
 */
function addPackageGroup($post)
{
    $hPackGrp = new Xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['id']) && ($post['id'] > 0)) {
        $grp = $hPackGrp->get($post['id']);
        $op  = 'Edited';
    } else {
        $grp = $hPackGrp->create();
        $op  = 'Created';
    }
    //
    $grp->setVar('applicationid', $post['appid']);
    $grp->setVar('name', $post['name']);
    $grp->setVar('grpDesc', $post['grpDesc']);
    $grp->setVar('version', $post['version']);
    $grp->setVar('datePublished', time());
    //
    if ($hPackGrp->insert($grp)) {
        redirect_header('main.php?op=managePackages&appid=' . $post['appid'], 3, "Package Group $op.");
    }
}

//////////////////////////////////////////////////
/**
 * @param $id
 */
function deletePackage($id)
{
    xoops_cp_header();
    xoops_confirm(['id' => $id], 'main.php?op=doDeletePackage', 'Are you sure you want to delete this Package?', '', true);
}

//////////////////////////////////////////////////
/**
 * @param $id
 */
function doDeletePackage($id)
{
    $hPack = new Xasset\PackageHandler($GLOBALS['xoopsDB']);
    $hPack->deleteByID($id);
    redirect_header('main.php?op=managePackages', 2, 'Package Deleted');
}

//////////////////////////////////////////////////
/**
 * @param $id
 */
function editPackage($id)
{
    global $xoopsTpl;
    //
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_package_edit.tpl';
    //
    $crit = new \CriteriaCompo(new \Criteria('id', $id));
    //
    $hPackGrp = new Xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
    $hPack    = new Xasset\PackageHandler($GLOBALS['xoopsDB']);
    $pack     = $hPack->getPackagesArray($crit);
    //
    $appid = $hPack->getPackageApplication($id);
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manPack'));
    $xoopsTpl->assign('xasset_app_apppackagesselect', $hPackGrp->getApplicationGroupsSelect($appid));
    $xoopsTpl->assign('xasset_package', $pack[0]);
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
/**
 * @param $id
 */
function deletePackageGroup($id)
{
    $hPackGrp = new Xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
    $hPackGrp->deleteByID($id, true);
    //
    redirect_header('main.php?op=managePackages', 2, 'Package Group Deleted');
}

//////////////////////////////////////////////////
/**
 * @param $id
 * @param $appid
 */
function editPackageGroup($id, $appid)
{
    global $xoopsTpl;
    //
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_packagegroup_edit.tpl';
    //
    $hPackGrp = new Xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
    //
    $crit = new \CriteriaCompo(new \Criteria('id', $id));
    $pGrp = $hPackGrp->getPackageGroupArray($crit);
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manPack'));
    $xoopsTpl->assign('xasset_group', $pGrp[0]);
    $xoopsTpl->assign('xasset_active_appid', $pGrp[0]['applicationid']);
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////
/**
 * @param $post
 */
function addPackage($post)
{
    $hPack = new Xasset\PackageHandler($GLOBALS['xoopsDB']);
    //check if editing or creating
    if (isset($post['id']) && ($post['id'] > 0)) {
        $pack = $hPack->get($post['id']);
        $op   = 'Edited';
    } else {
        $pack = $hPack->create();
        $op   = 'Created';
    }
    $pack->setVarsFromArray($post);
    $pack->setVar('packagegroupid', $post['groupid']);
    $pack->setVar('protected', isset($post['protected']));
    $pack->setVar('isVideo', isset($post['isVideo']));
    //
    if ($hPack->insert($pack)) {
        redirect_header('main.php?op=managePackages&appid=' . $post['appid'], 3, "Package $op.");
    }
}

//////////////////////////////////////////////////
/**
 * @param null $appid
 */
function manageLinks($appid = null)
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=manageLinks');
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_links_index.tpl';
    //
    $hApp  = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    $hLink = new Xasset\LinkHandler($GLOBALS['xoopsDB']);
    //
    $apps = $hApp->getApplicationsArray();
    //
    if (count($apps) > 0) {
        if ($appid > 0) {
            $cnt = 0;
            while ($apps[$cnt]['id'] <> $appid) {
                ++$cnt;
            }
            $activeAppID   = $apps[$cnt]['id'];
            $activeAppName = $apps[$cnt]['name'];
        } else {
            $activeAppID   = $apps[0]['id'];
            $activeAppName = $apps[0]['name'];
        }
    }
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manLink'));
    $xoopsTpl->assign('xasset_links', $hLink->getAllLinks());
    $xoopsTpl->assign('xasset_app_apppackagesselect', $hApp->getApplicationSelectArray());
    $xoopsTpl->assign('xasset_link_function', 'Create a');
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function addLink($post)
{
    $hLink = new Xasset\LinkHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['id'])) {
        $link = $hLink->get($post['id']);
    }
    if (!is_object($link)) {
        $link = $hLink->create();
    }
    //
    $link->setVar('applicationid', $post['appid']);
    $link->setVar('name', $post['name']);
    $link->setVar('link', $post['link']);
    //
    if ($hLink->insert($link)) {
        redirect_header('main.php?op=manageLinks', 3, 'Link Added.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $linkid
 */
function deleteLink($linkid)
{
    $hLink = new Xasset\LinkHandler($GLOBALS['xoopsDB']);
    //
    if ($hLink->deleteByID($linkid)) {
        redirect_header('main.php?op=manageLinks', 3, 'Link Deleted.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $linkid
 */
function editLink($linkid)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_links_index.tpl';
    //
    $hLink = new Xasset\LinkHandler($GLOBALS['xoopsDB']);
    $hApp  = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    //
    $link = $hLink->get($linkid);
    //
    $xasset_link['id']    = $link->getVar('id');
    $xasset_link['appid'] = $link->getVar('applicationid');
    $xasset_link['name']  = $link->getVar('name');
    $xasset_link['link']  = $link->getVar('link');
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manLink'));
    $xoopsTpl->assign('xasset_app_apppackagesselect', $hApp->getApplicationSelectArray());
    $xoopsTpl->assign('xasset_link_function', 'Edit');
    $xoopsTpl->assign('xasset_link', $xasset_link);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param null $appid
 */
function viewDownloadStats($appid = null)
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=viewDownloadStats');
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_download_stats_index.tpl';
    //
    $hPackGrp = new Xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
    $hApp     = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    //
    if (!($appid > 0)) {
        $crit = new \CriteriaCompo();
        $crit->setLimit(1);
        $objs = $hApp->getApplicationsArray($crit);
        if (count($objs) > 0) {
            $appid = $objs[0]['id'];
        } else {
            $xoopsTpl->assign('xasset_navigation', 'Error: No applications defined'); //hack..will need to do an error screen
            require_once __DIR__ . '/admin_header.php';
            xoops_cp_footer();
            exit;
        }
    }
    $app  = $hApp->get($appid);
    $apps = $hApp->getApplicationsSummaryArray();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manStat'));
    $xoopsTpl->assign('xasset_application', $app->getVar('name'));
    $xoopsTpl->assign('xasset_application_id', $appid);
    $xoopsTpl->assign('xasset_stats', $hPackGrp->getDownloadByApplicationSummaryArray($appid));
    $xoopsTpl->assign('xasset_application_list', $apps);
    $xoopsTpl->assign('xasset_application_count', count($apps));
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteStat($id)
{
    $hStat = new Xasset\UserPackageStatsHandler($GLOBALS['xoopsDB']);
    if ($hStat->deleteByID($id, true)) {
        redirect_header('main.php?op=viewDownloadStats', 3, 'Stat Deleted.');
    }
}

//////////////////////////////////////////////////////
function manageCountries()
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_country_index.tpl';
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=manageCountries');

    //
    $hCnt = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    $cnts = $hCnt->getCountriesArray();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manCount'));
    $xoopsTpl->assign('xasset_operation', 'Add a');
    $xoopsTpl->assign('xasset_operation_short', 'create');
    $xoopsTpl->assign('xasset_country_count', count($cnts));
    $xoopsTpl->assign('xasset_countries', $cnts);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function addCountry($post)
{
    $hCnt = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['countryid']) && ($post['countryid'] > 0)) {
        $cnt = $hCnt->get($post['countryid']);
    } else {
        $cnt = $hCnt->create();
    }
    //
    $cnt->setVar('name', $post['name']);
    $cnt->setVar('iso2', $post['iso2']);
    $cnt->setVar('iso3', $post['iso3']);
    //
    if ($hCnt->insert($cnt)) {
        redirect_header('main.php?op=manageCountries', 3, 'Country Added.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function editCountry($id)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_country_index.tpl';
    //
    $hCnt = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    $cnt  = $hCnt->get($id);
    //
    $ary['id']   = $cnt->getVar('id');
    $ary['name'] = $cnt->getVar('name');
    $ary['iso2'] = $cnt->getVar('iso2');
    $ary['iso3'] = $cnt->getVar('iso3');
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manCount'));
    $xoopsTpl->assign('xasset_country', $ary);
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
function manageZones()
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=manageZones');
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_zone_index.tpl';
    //
    $hZone  = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
    $hCount = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    //
    $zones = $hZone->getZonesArray();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manZone'));
    $xoopsTpl->assign('xasset_operation', 'Add a');
    $xoopsTpl->assign('xasset_operation_short', 'create');
    $xoopsTpl->assign('xasset_zones_count', count($zones));
    $xoopsTpl->assign('xasset_zones', $zones);
    $xoopsTpl->assign('xasset_countries', $hCount->getCountriesSelect());
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function addZone($post)
{
    $hZone = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['zoneid']) && ($post['zoneid'] > 0)) {
        $zone = $hZone->get($post['zoneid']);
    } else {
        $zone = $hZone->create();
    }
    //
    $zone->setVar('country_id', $post['country_id']);
    $zone->setVar('code', $post['code']);
    $zone->setVar('name', $post['name']);
    //
    if ($hZone->insert($zone)) {
        redirect_header('main.php?op=manageZones', 3, 'Zone Added.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function editZone($id)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_zone_index.tpl';
    //
    $hZone  = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
    $hCount = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    //
    $zone = $hZone->get($id);
    //
    $ary['id']         = $zone->getVar('id');
    $ary['country_id'] = $zone->getVar('country_id');
    $ary['code']       = $zone->getVar('code');
    $ary['name']       = $zone->getVar('name');
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manZone'));
    $xoopsTpl->assign('xasset_zone', $ary);
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    $xoopsTpl->assign('xasset_countries', $hCount->getCountriesSelect());
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteZone($id)
{
    $hZone = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
    if ($hZone->deleteByID($id, true)) {
        redirect_header('main.php?op=manageZones', 2, 'Zone Deleted.');
    }
}

//////////////////////////////////////////////////////
function manageTaxes()
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=manageTaxes');
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_taxrates_index.tpl';
    //
    $hZone     = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
    $hCount    = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    $hTaxClass = new Xasset\TaxClassHandler($GLOBALS['xoopsDB']);
    $hTaxRate  = new Xasset\TaxRateHandler($GLOBALS['xoopsDB']);
    $hTaxZone  = new Xasset\TaxZoneHandler($GLOBALS['xoopsDB']);
    $hRegion   = new Xasset\RegionHandler($GLOBALS['xoopsDB']);
    //
    $classes  = $hTaxClass->getClassArray();
    $rates    = $hTaxRate->getRegionOrderedRatesArray(); //getRatesArray();
    $classSel = $hTaxClass->getSelectArray();
    //
    $countArray   = $hCount->getCountriesSelect();
    $regionArray  = $hRegion->getSelectArray();
    $taxZoneArray = $hTaxZone->getAllTaxZoneArray();
    //
    $zoneArray = [];
    if (count($countArray) > 0) {
        $tmp       = reset($countArray);
        $tmp       = !empty($tmp['id']) ? $tmp['id'] : 0; // PHP 5.4 changes how empty() behaves when passed string offsets.
        $zoneArray = $hZone->getZonesByCountry($tmp);
    }
    $zoneArrayCnt = count($zoneArray);
    //$zonesScript = $hCount->constructSelectJavascript('zone_id','country_id');
    //insert script into header
    echo insertHeaderCountriesJavaScript();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manTax'));
    $xoopsTpl->assign('xasset_operation', 'Add a');
    $xoopsTpl->assign('xasset_operation_short', 'create');
    $xoopsTpl->assign('xasset_class_count', count($classes));
    $xoopsTpl->assign('xasset_rates_count', count($rates));
    $xoopsTpl->assign('xasset_classes', $classes);
    $xoopsTpl->assign('xasset_rates', $rates);
    $xoopsTpl->assign('xasset_tax_classes', $classSel);
    $xoopsTpl->assign('xasset_tax_classes_count', count($classSel));
    $xoopsTpl->assign('xasset_tax_zone_count', count($taxZoneArray));
    $xoopsTpl->assign('xasset_tax_zones', $taxZoneArray);
    //$xoopsTpl->assign('xasset_zones',$zoneArray);
    $xoopsTpl->assign('xasset_countries_select', $countArray);
    $xoopsTpl->assign('xasset_region_select', $regionArray);
    //$xoopsTpl->assign('xasset_regions',$regionArray);
    $xoopsTpl->assign('xasset_zone_select', $zoneArray);
    $xoopsTpl->assign('xasset_show_class', 1);
    $xoopsTpl->assign('xasset_show_region', ($zoneArrayCnt > 0) && (count($countArray) > 0));
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function addTaxClass($post)
{
    $hClass = new Xasset\TaxClassHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['taxclassid']) && ($post['taxclassid'] > 0)) {
        $class = $hClass->get($post['taxclassid']);
    } else {
        $class = $hClass->create();
    }
    //
    $class->setVar('code', $post['code']);
    $class->setVar('description', $post['description']);
    //
    if ($hClass->insert($class)) {
        redirect_header('main.php?op=manageTaxes', 3, 'Tax Class Added.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function addTaxZone($post)
{
    $hTZone = new Xasset\TaxZoneHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['taxzoneid']) && ($post['taxzoneid'] > 0)) {
        $zone = $hTZone->get($post['taxzoneid']);
    } else {
        $zone = $hTZone->create();
    }
    //
    $zone->setVarsFromArray($post);
    //
    if ($hTZone->insert($zone)) {
        redirect_header('main.php?op=manageTaxes', 3, 'Tax Zone Added.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function editTaxZone($id)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_tax_region_zone.tpl';
    //
    $hZone   = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
    $hTZone  = new Xasset\TaxZoneHandler($GLOBALS['xoopsDB']);
    $hRegion = new Xasset\RegionHandler($GLOBALS['xoopsDB']);
    $hCount  = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    //
    echo insertHeaderCountriesJavaScript();
    //
    $taxZone     = $hTZone->get($id);
    $countArray  = $hCount->getCountriesSelect();
    $regionArray = $hRegion->getSelectArray();
    //
    $ary =& $taxZone->getArray();
    //
    if ($ary['country_id'] > 0) {
        $zoneSelect = $hZone->getZonesByCountry($ary['country_id']);
    }
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manTax'));
    $xoopsTpl->assign('xasset_tax_zone', $ary);
    $xoopsTpl->assign('xasset_region_select', $regionArray);
    $xoopsTpl->assign('xasset_countries_select', $countArray);
    $xoopsTpl->assign('xasset_zone_select', $zoneSelect);
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    $xoopsTpl->assign('xasset_show_class', 1);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteTaxZone($id)
{
    $hZone = new Xasset\TaxZoneHandler($GLOBALS['xoopsDB']);
    if ($hZone->deleteByID($id, true)) {
        redirect_header('main.php?op=manageTaxes', 3, 'Tax Zone Deleted.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function addTaxRate($post)
{
    $hRate = new Xasset\TaxRateHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['taxrateid']) && ($post['taxrateid'] > 0)) {
        $rate = $hRate->get($post['taxrateid']);
    } else {
        $rate = $hRate->create();
    }
    //
    $rate->setVarsFromArray($post);
    //
    if ($hRate->insert($rate)) {
        redirect_header('main.php?op=manageTaxes', 3, 'Tax Rate Added.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function editTaxClass($id)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_taxrates_index.tpl';
    //
    $hClass = new Xasset\TaxClassHandler($GLOBALS['xoopsDB']);
    $class  = $hClass->get($id);
    //
    $ary['id']          = $class->getVar('id');
    $ary['code']        = $class->getVar('code');
    $ary['description'] = $class->getVar('description');
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manTax'));
    $xoopsTpl->assign('xasset_tax_class', $ary);
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    $xoopsTpl->assign('xasset_show_class', 1);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function editTaxRate($id)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_taxrates_index.tpl';
    //
    $hRate     = new Xasset\TaxRateHandler($GLOBALS['xoopsDB']);
    $hRegion   = new Xasset\RegionHandler($GLOBALS['xoopsDB']);
    $hTaxClass = new Xasset\TaxClassHandler($GLOBALS['xoopsDB']);
    //
    $rate = $hRate->get($id);
    //
    $ary =& $rate->getArray();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manTax'));
    $xoopsTpl->assign('xasset_tax_rate', $ary);
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    $xoopsTpl->assign('xasset_show_class', 0);
    $xoopsTpl->assign('xasset_tax_classes_count', 1);
    $xoopsTpl->assign('xasset_tax_classes', $hTaxClass->getSelectArray());
    $xoopsTpl->assign('xasset_region_select', $hRegion->getSelectArray());
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteTaxClass($id)
{
    $hClass = new Xasset\TaxClassHandler($GLOBALS['xoopsDB']);
    if ($hClass->deleteClass($id)) {
        redirect_header('main.php?op=manageTaxes', 3, 'Tax Class Deleted.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteTaxRate($id)
{
    $hRate = new Xasset\TaxRateHandler($GLOBALS['xoopsDB']);
    if ($hRate->deleteRate($id, true)) {
        redirect_header('main.php?op=manageTaxes', 3, 'Tax Rate Deleted.');
    }
}

//////////////////////////////////////////////////////
function manageCurrencies()
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=manageCurrencies');
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_currency_index.tpl';
    //
    $hCurrency = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
    //
    $currs = $hCurrency->getCurrencyArray();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manCurr'));
    $xoopsTpl->assign('xasset_operation', 'Add a');
    $xoopsTpl->assign('xasset_operation_short', 'create');
    $xoopsTpl->assign('xasset_currencies', $currs);
    $xoopsTpl->assign('xasset_currencies_count', count($currs));
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function addCurrency($post)
{
    $hCurrency = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['currencyid']) && ($post['currencyid'] > 0)) {
        $curr = $hCurrency->get($post['currencyid']);
    } else {
        $curr = $hCurrency->create();
    }
    //
    $curr->setVar('name', $post['name']);
    $curr->setVar('code', $post['code']);
    $curr->setVar('decimal_places', $post['decimal_places']);
    $curr->setVar('symbol_left', $post['symbol_left']);
    $curr->setVar('symbol_right', $post['symbol_right']);
    $curr->setVar('decimal_point', $post['decimal_point']);
    $curr->setVar('thousands_point', $post['thousands_point']);
    $curr->setVar('value', $post['value']);
    $curr->setVar('updated', time());
    //
    if ($hCurrency->insert($curr)) {
        redirect_header('main.php?op=manageCurrencies', 2, 'Currency Added.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function editCurrency($id)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_currency_index.tpl';
    //
    $hCurrency = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
    //
    $curr = $hCurrency->get($id);
    //
    $ar['id']              = $curr->getVar('id');
    $ar['name']            = $curr->getVar('name');
    $ar['code']            = $curr->getVar('code');
    $ar['decimal_places']  = $curr->getVar('decimal_places');
    $ar['symbol_left']     = $curr->getVar('symbol_left');
    $ar['symbol_right']    = $curr->getVar('symbol_right');
    $ar['decimal_point']   = $curr->getVar('decimal_point');
    $ar['thousands_point'] = $curr->getVar('thousands_point');
    $ar['value']           = $curr->getVar('value');
    $ar['updated']         = $curr->getVar('updated');
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manCurr'));
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    $xoopsTpl->assign('xasset_currency', $ar);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteCurrency($id)
{
    $hCurrency = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
    if ($hCurrency->deleteByID($id, true)) {
        redirect_header('main.php?op=manageCurrency', 3, 'Currency Deleted.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function addAppProduct($post)
{
    $hAppProd = new Xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['appprodid']) && ($post['appprodid'] > 0)) {
        $prod = $hAppProd->get($post['appprodid']);
    } else {
        $prod = $hAppProd->create();
    }
    //
    $prod->setVarsFromArray($post);
    $prod->setVar('enabled', isset($post['enabled']));
    // set expiry date
    if ($prod->getVar('add_to_group') > 0) {
        if (-1 == $post['rbGrpExpire']) {
            $prod->setVar('group_expire_date', $post['expire_days']);
        } else {
            $prod->setVar('group_expire_date', $post['rbGrpExpire']);
        }
    } else {
        $prod->setVar('group_expire_date', 0);
    }
    if ($prod->getVar('add_to_group2') > 0) {
        if (-1 == $post['rbGrpExpire2']) {
            $prod->setVar('group_expire_date2', $post['expire_days2']);
        } else {
            $prod->setVar('group_expire_date2', $post['rbGrpExpire2']);
        }
    } else {
        $prod->setVar('group_expire_date2', 0);
    }
    //
    if ($hAppProd->insert($prod)) {
        redirect_header('main.php?op=manageApplications', 2, 'Application Product Added.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteAppProduct($id)
{
    xoops_cp_header();
    xoops_confirm(['id' => $id], 'main.php?op=doDeleteAppProduct', 'Are you sure you want to delete this Application Product?', '', true);
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function doDeleteAppProduct($id)
{
    $hAppProd = new Xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);
    if ($hAppProd->deleteByID($id)) {
        redirect_header('main.php?op=manageApplications', 3, 'Application Product Deleted.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function editAppProduct($id)
{
    global $xoopsTpl;
    /** @var Xasset\Helper $helper */
    $helper = Xasset\Helper::getInstance();

    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_application_product_add.tpl';
    //
    $hApps      = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
    $hTaxClass  = new Xasset\TaxClassHandler($GLOBALS['xoopsDB']);
    $hCurrency  = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
    $hAppProd   = new Xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);
    $hPackGroup = new Xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
    //  $hEditor    = xoops_getModuleHandler('editor','xasset');
    $hMember = xoops_getHandler('member');
    //
    $classArray = $hTaxClass->getSelectArray();
    $currArray  = $hCurrency->getSelectArray();
    $appsArray  = $hApps->getApplicationSelectArray();
    //
    $prod      = $hAppProd->get($id);
    $aPackages = $hPackGroup->getAllGroupsSelectArray();
    $ar        =& $prod->getArray();
    //
    $aMembers   = $hMember->getGroups();
    $aGroups    = [];
    $aGroups[0] = 'No Action';
    foreach ($aMembers as $group) {
        $aGroups[$group->getVar('groupid')] = $group->getVar('name');
    }
    //
    //$dateField = getDateField('expires',$prod->getVar('expires'));
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manApp'));
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    $xoopsTpl->assign('xasset_app_product', $ar);
    $xoopsTpl->assign('xasset_applications', $appsArray);
    $xoopsTpl->assign('xasset_tax_classes', $classArray);
    $xoopsTpl->assign('xasset_currencies', $currArray);
    $xoopsTpl->assign('xasset_date_field', getDateField('expires', $prod->getVar('expires')));
    $xoopsTpl->assign('xasset_expdate_field', getDateField('group_expire_date', $prod->getVar('group_expire_date')));

    //    $xoopsTpl->assign('xasset_appprod_memo_field', $hEditor->slimEditorDraw('item_rich_description', $ar['item_rich_description']));

    if (class_exists('XoopsFormEditor')) {
        $configs = [
            'name'   => 'item_rich_description',
            'value'  => $ar['item_rich_description'],
            'rows'   => 25,
            'cols'   => '100%',
            'width'  => '100%',
            'height' => '250px'
        ];
        $editor  = new \XoopsFormEditor('', $helper->getConfig('editor_options'), $configs, false, $onfailure = 'textarea');
    } else {
        $editor = new \XoopsFormDhtmlTextArea('', 'item_rich_description', $this->getVar('item_rich_description', 'e'), '100%', '100%');
    }

    $xoopsTpl->assign('xasset_appprod_memo_field', $editor->render());

    $xoopsTpl->assign('xasset_xoops_groups', $aGroups);
    $xoopsTpl->assign('xasset_xoops_packages', $aPackages);
    //
    if ($prod->getVar('group_expire_date') > 0) {
        $xoopsTpl->assign('xasset_date_checked', 'checked');
    }
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param null $id
 */
function manageGateways($id = null)
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=manageGateways');
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_gateway_index.tpl';
    //
    $hGateway = new Xasset\GatewayHandler($GLOBALS['xoopsDB']);
    //
    $gateway   = 0;
    $gateways  = $hGateway->parseGatewayModules();
    $installed = $hGateway->getInstalledGatewayArray();
    //
    if (null !== $id && ($id > 0)) {
        $gateway = $hGateway->get($id);
    } else {
        if (count($gateways) > 0) {
            $gateway = reset($installed);
            $gateway = $hGateway->get($gateway['id']);
        }
    }
    //
    if (is_object($gateway)) {
        $gateConfigs = $gateway->getDetailArray();
        $xoopsTpl->assign('xasset_config', $gateConfigs);
        $xoopsTpl->assign('xasset_gateway_id', $gateway->getVar('id'));
        $xoopsTpl->assign('xasset_gateway_name', $gateway->getVar('code'));
        $xoopsTpl->assign('xasset_gateway_count', 1);
    }
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manGate'));
    $xoopsTpl->assign('xasset_gateway', $gateways);
    $xoopsTpl->assign('xasset_installed_gateway', $installed);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function toggleGateway($post)
{
    $hGateway = new Xasset\GatewayHandler($GLOBALS['xoopsDB']);
    //
    foreach ($post['gateway'] as $class) {
        if (isset($post['bEnable'])) {
            $hGateway->enableGateway($class);
        } elseif (isset($post['bDisable'])) {
            $hGateway->disableGateway($class);
        }
    }
    //
    redirect_header('main.php?op=manageGateways', 2, 'Gateway Updated.');
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function updateGatewayValues($post)
{
    $id = $post['gateway_id'];
    //
    $hGateway = new Xasset\GatewayHandler($GLOBALS['xoopsDB']);
    //
    $gateway = $hGateway->get($id);
    //
    foreach ($post['values'] as $key => $value) {
        $gateway->saveConfigValue($key, $value);
    }
    //now sort binary keys
    $gateway->toggleBinaryValues($post['values']);
    //
    redirect_header("main.php?op=manageGateways&id=$id", 2, 'Gateway Values Updated.');
}

//////////////////////////////////////////////////////
function gatewayLogs()
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=gatewayLogs');
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_gateway_log_index.tpl';
    //
    $hGateway = new Xasset\GatewayLogHandler($GLOBALS['xoopsDB']);
    //
    $gateLogs = $hGateway->getLogs();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('gateLogs'));
    $xoopsTpl->assign('xasset_logs', $gateLogs);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function showLogDetail($id)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_gateway_log_detail.tpl';
    //
    $hGateway = new Xasset\GatewayLogHandler($GLOBALS['xoopsDB']);
    $oGateLog = $hGateway->get($id);
    $aGateLog = $oGateLog->getArray();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('gateLogs'));
    $xoopsTpl->assign('xasset_log', $aGateLog);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function removeLogItem($id)
{
    $hGate = new Xasset\GatewayLogHandler($GLOBALS['xoopsDB']);
    if ($hRate->deleteByID($id, true)) {
        redirect_header('main.php?op=gatewayLogs', 3, 'Gatway Log Enry deleted.');
    }
}

//////////////////////////////////////////////////////
function config()
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_config.tpl';
    //
    $hConfig = new Xasset\ConfigHandler($GLOBALS['xoopsDB']);
    $hCurr   = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
    $hMember = xoops_getHandler('member');
    //
    $groups = $hMember->getGroups();
    $curs   = $hCurr->getCurrencyArray();
    //
    $ar = [];
    foreach ($groups as $group) {
        $ar[$group->getVar('groupid')] = $group->getVar('name');
    }
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('index'));
    $xoopsTpl->assign('xasset_config', $hConfig->getConfigArray());
    $xoopsTpl->assign('xasset_config_currencies', $hCurr->getSelectArray());
    $xoopsTpl->assign('xasset_config_groups', $ar);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
function manageRegion()
{
    global $xoopsTpl;
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=manageRegion');
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_region_index.tpl';
    //
    $hRegion = new Xasset\RegionHandler($GLOBALS['xoopsDB']);
    //
    $regions = $hRegion->getRegionArray();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manRegion'));
    $xoopsTpl->assign('xasset_operation', 'Add a');
    $xoopsTpl->assign('xasset_operation_short', 'create');
    $xoopsTpl->assign('xasset_regions', $regions);
    $xoopsTpl->assign('xasset_region_count', count($regions));
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function addRegion($post)
{
    $hRegion = new Xasset\RegionHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['regionid']) && ($post['regionid'] > 0)) {
        $region = $hRegion->get($post['regionid']);
    } else {
        $region = $hRegion->create();
    }
    //
    $region->setVarsFromArray($post);
    //
    if ($hRegion->insert($region)) {
        redirect_header('main.php?op=manageRegion', 2, 'Region Added.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function editRegion($id)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_region_index.tpl';
    //
    $hRegion = new Xasset\RegionHandler($GLOBALS['xoopsDB']);
    $region  = $hRegion->get($id);
    //
    $ary =& $region->getArray();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manRegion'));
    $xoopsTpl->assign('xasset_region', $ary);
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function deleteRegion($id)
{
    $hRegion = new Xasset\RegionHandler($GLOBALS['xoopsDB']);
    //can we delete if this region is used in tax zones
    if ($hRegion->deleteByID($id, true)) {
        redirect_header('main.php?op=manageRegion', 3, 'Region Deleted.');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function updateConfig($post)
{
    $hConfig = new Xasset\ConfigHandler($GLOBALS['xoopsDB']);
    //
    $hConfig->setGroup($post['group_id']);
    $hConfig->setEmailGroup($post['email_group_id']);
    $hConfig->setBaseCurrency($post['currencyid']);
    //
    redirect_header('main.php', 2, 'Configuration Updated.');
}

//////////////////////////////////////////////////////
function orderTracking()
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_order_tracking.tpl';
    xoops_cp_header();

    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=orderTracking');

    //
    $hOrder  = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
    $aOrders = $hOrder->getOrders();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('orderTrack'));
    $xoopsTpl->assign('xasset_orders', $aOrders);
    $xoopsTpl->assign('xasset_order_count', count($aOrders));
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $orderID
 */
function showOrderLogDetail($orderID)
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_order_details.tpl';
    xoops_cp_header();
    //
    $hOrder   = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
    $hGateway = new Xasset\GatewayLogHandler($GLOBALS['xoopsDB']);
    //
    $oOrder = $hOrder->get($orderID);
    //
    $aOrder       =& $oOrder->getArray();
    $aOrderDetail =& $oOrder->getOrderDetailsArray();
    $aGateLogs    = $hGateway->getLogsByOrder($orderID);
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('orderTrack'));
    $xoopsTpl->assign('xasset_order', $aOrder);
    $xoopsTpl->assign('xasset_order_detail', $aOrderDetail);
    $xoopsTpl->assign('xasset_logs', $aGateLogs);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
function checkTables()
{
    xoops_cp_header();
    //
    $hCommon = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
    $success = true;
    //check xasset_app_product for enabled field for versiob 0.82
    echo '<p>Please note that the xAsset table checker works with xAsset versions 0.8 and upwards. You must un-install any previous xAsset prior to version 0.8 and install the latest release. To confirm. There is no update path from xAsset versions earlier to 0.8.</p>';
    echo '<p><u>Checking 0.82 table updates</u></p>';
    if (!$hCommon->fieldExists('xasset_app_product', 'enabled')) {
        $table = $hCommon->_db->prefix('xasset_app_product');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD enabled tinyint(4) DEFAULT '1'";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db->_errors);
        }
    }
    //check xasset_app_product for enabled field for version 0.85
    echo '<p><u>Checking 0.85 table updates</u></p>';
    echo '<p>Checking xasset_app_product table structure</p>';
    if (!$hCommon->fieldExists('xasset_app_product', 'group_expire_date')) {
        $table = $hCommon->_db->prefix('xasset_app_product');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD group_expire_date int(11) DEFAULT NULL";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db->_errors);
        }
    }
    echo '<p>Checking if table xasset_app_prod_memb exists</p>';
    if (!$hCommon->tableExists('xasset_app_prod_memb')) {
        $table = $hCommon->_db->prefix('xasset_app_prod_memb');
        echo "Creating table $table<br>";
        $sql = "CREATE TABLE $table (
          `id` int(11) NOT NULL auto_increment,
          `uid` int(11) NOT NULL default '0',
          `order_detail_id` int(11) NOT NULL default '0',
          `group_id` int(11) NOT NULL default '0',
          `expiry_date` int(11) NOT NULL default '0',
           PRIMARY KEY  (`id`),
           UNIQUE KEY `id` (`id`),
           KEY `uid` (`uid`),
           KEY `order_detail_id` (`order_detail_id`),
           KEY `group_id` (`group_id`)
           ) ENGINE=MyISAM";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Created $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db->_errors);
        }
    }
    //check xasset_app_product for enabled field for version 0.90
    echo '<p><u>Checking 0.90 table updates</u></p>';
    if (!$hCommon->fieldExists('xasset_application', 'productsVisible')) {
        $table = $hCommon->_db->prefix('xasset_application');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD productsVisible tinyint(4) DEFAULT '1'";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db->_errors);
        }
    }
    if (!$hCommon->fieldExists('xasset_userpackagestats', 'dns')) {
        $table = $hCommon->_db->prefix('xasset_userpackagestats');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD dns varchar(250) DEFAULT null";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db->_errors);
        }
    }
    //check xasset_app_product for enabled field for version 0.91
    echo '<p><u>Checking 0.91 table updates</u></p>';
    if (!$hCommon->fieldExists('xasset_app_product', 'add_to_group2')) {
        $table = $hCommon->_db->prefix('xasset_app_product');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD add_to_group2 int(11) DEFAULT NULL";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db->_errors);
        }
    }
    if (!$hCommon->fieldExists('xasset_app_product', 'group_expire_date2')) {
        $table = $hCommon->_db->prefix('xasset_app_product');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD group_expire_date2 int(11) DEFAULT NULL";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db->_errors);
        }
    }
    //
    if (!$hCommon->fieldExists('xasset_app_prod_memb', 'sent_warning')) {
        $table = $hCommon->_db->prefix('xasset_app_prod_memb');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD sent_warning int(11) DEFAULT NULL";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db->_errors);
        }
    }
    if (!$hCommon->fieldExists('xasset_app_product', 'extra_instructions')) {
        $table = $hCommon->_db->prefix('xasset_app_product');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD extra_instructions text";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db);
        }
    }
    //check fields for version 0.92
    echo '<p><u>Checking 0.92 table updates</u></p>';
    if (!$hCommon->fieldExists('xasset_application', 'product_list_template')) {
        $table = $hCommon->_db->prefix('xasset_application');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD product_list_template text";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db);
        }
    }
    if (!$hCommon->fieldExists('xasset_application', 'image')) {
        $table = $hCommon->_db->prefix('xasset_application');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD image varchar(250) default NULL";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db);
        }
    }
    if (!$hCommon->fieldExists('xasset_package', 'isVideo')) {
        $table = $hCommon->_db->prefix('xasset_package');
        echo "Upgrading table $table.<br>";
        $sql = "ALTER TABLE $table ADD isVideo tinyint(4) default '0'";
        if ($hCommon->_db->queryF($sql)) {
            $success = true;
            echo "Upgraded $table.<br>";
        } else {
            $success = false;
            print_r($hCommon->_db);
        }
    }
    //
    if ($success) {
        echo '<p>Upgrade Complete.</p>';
    } else {
        echo '<p>Errors Encountered.</p>';
    }
    //
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
function support()
{
    global $xoopsTpl;
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_support.tpl';
    xoops_cp_header();
    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('index'));
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function opCompOrder($post)
{
    if (count($post['ID']) > 0) {
        $hOrder = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
        //
        foreach ($post['ID'] as $key => $id) {
            $oOrder = $hOrder->get($id);
            $oOrder->setVar('status', $oOrder->orderStatusComplete());
            $hOrder->insert($oOrder);
            $oOrder->processPurchase();
            //
            unset($oOrder);
        }
        redirect_header('main.php?op=orderTracking', 2, 'Orders Manually Completed');
    }
}

//////////////////////////////////////////////////////
/**
 * @param $post
 */
function opDelOrder($post)
{
    if (count($post['ID']) > 0) {
        $hOrder = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
        //
        foreach ($post['ID'] as $key => $id) {
            $hOrder->delete($id);
        }
        redirect_header('main.php?op=orderTracking', 2, 'Orders Deleted');
    }
}

//////////////////////////////////////////////////////
function membership()
{
    global $xoopsTpl;

    $GLOBALS['xoopsOption']['template_main'] = 'xasset_admin_membership_index.tpl';
    xoops_cp_header();
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation('main.php?op=membership');

    //
    //  $xoopsTpl->assign('xasset_navigation',$oAdminButton->renderButtons('manMember'));
    //
    $hMembers = new Xasset\ApplicationProductMembHandler($GLOBALS['xoopsDB']);
    //
    $aMembers = $hMembers->getMembers();
    //
    $xoopsTpl->assign('xasset_members', $aMembers);
    //
    require_once __DIR__ . '/admin_header.php';
    xoops_cp_footer();
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function removeFromGroup($id)
{
    xoops_cp_header();
    xoops_confirm(['id' => $id], 'main.php?op=doRemoveFromGroup', 'Are you sure you want to remove this member from this group?', '', true);
}

//////////////////////////////////////////////////////
/**
 * @param $id
 */
function doRemoveFromGroup($id)
{
    $hMembers = new Xasset\ApplicationProductMembHandler($GLOBALS['xoopsDB']);
    if ($hMembers->removeFromGroup($id)) {
        redirect_header('main.php?op=membership', 2, 'User removed from Xoops Groups');
    }
}
