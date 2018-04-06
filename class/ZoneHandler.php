<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * Class ZoneHandler
 */
class ZoneHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Zone::class;
    public $_dbtable  = 'xasset_zone';

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
     * @param $db
     *
     * @return Xasset\ZoneHandler
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
     * @return array|bool
     */
    public function &getCountryZones()
    {
        $hCountry = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
        //
        $thisTable    = $this->_db->prefix($this->_dbtable);
        $countryTable = $this->_db->prefix($hCountry->_dbtable);
        //
        $sql = "select c.id, c.name, c.iso2, c.iso3, z.id zone_id, z.code zone_code, z.name zone_name
            from $countryTable c left join $thisTable z on
              c.id = z.country_id
            order by c.name";
        //
        if ($res = $this->_db->query($sql)) {
            $cntAry      = [];
            $zoneAry     = [];
            $lastCountry = '';
            //
            while (false !== ($row = $this->_db->fetchArray($res))) {
                if ($lastCountry != $row['name']) {
                    //add zones array
                    if ((count($zoneAry) > 0) && (count($cntAry) > 0)) {
                        $cntAry[count($cntAry) - 1]['zones'] = $zoneAry;
                    }

                    $cntAry[] = [
                        'id'   => $row['id'],
                        'name' => $row['name'],
                        'iso2' => $row['iso2'],
                        'iso3' => $row['iso3']
                    ];
                    //
                    unset($zoneAry);
                    $zoneAry = [];
                    //
                    if ($row['zone_id'] > 0) {
                        $zoneAry[] = [
                            'id'   => $row['zone_id'],
                            'code' => $row['zone_code'],
                            'name' => $row['zone_name']
                        ];
                    }
                    //
                    $lastCountry = $row['name'];
                } else {
                    $zoneAry[] = [
                        'id'   => $row['zone_id'],
                        'code' => $row['zone_code'],
                        'name' => $row['zone_name']
                    ];
                }
            }
            //add the last zone array to the country
            if ((count($zoneAry) > 0) && (count($cntAry) > 0)) {
                $cntAry[count($cntAry) - 1]['zones'] = $zoneAry;
            }

            return $cntAry;
        } else {
            $res = false;

            return $res;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     * @param bool $allZones
     *
     * @return array
     */
    public function getSelectArray($criteria = null, $allZones = true)
    {
        if (!isset($criteria)) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('code');
        }
        //
        $objs = $this->getObjects($criteria);
        //
        $ar = [];
        if ($allZones) {
            $ar[0] = 'All Zones';
        }
        //
        foreach ($objs as $obj) {
            //$ar[$obj->getVar('id')] = sprintf('%s - %s',$obj->getVar('code'),$obj->getVar('name'));
            $ar[$obj->getVar('id')] = $obj->getVar('name');
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param      $countryID
     * @param bool $allZones
     *
     * @return array
     */
    public function &getZonesByCountry($countryID, $allZones = true)
    {
        $crit = new \Criteria('country_id', $countryID);
        $crit->setSort('name');
        //
        $ary = $this->getSelectArray($crit, $allZones);

        //
        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function &getZonesArray($criteria = null)
    {
        global $imagearray;
        //
        $objs = $this->getObjects($criteria);
        $ary  = [];
        //
        $hCnt = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
        //
        $thisTable = $this->_db->prefix($this->_dbtable);
        $cntTable  = $this->_db->prefix($hCnt->_dbtable);
        //
        $sql = "select z.*, c.name country_name from $thisTable z inner join $cntTable c on
                    z.country_id = c.id";
        $this->postProcessSQL($sql, $criteria);
        //
        if ($res = $this->_db->query($sql)) {
            while (false !== ($row = $this->_db->fetchArray($res))) {
                $actions = '<a href="main.php?op=editZone&id=' . $row['id'] . '">' . $imagearray['editimg'] . '</a>' . '<a href="main.php?op=deleteZone&id=' . $row['id'] . '">' . $imagearray['deleteimg'] . '</a>';
                //
                $ary[] = [
                    'id'          => $row['id'],
                    'countryid'   => $row['country_id'],
                    'code'        => $row['code'],
                    'name'        => $row['name'],
                    'countryname' => $row['country_name'],
                    'actions'     => $actions
                ];
            }
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $zoneID
     *
     * @return bool
     */
    public function getZoneNameByID($zoneID)
    {
        $crit = new \Criteria('id', $zoneID);
        $objs = $this->getObjects($crit);
        if (count($objs) > 0) {
            $obj = reset($objs);

            return $obj->getVar('name');
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $countryID
     * @param $zoneID
     *
     * @return bool
     */
    public function zoneInCountry($countryID, $zoneID)
    {
        $crit = new \CriteriaCompo(new \Criteria('country_id', $countryID));
        $crit->add(new \Criteria('id', $zoneID));
        //
        $objs = $this->getObjects($crit);

        //
        return count($objs) > 0;
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|\XoopsObject $obj
     * @param bool               $force
     * @return bool
     */
    public function insert(\XoopsObject $obj, $force = false)
    {
        if (!parent::insert($obj, $force)) {
            return false;
        }
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        // Create query for DB update
        if ($obj->isNew()) {
            // Determine next auto-gen ID for table
            $id  = $this->_db->genId($this->_db->prefix($this->_dbtable) . '_uid_seq');
            $sql = sprintf('INSERT INTO %s (id, country_id, CODE, NAME)
                                      VALUES (%u, %u, %s, %s)', $this->_db->prefix($this->_dbtable), $id, $country_id, $this->_db->quoteString($code), $this->_db->quoteString($name));
        } else {
            $sql = sprintf('UPDATE %s SET country_id = %u, CODE = %s, NAME = %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $country_id, $this->_db->quoteString($code), $this->_db->quoteString($name), $id);
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
