<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;

/**
 * class TaxRate
 */
class TaxRate extends xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('region_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('tax_class_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('rate', XOBJ_DTYPE_OTHER, 0, false);
        $this->initVar('priority', XOBJ_DTYPE_INT, null, false);
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

    /////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getZone()
    {
        $zone = new xasset\ZoneHandler($GLOBALS['xoopsDB']);

        return $zone->get($this->getVar('zoneid'));
    }

    /////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getTaxClass()
    {
        $class = new xasset\TaxClassHandler($GLOBALS['xoopsDB']);

        return $class->get($this->getVar('taxclassid', 'xasset'));
    }
}
