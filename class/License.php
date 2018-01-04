<?php namespace XoopsModules\Xasset;

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
        if (isset($id)) {
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
        } else {
            return '';
        }
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
        } else {
            return '';
        }
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
