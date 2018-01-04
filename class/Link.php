<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class Link
 */
class Link extends \XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('applicationid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('link', XOBJ_DTYPE_TXTBOX, null, false, 255);
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
     * @return mixed
     */
    public function getApplication()
    {
        $hDept = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);

        return $hDept->get($this->getVar('applicationid'));
    }

    ///////////////////////////////////////////////////

    /**
     * @return bool
     */
    public function getLinkApplication()
    {
        $id = (int)$uid;
        if (!$id) {
            return false;
        }
        $hApplication = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
        $arr          = $hApplication->getObjects($this->getVar('applicationid'));

        //
        return $arr;
    }
}
