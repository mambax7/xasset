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
 * class UserAppProductsHandler
 */
class UserAppProductsHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = UserAppProducts::class;
    public $_dbtable  = 'xasset_user_products';

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
     * @return Xasset\UserAppProductsHandler
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
     * @param $uid
     * @param $prodid
     *
     * @return bool
     */
    public function getUserProductMaxDowns($uid, $prodid)
    {
        $hAppProds = new Xasset\ApplicationProductHandler($GLOBALS['xoopsDB']);
        //
        $thisTable = $this->_db->prefix($this->_dbtable);
        $prodTable = $this->_db->prefix($hAppProds->_dbtable);
        //
        $sql = "select sum(ap.max_access) sm from $prodTable ap inner join $thisTable ua on
                    ap.application_product_id = ua.id
                  where ua.application_product_id = $prodid and ua.uid = $uid";
        //
        if ($res = $this->_db->query($sql)) {
            if ($row = $this->_db->fetchArray($res)) {
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
        $crit = new \CriteriaCompo(new \Criteria('application_product_id', $appProdID));
        $crit->add(new \Criteria('uid', $uid));
        //
        $objs = $this->getObjects($crit);

        //
        return count($objs) > 0;
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
            $sql = sprintf('INSERT INTO `%s` (id, uid, application_product_id)
                                      VALUES (%u, %u, %u)', $this->_db->prefix($this->_dbtable), $id, $uid, $application_product_id);
        } else {
            $sql = sprintf('UPDATE `%s` SET uid = %u, application_poduct_id = %u WHERE id = %u', $this->_db->prefix($this->_dbtable), $uid, $application_poduct_id, $id);
        }
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

        return true;
    }
}
