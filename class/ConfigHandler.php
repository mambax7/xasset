<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class ConfigHandler
 */
class ConfigHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Config::class;
    public $_dbtable  = 'xasset_config';

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
     * @return Xasset\ConfigHandler
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
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function setValue($key, $value)
    {
        $objs = $this->getObjects(new \Criteria('dkey', $key));
        if (count($objs) > 0) {
            $obj = $this->get($objs[0]->getVar('id'));
            $obj->setVar('dvalue', $value);
        } else {
            $obj = $this->create();
            $obj->setVar('dkey', $key);
            $obj->setVar('dvalue', $value);
        }

        return $this->insert($obj);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $key
     *
     * @return array
     */
    public function getValueObj($key)
    {
        return $this->getObjects(new \Criteria('dkey', $key), true);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $key
     *
     * @return array
     */
    public function getValueValue($key)
    {
        $objs = $this->getObjects(new \Criteria('dkey', $key), true);
        if (1 == count($objs)) {
            foreach ($objs as $obj) {
                return $obj->getVar('dvalue');
                //        exit;
            }
        } else {
            return $this->getValueArray($key);
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $key
     *
     * @return array
     */
    public function getValueArray($key)
    {
        $objs = $this->getObjects(new \Criteria('dkey', $key));
        //
        $ary = [];
        foreach ($objs as $obj) {
            $ary[] = $obj->getVar('dvalue');
        }

        return $ary;
    }

    ////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getConfigArray()
    {
        $ary['group_id']       = $this->getGroup();
        $ary['email_group_id'] = $this->getEmailGroup();
        $ary['currency_id']    = $this->getBaseCurrency();

        //
        return $ary;
    }

    ////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    /**
     * @return array
     */
    public function getGroup()
    {
        return $this->getValueValue('group_id');
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function setGroup($value)
    {
        return $this->setValue('group_id', $value);
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function getEmailGroup()
    {
        return $this->getValueValue('email_group_id');
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function setEmailGroup($value)
    {
        return $this->setValue('email_group_id', $value);
    }

    ///////////////////////////////////////////////////

    /**
     * @return array|bool
     */
    public function getBaseCurrency()
    {
        $id = $this->getValueValue('currency_id');
        if ($id > 0) {
            return $id;
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $value
     *
     * @return bool
     */
    public function setBaseCurrency($value)
    {
        return $this->setValue('currency_id', $value);
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|\XoopsObject $obj
     * @param bool               $force
     * @return bool
     */
    public function insert(\XoopsObject $obj, $force = false)
    {
        parent::insert($obj, $force);
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        // Create query for DB update
        if ($obj->isNew()) {
            // Determine next auto-gen ID for table
            $id  = $this->_db->genId($this->_db->prefix($this->_dbtable) . '_uid_seq');
            $sql = sprintf('INSERT INTO `%s` (id, dkey, dvalue) VALUES (%u, %s, %s)', $this->_db->prefix($this->_dbtable), $id, $this->_db->quoteString($dkey), $this->_db->quoteString($dvalue));
        } else {
            $sql = sprintf('UPDATE `%s` SET dkey = %s, dvalue = %s  WHERE id = %u', $this->_db->prefix($this->_dbtable), $this->_db->quoteString($dkey), $this->_db->quoteString($dvalue), $id);
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
