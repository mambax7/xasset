<?php namespace XoopsModules\Xasset;

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

/**
 * class Order
 */
class Order extends Xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('user_detail_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('currency_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('number', XOBJ_DTYPE_INT, null, false);
        $this->initVar('date', XOBJ_DTYPE_INT, time(), false);
        $this->initVar('status', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('gateway', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('trans_id', XOBJ_DTYPE_TXTBOX, 0, false, 200);
        $this->initVar('value', XOBJ_DTYPE_OTHER, 0, false);
        $this->initVar('fee', XOBJ_DTYPE_OTHER, 0, false);
        //
        if (null !== $id) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    ////////////////////////////////////////////  `

    /**
     * @return bool
     */
    public function getOrderNet()
    {
        $hODetail  = new Xasset\OrderDetailHandler($GLOBALS['xoopsDB']);
        $hAppProd  = new Xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);
        $hCurrency = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //tables
        $thisTable = $hODetail->_db->prefix($hODetail->_dbtable);
        $apTable   = $hODetail->_db->prefix($hAppProd->_dbtable);
        $curTable  = $hCurrency->_db->prefix($hCurrency->_dbtable);
        //
        $sql  = "select sum(od.qty * (ap.unit_price/c.value)) totalPrice
                   from   $thisTable od inner join $apTable ap on
                     od.app_prod_id = ap.id inner join $curTable c on
                     ap.base_currency_id = c.id";
        $crit = new \CriteriaCompo(new \Criteria('order_index_id', $this->getVar('id')));
        //
        $hODetail->postProcessSQL($sql, $crit);
        //
        if ($res = $hODetail->_db->query($sql)) {
            if ($row = $hODetail->_db->fetchArray($res)) {
                return $row['totalPrice'];
            }
        }

        return false;
    }

    ////////////////////////////////////////////  `

    /**
     * @param string $format
     *
     * @return mixed
     */
    public function getOrderTotal($format = 'f')
    { //f=full s=short
        $hCurr = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //
        $cur = $hCurr->get($this->getVar('currency_id'));
        //
        $orderNet = $this->getOrderNet();
        $tax      = $this->getOrdertaxTotalSum();
        //
        $total = $tax['amount'] + $orderNet;
        //
        if ('f' === $format) {
            return $cur->valueFormat($total);
        } elseif ('s' === $format) {
            return $cur->valueOnlyFormat($total);
        }
    }

    ////////////////////////////////////////////  `

    /**
     * @return array
     */
    public function getOrdertaxTotalSum()
    {
        $hCurr = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //
        $cur      = $hCurr->get($this->getVar('currency_id'));
        $taxArray =& $this->getOrderTax();
        $total    = 0;
        //
        foreach ($taxArray as $i => $iValue) {
            $total += (float)$taxArray[$i]['amount'];
        }
        $res = [
            'amount'    => $total,
            'fmtAmount' => $cur->valueFormat($total),
            'name'      => 'Total Tax'
        ];

        //
        return $res;
    }

    ////////////////////////////////////////////  `

    /**
     * @return array
     */
    public function getOrderTaxTotal()
    {
        $hCurr = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //
        $cur      = $hCurr->get($this->getVar('currency_id'));
        $taxArray =& $this->getOrderTax();
        $total    = 0;
        //
        $res = [];
        for ($i = 0, $iMax = count($taxArray); $i < $iMax; ++$i) {
            $res[] = [
                'amount'    => $taxArray[$i]['amount'],
                'fmtAmount' => $cur->valueFormat($taxArray[$i]['amount']),
                'name'      => $taxArray[$i]['description']
            ];
            //$total =. $taxArray[$i]['amount'];
        }

        return $res;
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function &getOrderTax()
    {
        $hIndex   = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
        $hODetail = new Xasset\OrderDetailHandler($GLOBALS['xoopsDB']);
        $hAppProd = new Xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);
        $hClient  = new Xasset\UserDetailsHandler($GLOBALS['xoopsDB']);
        $hTaxRate = new Xasset\TaxRateHandler($GLOBALS['xoopsDB']);
        $hTaxZone = new Xasset\TaxZoneHandler($GLOBALS['xoopsDB']);
        $hCurr    = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //tables
        $thisTable  = $hIndex->_db->prefix($hIndex->_dbtable);
        $ODetTable  = $hIndex->_db->prefix($hODetail->_dbtable);
        $indexTable = $hIndex->_db->prefix($hIndex->_dbtable);
        $apTable    = $hIndex->_db->prefix($hAppProd->_dbtable);
        $cliTable   = $hIndex->_db->prefix($hClient->_dbtable);
        $rateTable  = $hIndex->_db->prefix($hTaxRate->_dbtable);
        $tzTable    = $hIndex->_db->prefix($hTaxZone->_dbtable);
        //
        $id  = $this->getVar('id');
        $cur = $hCurr->get($this->getVar('currency_id'));
        //could have gone the object route but this is far more efficient.
        $sql = "SELECT tr.id, ap.tax_class_id, tr.description, tr.priority, tr.rate
             FROM $ODetTable od
             INNER JOIN $thisTable oi ON (od.order_index_id = oi.id)
             INNER JOIN $cliTable ud ON (oi.user_detail_id = ud.id)
             INNER JOIN $tzTable tz ON (ud.country_id = tz.country_id) AND ((ud.zone_id = tz.zone_id) or (tz.zone_id = 0))
             INNER JOIN $apTable ap ON (od.app_prod_id = ap.id)
             inner join $rateTable tr on (tr.region_id = tz.region_id) and (tr.tax_class_id = ap.tax_class_id)
           where oi.id = $id
           group by tr.id, tax_class_id, tr.description, tr.priority
           order by tr.priority";
        //
        $taxArray = [];
        //
        if ($res = $hIndex->_db->query($sql)) {
            while (false !== ($row = $hIndex->_db->fetchArray($res))) {
                $taxArray[$row['priority']][] = $row;
            }
        }
        // print_r($taxArray);
        //now get order items and apply relevant tax and build into result array
        $prodArray = $hODetail->getOrderApplicationProducts($id); //print_r($prodArray);
        //repopulate $taxArray with order values.
        foreach ($taxArray as $priority => $aTax) {
            if (null !== $subTax) {
                unset($subTax);
            }
            for ($j = 0, $jMax = count($prodArray); $j < $jMax; ++$j) {
                $tax = 0;
                for ($i = 0, $iMax = count($aTax); $i < $iMax; ++$i) {
                    if ($prodArray[$j]['tax_class_id'] == $aTax[$i]['tax_class_id']) {
                        $tax                               += $prodArray[$j]['qty'] * $prodArray[$j]['unit_price'] * ($aTax[$i]['rate'] / 100);
                        $subTax[$i]                        += $prodArray[$j]['qty'] * $prodArray[$j]['unit_price'] * ($aTax[$i]['rate'] / 100);
                        $taxArray[$priority][$i]['amount'] = $subTax[$i];
                    }
                }
                $prodArray[$j]['unit_price'] += $tax;
            }
        } //print_r($prodArray); print_r($taxArray);
        //finally construct output array
        $aOutTax = [];
        foreach ($taxArray as $priority => $aTaxs) {
            foreach ($aTaxs as $key => $aTax) {
                $aOutTax[] = $aTax;
            }
        } //print_r($aOutTax);

        return $aOutTax;
    }

    ///////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getOrderDetailsArray()
    {
        $hODetail = new Xasset\OrderDetailHandler($GLOBALS['xoopsDB']);
        $hCurr    = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //
        $currID = isset($_SESSION['currency_id']) ? $_SESSION['currency_id'] : $this->getVar('currency_id');
        //
        $cur     = $hCurr->get($currID);
        $details = $hODetail->getOrderDetailsByIndex($this->getVar('id'));
        //now add the currency info
        for ($i = 0, $iMax = count($details); $i < $iMax; ++$i) {
            $details[$i]['fmtUnitPrice'] = $cur->valueFormat($details[$i]['unit_price']);
            $details[$i]['fmtTotPrice']  = $cur->valueFormat($details[$i]['totalPrice']);
        }

        //
        return $details;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $product
     * @param $qty
     *
     * @return mixed
     */
    public function addOrderItem($product, $qty)
    {
        //only save if the index record has been posted
        $hODetail = new Xasset\OrderDetailHandler($GLOBALS['xoopsDB']);
        //check if we ar updating or inserting
        $crit = new \CriteriaCompo(new \Criteria('order_index_id', $this->getVar('id')));
        $crit->add(new \Criteria('app_prod_id', $product));
        //
        if ($orderObjs = $hODetail->getObjects($crit)) {
            $order = $hODetail->get($orderObjs[0]->getVar('id'));
            $qty   += $order->getVar('qty');
        } else {
            $order = $hODetail->create();
        }
        //
        $order->setVar('order_index_id', $this->getVar('id'));
        $order->setVar('app_prod_id', $product);
        $order->setVar('qty', $qty);

        //
        return $hODetail->insert($order, true);
    }

    ///////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &orderDetails()
    {
        $hODetails = new Xasset\OrderDetailHandler($GLOBALS['xoopsDB']);

        return $hODetails->getOrderDetailsObjectsByIndex($this->getVar('id'));
    }

    //////////////////////////////////////////////////
    public function addOrderProductsToUser()
    {
        global $xoopsUser;
        //
        $huAppProd = new Xasset\UserAppProductsHandler($GLOBALS['xoopsDB']);
        $items     =& $this->orderDetails();
        //
        foreach ($items as $item) {
            $huAppProd->addUserProduct($xoopsUser, $item->getVar('id'));
        }
    }

    //////////////////////////////////////////////////
    public function processPurchase()
    {
        $hNotify     = new Xasset\NotificationServiceHandler($GLOBALS['xoopsDB']);
        $hProdMember = new Xasset\ApplicationProductMembHandler($GLOBALS['xoopsDB']);
        //we've got the order ID here. So iterate through order items and:
        //1. Add to xoops groups if required
        $aDetails =& $this->orderDetails();
        foreach ($aDetails as $key => $oDetail) {
            $oAppProduct =& $oDetail->getAppProduct();
            //now check for group membership
            if ($oAppProduct->getVar('add_to_group') > 0) {
                $oUserDetail =& $this->getUserDetail();
                $oUserDetail->addUserToGroup($oAppProduct->getVar('add_to_group'));
                //add to group expiry table
                $hProdMember->AddGroupExpiry($oDetail, $oAppProduct, $oUserDetail);
                //
                if (null !== $oUserDetail) {
                    unset($oUserDetail);
                }
            }
            if ($oAppProduct->getVar('add_to_group2') > 0) {
                $oUserDetail =& $this->getUserDetail();
                $oUserDetail->addUserToGroup($oAppProduct->getVar('add_to_group2'));
                //add to group expiry table
                $hProdMember->AddGroupExpiry($oDetail, $oAppProduct, $oUserDetail, '2');
                //
                if (null !== $oUserDetail) {
                    unset($oUserDetail);
                }
            }
        }
        //order is complete.. generate order complete email
        $hNotify->order_complete($this);
    }

    //////////////////////////////////////////////////

    /**
     * @return bool|void
     */
    public function getUserDetail()
    {
        $hUserDetail = new Xasset\UserDetailsHandler($GLOBALS['xoopsDB']);

        return $hUserDetail->get($this->getVar('user_detail_id'));
    }

    //////////////////////////////////////////////////

    /**
     * @return string
     */
    public function getOrderItemsAsText()
    {
        $oItems = $this->orderDetails();
        //
        $items = '';
        foreach ($oItems as $key => $oItem) {
            $oAppProd = $oItem->getAppProduct();
            //
            $product = $oAppProd->getVar('item_description');
            $qty     = $oItem->getVar('qty');
            //
            $items .= "Product : $product\t  Quantity: $qty\n";
        }

        return $items;
    }

    //////////////////////////////////////////////////

    /**
     * @return string
     */
    public function getSpecialInstructionsAsText()
    {
        $oItems =& $this->orderDetails();
        //
        $inst = '';
        foreach ($oItems as $key => $oItem) {
            $oAppProd =& $oItem->getAppProduct();
            //
            $inst .= $oAppProd->getVar('extra_instructions') . "\n\n";
        }
        if ('' <> $inst) {
            $inst = "Special Instructions\n\n" . $inst;
        }

        //
        return $inst;
    }

    //////////////////////////////////////////////////

    /**
     * @return array
     */
    public function &getArray()
    {
        $hOrder = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
        $hCurr  = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //
        $oCurr = $hCurr->get($this->getVar('currency_id'));
        //
        $ar                =& parent::getArray();
        $ar['dateFmt']     = formatTimestamp($this->getVar('date'), 's');
        $ar['statusFmt']   = $hOrder->getStatuByCode($this->getVar('status'));
        $ar['currencyFmt'] = $oCurr->getVar('name');

        //
        return $ar;
    }

    //////////////////////////////////////////////////

    /**
     * @return int
     */
    public function orderStatusNew()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function orderStatusCheckout()
    {
        return 2;
    }

    /**
     * @return int
     */
    public function orderStatusGateway()
    {
        return 3;
    }

    /**
     * @return int
     */
    public function orderStatusValidate()
    {
        return 4;
    }

    /**
     * @return int
     */
    public function orderStatusComplete()
    {
        return 5;
    }
}
