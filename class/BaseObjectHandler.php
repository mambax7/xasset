<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

//use XoopsModules\Xasset\xajax;

/**
 * Class BaseObjectHandler
 */
class BaseObjectHandler extends \XoopsObjectHandler
{
    /**
     * @return mixed
     */
    public function create()
    {
        $obj = new $this->classname();

        return $obj;
    }

    /**
     * gets a value object
     *
     * @param int $id
     * @internal param int $int_id
     *
     * @return bool|void
     * @abstract
     */
    public function get($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $sql = $this->_selectQuery(new \Criteria('id', $id));
            if (!$result = $this->_db->query($sql)) {
                return false;
            }
            $numrows = $this->_db->getRowsNum($result);
            if (1 == $numrows) {
                $obj = new $this->classname($this->_db->fetchArray($result));

                return $obj;
            }
        }

        return false;
    }

    ///////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    /**
     * @param $sql
     * @param $criteria
     */
    public function postProcessSQL(&$sql, $criteria)
    {
        if (isset($criteria) && is_subclass_of($criteria, 'CriteriaElement')) {
            if ('' != $criteria->renderWhere()) {
                $sql .= ' ' . $criteria->renderWhere();
            }
            if ('' != $criteria->groupby) {
                $sql .= $criteria->getGroupby();
            }
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . '
                  ' . $criteria->getOrder();
            }
        }
    }

    /**
     * @param null $criteria
     * @param bool $id_as_key
     *
     * @return array
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = $this->_selectQuery($criteria);
        if (isset($criteria)) {
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }

        $result = $this->_db->query($sql, $limit, $start);
        // If no records from db, return empty array
        if (!$result) {
            return $ret;
        }

        // Add each returned record to the result array
        while (false !== ($myrow = $this->_db->fetchArray($result))) {
            $obj = new $this->classname($myrow);
            if (!$id_as_key) {
                $ret[] =& $obj;
            } else {
                $ret[$obj->getVar('id')] =& $obj;
            }
            unset($obj);
        }

        return $ret;
    }

    /**
     * @param null $criteria
     *
     * @return string
     */
    public function _selectQuery($criteria = null)
    {
        $sql = sprintf('SELECT * FROM %s', $this->_db->prefix($this->_dbtable));
        if (isset($criteria) && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . '
                 ' . $criteria->getOrder();
            }
        }

        return $sql;
    }

    /**
     * @param null $criteria
     *
     * @return int
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->_db->prefix($this->_dbtable);
        if (isset($criteria) && is_subclass_of($criteria, 'CriteriaElement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->_db->query($sql)) {
            return 0;
        }
        list($count) = $this->_db->fetchRow($result);

        return $count;
    }

    /**
     * @param XoopsObject $obj
     * @param bool        $force
     *
     * @return bool
     */
    public function delete(\XoopsObject $obj, $force = false)
    {
        if (0 != strcasecmp($this->classname, get_class($obj))) {
            return false;
        }

        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $obj->getVar('id'));
        //echo $sql;
        if ($force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }
        if (!$result) {
            return false;
        }

        return true;
    }

    //

    /**
     * @param      $pid
     * @param bool $force
     *
     * @return bool
     */
    public function deleteByID($pid, $force = false)
    {
        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $pid);
        if ($force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }
        if (!$result) {
            return false;
        }

        return true;
    }

    ///////////////////////////////////////////

    /**
     * @param      $sql
     * @param bool $object
     * @param int  $limit
     * @param int  $offset
     *
     * @return array
     */
    public function &sqlToArray($sql, $object = false, $limit = 0, $offset = 0)
    {
        $ary = [];
        if ($res = $this->_db->query($sql, $limit, $offset)) {
            while (false !== ($row = $this->_db->fetchArray($res))) {
                if ($object) {
                    $ary[] = new $this->classname($row);
                } else {
                    $ary[] = $row;
                }
            }
        } else {
            echo $sql;
        }

        return $ary;
    }

    //////////////////////////////////////////

    /**
     * @return mixed
     */
    public function tableName()
    {
        return $this->_db->prefix($this->_dbtable);
    }

    //

    /**
     * @param XoopsObject $obj
     * @param bool        $force
     *
     * @return bool
     */
    public function insert(\XoopsObject $obj, $force = false)
    {
        // Make sure object is of correct type
        //    if (get_class($obj) != $this->classname) {
        //      return false;
        //    }
        $result = true;
        //
        if (0 != strcasecmp($this->classname, get_class($obj))) {
            return false;
        }

        // Make sure object needs to be stored in DB
        if (!$obj->isDirty()) {
            $result = true;
        }

        // Make sure object fields are filled with valid values
        if (!$obj->cleanVars()) {
            return false;
        }

        //
        return $result;
    }
}

/////////////////// global functions /////////////////////////

/**
 * @param $class
 *
 * @return bool
 */
//function &xoopGetModuleHandler($class)
//{
//    return xoops_getModuleHandler($class, 'xasset');
//}
