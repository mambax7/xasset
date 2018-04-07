<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * Class ApplicationGroupHandler
 */
class ApplicationGroupHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = ApplicationGroup::class;
    public $_dbtable  = 'xasset_application_groups';

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
     * @return Xasset\ApplicationGroupHandler
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
     * @param $appID
     *
     * @return array
     */
    public function getGroupIDArray($appID)
    {
        $crit = new \Criteria('application_id', $appID);
        $objs = $this->getObjects($crit);
        //
        $ar = [];
        foreach ($objs as $key => $obj) {
            $ar[$obj->getVar('group_id')] = true;
        }

        //
        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $uid
     *
     * @return array
     */
    public function &getAppObjectsByUID($uid)
    {
        $hMember = xoops_getHandler('member');
        $aGroups = $hMember->getGroupsByUser($uid);
        //filter this if user is register and member of full group then remove the registered group
        //    if (count($aGroups)>1) {
        //      $tmp = array();
        //      foreach ($aGroups as $key=>$grp) {
        //        if ($grp <> XOOPS_GROUP_USERS) {
        //          $tmp[] = $grp;
        //        }
        //      }
        //      $aGroups = $tmp;
        //    }
        $crit = new \CriteriaCompo();
        //
        if ($uid > 0) {
            for ($i = 0, $iMax = count($aGroups); $i < $iMax; ++$i) {
                if (0 == $i) {
                    $crit->add(new \Criteria('group_id', $aGroups[$i]));
                } else {
                    $crit->add(new \Criteria('group_id', $aGroups[$i]), 'or');
                }
            }
        } else {
            $crit->add(new \Criteria('group_id', XOOPS_GROUP_ANONYMOUS));
        }

        //
        return $this->getObjects($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @param int $appID
     *
     * @return string
     */
    public function getCBGroupString($appID = 0)
    {
        $hMember = xoops_getHandler('member');
        //
        $groups = $hMember->getGroups();
        //
        if ($appID > 0) {
            $aAppGroups = $this->getGroupIDArray($appID);
        } else {
            $aAppGroups = [];
        }
        $grps = '';
        //
        foreach ($groups as $group) {
            $name  = $group->getVar('name');
            $grpid = $group->getVar('groupid');
            if (isset($aAppGroups[$group->getVar('groupid')])) {
                $checked = 'checked=checked';
            } else {
                $checked = '';
            }
            //
            $grps .= "<input name='cb[]' type='checkbox' value='$grpid' $checked> $name";
        }

        return $grps;
    }

    ///////////////////////////////////////////////////

    /**
     * @param      $appID
     * @param null $aGrps
     */
    public function updateGroup($appID, $aGrps = null)
    {
        $table = $this->_db->prefix($this->_dbtable);
        $sql   = "delete from $table where application_id = $appID";
        //
        $this->_db->queryF($sql);
        //
        if (isset($aGrps)) {
            foreach ($aGrps as $key => $groupid) {
                $grp = $this->create();
                $grp->setVar('application_id', $appID);
                $grp->setVar('group_id', $groupid);
                //
                $this->insert($grp);
            }
        }
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
            $sql = sprintf('INSERT INTO `%s` (id, application_id, group_id)
                                      VALUES (%u, %u, %u)', $this->_db->prefix($this->_dbtable), $id, $application_id, $group_id);
        } else {
            $sql = sprintf('UPDATE `%s` SET application_id = %u, group_id = %uwhere id = %u', $this->_db->prefix($this->_dbtable), $application_id, $group_id, $id);
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
