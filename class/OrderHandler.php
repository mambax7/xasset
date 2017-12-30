<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;


/**
 * class OrderHandler
 */
class OrderHandler extends xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Order::class;
    public $_dbtable  = 'xasset_order_index';
    public $_weight   = 332;

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
     * @return xasset\OrderHandler
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
     * @param $status
     *
     * @return string
     */
    public function getStatuByCode($status)
    {
        switch ($status) {
            case 1:
                return 'In Cart';
            case 2:
                return 'Checked Out';
            case 3:
                return 'Gone to Gateway';
            case 4:
                return 'Validated';
            case 5:
                return 'Payment Complete';
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $transID
     *
     * @return bool
     */
    public function transactionExists($transID)
    {
        $crit = new \Criteria('trans_id', $transID);

        return $this->getCount($crit) > 0;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $userID
     *
     * @return array
     */
    public function &getUserDownloads($userID)
    {
        global $imagearray;
        //
        $hOrderDetail = new xasset\OrderDetailHandler($GLOBALS['xoopsDB']);
        $hAppProduct  = new xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);
        $hPackGroup   = new xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
        $hPackage     = new xasset\PackageHandler($GLOBALS['xoopsDB']);
        $hUserStats   = new xasset\UserPackageStatsHandler($GLOBALS['xoopsDB']);
        $hOrder       = $this;
        //
        $crypt = new xasset\Crypt();
        //
        $tableOrderDetail = $this->_db->prefix($hOrderDetail->_dbtable);
        $tableAppProduct  = $this->_db->prefix($hAppProduct->_dbtable);
        $tablePackGroup   = $this->_db->prefix($hPackGroup->_dbtable);
        $tablePackage     = $this->_db->prefix($hPackage->_dbtable);
        $tableStats       = $this->_db->prefix($hUserStats->_dbtable);
        $tableOrder       = $this->_db->prefix($hOrder->_dbtable);
        //
        $sql = "select od.qty, oi.status, oi.number, oi.trans_id, oi.date,
                   ap.item_description, ap.max_access, ap.max_days, ap.expires, p.filename,
                   p.serverFilePath, p.filetype, p.id packageID, p.isVideo, count(us.id) downloaded
            from $tableOrderDetail od inner join $tableOrder oi on
              od.order_index_id    = oi.id inner join $tableAppProduct ap on
              od.app_prod_id       = ap.id inner join $tablePackGroup pg ON
              ap.package_group_id  = pg.id inner join $tablePackage p on
              ap.package_group_id  = p.packagegroupid left join $tableStats us on
              us.uid               = oi.uid and us.packageid = p.id
            where oi.user_detail_id = $userID
            group by od.qty, oi.status, oi.number, oi.trans_id, oi.date,
                     ap.item_description, ap.max_access, ap.max_days, ap.expires, p.filename,
                     p.serverFilePath, p.filetype, p.id
            order by p.filename";
        //
        $i   = 0;
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            while ($row = $this->_db->fetchArray($res)) {
                $ary[$i]                 = $row;
                $ary[$i]['statusFmt']    = $this->getStatuByCode($row['status']);
                $ary[$i]['packageKey']   = $crypt->cryptValue($row['packageID'], $hPackage->_weight);
                $ary[$i]['datePurchase'] = formatTimestamp($row['date'], 's');
                $ary[$i]['downloadIcon'] = $imagearray['download'];
                //
                if ($row['max_days'] > 0) {
                    $ary[$i]['expiresFmt'] = $row['max_days'] . ' Days from download.';
                } else {
                    $ary[$i]['expiresFmt'] = 'Never';
                }
                //
                ++$i;
            }
        } else {
            echo $sql;
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function &getOrders()
    {
        return $this->getOrderArray();
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $crit
     *
     * @return array
     */
    public function &getOrderArray($crit = null)
    {
        if (!isset($crit)) {
            $crit = new \Criteria('1', 1);
            $crit->setSort('id');
        }
        //
        $hClient   = new xasset\UserDetailsHandler($GLOBALS['xoopsDB']);
        $hCurrency = new xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //
        $thisTable   = $this->_db->prefix($this->_dbtable);
        $clientTable = $this->_db->prefix($hClient->_dbtable);
        $curTable    = $this->_db->prefix($hCurrency->_dbtable);
        $userTable   = $this->_db->prefix('users');
        //
        $sql = "select o.*, u.uname, c.first_name, c.last_name, cu.code currency from $thisTable o inner join $clientTable c on
              o.user_detail_id = c.id inner join $userTable u on
              c.uid = u.uid inner join $curTable cu on
              o.currency_id = cu.id";
        //
        $this->postProcessSQL($sql, $crit);
        //
        $ar = [];
        $i  = 0;
        //
        if ($res = $this->_db->query($sql)) {
            while ($row = $this->_db->fetchArray($res)) {
                $ar[$i]              = $row;
                $ar[$i]['dateFmt']   = formatTimestamp($row['date'], 's');
                $ar[$i]['statusFmt'] = $this->getStatuByCode($row['status']);
                $ar[$i]['fullName']  = $row['first_name'] . ' ' . $row['last_name'];
                //
                ++$i;
            }
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $uid
     *
     * @return bool
     */
    public function userInCartOrders($uid)
    {
        $crit = new \CriteriaCompo(new \Criteria('uid', $uid));
        $crit->add(new \Criteria('status', 3, '<'));
        //
        $objs = $this->getObjects($crit);
        //
        if (count($objs) > 0) {
            $obj = reset($objs);

            return $obj->getVar('id');
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|XoopsObject $orderID
     *
     * @param bool               $force
     * @return bool|void
     */
    public function delete(\XoopsObject $orderID, $force = false)
    {
        //delete items first
        $hOrderDetail = new xasset\OrderDetailHandler($GLOBALS['xoopsDB']);
        $hOrderDetail->deleteByOrder($orderID);
        //
        parent::deleteByID($orderID);
    }

    ///////////////////////////////////////////////////

    /**
     * @param XoopsObject $obj
     * @param bool        $force
     *
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
            $sql = sprintf('INSERT INTO %s (id, user_detail_id, currency_id, uid, NUMBER, DATE, STATUS, gateway, trans_id, VALUE, fee)
                                      VALUES (%u, %u, %u, %u, %u, %u, %u, %u, %s, %f, %f)', $this->_db->prefix($this->_dbtable), $id, $user_detail_id, $currency_id, $uid, $number, $date, $status, $gateway, $this->_db->quoteString($trans_id), $value, $fee);
        } else {
            $sql = sprintf('UPDATE %s SET user_detail_id = %u, currency_id = %u, uid = %u, NUMBER = %u, DATE = %u,
                                        STATUS = %u, gateway = %u, trans_id = %s, VALUE = %f, fee = %f WHERE id = %u', $this->_db->prefix($this->_dbtable), $user_detail_id, $currency_id, $uid, $number, $date, $status, $gateway, $this->_db->quoteString($trans_id), $value, $fee, $id);
        }
        //echo $sql;
        // Update DB
        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            print_r($this);

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
