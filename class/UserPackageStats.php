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
 * class UserPackageStats
 */
class UserPackageStats extends \XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('packageid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('ip', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('date', XOBJ_DTYPE_INT, time(), false);
        $this->initVar('dns', XOBJ_DTYPE_TXTBOX, null, false, 250);
        //
        if (null !== $id) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    //////////////////////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return string
     */
    public function date($format = 'l')
    {
        if ($this->getVar('date') > 0) {
            return formatTimestamp($this->getVar('date'), $format);
        }

        return '';
    }

    //////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getPackage()
    {
        $hDept = new Xasset\PackageHandler($GLOBALS['xoopsDB']);

        return $hDept->get($this->getVar('packageid'));
    }
}
