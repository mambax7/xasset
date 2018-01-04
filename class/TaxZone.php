<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class TaxZone
 */
class TaxZone extends Xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('region_id', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('zone_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('country_id', XOBJ_DTYPE_INT, null, false);
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
