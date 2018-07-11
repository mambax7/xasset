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
 * class OrderDetail
 */
class OrderDetail extends Xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('order_index_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('app_prod_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('qty', XOBJ_DTYPE_INT, time(), false);
        //
        if (null !== $id) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    //////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getAppProdID()
    {
        return $this->getVar('app_prod_id');
    }

    //////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getOrderIndex()
    {
        $idx = new Xasset\OrderHandler($GLOBALS['xoopsDB']);

        return $idx->get($this->getVar('order_index_id'));
    }

    //////////////////////////////////////////////////

    /**
     * @return bool|void
     */
    public function &getAppProduct()
    {
        $hProd = new Xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);

        return $hProd->get($this->getVar('app_prod_id'));
    }

    /////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getOrderItemDescription()
    {
        $oAppProd =& $this->getAppProduct();

        return $oAppProd->itemDescription();
    }
}
