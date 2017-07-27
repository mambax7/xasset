<?php

require_once __DIR__ . '/xassetBaseObject.php';

/**
 * Class xassetOrderDetail
 */
class XassetOrderDetail extends XassetBaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('order_index_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('app_prod_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('qty', XOBJ_DTYPE_INT, time(), false);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    //////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getAppProdID()
    {
        return $this->getVar('app_prod_id');
    }

    //////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getOrderIndex()
    {
        $idx = xoops_getModuleHandler('order', 'xasset');

        return $idx->get($this->getVar('order_index_id'));
    }

    //////////////////////////////////////////////////

    /**
     * @return XoopsObject
     */
    public function &getAppProduct()
    {
        $hProd = xoops_getModuleHandler('applicationProduct', 'xasset');

        return $hProd->get($this->getVar('app_prod_id'));
    }

    /////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getOrderItemDescription()
    {
        $oAppProd =& $this->getAppProduct();

        return $oAppProd->itemDescription();
    }
}

/**
 * Class xassetOrderDetailHandler
 */
class XassetOrderDetailHandler extends XassetBaseObjectHandler
{
    //vars
    public $_db;
    public $classname = 'xassetorderdetail';
    public $_dbtable  = 'xasset_order_detail';

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
     * @param $indexID
     *
     * @return array
     */
    public function &getOrderDetailsObjectsByIndex($indexID)
    {
        $crit = new CriteriaCompo(new Criteria('order_index_id', $indexID));

        return $this->getObjects($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $indexID
     *
     * @return array
     */
    public function getOrderDetailsByIndex($indexID)
    {
        $crit = new CriteriaCompo(new Criteria('order_index_id', $indexID));

        return $this->getOrderDetailArray($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $criteria
     *
     * @return array
     */
    public function getOrderDetailArray($criteria)
    {
        global $imagearray;
        //
        $hAppProd = xoops_getModuleHandler('applicationProduct', 'xasset');
        $hApp     = xoops_getModuleHandler('application', 'xasset');
        $hCurr    = xoops_getModuleHandler('currency', 'xasset');
        //tables
        $thisTable = $this->_db->prefix($this->_dbtable);
        $apTable   = $this->_db->prefix($hAppProd->_dbtable);
        $aTable    = $this->_db->prefix($hApp->_dbtable);
        $curTable  = $this->_db->prefix($hCurr->_dbtable);
        //
        $sql = "select od.id, od.qty, ap.id appProdID, (ap.unit_price/c.value) unit_price,
                          (od.qty * (ap.unit_price/c.value)) totalPrice,
                          ap.item_code, ap.item_description, a.id appID, a.name, a.description, a.version
                   from   $thisTable od inner join $apTable ap on
                     od.app_prod_id = ap.id inner join $aTable a on
                     ap.application_id = a.id inner join $curTable c on
                     ap.base_currency_id = c.id";
        //
        $this->postProcessSQL($sql, $criteria);
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            while ($row = $this->_db->fetchArray($res)) {
                $actions = '<a href="order.php?op=removeOrderItem&id=' . $row['id'] . '">' . $imagearray['deleteimg'] . '</a>';
                //
                $ary[] = [
                    'id'              => $row['id'],
                    'appProdID'       => $row['appProdID'],
                    'appID'           => $row['appID'],
                    'qty'             => $row['qty'],
                    'unit_price'      => $row['unit_price'],
                    'totalPrice'      => $row['totalPrice'],
                    'item_code'       => $row['item_code'],
                    'name'            => $row['name'],
                    'description'     => $row['description'],
                    'prodDescription' => $row['item_description'],
                    'version'         => $row['version'],
                    'actions'         => $actions
                ];
            }
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $orderID
     *
     * @return array
     */
    public function &getOrderApplicationProducts($orderID)
    {
        $hAppProd  = xoops_getModuleHandler('applicationProduct', 'xasset');
        $hCurrency = xoops_getModuleHandler('currency', 'xasset');
        //
        $thisTable    = $this->_db->prefix($this->_dbtable);
        $appProdTable = $this->_db->prefix($hAppProd->_dbtable);
        $currTable    = $this->_db->prefix($hCurrency->_dbtable);
        //
        $sql = "select ap.*, od.qty, c.value base_exchange
            from $appProdTable ap inner join $thisTable od on
              od.app_prod_id = ap.id inner join $currTable c on
              ap.base_currency_id = c.id
              where od.order_index_id = $orderID
            order by ap.tax_class_id";
        //
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            while ($row = $this->_db->fetchArray($res)) {
                $ary[] = [
                    'id'               => $row['id'],
                    'tax_class_id'     => $row['tax_class_id'],
                    'base_currency_id' => $row['base_currency_id'],
                    'unit_price'       => $row['unit_price'] / $row['base_exchange'],
                    //'base_exchange'    => $row['base_exchange'],
                    'qty'              => $row['qty']
                ];
            }
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $id
     * @param $qty
     *
     * @return bool
     */
    public function updateOrderQty($id, $qty)
    {
        $item =& $this->get($id);
        $item->setVar('qty', $qty);

        return $this->insert($item);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $db
     *
     * @return xassetOrderDetailHandler
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
     * @param $orderID
     */
    public function deleteByOrder($orderID)
    {
        $thisTable = $this->_db->prefix($this->_dbtable);
        $sql       = "delete from $thisTable where order_index_id = $orderID";
        //
        $this->_db->query($sql);
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
            $sql = sprintf('INSERT INTO %s (id, order_index_id, app_prod_id, qty)
                                      VALUES (%u, %u, %u, %u)', $this->_db->prefix($this->_dbtable), $id, $order_index_id, $app_prod_id, $qty);
        } else {
            $sql = sprintf('UPDATE %s SET order_index_id = %u, app_prod_id = %u, qty = %u WHERE id = %u', $this->_db->prefix($this->_dbtable), $order_index_id, $app_prod_id, $qty, $id);
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
