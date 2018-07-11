<?php namespace XoopsModules\Xasset;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Nazar Aziz (www.panthersoftware.com)
 * @author       XOOPS Development Team
 * @package      xAsset
 */

use XoopsModules\Xasset;

/**
 * Class ApplicationProductMembHandler
 */
class ApplicationProductMembHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = ApplicationProductMemb::class;
    public $_dbtable  = 'xasset_app_prod_memb';

    //cons

    /**
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        $this->_db = $db;
    }

    ///////////////////////////////////////////////////

    /**
     * @param \XoopsDatabase $db
     *
     * @return ApplicationProductMembHandler
     */
    public function getInstance(\XoopsDatabase $db = null)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($db);
        }

        return $instance;
    }

    ///////////////////////////////////////////////////

    /**
     * @param        $oOrdDetail
     * @param        $oAppProd
     * @param        $oUserDetails
     * @param string $group
     *
     * @return bool
     */
    public function AddGroupExpiry($oOrdDetail, $oAppProd, $oUserDetails, $group = '1')
    {
        $grpField = '1' == $group ? 'add_to_group' : 'add_to_group' . $group;
        $expField = '1' == $group ? 'group_expire_date' : 'group_expire_date' . $group;
        //
        $qty = $oOrdDetail->getVar('qty');
        //now determine if this is a new entry or an update.
        $crit = new \CriteriaCompo(new \Criteria('uid', $oUserDetails->uid()));
        $crit->add(new \Criteria('group_id', $oAppProd->getVar($grpField)));
        //
        $existing = $this->getObjects($crit);
        if (count($existing) > 0) {
            $oMember = reset($existing);
            //
            $oMember->setVar('order_detail_id', $oOrdDetail->ID());
            if ($oMember->getVar('expiry_date') < time()) { //membership expired
                $oMember->setVar('expiry_date', time() + $oAppProd->getVar($expField) * $oOrdDetail->getVar('qty') * 60 * 60 * 24);
            } else { //valid membership...extend
                $oMember->setVar('expiry_date', $oMember->getVar('expiry_date') + $oAppProd->getVar($expField) * $oOrdDetail->getVar('qty') * 60 * 60 * 24);
            }

            //insert
            return $this->insert($oMember);
        } else {
            $obj = $this->create();
            $obj->setVar('uid', $oUserDetails->uid());
            $obj->setVar('order_detail_id', $oOrdDetail->ID());
            $obj->setVar('group_id', $oAppProd->getVar($grpField));
            $obj->setVar('expiry_date', time() + $oAppProd->getVar($expField) * $oOrdDetail->getVar('qty') * 60 * 60 * 24);

            //
            return $this->insert($obj);
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function getMembers($criteria = null)
    {
        global $imagearray;
        //
        $hUserDetails = new Xasset\GatewayHandler($GLOBALS['xoopsDB']);
        $hMember      = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
        //tables
        $thisTable  = $this->_db->prefix($this->_dbtable);
        $userTable  = $this->_db->prefix('users');
        $groupTable = $this->_db->prefix('groups');
        $linkTable  = $this->_db->prefix('groups_users_link');
        //
        if (null === $criteria) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('expiry_date', 'asc');
        }
        //
        $sql = "select distinct am.*, u.uname, g.name
            from $thisTable am inner join $userTable u on
              am.uid = u.uid inner join $groupTable g ON
              am.group_id = g.groupid inner join $linkTable gl ON
              g.groupid = gl.groupid and gl.uid = u.uid";
        //
        $this->postProcessSQL($sql, $criteria);
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            $i = 0;
            while (false !== ($row = $this->_db->fetchArray($res))) {
                $actions = '<a href="main.php?op=removeFromGroup&id=' . $row['id'] . '">' . $imagearray['deleteimg'] . '</a>';
                //
                $ary[$i]                     = $row;
                $ary[$i]['expired']          = $row['expiry_date'] < time();
                $ary[$i]['formatExpiryDate'] = formatTimestamp($row['expiry_date'], 'l');
                $ary[$i]['actions']          = $actions;
                //
                ++$i;
            }
        }

        return $ary;
    }

    //////////////////////////////////////////////////

    /**
     * @param $crit
     *
     * @return array
     */
    public function getMembersForSubscription($crit)
    {
        $hAppProd = new Xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);
        //two step process: first get members then another query to get products and buy now buttons
        $aSubs =& $this->getMembers($crit);
        //
        $cOrder = new \CriteriaCompo();
        foreach ($aSubs as $key => $aSub) {
            $cOrder->add(new \Criteria('id', $aSub['order_detail_id']), 'or');
        }
        //now get list of appProds and add to return array
        $aAppProds = $hAppProd->getApplicationProductObjectsByOrderDetail($cOrder); //print_r($aAppProds);
        //iterate through aSubs again and build buy now buttons
        foreach ($aSubs as $key => $aSub) {
            echo $aSubs[$key]['order_detail_id'];
            $aSubs[$key]['product'] = $aAppProds[$aSubs[$key]['order_detail_id']]->itemDescription();
            $aSubs[$key]['period']  = $aAppProds[$aSubs[$key]['order_detail_id']]->groupExpireDate();
            $aSubs[$key]['buyNow']  = $aAppProds[$aSubs[$key]['order_detail_id']]->getBuyNowButton();
        }

        return $aSubs;
    }

    ///////////////////////////////////////////////////

    /**
     * @param      $id
     * @param bool $force
     *
     * @return bool
     */
    public function removeFromGroup($id, $force = false)
    {
        $hMember = xoops_getHandler('member');

        $oObj = $this->get($id);
        //first remove from xoops group
        if (!$force) {
            $hMember->removeUsersFromGroup($oObj->getVar('group_id'), [$oObj->getVar('uid')]);
        } else {
            $table   = $this->_db->prefix('groups_users_link');
            $groupid = $oObj->getVar('group_id');
            $uid     = $oObj->getVar('uid');
            //
            $sql = "delete from $table where groupid = $groupid and uid = $uid";

            return $this->_db->queryF($sql);
        }

        //last, delete from this table
        return $this->delete($oObj);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $xoopsUser
     *
     * @return bool|int
     */
    public function getSubscriberCountByUser($xoopsUser)
    {
        if ($xoopsUser) {
            $crit = new \Criteria('uid', $xoopsUser->uid());

            return $this->getCount($crit);
        }

        return false;
    }

    ///////////////////////////////////////////////////

    /**
     * @param \XoopsObject $obj
     * @param bool         $force
     *
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
            $sql = sprintf('INSERT INTO `%s` (id, uid, order_detail_id, group_id, expiry_date, sent_warning)
                                      VALUES (%u, %u, %u, %u, %u, %u)', $this->_db->prefix($this->_dbtable), $id, $uid, $order_detail_id, $group_id, $expiry_date, $sent_warning);
        } else {
            $sql = sprintf('UPDATE `%s` SET uid = %u, order_detail_id = %u, group_id = %u, expiry_date = %u, sent_warning = %u WHERE id = %u', $this->_db->prefix($this->_dbtable), $uid, $order_detail_id, $group_id, $expiry_date, $sent_warning, $id);
        }
        //echo $sql;
        // Update DB
        if (false !== $force) {
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

        //
        return true;
    }
}
