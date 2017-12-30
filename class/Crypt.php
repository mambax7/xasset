<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;

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
