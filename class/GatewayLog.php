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
 * class GatewayLog
 */
class GatewayLog extends Xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('order_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gateway_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('date', XOBJ_DTYPE_INT, null, false);
        $this->initVar('order_stage', XOBJ_DTYPE_INT, null, false);
        $this->initVar('log_text', XOBJ_DTYPE_TXTBOX, null, false, 50000);

        //
        if (null !== $id) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getLogDate($format = 'l')
    {
        if ($this->getVar('date') > 0) {
            return formatTimestamp($this->date(''), $format);
        }

        return '';
    }
}
