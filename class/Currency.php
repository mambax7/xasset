<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class Currency
 */
class Currency extends Xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('code', XOBJ_DTYPE_TXTBOX, null, false, 3);
        $this->initVar('decimal_places', XOBJ_DTYPE_INT, 2, false);
        $this->initVar('symbol_left', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('symbol_right', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('decimal_point', XOBJ_DTYPE_TXTBOX, '.', false, 1);
        $this->initVar('thousands_point', XOBJ_DTYPE_TXTBOX, ',', false, 1);
        $this->initVar('value', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('enabled', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('updated', XOBJ_DTYPE_INT, null, false);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    ////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return string
     */
    public function lastUpdated($format = 'l')
    {
        if ($this->getVar('updated') > 0) {
            return formatTimestamp($this->getVar('updated'), $format);
        } else {
            return '';
        }
    }

    ////////////////////////////////////////

    /**
     * @param $value
     *
     * @return string
     */
    public function valueFormat($value)
    {
        $val = $this->getVar('symbol_left') . number_format($this->getVar('value') * $value, $this->getVar('decimal_places'), $this->getVar('decimal_point'), $this->getVar('thousands_point')) . $this->getVar('symbol_right');

        //
        return $val;
    }

    ////////////////////////////////////////

    /**
     * @param $value
     *
     * @return string
     */
    public function valueOnlyFormat($value)
    {
        $val = number_format($this->getVar('value') * $value, $this->getVar('decimal_places'), $this->getVar('decimal_point'), $this->getVar('thousands_point'));

        //
        return $val;
    }

    ////////////////////////////////////////

    /**
     * @param $value
     *
     * @return mixed
     */
    public function bConvert($value)
    {
        return $this->getVar('value') * $value * 100;
    }

    ////////////////////////////////////////

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->getVar('value');
    }
}
