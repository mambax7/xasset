<?php

require_once __DIR__ . '/xassetBaseObject.php';

/**
 * Class xassetCurrency
 */
class XassetCurrency extends XassetBaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('code', XOBJ_DTYPE_TXTBOX, null, false, 3);
        $this->initVar('decimal_places', XOBJ_DTYPE_INT, 2, false);
        $this->initVar('symbol_left', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('symbol_right', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('decimal_point', XOBJ_DTYPE_TXTBOX, '.', false, 1);
        $this->initVar('thousands_point', XOBJ_DTYPE_TXTBOX, ',', false, 1);
        $this->initVar('value', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('enabled', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('updated', XOBJ_DTYPE_INT, null, false);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    ////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return string
     */
    public function lastUpdated($format = 'l')
    {
        if ($this->getVar('updated') > 0) {
            return formatTimestamp($this->getVar('updated'), $format);
        } else {
            return '';
        }
    }

    ////////////////////////////////////////

    /**
     * @param $value
     *
     * @return string
     */
    public function valueFormat($value)
    {
        $val = $this->getVar('symbol_left') . number_format($this->getVar('value') * $value, $this->getVar('decimal_places'), $this->getVar('decimal_point'), $this->getVar('thousands_point')) . $this->getVar('symbol_right');

        //
        return $val;
    }

    ////////////////////////////////////////

    /**
     * @param $value
     *
     * @return string
     */
    public function valueOnlyFormat($value)
    {
        $val = number_format($this->getVar('value') * $value, $this->getVar('decimal_places'), $this->getVar('decimal_point'), $this->getVar('thousands_point'));

        //
        return $val;
    }

    ////////////////////////////////////////

    /**
     * @param $value
     *
     * @return mixed
     */
    public function bConvert($value)
    {
        return $this->getVar('value') * $value * 100;
    }

    ////////////////////////////////////////

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->getVar('value');
    }
}

/**
 * Class xassetCurrencyHandler
 */
class XassetCurrencyHandler extends XassetBaseObjectHandler
{
    //vars
    public $_db;
    public $classname = 'xassetcurrency';
    public $_dbtable  = 'xasset_currency';

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
     * @param $db
     *
     * @return xassetCurrencyHandler
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
     * @param null $criteria
     *
     * @return array
     */
    public function getSelectArray($criteria = null)
    {
        if (!isset($criteria)) {
            $criteria = new CriteriaCompo();
            $criteria->setSort('name');
        }
        //
        $criteria->add(new Criteria('enabled', 1));
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
            $criteria = new CriteriaCompo();
            $criteria->setSort('name');
        }
        $criteria->add(new Criteria('enabled', 1));
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
        $crit = new Criteria('code', $code);
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
        $hRate = xoops_getModuleHandler('taxRate', 'xasset');
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
    public function insert(XoopsObject $obj, $force = false)
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
