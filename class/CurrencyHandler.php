<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;


/**
 * class CurrencyHandler
 */
class CurrencyHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Currency::class;
    public $_dbtable  = 'xasset_currency';

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
     * @return Xasset\CurrencyHandler
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
        $criteria->add(new \Criteria('enabled', 1));
        //
        $objs = $this->getObjects($criteria);
        //
        $ar = [];
        //
        foreach ($objs as $obj) {
            $ar[$obj->getVar('id')] = sprintf('%s - %s', $obj->getVar('code'), $obj->getVar('name'));
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function getCurrencyArray($criteria = null)
    {
        global $imagearray;
        //
        if (!isset($criteria)) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('name');
        }
        $criteria->add(new \Criteria('enabled', 1));
        //
        $objs = $this->getObjects($criteria);
        $ary  = [];
        $i    = 0;
        //
        foreach ($objs as $obj) {
            $actions = '<a href="main.php?op=editCurrency&id=' . $obj->getVar('id') . '">' . $imagearray['viewlic'] . '</a>' . '<a href="main.php?op=deleteCurrency&id=' . $obj->getVar('id') . '">' . $imagearray['deleteimg'] . '</a>';
            //
            $ary[$i]               = $obj->getArray();
            $ary[$i]['actions']    = $actions;
            $ary[$i]['updatedFmt'] = formatTimestamp($obj->getVar('updated'), 's');
            ++$i;
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $code
     *
     * @return bool|mixed
     */
    public function &getByCode($code)
    {
        $crit = new \Criteria('code', $code);
        $objs = $this->getObjects($crit);
        if (count($objs) > 0) {
            return current($objs);
        } else {
            $res = false;

            return $res;
        }
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
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $sLeft
     * @param $sRight
     * @param $point
     * @param $places
     * @param $thousand
     * @param $curValue
     * @param $value
     *
     * @return string
     */
    public function formatCurrency($sLeft, $sRight, $point, $places, $thousand, $curValue, $value)
    {
        $val = $sLeft . number_format($curValue * $value, $places, $point, $thousand) . $sRight;

        //
        return $val;
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
            $sql = sprintf(
                'INSERT INTO %s (id, NAME, CODE, decimal_places, symbol_left, symbol_right, decimal_point, thousands_point, VALUE, updated)
                                      VALUES (%u, %s, %s, %u, %s, %s, %s, %s, %f, %u)',
                $this->_db->prefix($this->_dbtable),
                $id,
                $this->_db->quoteString($name),
                $this->_db->quoteString($code),
                $decimal_places,
                $this->_db->quoteString($symbol_left),
                $this->_db->quoteString($symbol_right),
                           $this->_db->quoteString($decimal_point),
                $this->_db->quoteString($thousands_point),
                $value,
                $updated
            );
        } else {
            $sql = sprintf(
                'UPDATE %s SET NAME = %s, CODE = %s, decimal_places = %u, symbol_left = %s, symbol_right = %s, decimal_point = %s, thousands_point = %s, VALUE = %f, updated = %u  WHERE id = %u',
                $this->_db->prefix($this->_dbtable),
                $this->_db->quoteString($name),
                           $this->_db->quoteString($code),
                $decimal_places,
                $this->_db->quoteString($symbol_left),
                $this->_db->quoteString($symbol_right),
                $this->_db->quoteString($decimal_point),
                $this->_db->quoteString($thousands_point),
                $value,
                $updated,
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
