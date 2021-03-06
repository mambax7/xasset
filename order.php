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

require_once __DIR__ . '/header.php';
//require('class/crypt.php');
//require(XOOPS_ROOT_PATH . "/header.php");

require_once __DIR__ . '/class/validator.php';

$op    = \Xmf\Request::getCmd('op', 'default');

switch ($op) {
    case 'default':
    default:
        //be default in no op specified then just redirect home.
        redirect_header('index.php', 2, 'Un-Authorised Page Request.');
        break;
    //
    case 'addToCart':
        addToCart($_GET['id'], $_GET['key'], 1);
        break;
    //
    case 'askUserDetails':
        askUserDetails();
        break;
    //
    case 'addCustomer':
        addCustomer($_POST);
        break;
    //
    case 'showCart':
        showCart();
        break;
    //
    case 'showUserDetails':
        showUserDetails();
        break;
    //
    case 'removeOrderItem':
        removeOrderItem($_GET['id']);
        break;
    //
    case 'checkout':
        if (\Xmf\Request::hasVar('updateCart', 'POST')) {
            updateOrderQuantities($_POST);
        } elseif (\Xmf\Request::hasVar('checkout', 'POST')) {
            choosePayment();
        }
        break;
    //
    case 'processPayment':
        processPayment($_POST);
        break;
    //
    case 'processOptionForm':
        processOptionForm($_GET['gateID']);
        break;
    //
    case 'postOptionForm':
        postOptionForm($_POST);
        break;
}

//////////////////////////////////////////////////////////////////////////////
/**
 * @param      $itemID
 * @param      $key
 * @param int  $qty
 * @param null $forceUser
 *
 * @return int
 */
function addToCart($itemID, $key, $qty = 1, $forceUser = null)
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $xasset_module_header;
    //check if not anonymous user
    if (null !== $forceUser) {
        $xoopsUser = $forceUser;
    }
    if (!$xoopsUser && null === $forceUser) {
        //no user record... redirect to User Detail Page.
        $redirect = [
            'id'  => $itemID,
            'key' => $key,
            'qty' => $qty
        ];
        //
        $_SESSION['stage']    = 1;
        $_SESSION['redirect'] = $redirect;
        //
        askUserDetails();

        return 0;
        //redirect_header('../../user.php',3,'Please login or register first to access your shopping cart.');
    }
    $hOrder   = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
    $hAppProd = new Xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);
    //
    $appProdTmp = $hAppProd->create();
    //check id and key first
    if (!keyMatches($itemID, $key, $appProdTmp->weight, 'Invalid Key. Cannot download package file')) {
        redirect_header('index.php', 3, 'Product Key mismatch. Cannot add to Cart.');
    }
    //check if there is an active order for this session
    if (isset($_SESSION['orderID']) && ($_SESSION['orderID'] > -1)) {
        //retrieve order object
        if (!$order = $hOrder->get($_SESSION['orderID'])) {
            unset($_SESSION['orderID']);
            addToCart($itemID, $key, $qty);
            exit;
        }
        //check if the uid records match up
        if ($order->getVar('uid') != $xoopsUser->uid()) {
            //something wrong here...blank the order id and redirect to the home page
            unset($_SESSION['orderID']);
            redirect_header('index.php', 2, 'Un-Authorised Page Request.');
        }
        //if here then safe to add item to cart
        if ($order->addOrderItem($itemID, $qty)) {
            redirect_header('order.php?op=showCart', 2, 'Item Added to Your Cart');
        }
    } else {
        //order record doesn't exist.. first item added to cart.
        //check if this user has a UserDetail record.
        $hUserDetail = new Xasset\UserDetailsHandler($GLOBALS['xoopsDB']);
        //
        if ($userDetail = $hUserDetail->getUserDetailByID($xoopsUser->uid())) {
            if (\Xmf\Request::hasVar('currency_id', 'SESSION') && ($_SESSION['currency_id'] > 0)) {
                $currid = $_SESSION['currency_id'];
            } else {
                $hConfig = new Xasset\ConfigHandler($GLOBALS['xoopsDB']);
                $currid  = $hConfig->getBaseCurrency();
                //
                if (!$currid > 0) {
                    //can't continue... redirect
                    redirect_header('index.php', 3, 'A Default currency has not been setup for this site. Please notify the webmaster.');
                }
            }
            $order = $hOrder->create();
            $order->setVar('uid', $xoopsUser->uid());
            $order->setVar('user_detail_id', $userDetail->getVar('id'));
            //$order->setVar('number',
            $order->setVar('currency_id', $currid);
            $order->setVar('date', time());
            $order->setVar('status', 1); //for stage 1
            //
            if ($hOrder->insert($order, true)) {
                if ($order->addOrderItem($itemID, $qty)) {
                    //item added... redirect somwhere or do something?
                    //add id to session
                    $_SESSION['orderID'] = $order->getVar('id');
                    redirect_header('order.php?op=showCart', 2, 'Item Added to Your Cart');
                }
            }
        } else {
            //no user record... redirect to User Detail Page.
            $redirect = [
                'id'  => $itemID,
                'key' => $key,
                'qty' => $qty
            ];
            //
            $_SESSION['stage']    = 1;
            $_SESSION['redirect'] = $redirect;
            //
            redirect_header('order.php?op=showUserDetails', 3, 'Please Complete User Detail Information Before Proceeding.');
        }
    }
}

//////////////////////////////////////////////////////////////////////////////
/**
 * @param null $userDetails
 */
function askUserDetails($userDetails = null)
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $xasset_module_header;
    //
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_order_index.tpl';
    require_once XOOPS_ROOT_PATH . '/header.php';
    //
    $hCountry = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    //
    $countriesSelect = $hCountry->getCountriesSelect();
    if (count($countriesSelect) > 0) {
        $country = key($countriesSelect);
        $country = $hCountry->get($country);
    } else {
        die('No countried defined.');
    }
    //
    if (null !== $userDetails) {
        $cust    = $userDetails;
        $aCust   = $cust->getArray();
        $country = $hCountry->get($cust->getVar('country_id'));
        $errors  =& $userDetails->getErrors();
        $email   = $cust->getVar('company_name');
        if (isset($errors['email'])) {
            $emailError = $errors['email'];
        } else {
            $emailError = '';
        }
    } else {
        $email      = '';
        $emailError = '';
    }
    //
    if (is_object($country)) {
        $zones =& $country->getZonesSelect();
        if (count($zones) > 0) {
            $xoopsTpl->assign('xasset_state_style', 'display:none');
            $xoopsTpl->assign('xasset_zone_style', '');
        } else {
            $xoopsTpl->assign('xasset_state_style', '');
            $xoopsTpl->assign('xasset_zone_style', 'display:none');
        }
    } else {
        die('Please define some countries first.');
    }
    $emailRow = '<tr>
                <td class="head">Email Address *</td>
                <td class="even">
                  <input name="email" type="text" size="32" maxlength="100" value=' . $email . '>
                  <span class="error">' . $emailError . '</span>
                </td>
              </tr>';
    //
    $xasset_module_header .= insertHeaderCountriesJavaScriptNoAllZones();
    //
    if (null !== $cust) {
        $xoopsTpl->assign('xasset_customer', $aCust);
    }
    if (null !== $errors) {
        $xoopsTpl->assign('xasset_error', $errors);
    }
    //
    $xoopsTpl->assign('xoops_module_header', $xasset_module_header);
    $xoopsTpl->assign('xasset_country_select', $hCountry->getCountriesSelect());
    $xoopsTpl->assign('xasset_order_stage', 0);
    $xoopsTpl->assign('xasset_zone_select', $zones);
    $xoopsTpl->assign('xasset_email_row', $emailRow);
    $xoopsTpl->assign('xasset_operation', 'Add');
    $xoopsTpl->assign('xasset_operation_short', 'create');
    //
    require_once XOOPS_ROOT_PATH . '/footer.php';
}

////////////////////////////////////////////////////////
/**
 * @param null $userDetails
 */
function showUserDetails($userDetails = null)
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $xasset_module_header;
    //
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_order_index.tpl';
    require_once XOOPS_ROOT_PATH . '/header.php';
    //
    if (!$xoopsUser) {
        redirect_header(XOOPS_URL . '/user.php', 3, 'Not Logged In.');
    }
    //
    $hCustDet = new Xasset\UserDetailsHandler($GLOBALS['xoopsDB']);
    $hCount   = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    //
    if (null !== $userDetails) {
        $cust = $userDetails;
    } else {
        $cust = $hCustDet->getUserDetailByID($xoopsUser->uid());
    }
    if (is_object($cust)) {
        $aCust   =& $cust->getArray();
        $aErrors = $cust->getErrors();
    } else {
        $aCust          = [];
        $aCust['email'] = $xoopsUser->email();
        $aErrors        = [];
    }
    //
    $aCountrySelect = $hCount->getCountriesSelect();
    //die if no countries define
    if (!(count($aCountrySelect) > 0)) {
        die('Please define at least one country.'); //------------------------->
    }
    //
    if (is_object($cust)) {
        $country = $hCount->get($cust->getVar('country_id'));
        $zones   =& $country->getZonesSelect();
    } else {
        $country = $hCount->get(key($aCountrySelect));
    }
    $zones =& $country->getZonesSelect();

    if (count($zones) > 0) {
        $xoopsTpl->assign('xasset_state_style', 'display:none');
        $xoopsTpl->assign('xasset_zone_style', '');
    } else {
        $xoopsTpl->assign('xasset_state_style', '');
        $xoopsTpl->assign('xasset_zone_style', 'display:none');
    }
    //
    $xasset_module_header .= insertHeaderCountriesJavaScriptNoAllZones();
    //
    $xoopsTpl->assign('xoops_module_header', $xasset_module_header);
    $xoopsTpl->assign('xasset_operation', 'Edit');
    $xoopsTpl->assign('xasset_operation_short', 'modify');
    $xoopsTpl->assign('xasset_order_stage', 0);
    $xoopsTpl->assign('xasset_country_select', $aCountrySelect);
    $xoopsTpl->assign('xasset_zone_select', $zones);
    $xoopsTpl->assign('xasset_customer', $aCust);
    $xoopsTpl->assign('xasset_error', $aErrors);
    //
    require_once XOOPS_ROOT_PATH . '/footer.php';
}

//////////////////////////////////////////////////////////////////////////////
/**
 * @param $post
 *
 * @return void
 */
function addCustomer($post)
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $xasset_module_header;
    //
    $hCust    = new Xasset\UserDetailsHandler($GLOBALS['xoopsDB']);
    $hZone    = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
    $hCountry = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
    $hCommon  = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
    $hNotify  = new Xasset\NotificationServiceHandler($GLOBALS['xoopsDB']);
    //
    if (isset($post['id']) && ($post['id'] > 0)) {
        $cust = $hCust->get($post['id']);
    } else {
        $cust = $hCust->create();
    }
    //
    $country = $hCountry->get($post['country_id']);
    if ($country->hasZones()) {
        //check if correct zone is selected...antihack
        if ($hZone->zoneInCountry($post['country_id'], $post['zone_id'])) {
            $cust->setVar('zone_id', $post['zone_id']);
            $cust->setVar('state', $hZone->getZoneNameByID($post['zone_id']));
        } else {
            redirect_header('order.php?op=showUserDetails', 3, 'Country and State mismatch. Please select Country and State.');
        }
    } else {
        $cust->setVar('zone_id', 0);
        $cust->setVar('state', $post['state']);
    }
    //
    $cust->setVarsFromArray($post);
    $cust->setVar('company_name', $post['email']);
    //check if post is valid
    $cust->cleanVars();
    if (!$xoopsUser) {
        if ('' === strlen($cust->getVar('company_name'))) {
            $cust->setErrors('email', 'Email is required');
        } else { //check for a valid email
            if (!$hCommon->validEmail('company_name', $msg)) {
                $cust->setErrors('email', $msg);
            }
            if ($hCommon->xoopsUserByEmail($cust->getVar('company_name'))) {
                $cust->setErrors('email', 'Email already exists. If you have previously registered with this email then please login first.');
            }
        }
    }
    //
    if (!$cust->cleanVars()) {
        if ($xoopsUser) {
            //$errors = $cust->getErrors(); print_r($errors);
            showUserDetails($cust);
        } else {
            askUserDetails($cust);
        }

        return false;
    }
    //if not xoops user then create
    if ($xoopsUser) {
        $cust->setVar('uid', $xoopsUser->uid());
    } else {
        if ($oUser = $hCommon->AccountFromEmail($cust->getVar('company_name'), $cust->getVar('first_name'), $password, 1)) {
            $hMember = xoops_getHandler('member');
            $hNotify->new_user([$oUser, $password]);
            //
            $myts = \MyTextSanitizer::getInstance();
            $hMember->loginUser($myts->addSlashes($oUser->uname()), $myts->addSlashes($password));
            if (null === $_SESSION) {
                $_SESSION = [];
            }
            $_SESSION['xoopsUserId']     = $oUser->getVar('uid');
            $_SESSION['xoopsUserGroups'] = $oUser->getGroups();
            if ($xoopsConfig['use_mysession'] && '' != $xoopsConfig['session_name']) {
                setcookie($xoopsConfig['session_name'], session_id(), time() + (60 * $xoopsConfig['session_expire']), '/', '', 0);
            }
            //
            $cust->setVar('uid', $oUser->uid());
        }
    }
    //we are here so the data looks good...save it
    if ($hCust->insert($cust)) {
        if (\Xmf\Request::hasVar('stage', 'SESSION')) {
            if (1 == $_SESSION['stage']) {
                //direct to stage 2
                $_SESSION['stage'] = 2;
                //redirect back
                $redir = $_SESSION['redirect'];
                unset($_SESSION['redirect']);
                //
                if (!$xoopsUser) {
                    $xoopsUser = $hMember->getUser($_SESSION['xoopsUserId']);
                    addToCart($redir['id'], $redir['key'], $redir['qty'], $xoopsUser);
                } else {
                    addToCart($redir['id'], $redir['key'], $redir['qty']);
                }
            } else {
                unset($_SESSION['stage']); //corrupted...so clear
            }
        } else {
            redirect_header('index.php', 2, 'Updated User Details.');
        }
    } else {
        die('Error 303.Failed Saving Client Details.');
    }
}

//////////////////////////////////////////////////////////////////////////////
function showCart()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $xasset_module_header;
    //
    $hOrder = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
    //get the order id from session
    if (\Xmf\Request::hasVar('orderID', 'SESSION') && ($_SESSION['orderID'] > 0)) {
        $GLOBALS['xoopsOption']['template_main'] = 'xasset_order_index.tpl';
        require_once XOOPS_ROOT_PATH . '/header.php';
        //
        if ($order = $hOrder->get($_SESSION['orderID'])) {
            //check that this order is not complete
            if ($order->getVar('status') == $order->orderStatusComplete()) {
                unset($_SESSION['orderID']);
                redirect_header('index.php', 2, 'Cannot find your cart.');
            }
            $items = $order->getOrderDetailsArray();
            $cnt   = count($items);
            //
            if ($cnt > 1) {
                $itemW = "$cnt items";
            } else {
                $itemW = "$cnt item";
            }
            //
            $xoopsTpl->assign('xoops_module_header', $xasset_module_header);
            $xoopsTpl->assign('xasset_order_stage', 1);
            $xoopsTpl->assign('xasset_basket_count', $itemW);
            $xoopsTpl->assign('xasset_basket_items', $items);
            $xoopsTpl->assign('xasset_total_price', $order->getOrderTotal());
            $xoopsTpl->assign('xasset_tax', $order->getOrderTaxTotal());
            //
            require_once XOOPS_ROOT_PATH . '/footer.php';
        } else { //why are we here... redirect back to index
            redirect_header('index.php', 2, 'No items in your cart.');
        }
    } //phantom session?!?...user has logged out and the cookie has expired/been erased..check database for pending orders
    else {
        if ($xoopsUser && ($_SESSION['orderID'] = $hOrder->userInCartOrders($xoopsUser->uid()))) {
            showCart();
        } else {
            redirect_header('index.php', 2, 'No items in your cart.');
        }
    }
}

//////////////////////////////////////////////////////////////////////////////
/**
 * @param $id
 */
function removeOrderItem($id)
{
    $hODetail = new Xasset\OrderDetailHandler($GLOBALS['xoopsDB']);
    //
    if ($hODetail->deleteByID($id, true)) {
        redirect_header('order.php?op=showCart', 2, 'Order Item Deleted.');
    } else {
        redirect_header('order.php?op=showCart', 2, 'Could not delete order item.');
    }
}

//////////////////////////////////////////////////////////////////////////////
/**
 * @param $post
 */
function updateOrderQuantities($post)
{
    $hODetail = new Xasset\OrderDetailHandler($GLOBALS['xoopsDB']);
    //
    if (count($post['qty']) > 0) {
        foreach ($post['qty'] as $key => $value) {
            if (0 == $value) {
                $hODetail->deleteByID($key);
            } else {
                $hODetail->updateOrderQty($key, $value);
            }
        }
    }
    //
    redirect_header('order.php?op=showCart', 2, 'Order Items Updated.');
}

//////////////////////////////////////////////////////////////////////////////
function choosePayment()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $xasset_module_header;
    //get the order id from session
    if (\Xmf\Request::hasVar('orderID', 'SESSION') && ($_SESSION['orderID'] > 0)) {
        $hOrder   = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
        $hGateway = new Xasset\GatewayHandler($GLOBALS['xoopsDB']);
        //
        if ($order = $hOrder->get($_SESSION['orderID'])) {
            $installed = $hGateway->getInstalledGatewayWithDescArray();
            $items     = $order->getOrderDetailsArray();
            $cnt       = count($items);
            //
            if (0 == count($installed)) {
                die('No payment gateways have been setup.');
            }
            //
            if ($cnt > 0) {
                $GLOBALS['xoopsOption']['template_main'] = 'xasset_order_index.tpl';
                require_once XOOPS_ROOT_PATH . '/header.php';
                //
                $tax = $order->getOrderTaxTotal();
                //
                if ($cnt > 1) {
                    $itemW = "$cnt items";
                } else {
                    $itemW = "$cnt item";
                }
                //
                $xoopsTpl->assign('xoops_module_header', $xasset_module_header);
                $xoopsTpl->assign('xasset_order_stage', 2);
                $xoopsTpl->assign('xasset_gateway', $installed);
                $xoopsTpl->assign('xasset_gateway_count', count($installed));
                $xoopsTpl->assign('xasset_basket_count', $itemW);
                $xoopsTpl->assign('xasset_basket_items', $items);
                $xoopsTpl->assign('xasset_total_price', $order->getOrderTotal());
                $xoopsTpl->assign('xasset_tax', $tax);
                //
                require_once XOOPS_ROOT_PATH . '/footer.php';
            } else {
                redirect_header('index.php', 2, 'Cannot checkout. Your cart is empty.');
            }
        } else { //why are we here... redirect back to index
            redirect_header('index.php', 2, 'Cannot find Cart.');
        }
        //
        require_once XOOPS_ROOT_PATH . '/footer.php';
    } else {
        redirect_header('index.php', 2, 'Cannot find Cart.');
    }
}

//////////////////////////////////////////////////////////////////////////////
/**
 * @param $post
 */
function processPayment($post)
{ //print_r($post);
    $hGateway = new Xasset\GatewayHandler($GLOBALS['xoopsDB']);
    $hOrder   = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
    $hCommon  = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
    $hNotify  = new Xasset\NotificationServiceHandler($GLOBALS['xoopsDB']);
    //save gatewayid in order index for return
    $value = $post['gateway'];
    if (\Xmf\Request::hasVar('orderID', 'SESSION') && ($_SESSION['orderID'] > -1)) {
        $order = $hOrder->get($_SESSION['orderID']);
        $order->setVar('gateway', $value);
        $order->setVar('status', $order->orderStatusGateway());
        if ($hOrder->insert($order, true)) {
            $oGateway = $hGateway->getGatewayModuleByID($value);
            //now notify the customer of the purchase
            $hNotify->new_client_purchase($order);
            //
            if ($oGateway->preprocess()) {
                $_SESSION['gatewayID'] = $value;
                if ($oGateway->requiresSSL()) {
                    runkit_constant_redefine('XOOPS_URL', $hCommon->sslXoopsUrl());
                    header('location:' . XOOPS_URL . '/modules/xasset/order.php?op=processOptionForm&ssl=1&gateID=' . $value . '&url=' . urlencode(base64_encode(XOOPS_URL)));
                } else {
                    processOptionForm($value);
                }
            } else {
                $oGateway->postToGateway();
            }
        }
    } else {
        redirect_header('index.php', 3, 'Could not find your Order');
    }
}

////////////////////////////////////////////////////////////////////////////
/**
 * @param $gatewayID
 */
function processOptionForm($gatewayID)
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $xasset_module_header;
    //
    $hGateway = new Xasset\GatewayHandler($GLOBALS['xoopsDB']);
    $hOrder   = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
    //
    $gateway = $hGateway->getGatewayModuleByID($gatewayID);
    //
    $GLOBALS['xoopsOption']['template_main'] = 'xasset_order_extra.tpl';
    require_once XOOPS_ROOT_PATH . '/header.php';
    //
    $paygate['name'] = $gateway->shortDesc;
    $paygate['form'] = $gateway->doPreprocess();
    //
    $xoopsTpl->assign('xoops_module_header', $xasset_module_header);
    $xoopsTpl->assign('paygate', $paygate);
    //
    require_once XOOPS_ROOT_PATH . '/footer.php';
}

///////////////////////////////////////////////////////////////////////////
/**
 * @param $post
 */
function postOptionForm($post)
{
    $hGateway = new Xasset\GatewayHandler($GLOBALS['xoopsDB']);
    //
    $oGateway = $hGateway->getGatewayModuleByID($_SESSION['gatewayID']);
    $errors   = '';
    $oGateway->processPost($post, $errors);
}
