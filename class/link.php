<?php

require_once __DIR__ . '/xassetBaseObject.php';

/**
 * Class xassetLink
 */
class XassetLink extends XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('applicationid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('link', XOBJ_DTYPE_TXTBOX, null, false, 255);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    ////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getApplication()
    {
        $hDept = xoops_getModuleHandler('application', 'xasset');

        return $hDept->get($this->getVar('applicationid'));
    }

    ///////////////////////////////////////////////////

    /**
     * @return bool
     */
    public function getLinkApplication()
    {
        $id = (int)$uid;
        if (!$id) {
            return false;
        }
        $hApplication = xoops_getModuleHandler('application', 'xasset');
        $arr          = $hApplication->getObjects($this->getVar('applicationid'));

        //
        return $arr;
    }
}

/**
 * Class xassetLinkHandler
 */
class XassetLinkHandler extends XassetBaseObjectHandler
{
    //vars
    public $_db;
    public $classname = 'xassetlink';
    public $_dbtable  = 'xasset_links';

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
     * @param $appid
     *
     * @return array
     */
    public function getApplicationLinks($appid)
    {
        $crit = new CriteriaCompo();
        $crit->add(new Criteria('applicationid', $appid));
        $crit->setSort('name');

        //
        return $this->getLinksArray($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function getAllLinks()
    {
        return $this->getLinksArray();
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $crit
     *
     * @return array
     */
    public function getLinksArray($crit = null)
    {
        global $imagearray;
        //
        $appTable  = $this->_db->prefix('xasset_application');
        $linkTable = $this->_db->prefix($this->_dbtable);
        //
        $sql = "select l.*, a.name appname from $linkTable l inner join $appTable a on
             l.applicationid = a.id ";
        $this->postProcessSQL($sql, $crit);
        //
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            while ($row = $this->_db->fetchArray($res)) {
                $actions = '<a href="' . $row['link'] . '">' . $imagearray['viewlic'] . '</a>' . '<a href="main.php?op=editLink&id=' . $row['id'] . '">' . $imagearray['editimg'] . '</a>' . '<a href="main.php?op=deleteLink&id=' . $row['id'] . '">' . $imagearray['deleteimg'] . '</a>';

                $ary[] = [
                    'id'            => $row['id'],
                    'applicationid' => $row['applicationid'],
                    'appname'       => $row['appname'],
                    'name'          => $row['name'],
                    'link'          => '<a href="' . $row['link'] . '">' . $row['name'] . '</a>',
                    'actions'       => $actions
                ];
            }
        }

        return $ary;
    }

    /////////////////////////////////////////////////////

    /**
     * @return int
     */
    public function getAllLinksCount()
    {
        return $this->getCount();
    }

    /////////////////////////////////////////////////////

    /**
     * @param $db
     *
     * @return xassetLinkHandler
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
            $sql = sprintf('INSERT INTO %s (id, applicationid, NAME, link) VALUES (%u, %u, %s, %s)', $this->_db->prefix($this->_dbtable), $id, $applicationid, $this->_db->quoteString($name), $this->_db->quoteString($link));
        } else {
            $sql = sprintf('UPDATE %s SET applicationid = %u, NAME = %s, link = %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $applicationid, $this->_db->quoteString($name), $this->_db->quoteString($link), $id);
        }

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
