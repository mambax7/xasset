<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class TaxZoneHandler
 */
class TaxZoneHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = TaxZone::class;
    public $_dbtable  = 'xasset_tax_zone';

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
     * @return Xasset\TaxZoneHandler
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
     * @param null $criteria
     *
     * @return array
     */
    public function getSelectArray($criteria = null)
    {
        if (!isset($criteria)) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('name');
        }
        //
        $objs = $this->getObjects($criteria);
        //
        $ar = [];
        //
        foreach ($objs as $obj) {
            $ar[$obj->getVar('id')] = $obj->getVar('name');
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function getAllTaxZoneArray()
    {
        global $imagearray;
        //
        $criteria = new \CriteriaCompo();
        $criteria->setSort('region');

        //
        return $this->getArray($criteria);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $criteria
     *
     * @return array
     */
    public function getArray($criteria)
    {
        global $imagearray;
        //
        $hRegion  = new Xasset\RegionHandler($GLOBALS['xoopsDB']);
        $hZone    = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
        $hCountry = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
        //
        $thisTable    = $this->_db->prefix($this->_dbtable);
        $regionTable  = $this->_db->prefix($hRegion->_dbtable);
        $zoneTable    = $this->_db->prefix($hZone->_dbtable);
        $countryTable = $this->_db->prefix($hCountry->_dbtable);
        //
        $sql = "select r.region, tz.id, tz.region_id, tz.country_id, tz.zone_id, c.name country, z.code zone
            from $thisTable tz inner join $regionTable r on
              tz.region_id = r.id inner join $countryTable c on
              tz.country_id = c.id left join $zoneTable z on
              tz.zone_id    = z.id";
        //
        $this->postProcessSQL($sql, $criteria);
        //
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            while (false !== ($row = $this->_db->fetchArray($res))) {
                $actions = '<a href="main.php?op=editTaxZone&id=' . $row['id'] . '">' . $imagearray['editimg'] . '</a>' . '<a href="main.php?op=deleteTaxZone&id=' . $row['id'] . '">' . $imagearray['deleteimg'] . '</a>';
                //
                '' == $row['zone'] ? $zone = 'All Zones' : $zone = $row['zone'];
                //
                $ary[] = [
                    'id'         => $row['id'],
                    'region'     => $row['region'],
                    'country'    => $row['country'],
                    'zone'       => $zone,
                    'region_id'  => $row['region_id'],
                    'country_id' => $row['country_id'],
                    'zone_id'    => $row['zone_id'],
                    'actions'    => $actions
                ];
            }
        }

        return $ary;
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
            $sql = sprintf('INSERT INTO %s (id, region_id, zone_id, country_id)
                                      VALUES (%u, %u, %u, %u)', $this->_db->prefix($this->_dbtable), $id, $region_id, $zone_id, $country_id);
        } else {
            $sql = sprintf('UPDATE %s SET region_id = %u, zone_id = %u, country_id = %u WHERE id = %u', $this->_db->prefix($this->_dbtable), $region_id, $zone_id, $country_id, $id);
        }
        //echo $sql;
        // Update DB
        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            echo $sql;

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
