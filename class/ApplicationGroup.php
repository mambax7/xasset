<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * Class ApplicationGroup
 */
class ApplicationGroup extends Xasset\BaseObject
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
        $this->initVar('group_id', XOBJ_DTYPE_INT, null, false);
        //
        $this->weight = 17;
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /////////////////////////////////////////

    /**
     * @return \XoopsObject
     */
    public function getApplication()
    {
        $app = new \Xasset\ApplicationHandler($GLOBALS['xoopsDB']);

        return $app->get($this->getVar('applicationid'));
    }
}
