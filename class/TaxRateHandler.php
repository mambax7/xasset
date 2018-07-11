<?php namespace XoopsModules\Xasset;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Nazar Aziz (www.panthersoftware.com)
 * @author       XOOPS Development Team
 * @package      xAsset
 */

use XoopsModules\Xasset;

/**
 * class TaxRateHandler
 */
class TaxRateHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = TaxRate::class;
    public $_dbtable  = 'xasset_tax_rates';

    //cons

    /**
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        $this->_db = $db;
    }

    ///////////////////////////////////////////////////

    /**
     * @param \XoopsDatabase $db
     *
     * @return Xasset\TaxRateHandler
     */
    public function getInstance(\XoopsDatabase $db = null)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($db);
        }

        return $instance;
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function getRegionOrderedRatesArray()
    {
        $crit = new \CriteriaCompo();
        $crit->setSort('region_id');

        //
        return $this->getRatesArray($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function getRatesArray($criteria = null)
    {
        global $imagearray;
        //
        //$hZone   = xoops_getModuleHandler('zone','xasset');
        $hRegion = new Xasset\RegionHandler($GLOBALS['xoopsDB']);
        $hClass  = new Xasset\TaxClassHandler($GLOBALS['xoopsDB']);
        //
        $thisTable  = $this->_db->prefix($this->_dbtable);
        $classTable = $this->_db->prefix($hClass->_dbtable);
        //$zoneTable  = $this->_db->prefix($hZone->_dbtable);
        $regionTable = $this->_db->prefix($hRegion->_dbtable);
        //
        $sql = "select r.*, c.code class_code, g.region
                  from $thisTable r inner join $classTable c on
                    r.tax_class_id = c.id inner join $regionTable g on
                    r.region_id = g.id";
        $this->postProcessSQL($sql, $criteria);
        //
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            while (false !== ($row = $this->_db->fetchArray($res))) {
                $actions = '<a href="main.php?op=editTaxRate&id=' . $row['id'] . '">' . $imagearray['editimg'] . '</a>' . '<a href="main.php?op=deleteTaxRate&id=' . $row['id'] . '">' . $imagearray['deleteimg'] . '</a>';
                //
                $ary[] = [
                    'id'           => $row['id'],
                    'tax_class_id' => $row['tax_class_id'],
                    'class_code'   => $row['class_code'],
                    'region'       => $row['region'],
                    'region_id'    => $row['region_id'],
                    'rate'         => $row['rate'],
                    'priority'     => $row['priority'],
                    'description'  => $row['description'],
                    'actions'      => $actions
                ];
            }
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param      $id
     * @param bool $force
     *
     * @return mixed
     */
    public function deleteByClass($id, $force = false)
    {
        $thisTable = $this->_db->prefix($this->_dbtable);
        $sql       = "delete from $thisTable where tax_class_id = $id";

        //
        return $this->_db->query($sql, $force);
    }

    ///////////////////////////////////////////////////

    /**
     * @param      $id
     * @param bool $force
     *
     * @return bool
     */
    public function deleteRate($id, $force = false)
    {
        return $this->deleteByID($id, $force);
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
            $sql = sprintf('INSERT INTO `%s` (id, region_id, tax_class_id, rate, priority, description)
                                      VALUES (%u, %u, %u, %f, %u, %s)', $this->_db->prefix($this->_dbtable), $id, $region_id, $tax_class_id, $rate, $priority, $this->_db->quoteString($description));
        } else {
            $sql = sprintf('UPDATE `%s` SET region_id = %u, tax_class_id = %u, rate = %f, priority = %u, description = %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $region_id, $tax_class_id, $rate, $priority, $this->_db->quoteString($description), $id);
        }
        //echo $sql;
        // Update DB
        if (false !== $force) {
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
