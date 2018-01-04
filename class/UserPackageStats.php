<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class UserPackageStats
 */
class UserPackageStats extends \XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('packageid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('ip', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('date', XOBJ_DTYPE_INT, time(), false);
        $this->initVar('dns', XOBJ_DTYPE_TXTBOX, null, false, 250);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    //////////////////////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return string
     */
    public function date($format = 'l')
    {
        if ($this->getVar('date') > 0) {
            return formatTimestamp($this->getVar('date'), $format);
        } else {
            return '';
        }
    }

    //////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getPackage()
    {
        $hDept = new Xasset\PackageHandler($GLOBALS['xoopsDB']);

        return $hDept->get($this->getVar('packageid'));
    }
}
