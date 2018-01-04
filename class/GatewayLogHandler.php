<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;


/**
 * class GatewayLogHandler
 */
class GatewayLogHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = GatewayLog::class;
    public $_dbtable  = 'xasset_gateway_log';

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
     * @return Xasset\GatewayLogHandler
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
     * @param      $orderID
     * @param      $gatewayID
     * @param      $orderStage
     * @param      $log
     * @param bool $force
     *
     * @return bool
     */
    public function addLog($orderID, $gatewayID, $orderStage, $log, $force = false)
    {
        if (is_array($log)) {
            $save = '';
            foreach ($log as $key => $value) {
                $save .= "$key : $value\n";
            }
        } else {
            $save = $log;
        }
        //
        $save = addslashes($save);
        //
        $obj = $this->create();
        $obj->setVar('order_id', $orderID);
        $obj->setVar('gateway_id', $gatewayID);
        $obj->setVar('date', time());
        $obj->setVar('order_stage', $orderStage);
        $obj->setVar('log_text', $save);

        //
        return $this->insert($obj, $force);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $orderID
     *
     * @return array
     */
    public function &getLogsByOrder($orderID)
    {
        $crit = new \Criteria('order_id', $orderID);

        return $this->getLogs($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function getLogs($criteria = null)
    {
        global $imagearray;
        //
        $hGateway = new Xasset\GatewayHandler($GLOBALS['xoopsDB']);
        $hOrder   = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
        //tables
        $thisTable = $this->_db->prefix($this->_dbtable);
        $gtTable   = $this->_db->prefix($hGateway->_dbtable);
        $oTable    = $this->_db->prefix($hOrder->_dbtable);
        //
        if (!isset($criteria)) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('date');
        }
        //
        $sql = "select l.id, l.date, l.order_stage, g.id gateway_id, g.code, o.id order_id, o.uid
                   from $thisTable l inner join $gtTable g on
                     l.gateway_id = g.id inner join $oTable o on
                     l.order_id   = o.id";
        //
        $this->postProcessSQL($sql, $criteria);
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            $i = 0;
            while ($row = $this->_db->fetchArray($res)) {
                $actions = '<a href="main.php?op=removeLogItem&id=' . $row['id'] . '">' . $imagearray['deleteimg'] . '</a>';
                //
                $ary[$i]               = $row;
                $ary[$i]['formatDate'] = formatTimestamp($row['date'], 'l');
                $ary[$i]['actions']    = $actions;
                //
                ++$i;
            }
        }

        return $ary;
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
            $sql = sprintf('INSERT INTO %s (id, order_id, gateway_id, DATE, order_stage, log_text)
                                                            VALUES (%u, %u, %u, %u, %u, %s)', $this->_db->prefix($this->_dbtable), $id, $order_id, $gateway_id, $date, $order_stage, $this->_db->quoteString($log_text));
        } else {
            $sql = sprintf('UPDATE %s SET order_id = %u, gateway_id = %u, DATE = %u, ordre_stage = %u, log_text = %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $order_id, $gateway_id, $date, $order_stage, $this->_db->quoteString($log_text), $id);
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
