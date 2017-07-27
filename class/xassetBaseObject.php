<?php

/**
 * Class XassetBaseObject
 */
class XassetBaseObject extends XoopsObject
{
    //cons
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    //////////////////////////////////////

    /**
     * @return mixed
     */
    public function ID()
    {
        return $this->getVar('id');
    }

    ///////////////////////////////////////////////////////

    /**
     * initialize variables for the object
     *
     * YOU SHOULD NOT USE THE $enumeration PARAMETER
     *
     * @access   public
     *
     * @param string $key
     * @param int    $data_type set to one of XOBJ_DTYPE_XXX constants (set to XOBJ_DTYPE_OTHER if no data type ckecking nor text sanitizing is required)
     * @param null   $value
     * @param bool   $required  require html form input?
     * @param int    $maxlength for XOBJ_DTYPE_TXTBOX type only
     * @param string $options
     * @param string $pretty
     *
     * @internal param $mixed $
     * @internal param string $option does this data have any select options?
     * @internal param string $enumeration array for XOBJ_DTYPE_ENUM type only
     */
    public function initVar(
        $key,
        $data_type,
        $value = null,
        $required = false,
        $maxlength = null,
        $options = '',
        $pretty = ''
    ) {
        parent::initVar($key, $data_type, $value, $required, $maxlength, $options);
        $this->vars[$key]['pretty'] = $pretty;
    }

    ///////////////////////////////////////////////////////

    /**
     * @return array
     */
    public function &getArray()
    {
        $ary  = [];
        $vars =& $this->getVars();
        foreach ($vars as $key => $value) {
            $ary[$key] = $value['value'];
        }

        return $ary;
    }

    ///////////////////////////////////////////////////////

    /**
     * @param $post
     */
    public function setVarsFromArray($post)
    {
        $vars =& $this->getVars();
        //
        foreach ($post as $key => $value) {
            if (isset($vars[$key])) {
                $this->setVar($key, $value);
            }
        }
    }

    ///////////////////////////////////////////////////////
    /**
     * @param $key
     * @param $value
     */
    //    public function setErrors($key, $value)
    //    {
    //        $this->_errors[$key] = trim($value);
    //    }

    ///////////////////////////////////////////////////////
    /**
     * clean values of all variables of the object for storage.
     * also add slashes whereever needed
     *
     * YOU SHOULD NOT USE ANY OF THE UNICODE TYPES, THEY WILL BE REMOVED
     *
     * @return bool true if successful
     * @access public
     */
    public function cleanVars()
    {
        $ts = MyTextSanitizer::getInstance();
        foreach ($this->vars as $k => $v) {
            $cleanv = $v['value'];
            if (!$v['changed']) {
            } else {
                $cleanv = is_string($cleanv) ? trim($cleanv) : $cleanv;
                switch ($v['data_type']) {
                    case XOBJ_DTYPE_TXTBOX:
                        if ($v['required'] && $cleanv != '0' && $cleanv == '') {
                            //                            $this->setErrors($k, "$v[pretty] is required.");
                            $this->setErrors(sprintf("$v[pretty] is required.", $k));
                            continue 2;
                        }
                        if (isset($v['maxlength']) && strlen($cleanv) > (int)$v['maxlength']) {
                            //                            $this->setErrors($k, "$v[pretty] must be shorter than " . (int)$v['maxlength'] . ' characters.');
                            $this->setErrors(sprintf("$v[pretty] must be shorter than " . (int)$v['maxlength'] . ' characters.', $k));
                            continue 2;
                        }
                        if (!$v['not_gpc']) {
                            $cleanv = $ts->stripSlashesGPC($ts->censorString($cleanv));
                        } else {
                            $cleanv = $ts->censorString($cleanv);
                        }
                        break;
                    case XOBJ_DTYPE_TXTAREA:
                        if ($v['required'] && $cleanv != '0' && $cleanv == '') {
                            //                            $this->setErrors($k, "$v[pretty] is required.");
                            $this->setErrors(sprintf("$v[pretty] is required.", $k));
                            continue 2;
                        }
                        if (!$v['not_gpc']) {
                            $cleanv = $ts->stripSlashesGPC($ts->censorString($cleanv));
                        } else {
                            $cleanv = $ts->censorString($cleanv);
                        }
                        break;
                    case XOBJ_DTYPE_SOURCE:
                        if (!$v['not_gpc']) {
                            $cleanv = $ts->stripSlashesGPC($cleanv);
                        } else {
                            $cleanv = $cleanv;
                        }
                        break;
                    case XOBJ_DTYPE_INT:
                        $cleanv = (int)$cleanv;
                        break;
                    case XOBJ_DTYPE_EMAIL:
                        if ($v['required'] && $cleanv == '') {
                            // $this->setErrors($k, "$v[pretty] is required.");
                            $this->setErrors(sprintf("$v[pretty] is required.", $k));
                            continue 2;
                        }
                        if ($cleanv != ''
                            && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i", $cleanv)) {
                            //                            $this->setErrors($k, 'Invalid Email');
                            $this->setErrors(sprintf('Invalid Email', $k));
                            continue;
                        }
                        if (!$v['not_gpc']) {
                            $cleanv = $ts->stripSlashesGPC($cleanv);
                        }
                        break;
                    case XOBJ_DTYPE_URL:
                        if ($v['required'] && $cleanv == '') {
                            // $this->setErrors($k, "$v[pretty] is required.");
                            $this->setErrors(sprintf("$v[pretty] is required.", $k));
                            continue 2;
                        }
                        if ($cleanv != '' && !preg_match("/^http[s]*:\/\//i", $cleanv)) {
                            $cleanv = 'http://' . $cleanv;
                        }
                        if (!$v['not_gpc']) {
                            $cleanv =& $ts->stripSlashesGPC($cleanv);
                        }
                        break;
                    case XOBJ_DTYPE_ARRAY:
                        $cleanv = serialize($cleanv);
                        break;
                    case XOBJ_DTYPE_STIME:
                    case XOBJ_DTYPE_MTIME:
                    case XOBJ_DTYPE_LTIME:
                        $cleanv = !is_string($cleanv) ? (int)$cleanv : strtotime($cleanv);
                        break;
                    default:
                        break;
                }
            }
            $this->cleanVars[$k] =& $cleanv;
            unset($cleanv);
        }
        if (count($this->_errors) > 0) {
            return false;
        }
        $this->unsetDirty();

        return true;
    }
}

/**
 * Class xassetBaseObjectHandler
 */
class XassetBaseObjectHandler extends XoopsObjectHandler
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
            $sql = $this->_selectQuery(new Criteria('id', $id));
            if (!$result = $this->_db->query($sql)) {
                return false;
            }
            $numrows = $this->_db->getRowsNum($result);
            if ($numrows == 1) {
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
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            if ($criteria->renderWhere() != '') {
                $sql .= ' ' . $criteria->renderWhere();
            }
            if ($criteria->groupby != '') {
                $sql .= $criteria->getGroupby();
            }
            if ($criteria->getSort() != '') {
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
        while ($myrow = $this->_db->fetchArray($result)) {
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
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ($criteria->getSort() != '') {
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
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
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
    public function delete(XoopsObject $obj, $force = false)
    {
        if (strcasecmp($this->classname, get_class($obj)) != 0) {
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
            while ($row = $this->_db->fetchArray($res)) {
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
    public function insert(XoopsObject $obj, $force = false)
    {
        // Make sure object is of correct type
        //    if (get_class($obj) != $this->classname) {
        //      return false;
        //    }
        $result = true;
        //
        if (strcasecmp($this->classname, get_class($obj)) != 0) {
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
function &xoopGetModuleHandler($class)
{
    return xoops_getModuleHandler($class, 'xasset');
}
