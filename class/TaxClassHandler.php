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
 * class TaxClassHandler
 */
class TaxClassHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = TaxClass::class;
    public $_dbtable  = 'xasset_tax_class';

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
     * @return Xasset\TaxClassHandler
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
     * @param null $criteria
     *
     * @return array
     */
    public function getSelectArray($criteria = null)
    {
        if (null === $criteria) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('description');
        }
        //
        $objs = $this->getObjects($criteria);
        //
        $ar = [];
        //
        foreach ($objs as $obj) {
            $ar[$obj->getVar('id')] = sprintf('%s - %s', $obj->getVar('code'), $obj->getVar('description'));
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function getClassArray($criteria = null)
    {
        global $imagearray;
        //
        if (null === $criteria) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('description');
        }
        //
        $objs = $this->getObjects($criteria);
        $ary  = [];
        //
        foreach ($objs as $obj) {
            $actions = '<a href="main.php?op=editTaxClass&id=' . $obj->getVar('id') . '">' . $imagearray['editimg'] . '</a>' . '<a href="main.php?op=deleteTaxClass&id=' . $obj->getVar('id') . '">' . $imagearray['deleteimg'] . '</a>';
            //
            $ary[] = [
                'id'          => $obj->getVar('id'),
                'code'        => $obj->getVar('code'),
                'description' => $obj->getVar('description'),
                'actions'     => $actions
            ];
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $id
     *
     * @return bool
     */
    public function deleteClass($id)
    {
        //first delete all rates with this class
        $hRate = new Xasset\TaxRateHandler($GLOBALS['xoopsDB']);
        if ($hRate->deleteByClass($id, true)) {
            //delete class itself
            return $this->deleteByID($id, true);
        }

        return false;
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
            $sql = sprintf('INSERT INTO `%s` (id, CODE, description)
                                      VALUES (%u, %s, %s)', $this->_db->prefix($this->_dbtable), $id, $this->_db->quoteString($code), $this->_db->quoteString($description));
        } else {
            $sql = sprintf('UPDATE `%s` SET CODE = %s, description = %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $this->_db->quoteString($code), $this->_db->quoteString($description), $id);
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
