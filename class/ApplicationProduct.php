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
 * Class ApplicationProduct
 */
class ApplicationProduct extends Xasset\BaseObject
{
    public $weight;

    //

    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('application_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('tax_class_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('display_order', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('base_currency_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('package_group_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('sample_package_group_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('item_code', XOBJ_DTYPE_TXTBOX, null, true, 10);
        $this->initVar('item_description', XOBJ_DTYPE_TXTBOX, null, true, 100);
        $this->initVar('unit_price', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('old_unit_price', XOBJ_DTYPE_OTHER, 0, false);
        $this->initVar('min_unit_count', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('max_access', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('max_days', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('expires', XOBJ_DTYPE_LTIME, null, false);
        $this->initVar('add_to_group', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('add_to_group2', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('item_rich_description', XOBJ_DTYPE_TXTBOX, null, true, 50000);
        $this->initVar('enabled', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('group_expire_date', XOBJ_DTYPE_INT, null, false);
        $this->initVar('group_expire_date2', XOBJ_DTYPE_INT, null, false);
        $this->initVar('extra_instructions', XOBJ_DTYPE_TXTBOX, null, true, 60000);
        //
        $this->weight = 13;
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
    public function itemDescription()
    {
        return $this->getVar('item_description');
    }

    /////////////////////////////////////////

    /**
     * @return mixed
     */
    public function packageGroupID()
    {
        return $this->getVar('package_group_id');
    }

    /////////////////////////////////////////

    /**
     * @return mixed
     */
    public function applicationID()
    {
        return $this->getVar('application_id');
    }

    /////////////////////////////////////////

    /**
     * @return mixed
     */
    public function sampleGroupID()
    {
        return $this->getVar('sample_package_group_id');
    }

    /////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getApplication()
    {
        $app = xoops_modulehandler('application', 'xasset');

        return $app->get($this->getVar('applicationid'));
    }

    /////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getTaxClass()
    {
        $class = xoops_modulehandler('taxClass', 'xasset');

        return $class->get($this->getVar('taxclassid', 'xasset'));
    }

    /////////////////////////////////////////

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

    ////////////////////////////////////////

    /**
     * @return mixed
     */
    public function groupExpireDate()
    {
        return $this->getVar('group_expire_date');
    }

    ///////////////////////////////////////////////

    /**
     * @return string
     */
    public function getKey()
    {
        $crypt = new Xasset\Crypt();

        return $crypt->cryptValue($this->getVar('id'), $this->weight);
    }

    //////////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return mixed
     */
    public function getPrice($format = 's')
    {
        $hCurrency = new Xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //have two currency choices.. either the chosen currency in $_SESSION or the base currency;
        $curID   = isset($_SESSION['currency_id']) ? $_SESSION['currency_id'] : $this->getVar('base_currency_id');
        $oCur    = $hCurrency->get($curID);
        $oAppCur = $hCurrency->get($this->getVar('base_currency_id'));
        //
        if ('s' === $format) {
            return $oCur->valueOnlyFormat($this->getVar('unit_price') / $oAppCur->value());
        } elseif ('l' === $format) {
            return $oCur->valueFormat($this->getVar('unit_price') / $oAppCur->value());
        }
    }

    //////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getRichDescription()
    {
        return $this->getVar('item_rich_description', 'n');
    }

    //////////////////////////////////////////////

    /**
     * @param string $image
     *
     * @return string
     */
    public function getBuyNowButton($image = '')
    {
        if ('' == $image) {
            $image = XOOPS_URL . '/modules/xasset/assets/images/buyNow.png';
        }
        //
        $button = '<form method="post" action="' . XOOPS_URL . '/modules/xasset/order.php?id=' . $this->ID() . '&amp;key=' . $this->getKey() . '&amp;op=addToCart">
                         <input type="image" src="' . $image . '" title="Buy Now" ALT="Buy Now" name="buyNow" style="border:0;background:transparent">
                         </form>';

        return $button;
    }

    //////////////////////////////////////////////

    /**
     * @return array
     */
    public function &getArray()
    {
        $ary                 =& parent::getArray();
        $ary['product_link'] = $this->getBuyNowButton();

        //
        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $movie_id
     *
     * @return bool|mixed|string
     */
    public function getVideoPlayer($movie_id = null)
    {
        global $xoopsUser;
        //
        $hCommon  = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
        $hPackage = new Xasset\PackageHandler($GLOBALS['xoopsDB']);
        //
        if (null === $movie_id) {
            //get first sample video from packages
            $aoPackages = $hPackage->getProductSamplePackages($this);
            if (count($aoPackages) > 0) {
                $oPackage =& $aoPackages[0];
            }
        } else {
            $oPackage = $hPackage->get($movie_id);
        }
        //
        if (is_object($oPackage)) {
            $tpl = new \XoopsTpl();
            $tpl->assign('xasset_movie_id', $oPackage->ID());
            $tpl->assign('xasset_movie_size', $oPackage->fileSize());
            $tpl->assign('xasset_token', $xoopsUser ? $hCommon->pspEncrypt($xoopsUser->uid()) : $hCommon->pspEncrypt(0));

            //
            return $tpl->fetch('db:xasset_player_code.tpl');
        }

        return '';
    }
}
