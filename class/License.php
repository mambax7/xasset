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
 * class License
 */
class License extends Xasset\BaseObject
{
    public $weight;

    //

    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('applicationid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('authKey', XOBJ_DTYPE_TXTBOX, null, true, 50);
        $this->initVar('authCode', XOBJ_DTYPE_TXTBOX, null, true, 100);
        $this->initVar('expires', XOBJ_DTYPE_LTIME, null, false);
        $this->initVar('dateIssued', XOBJ_DTYPE_INT, time(), false);
        //
        $this->weight = 2;
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
     * @param string $format
     *
     * @return string
     */
    public function expires($format = 'l')
    {
        if ($this->getVar('expires') > 0) {
            return formatTimestamp($this->getVar('expires'), $format);
        }

        return '';
    }

    ////////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return string
     */
    public function dateIssued($format = 'l')
    {
        if ($this->getVar('dateIssued') > 0) {
            return formatTimestamp($this->getVar('dateIssued'), $format);
        }

        return '';
    }

    ////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getApplication()
    {
        $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);

        return $hApp->get($this->getVar('applicationid'));
    }
}
