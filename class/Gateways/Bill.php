<?php namespace XoopsModules\Xasset\Gateways;

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
use XoopsModules\Xasset\Gateways;

/**
 * Class bill
 */
class Bill extends Gateways\BaseGateway
{
    //
    /**
     * bill constructor.
     */
    public function __construct()
    {
        //call code first
        $this->code     = 'bill';
        $this->_version = '93';
        //inherited
        parent::__construct();
        //
        $this->shortDesc = 'Bill Gateway';
        if (defined('BILL_GATEWAY_DESCRIPTION')) {
            $this->description = BILL_GATEWAY_DESCRIPTION;
        }
        $this->postURL = XOOPS_URL . '/modules/xasset/return.php';
        //
        $this->_validates = false;
    }

    /////////////////////////////////////////////////////

    /**
     * @return array
     */
    public function keys()
    {
        $ary = ['BILL_ENABLED', 'BILL_GATEWAY_DESCRIPTION'];

        return $ary;
    }

    /////////////////////////////////////////

    /**
     * @return bool
     */
    public function preprocess()
    {
        return strlen(BILL_GATEWAY_INSTRUCTIONS) > 0;
    }

    /////////////////////////////////////////
    public function extraFields()
    {
        //preprocess for any tags
        $body = BILL_GATEWAY_INSTRUCTIONS;
        if (preg_match('/{ORDERID}/', $body)) {
            $body = preg_replace('/{ORDERID}/', $_SESSION['orderID'], $body);
        }
        $this->addOption('EXTRA', 'box', '', $body);
        //also email user
        //    $xoopsMailer = xoops_getMailer();
        //    $xoopsMailer->sendMail($email,'Order Instructions',$body,'');
    }

    /////////////////////////////////////////////////////

    /**
     *
     */
    public function install()
    {
        parent::install();
        //
        $this->saveField('BILL_ENABLED', true, 2, 'Enable Bill Module?', 'b');
        $this->saveField('BILL_GATEWAY_DESCRIPTION', 'Bill Me', 3, 'Payment Description', 's');
        $this->saveField('BILL_GATEWAY_INSTRUCTIONS', '', 3, 'Extra Instructions (payment address, bank acccount etc)', 'x');
    }

    ////////////////////////////////////////////////

    /**
     * @param $post
     * @param $errors
     */
    public function processPost($post, &$errors)
    {
        $this->postToGateway();
    }

    ////////////////////////////////////////////////

    /**
     * @param $oOrder
     * @param $post
     * @param $error
     */
    public function processReturn($oOrder, $post, &$error = null)
    {
        parent::processReturn($oOrder, $post);
        $hCommon = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
        $hOrder  = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
        //
        $oOrder->setVar('trans_id', time());
        $oOrder->setVar('status', $oOrder->orderStatusValidate());
        $oOrder->setVar('value', $oOrder->getOrderTotal('s'));
        //
        $dest = '' <> $hCommon->getModuleOption('orderCompleteRedirect') ? $hCommon->getModuleOption('orderCompleteRedirect') : 'index.php';
        $time = $hCommon->getModuleOption('orderCompleteWait');
        //
        if ($hOrder->insert($oOrder, true)) {
            unset($_SESSION['orderID']);
            //
            redirect_header($dest, $time, _LANG_ORDER_COMPLETE);
        } else {
            redirect_header($dest, $time, 'Code 10. Could not save order details.');
        }
    }
}
