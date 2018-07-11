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
 * Class ApplicationProductMemb
 */
class ApplicationProductMemb extends Xasset\BaseObject
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
        $this->initVar('order_detail_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('group_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('expiry_date', XOBJ_DTYPE_INT, null, false);
        $this->initVar('sent_warning', XOBJ_DTYPE_INT, null, false);
        //
        $this->weight = 17;
        //
        if (null !== $id) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    ////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function uid()
    {
        return $this->getVar('uid');
    }

    ////////////////////////////////////////////////////////////

    /**
     * @return bool
     */
    public function sentOverADayAgo()
    {
        //check if it has been 24 hours since
        if ($this->getVar('sent_warning') > 0) {
            return (time() - $this->getVar('sent_warning')) > 60 * 60 * 24;
        }

        return true;
    }

    ///////////////////////////////////////////////////////////
    public function setSentWarning()
    {
        $this->setVar('sent_warning', time());
    }

    ///////////////////////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return bool|mixed|string
     */
    public function expiryDate($format = 'n')
    {
        switch ($format) {
            case 'n':
                return $this->getVar('expiry_date');
                break;
            case 's':
                return date('Y-m-d', $this->getVar('expiry_date'));
                break;
            case 'l':
                return date('l dS \of F Y h:i:s A', $this->getVar('expiry_date'));
        }
    }

    ///////////////////////////////////////////////////////////

    /**
     * @return bool|void
     */
    public function &getOrderDetails()
    {
        $hOrderDetail = new Xasset\OrderDetailHandler($GLOBALS['xoopsDB']);

        return $hOrderDetail->get($this->getVar('order_detail_id'));
    }
}
