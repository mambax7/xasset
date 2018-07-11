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
 * class Crypt
 */
class Crypt
{
    //
    /**
     * @param     $value
     * @param int $weight
     *
     * @return string
     */
    public function cryptValue($value, $weight = 0)
    {
        $val = $this->sliceValue($value + $weight);

        return $val;
    }

    //

    /**
     * @param $value
     *
     * @return string
     */
    public function sliceValue($value)
    {
        //change this method when public to add more security to encryption method
        $val = md5($value);
        $val = substr($val, 5, 5);
        $val = md5($val);
        $val = $this->sliceExternal($val, 5, 5);

        //
        return $val;
    }

    //

    /**
     * @param $key
     *
     * @return string
     */
    public function sliceExternal($key)
    {
        return substr($key, 5, 5);
    }

    //

    /**
     * @param     $value
     * @param     $extKey
     * @param int $weight
     *
     * @return bool
     */
    public function keyMatches($value, $extKey, $weight = 0)
    {
        $intKey = $this->sliceValue($value + $weight);

        //$intKey = $this->sliceExternal($intKey);
        return ($intKey == $extKey);
    }
}
