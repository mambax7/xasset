<?php

require_once __DIR__ . '/xassetBaseObject.php';
require_once __DIR__ . '/crypt.php';

/**
 * Class xassetPackageGroup
 */
class XAssetPackageGroup extends XassetBaseObject
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
        $hPackages = xoops_getModuleHandler('package', 'xasset');
        //
        $crit = new CriteriaCompo(new Criteria('packagegroupid', $id));
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
        $hApp = xoops_getModuleHandler('application', 'xasset');

        return $hApp->get($this->getVar('applicationid'));
    }
}

/**
 * Class xassetPackageGroupHandler
 */
class XassetPackageGroupHandler extends XassetBaseObjectHandler
{
    //vars
    public $_db;
    public $classname = 'xassetpackagegroup';
    public $_dbtable  = 'xasset_packagegroup';

    //cons

    /**
     * @param $db
     */
    public function __construct(XoopsDatabase $db)
    {
        $this->_db = $db;
    }

    //////////////////////////////////////////////////////

    /**
     * @param $criteria
     *
     * @return array
     */
    public function getPackageGroupArray($criteria)
    {
        if (!isset($criteria)) {
            $criteria = new CriteriaCompo();
            $criteria->setSort('name');
        }
        //
        $objs  = $this->getObjects($criteria, true);
        $crypt = new XassetCrypt();
        $ar    = [];
        //
        $i = 0;
        foreach ($objs as $obj) {
            $ar[$i]                  = $obj->getArray();
            $ar[$i]['datePublished'] = $obj->datePublished();
            $ar[$i]['cryptKey']      = $crypt->cryptValue($obj->getVar('id'), $obj->weight);
            //
            ++$i;
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $appid
     *
     * @return array
     */
    public function getApplicationGroupPackages($appid)
    {
        $crit = new CriteriaCompo(new Criteria('applicationid', $appid));
        $crit->setSort('name');

        //
        return $this->getApplicationGroupArray($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function getApplicationGroupAllPackages()
    {
        return $this->getApplicationGroupArray();
    }

    ///////////////////////////////////////////////////

    /**
     * @param $id
     *
     * @return array
     */
    public function getPackageGroup($id)
    {
        $crit = new CriteriaCompo(new Criteria('id', $id));

        //
        return $this->getApplicationGroupArray($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $crit
     *
     * @return array
     */
    public function getApplicationGroupArray($crit = null)
    {
        global $imagearray;
        //
        //$crit = new CriteriaCompo(new Criteria('applicationid', $appid));
        //$crit->setSort('name');
        //
        $hPack = xoops_getModuleHandler('package', 'xasset');
        //
        $objs = $this->getPackageGroupArray($crit);
        //
        for ($i = 0, $iMax = count($objs); $i < $iMax; ++$i) {
            $action = '<a href="main.php?op=editPackageGroup&id=' . $objs[$i]['id'] . '&appid=' . $objs[$i]['applicationid'] . '">' . $imagearray['editimg'] . '</a>' . '<a href="main.php?op=deletePackageGroup&id=' . $objs[$i]['id'] . '">' . $imagearray['deleteimg'] . '</a>';
            //
            $objs[$i]['actions'] = $action;
            //now need to get the packages
            $objs[$i]['packages'] = $hPack->getGroupPackagesArray($objs[$i]['id']);
        }

        return $objs;
    }

    ///////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getAllGroupsSelectArray()
    {
        $crit = new CriteriaCompo();
        $crit->setSort('name');
        //
        $ary[0] = 'None';
        $ary    = $ary + $this->getGroupsSelectArray($crit);

        //
        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $appid
     *
     * @return array
     */
    public function getApplicationGroupsSelect($appid)
    {
        $crit = new CriteriaCompo(new Criteria('applicationid', $appid));
        $crit->setSort('name');

        //
        return $this->getGroupsSelectArray($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $crit
     *
     * @return array
     */
    public function getGroupsSelectArray($crit)
    {
        $objs = $this->getObjects($crit);
        $ar   = [];
        //
        foreach ($objs as $obj) {
            $ar[$obj->getVar('id')] = $obj->getVar('name');
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $appid
     *
     * @return array
     */
    public function getDownloadByApplicationSummaryArray($appid)
    {
        $crit = new CriteriaCompo(new Criteria('applicationid', $appid));

        return $this->getDownloadSummaryArray($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $crit
     *
     * @return array
     */
    public function getDownloadSummaryArray($crit = null)
    {
        if (!isset($crit)) {
            $crit = new CriteriaCompo();
            $crit->setSort('id');
        }
        //
        $hPack = xoops_getModuleHandler('package', 'xasset');
        //
        $objs = $this->getObjects($crit);
        $ary  = [];
        //
        foreach ($objs as $obj) {
            $packs = $hPack->getDownloadSummaryByPackageGroupArray($obj->getVar('id'));
            $ary[] = [
                'id'       => $obj->getVar('id'),
                'name'     => $obj->getVar('name'),
                'grpDesc'  => $obj->getVar('grpDesc'),
                'packages' => $packs
            ];
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $db
     *
     * @return xassetPackageGroupHandler
     */
    public function getInstance(XoopsDatabase $db)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($db);
        }

        return $instance;
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|XoopsObject $obj
     * @param bool               $force
     * @return bool
     */
    public function insert(XoopsObject $obj, $force = false)
    {
        parent::insert($obj, $force);
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        // Create query for DB update
        if ($obj->isNew()) {
            // Determine next auto-gen ID for table
            $id  = $this->_db->genId($this->_db->prefix($this->_dbtable) . '_uid_seq');
            $sql = sprintf(
                'INSERT INTO %s (id, applicationid, NAME, grpDesc, version, datePublished) VALUES (%u, %u, %s, %s, %s, %u)',
                $this->_db->prefix($this->_dbtable),
                $id,
                $applicationid,
                $this->_db->quoteString($name),
                $this->_db->quoteString($grpDesc),
                $this->_db->quoteString($version),
                           $datePublished
            );
        } else {
            $sql = sprintf(
                'UPDATE %s SET applicationid = %u, NAME = %s, grpDesc = %s, version = %s, datePublished = %u WHERE id = %u',
                $this->_db->prefix($this->_dbtable),
                $applicationid,
                $this->_db->quoteString($name),
                $this->_db->quoteString($grpDesc),
                $this->_db->quoteString($version),
                           $datePublished,
                $id
            );
        }
        //echo $sql;
        // Update DB
        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            return false;
        }

        //Make sure auto-gen ID is stored correctly in object
        if (empty($id)) {
            $id = $this->_db->getInsertId();
        }
        $obj->assignVar('id', $id);

        return true;
    }
}
