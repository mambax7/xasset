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
 * class PackageGroup
 */
class PackageGroup extends Xasset\BaseObject
{
    public $weight;

    //

    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('applicationid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('grpDesc', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('version', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('datePublished', XOBJ_DTYPE_INT, time(), false);
        //
        $this->weight = 3;
        //
        if (null !== $id) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /////////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return string
     */
    public function datePublished($format = 'l')
    {
        if ($this->getVar('datePublished') > 0) {
            return formatTimestamp($this->getVar('datePublished'), $format);
        }

        return '';
    }

    //////////////////////////////////////////

    /**
     * @return array
     */
    public function getPackages()
    {
        $arr = [];
        //
        $id = (int)$this->getVar('id');
        if (!$id) {
            return $arr;
        }
        //
        $hPackages = new Xasset\PackageHandler($GLOBALS['xoopsDB']);
        //
        $crit = new \CriteriaCompo(new \Criteria('packagegroupid', $id));
        $crit->setSort('filename');
        //
        $arr = $hPackages->getObjects($crit);

        //
        return $arr;
    }

    //////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getApplication()
    {
        $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);

        return $hApp->get($this->getVar('applicationid'));
    }
}
