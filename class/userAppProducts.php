<?php

require_once __DIR__ . '/xassetBaseObject.php';

/**
 * Class xassetUserAppProducts
 */
class XassetUserAppProducts extends XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('application_product_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /////////////////////////////////////////
    public function increaseDownCount()
    {
        $this->setVar('down_count', $this->getVar('down_count') + 1);
    }
}

/**
 * Class xassetUserAppProductsHandler
 */
class XassetUserAppProductsHandler extends XassetBaseObjectHandler
{
    //vars
    public $_db;
    public $classname = 'xassetuserappproducts';
    public $_dbtable  = 'xasset_user_products';

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
     * @return xassetUserAppProductsHandler
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
     * @param $uid
     * @param $prodid
     *
     * @return bool
     */
    public function getUserProductMaxDowns($uid, $prodid)
    {
        $hAppProds = xoops_getModuleHandler('applicationProduct', 'xasset');
        //
        $thisTable = $this->_db->prefix($this->_dbtable);
        $prodTable = $this->_db->prefix($hAppProds->_dbtable);
        //
        $sql = "select sum(ap.max_access) sm from $prodTable ap inner join $thisTable ua on
                    ap.application_product_id = ua.id
                  where ua.application_product_id = $prodid and ua.uid = $uid";
        //
        if ($res = $this->_db->query($sql)) {
            if ($row = $this->_db->fetcharray($res)) {
                return $row['sm'];
            }
        }

        return false;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $uid
     * @param $appProdID
     *
     * @return bool
     */
    public function addUserProduct($uid, $appProdID)
    {
        $obj = $this->create();
        $obj->setVar('application_product_id', $appProdID);
        $obj->setVar('uid', $uid);

        //
        return $this->insert($obj);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $uid
     * @param $appProdID
     *
     * @return bool
     */
    public function userHasProduct($uid, $appProdID)
    {
        $crit = new CriteriaCompo(new Criteria('application_product_id', $appProdID));
        $crit->add(new Crtieria('uid', $uid));
        //
        $objs = $this->getObjects($crit);

        //
        return count($objs) > 0;
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|XoopsObject $obj
     * @param bool               $force
     * @return bool
     */
    public function insert(XoopsObject $obj, $force = false)
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
            $sql = sprintf('INSERT INTO %s (id, uid, application_product_id)
                                      VALUES (%u, %u, %u)', $this->_db->prefix($this->_dbtable), $id, $uid, $application_product_id);
        } else {
            $sql = sprintf('UPDATE %s SET uid = %u, application_poduct_id = %u WHERE id = %u', $this->_db->prefix($this->_dbtable), $uid, $application_poduct_id, $id);
        }
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
