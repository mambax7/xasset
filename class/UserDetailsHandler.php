<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class UserDetailsHandler
 */
class UserDetailsHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = UserDetails::class;
    public $_dbtable  = 'xasset_user_details';

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
     * @return Xasset\UserDetailsHandler
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
     * @param $uid
     *
     * @return bool|mixed
     */
    public function &getUserDetailByID($uid)
    {
        $crit = new \CriteriaCompo(new \Criteria('uid', $uid));
        $objs =& $this->getObjects($crit);
        if (count($objs) > 0) {
            $obj = reset($objs);

            return $obj;
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
    public function getUserDetailArraybyUID($id)
    {
        $crit = new \CriteriaCompo(new \Criteria('uid', $id));
        $cust = $this->getUserDetailArray($crit);
        if (count($cust) > 0) {
            return $cust[0];
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function getUserDetailArray($criteria = null)
    {
        global $xoopsUser;
        //
        $objs =& $this->getObjects($criteria);
        //
        $ary = [];
        //
        foreach ($objs as $obj) {
            $ary[] = [
                'id'              => $obj->getVar('id'),
                'first_name'      => $obj->getVar('first_name'),
                'last_name'       => $obj->getVar('last_name'),
                'street_address1' => $obj->getVar('street_address1'),
                'street_address2' => $obj->getVar('street_address2'),
                'town'            => $obj->getVar('town'),
                'state'           => $obj->getVar('state'),
                'zip'             => $obj->getVar('zip'),
                'tel_no'          => $obj->getVar('tel_no'),
                'fax_no'          => $obj->getVar('fax_no'),
                'email'           => $xoopsUser->email()
            ];
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $post
     */
    public function validatePost($post)
    {
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
            $sql = sprintf(
                'INSERT INTO %s ( id, uid, zone_id, country_id, first_name, last_name, street_address1,
                                                      street_address2, town, state, zip, tel_no, fax_no, company_name,
                                                      company_reg, vat_no, client_type)
                                      VALUES (%u, %u, %u, %u, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %u)',
                $this->_db->prefix($this->_dbtable),
                $id,
                $uid,
                $zone_id,
                $country_id,
                $this->_db->quoteString($first_name),
                $this->_db->quoteString($last_name),
                           $this->_db->quoteString($street_address1),
                $this->_db->quoteString($street_address2),
                $this->_db->quoteString($town),
                $this->_db->quoteString($state),
                $this->_db->quoteString($zip),
                $this->_db->quoteString($tel_no),
                $this->_db->quoteString($fax_no),
                           $this->_db->quoteString($company_name),
                $this->_db->quoteString($company_reg),
                $this->_db->quoteString($vat_no),
                $client_type
            );
        } else {
            $sql = sprintf(
                'UPDATE %s SET uid = %u, zone_id = %u, country_id = %u, first_name = %s, last_name = %s,
                                        street_address1 = %s, street_address2 = %s, town = %s, state = %s, zip = %s, tel_no = %s,
                                        fax_no = %s, company_name = %s, company_reg = %s, vat_no = %s,
                                        client_type = %u WHERE id = %u',
                $this->_db->prefix($this->_dbtable),
                $uid,
                $zone_id,
                $country_id,
                $this->_db->quoteString($first_name),
                $this->_db->quoteString($last_name),
                $this->_db->quoteString($street_address1),
                $this->_db->quoteString($street_address2),
                           $this->_db->quoteString($town),
                $this->_db->quoteString($state),
                $this->_db->quoteString($zip),
                $this->_db->quoteString($tel_no),
                $this->_db->quoteString($fax_no),
                $this->_db->quoteString($company_name),
                $this->_db->quoteString($company_reg),
                           $this->_db->quoteString($vat_no),
                $client_type,
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
