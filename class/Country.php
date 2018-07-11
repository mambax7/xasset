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
        if (null !== $id) {
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
