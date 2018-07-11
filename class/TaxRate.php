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
 * class TaxRate
 */
class TaxRate extends Xasset\BaseObject
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
        if (null !== $id) {
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
        $zone = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);

        return $zone->get($this->getVar('zoneid'));
    }

    /////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getTaxClass()
    {
        $class = new Xasset\TaxClassHandler($GLOBALS['xoopsDB']);

        return $class->get($this->getVar('taxclassid', 'xasset'));
    }
}
