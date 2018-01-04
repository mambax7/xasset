<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class GatewayDetail
 */
class GatewayDetail extends \XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gateway_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gkey', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('gvalue', XOBJ_DTYPE_TXTBOX, null, false, 64000);
        $this->initVar('gorder', XOBJ_DTYPE_INT, null, false);
        $this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 200);
        $this->initVar('list_ov', XOBJ_DTYPE_TXTBOX, null, false, 200);
        $this->initVar('gtype', XOBJ_DTYPE_TXTBOX, null, false, 1);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }
}
