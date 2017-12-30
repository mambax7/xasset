<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;


/**
 * class TaxClassHandler
 */
class TaxClassHandler extends xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = TaxClass::class;
    public $_dbtable  = 'xasset_tax_class';

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
     * @return xasset\TaxClassHandler
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
        if (!isset($criteria)) {
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
        $hRate = new xasset\TaxRateHandler($GLOBALS['xoopsDB']);
        if ($hRate->deleteByClass($id, true)) {
            //delete class itself
            return $this->deleteByID($id, true);
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|XoopsObject $obj
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
            $sql = sprintf('INSERT INTO %s (id, CODE, description)
                                      VALUES (%u, %s, %s)', $this->_db->prefix($this->_dbtable), $id, $this->_db->quoteString($code), $this->_db->quoteString($description));
        } else {
            $sql = sprintf('UPDATE %s SET CODE = %s, description = %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $this->_db->quoteString($code), $this->_db->quoteString($description), $id);
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
