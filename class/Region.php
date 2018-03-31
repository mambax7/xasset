<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class Region
 */
class Region extends Xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('region', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 200);
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