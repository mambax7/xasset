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
 * class Gateway
 */
class Gateway extends Xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('code', XOBJ_DTYPE_TXTBOX, null, false, 20);
        $this->initVar('enabled', XOBJ_DTYPE_INT, 1, false);
        //
        if (null !== $id) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getDetails()
    {
        $hgDetail = new Xasset\GatewayDetailHandler($GLOBALS['xoopsDB']);

        return $hgDetail->getByIndex($this->getVar('id'));
    }

    ///////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getDetailArray()
    {
        $hgDetail = new Xasset\GatewayDetailHandler($GLOBALS['xoopsDB']);

        return $hgDetail->getConfigArrayByIndex($this->getVar('id'));
    }

    ///////////////////////////////////////////////////

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function saveConfigValue($key, $value)
    {
        $hGDetail = new Xasset\GatewayDetailHandler($GLOBALS['xoopsDB']);

        return $hGDetail->saveConfigValue($this->getVar('id'), $key, $value);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $values
     */
    public function toggleBinaryValues($values)
    {
        $hGDetail = new Xasset\GatewayDetailHandler($GLOBALS['xoopsDB']);
        //
        $aDetail = $hGDetail->getBinaryConfigArrayByIndex($this->getVar('id'));
        //should have an array of binary fields... check if these exist in the post values array
        foreach ($aDetail as $detail) {
            if (isset($values[$detail['gkey']])) {
                $hGDetail->saveConfigValue($this->getVar('id'), $detail['gkey'], true);
            } else {
                $hGDetail->saveConfigValue($this->getVar('id'), $detail['gkey'], false);
            }
        }
    }
}
