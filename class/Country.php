<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class Country
 */
class Country extends \XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 75);
        $this->initVar('iso2', XOBJ_DTYPE_TXTBOX, null, false, 2);
        $this->initVar('iso3', XOBJ_DTYPE_TXTBOX, null, false, 3);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    ////////////////////////////////////////////

    /**
     * @return bool
     */
    public function hasZones()
    {
        $hZones = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
        //
        $crit   = new \Criteria('country_id', $this->getVar('id'));
        $objCnt = $hZones->getCount($crit);

        //
        return ($objCnt > 0);
    }

    ////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getZones()
    {
        $hZones = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
        //
        $crit = new \Criteria('country_id', $this->getVar('id'));

        return $hZones->getObjects($crit);
    }

    ////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getZonesSelect()
    {
        $hZones = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);

        //
        return $hZones->getZonesByCountry($this->getVar('id'), false);
    }
}
