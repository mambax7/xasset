<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;

/**
 * class PackageGroup
 */
class PackageGroup extends xasset\BaseObject
{
    public $weight;

    //

    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('applicationid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('grpDesc', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('version', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('datePublished', XOBJ_DTYPE_INT, time(), false);
        //
        $this->weight = 3;
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /////////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return string
     */
    public function datePublished($format = 'l')
    {
        if ($this->getVar('datePublished') > 0) {
            return formatTimestamp($this->getVar('datePublished'), $format);
        } else {
            return '';
        }
    }

    //////////////////////////////////////////

    /**
     * @return array
     */
    public function getPackages()
    {
        $arr = [];
        //
        $id = (int)$this->getVar('id');
        if (!$id) {
            return $arr;
        }
        //
        $hPackages = new xasset\PackageHandler($GLOBALS['xoopsDB']);
        //
        $crit = new \CriteriaCompo(new \Criteria('packagegroupid', $id));
        $crit->setSort('filename');
        //
        $arr = $hPackages->getObjects($crit);

        //
        return $arr;
    }

    //////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getApplication()
    {
        $hApp = new xasset\ApplicationHandler($GLOBALS['xoopsDB']);

        return $hApp->get($this->getVar('applicationid'));
    }
}
