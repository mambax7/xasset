<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;

/**
 * class Config
 */
class Config extends \XoopsObject
{
    //cons
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('dkey', XOBJ_DTYPE_TXTBOX, null, true, 50);
        $this->initVar('dvalue', XOBJ_DTYPE_TXTBOX, null, true, 100);

        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }
}
