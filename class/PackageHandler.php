<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class PackageHandler
 */
class PackageHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Package::class;
    public $_dbtable  = 'xasset_package';
    public $_weight   = 917;

    //cons

    /**
     * @param $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        $this->_db = $db;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $criteria
     *
     * @return array
     */
    public function getPackagesArray($criteria)
    {
        if (!isset($criteria)) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('filename');
        }
        //
        $objs = $this->getObjects($criteria, true);
        $ar   = [];
        //
        foreach ($objs as $obj) {
            $ar[] = $obj->getArray();
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $groupid
     *
     * @return array
     */
    public function getDownloadSummaryByPackageGroupArray($groupid)
    {
        $crit = new \CriteriaCompo(new \Criteria('packagegroupid', $groupid));
        $crit->setSort('filename');

        //
        return $this->getDownloadSummary($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $crit
     *
     * @return array
     */
    public function getDownloadSummary($crit)
    {
        $hStats = new Xasset\UserPackageStatsHandler($GLOBALS['xoopsDB']);
        //
        $objs = $this->getObjects($crit);
        $ary  = [];
        //
        foreach ($objs as $obj) {
            $stats = $hStats->getDownloadStatsByPackageArray($obj->getVar('id'));
            $ary[] = [
                'id'        => $obj->getVar('id'),
                'filename'  => $obj->getVar('filename'),
                'downloads' => $stats,
                'count'     => count($stats)
            ];
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $groupID
     *
     * @return array
     */
    public function getGroupPackagesArray($groupID)
    {
        global $imagearray;
        //
        $crit = new \CriteriaCompo(new \Criteria('packagegroupid', $groupID));
        $crit->setSort('filename');
        //
        $objs  = $this->getObjects($crit);
        $crypt = new Xasset\Crypt();
        $ar    = [];
        $i     = 0;
        //
        foreach ($objs as $obj) {
            $action = '<a href="main.php?op=editPackage&id='
                      . $obj->getVar('id')
                      . '">'
                      . $imagearray['editimg']
                      . '</a>'
                      . '<a href="main.php?op=deletePackage&id='
                      . $obj->getVar('id')
                      . '">'
                      . $imagearray['deleteimg']
                      . '</a>'
                      . '<a href="'
                      . XOOPS_URL
                      . '/modules/xasset/index.php?op=downloadPack&packid='
                      . $obj->getVar('id')
                      . '&key='
                      . $crypt->cryptValue($obj->getVar('id'), $obj->weight)
                      . '">'
                      . $imagearray['online']
                      . '</a>';
            if ($obj->getVar('protected') > 0) {
                $action .= $imagearray['protected'];
            }
            //
            $ar[$i]             = $obj->getArray();
            $ar[$i]['actions']  = $action;
            $ar[$i]['cryptKey'] = $crypt->cryptValue($obj->getVar('id'), $obj->weight);
            ++$i;
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @return int
     */
    public function getAllPackagesCount()
    {
        return $this->getCount();
    }

    ///////////////////////////////////////////////////

    /**
     * @param $packID
     *
     * @return bool
     */
    public function getPackageApplication($packID)
    {
        $hGrp = new Xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
        $hApp = new Xasset\ApplicationHandler($GLOBALS['xoopsDB']);
        //
        $thisTable = $this->_db->prefix($this->_dbtable);
        $grpTable  = $this->_db->prefix($hGrp->_dbtable);
        $appTable  = $this->_db->prefix($hApp->_dbtable);
        //
        $sql = "select a.id from $thisTable p inner join $grpTable g on
                    p.packagegroupid = g.id inner join $appTable a on
                    g.applicationid  = a.id where p.id = $packID";
        //
        if ($res = $this->_db->query($sql)) {
            if ($row = $this->_db->fetcharray($res)) {
                return $row['id'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $oAppProduct
     *
     * @return array|bool
     */
    public function &getProductSamplePackages($oAppProduct)
    {
        $crit = new \CriteriaCompo(new \Criteria('packagegroupid', $oAppProduct->sampleGroupID()));
        $objs = $this->getObjects($crit);
        //
        if (count($objs) > 0) {
            return $objs;
        } else {
            $objs = false;

            return $objs;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $db
     *
     * @return Xasset\PackageHandler
     */
    public function getInstance(\XoopsDatabase $db)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($db);
        }

        return $instance;
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|\XoopsObject $obj
     * @param bool               $force
     * @return bool
     */
    public function insert(\XoopsObject $obj, $force = false)
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
            $sql = sprintf('INSERT INTO %s (id, packagegroupid, filename, filesize, filetype, serverFilePath, protected, isVideo)
                                      VALUES (%u, %u, %s, %u, %s, %s, %u, %u)', $this->_db->prefix($this->_dbtable), $id, $packagegroupid, $this->_db->quoteString($filename), $filesize, $this->_db->quoteString($filetype), $this->_db->quoteString($serverFilePath), $protected, $isVideo);
        } else {
            $sql = sprintf(
                'UPDATE %s SET packagegroupid = %u, filename = %s, filesize = %u, filetype = %s,
                                        serverFilePath = %s, protected = %u, isVideo = %u WHERE id = %u',
                $this->_db->prefix($this->_dbtable),
                $packagegroupid,
                $this->_db->quoteString($filename),
                $filesize,
                $this->_db->quoteString($filetype),
                $this->_db->quoteString($serverFilePath),
                $protected,
                           $isVideo,
                $id
            );
        }

        // Update DB
        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            print_r($this->_db);

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
