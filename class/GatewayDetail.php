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
 * class GatewayDetail
 */
class GatewayDetail extends \XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gateway_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gkey', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('gvalue', XOBJ_DTYPE_TXTBOX, null, false, 64000);
        $this->initVar('gorder', XOBJ_DTYPE_INT, null, false);
        $this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 200);
        $this->initVar('list_ov', XOBJ_DTYPE_TXTBOX, null, false, 200);
        $this->initVar('gtype', XOBJ_DTYPE_TXTBOX, null, false, 1);
        //
        if (null !== $id) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }
}
