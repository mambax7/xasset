<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;

/**
 * class OrderDetail
 */
class OrderDetail extends xasset\BaseObject
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
        if (isset($id)) {
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
        $idx = new xasset\OrderHandler($GLOBALS['xoopsDB']);

        return $idx->get($this->getVar('order_index_id'));
    }

    //////////////////////////////////////////////////

    /**
     * @return XoopsObject
     */
    public function &getAppProduct()
    {
        $hProd = new xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);

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
