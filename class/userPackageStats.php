<?php

require_once __DIR__ . '/xassetBaseObject.php';

/**
 * Class xassetUserPackageStats
 */
class XassetUserPackageStats extends XoopsObject
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
        $hDept = xoops_getModuleHandler('package', 'xasset');

        return $hDept->get($this->getVar('packageid'));
    }
}

/**
 * Class xassetUserPackageStatsHandler
 */
class XassetUserPackageStatsHandler extends XassetBaseObjectHandler
{
    //vars
    public $_db;
    public $classname = 'xassetuserpackagestats';
    public $_dbtable  = 'xasset_userpackagestats';

    //cons

    /**
     * @param $db
     */
    public function __construct(XoopsDatabase $db)
    {
        $this->_db = $db;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $packid
     *
     * @return array
     */
    public function getDownloadStatsByPackageArray($packid)
    {
        $crit = new CriteriaCompo(new Criteria('packageid', $packid));

        return $this->getDownloadStatsArray($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $oPackage
     *
     * @return bool
     */
    public function logPackageDownload($oPackage)
    {
        global $xoopsUser;
        //
        if ($xoopsUser) {
            $uid = $xoopsUser->getVar('uid');
        } else {
            $uid = 0;
        }

        $stats = $this->create();
        $stats->setVar('packageid', $oPackage->getVar('id'));
        $stats->setVar('uid', $uid);
        $stats->setVar('ip', getenv('REMOTE_ADDR'));
        $stats->setVar('dns', gethostbyaddr(getenv('REMOTE_ADDR')));
        $stats->setVar('date', time());

        //
        return $this->insert($stats, true);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $crit
     *
     * @return array
     */
    public function getDownloadStatsArray($crit)
    {
        global $imagearray;
        //
        $table     = $this->_db->prefix($this->_dbtable);
        $userTable = $this->_db->prefix('users');

        //
        $sql = "select s.*, u.name, u.uname from $table s left join $userTable u on s.uid = u.uid";
        $this->postProcessSQL($sql, $crit); //echo $sql;
        //
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            while ($row = $this->_db->fetcharray($res)) {
                $actions = '<a href="main.php?op=deleteStat&id=' . $row['id'] . '">' . $imagearray['deleteimg'] . '</a>';
                //
                if (strlen($row['uid']) > 0) {
                    $name = $row['name'];
                } else {
                    $name = 'Anonymous';
                }
                //
                $ary[] = [
                    'id'      => $row['id'],
                    'uid'     => $row['uid'],
                    'name'    => $row['name'],
                    'uname'   => $name,
                    'ip'      => $row['ip'],
                    'date'    => formatTimestamp($row['date'], 'l'),
                    'actions' => $actions
                ];
            }
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $packid
     * @param $uid
     *
     * @return int
     */
    public function getUserPackageDownloadCount($packid, $uid)
    {
        $thisTable = $this->_db->prefix($this->_dbtable);
        //
        $sql = "select count(id) cnt from $thisTable where packageid = $packid and uid = $uid";
        //
        if ($res = $this->_db->query($sql)) {
            if ($row = $this->_db->fetcharray($res)) {
                return $row['cnt'];
            }
        }

        //shouldn't get here
        return 0;
    }

    ///////////////////////////////////////////////////

    /**
     * @return int
     */
    public function getAllDownloadStats()
    {
        return $this->getCount();
    }

    ///////////////////////////////////////////////////

    /**
     * @param $pPackageID
     * @param $pUID
     *
     * @return int
     */
    public function getFirstDownloadDate($pPackageID, $pUID)
    {
        $crit = new CriteriaCompo(new Criteria('packageid', $pPackageID));
        $crit->add(new Criteria('uid', $pUID));
        $crit->setOrder('date');
        //
        $objs = $this->getObjects($crit);
        //
        if (count($objs) > 0) {
            $obj = reset($objs);
            $obj = $obj['date'];
        } else {
            $obj = time();
        }

        return $obj;
    }

    /////////////////////////////////////////////////////

    /**
     * @param int $count
     *
     * @return array
     */
    public function getTopDownloads($count = 10)
    {
        $hStats    = xoops_getModuleHandler('userPackageStats', 'xasset');
        $hPackage  = xoops_getModuleHandler('package', 'xasset');
        $hPacGroup = xoops_getModuleHandler('packageGroup', 'xasset');
        $hAppProd  = xoops_getModuleHandler('applicationProduct', 'xasset');
        $hApp      = xoops_getModuleHandler('application', 'xasset');
        $hCommon   = xoops_getModuleHandler('common', 'xasset');
        //
        $statsTable     = $this->_db->prefix($hStats->_dbtable);
        $packageTable   = $this->_db->prefix($hPackage->_dbtable);
        $packGroupTable = $this->_db->prefix($hPacGroup->_dbtable);
        $appProdTable   = $this->_db->prefix($hAppProd->_dbtable);
        //
        $crit = new Criteria('1', 1);
        $crit->setLimit($count);

        $sql = "select p.filename, ap.application_id, count(p.id) downloads
            from $statsTable ups inner join $packageTable p on
              ups.packageid = p.id inner join $packGroupTable pg on
              p.packagegroupid = pg.id inner join $appProdTable ap on
              pg.id = ap.package_group_id
            group by p.filename, ap.application_id
            order by downloads";
        //
        $ary = [];
        //
        $i = 0;
        if ($res = $this->_db->query($sql)) {
            while ($row = $this->_db->fetchArray($res)) {
                $ary[$i]           = $row;
                $ary[$i]['appKey'] = $hCommon->cryptValue($row['application_id'], $hApp->_weight);
                ++$i;
            }
        } else {
            echo $sql;
        }

        //
        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $db
     *
     * @return xassetUserPackageStatsHandler
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
            $sql = sprintf('INSERT INTO %s (id, packageid, uid, ip, DATE, dns) VALUES (%u, %u, %u, %s, %u, %s)', $this->_db->prefix($this->_dbtable), $id, $packageid, $uid, $this->_db->quoteString($ip), $date, $this->_db->quoteString($dns));
        } else {
            $sql = sprintf('UPDATE %s SET packageid = %u, uid = %u, ip = %s, DATE = %u, dns = %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $packageidid, $uid, $this->_db->quoteString($ip), $date, $this->_db->quoteString($dns), $id);
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
