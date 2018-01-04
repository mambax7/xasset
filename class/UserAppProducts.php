<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class UserAppProducts
 */
class UserAppProducts extends \XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('application_product_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /////////////////////////////////////////
    public function increaseDownCount()
    {
        $this->setVar('down_count', $this->getVar('down_count') + 1);
    }
}
