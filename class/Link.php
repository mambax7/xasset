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
 * class Link
 */
class Link extends \XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('applicationid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('link', XOBJ_DTYPE_TXTBOX, null, false, 255);
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
     * @return mixed
     */
    public function getApplication()
    {
        $hDept = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);

        return $hDept->get($this->getVar('applicationid'));
    }

    ///////////////////////////////////////////////////

    /**
     * @return bool|array
     */
    public function getLinkApplication()
    {
        $id = (int)$uid;
        if (!$id) {
            return false;
        }
        $hApplication = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
        $arr          = $hApplication->getObjects($this->getVar('applicationid'));

        //
        return $arr;
    }
}
