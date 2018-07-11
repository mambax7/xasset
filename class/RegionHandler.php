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
 * class RegionHandler
 */
class RegionHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Region::class;
    public $_dbtable  = 'xasset_region';

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
     * @return Xasset\RegionHandler
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
     * @param null|\CriteriaCompo $criteria
     *
     * @return array
     */
    public function getSelectArray(\CriteriaCompo $criteria = null)
    {
        if (null === $criteria) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('region');
        }
        //
        $objs = $this->getObjects($criteria);
        //
        $ar = [];
        //
        foreach ($objs as $obj) {
            $ar[$obj->getVar('id')] = sprintf('%s - %s', $obj->getVar('region'), $obj->getVar('description'));
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function getRegionArray($criteria = null)
    {
        global $imagearray;
        //
        if (null === $criteria) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('region');
        }
        //
        $objs = $this->getObjects($criteria);
        $ary  = [];
        //
        foreach ($objs as $obj) {
            $actions = '<a href="main.php?op=editRegion&id=' . $obj->getVar('id') . '">' . $imagearray['editimg'] . '</a>' . '<a href="main.php?op=deleteRegion&id=' . $obj->getVar('id') . '">' . $imagearray['deleteimg'] . '</a>';
            //
            $ary[] = [
                'id'          => $obj->getVar('id'),
                'region'      => $obj->getVar('region'),
                'description' => $obj->getVar('description'),
                'actions'     => $actions
            ];
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
            $sql = sprintf('INSERT INTO `%s` (id, region, description)
                                      VALUES (%u, %s, %s)', $this->_db->prefix($this->_dbtable), $id, $this->_db->quoteString($region), $this->_db->quoteString($description));
        } else {
            $sql = sprintf('UPDATE `%s` SET region = %s, description = %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $this->_db->quoteString($region), $this->_db->quoteString($description), $id);
        }
        //echo $sql;
        // Update DB
        if (false !== $force) {
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
