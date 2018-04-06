<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;
use XoopsModules\Xasset\Gateways;

/**
 * class GatewayHandler
 */
class GatewayHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Gateway::class;
    public $_dbtable  = 'xasset_gateway';

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
     * @return Xasset\GatewayHandler
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
     * @param $code
     *
     * @return bool|mixed
     */
    public function &getByCode($code)
    {
        $crit = new \Criteria('code', $code);
        $objs = $this->getObjects($crit);
        //
        if (0 == count($objs)) {
            $res = false;

            return $res;
        } else {
            $res = current($objs);

            return $res;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $code
     *
     * @return bool
     */
    public function &getCodeID($code)
    {
        $crit = new \Criteria('code', $code);
        $objs = $this->getObjects($crit);
        //
        if (0 == count($objs)) {
            $res = false;

            return $res;
        } elseif (count($objs) > 0) {
            $obj = current($objs);

            return $obj->getVar('id');
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function getInstalledGatewayArray()
    {
        $crit = new \Criteria('enabled', true);

        return $this->getGatewayArray($crit);
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function getInstalledGatewayWithDescArray()
    {
        $ar = $this->getInstalledGatewayArray();
        for ($i = 0, $iMax = count($ar); $i < $iMax; ++$i) {
            $gateway               =& $this->getGatewayModuleByID($ar[$i]['id']);
            $ar[$i]['description'] = $gateway->description;
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $crit
     *
     * @return array
     */
    public function getGatewayArray($crit = null)
    {
        global $xoopsModule;
        //
        $objs = $this->getObjects($crit);
        $ary  = [];
        foreach ($objs as $obj) {
            $gateway =& $this->getGatewayModuleByID($obj->ID());
            if ($gateway->version() == $xoopsModule->getVar('version')) {
                $ary[] = $obj->getArray();
            }
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $id
     *
     * @return bool
     */
    public function &getGatewayModuleByID($id)
    {
        $gateway =& $this->get($id);
        //
        $directory_array = $this->_getDirectoryListing();
        //
        for ($i = 0, $n = count($directory_array); $i < $n; ++$i) {
            $file  = $directory_array[$i]['file'];
            $class = substr($file, 0, strrpos($file, '.'));
            //
            if (is_object($gateway)) {
                if ($class == $gateway->getVar('code')) {
                    require_once $directory_array[$i]['fullPath'];
                    $module = new $class;
                    if (!is_subclass_of($module, Gateways\BaseGateway::class)) {
                        unset($module);
                    }
                    break;
                }
            }
        }
        //
        if (isset($module)) {
            return $module;
        } else {
            $res = false;

            return $res;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $post
     * @param $gateway
     *
     * @return bool
     */
    public function getGatewayFromPost($post, &$gateway)
    {
        $directory_array = $this->_getDirectoryListing();
        //
        for ($i = 0, $n = count($directory_array); $i < $n; ++$i) {
            $file  = $directory_array[$i]['file'];
            $class = substr($file, 0, strrpos($file, '.'));
            //
            require_once $directory_array[$i]['fullPath'];
            $module = new $class;
            if (is_subclass_of($module, Gateways\BaseGateway::class)) {
                if ($orderID = $module->isThisGateway($post)) {
                    $gateway = $module;

                    return $orderID;
                } else {
                    unset($module);
                }
            }
        }

        return false;
    }

    ///////////////////////////////////////////////////

    /**
     * @return array
     */
    public function parseGatewayModules()
    {
        global $xoopsModule;
        //
        $directory_array = $this->_getDirectoryListing();
        //include and process payment modules
        $installed_modules = [];
        for ($i = 0, $n = count($directory_array); $i < $n; ++$i) {
            $file = $directory_array[$i]['file'];
            require_once $directory_array[$i]['fullPath'];
            //get class name based on file
            $className  = substr($file, 0, strrpos($file, '.'));
            $class = '\\XoopsModules\\Xasset\\Gateways\\' . $className;
            $module = new $class;
            //check if this class is a subclass of BaseGateway
            if (is_subclass_of($module, BaseGateway::class) && ($xoopsModule->getVar('version') == $module->version())) {
                $installed_modules[] = [
                    'id'        => $module->id,
                    'class'     => $class,
                    'file'      => $file,
                    'filePath'  => $directory_array[$i]['fullPath'],
                    'enabled'   => $module->enabled,
                    'installed' => $module->installed,
                    'shortDesc' => $module->shortDesc
                ];
            }
            unset($module);
        }

        return $installed_modules;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $class
     *
     * @return bool
     */
    public function enableGateway($class)
    {
        return $this->switchGateway($class, true);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $class
     */
    public function disableGateway($class)
    {
        $this->switchGateway($class, false);
        //now delete the gateway record
        if ($obj = $this->getByCode($class)) {
            //delete data
            $gate =& $this->getGatewayModuleByID($obj->getVar('id'));
            $gate->remove();
            //delete header
            $this->deleteByID($obj->getVar('id'));
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $class
     * @param $switch
     *
     * @return bool
     */
    public function switchGateway($class, $switch)
    {
        if ($obj = $this->getByCode($class)) {
            $obj->setVar('enabled', $switch);

            return $this->insert($obj);
        } else {
            //could not find in tables... need to install?
            $this->parseGatewayModules();
            //
            $module = new $class;

            return $module->install();
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $gateID
     */
    public function postPaymentDetails($gateID)
    {
        $gateway =& $this->getGatewayModuleByID($gateID);
        //do we need more info?
        if ($gateway->preprocess()) {
            $gateway->doPreprocess();
        } else {
            $gateway->postToGateway();
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|\XoopsObject $obj
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
            $sql = sprintf('INSERT INTO %s (id, CODE, enabled)
                                      VALUES (%u, %s, %u)', $this->_db->prefix($this->_dbtable), $id, $this->_db->quoteString($code), $enabled);
        } else {
            $sql = sprintf('UPDATE %s SET CODE = %s, enabled = %u WHERE id = %u', $this->_db->prefix($this->_dbtable), $this->_db->quoteString($code), $enabled, $id);
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

    ///////////////////////////////////////////////////
    /*function _postToGateway($url, $fields) {
        $form = "<html>
                         <body onLoad='document.checkout.submit()'>
                         <form name='checkout' method='post' action='$url'> $fields </form>
                         </body>
                         </html>";
        echo $form;
    }        */
    ///////////////////////////////////////////////////
    /**
     * @return array
     */
    public function _getDirectoryListing()
    {
        global $PHP_SELF;
        //
        $file_extension   = '.php'; //substr($PHP_SELF, strrpos($PHP_SELF, '.'));
        $module_directory = XASSET_CLASS_PATH . '/gateways/';
        //
        $directory_array = [];
        if ($dir = @dir($module_directory)) {
            while ($file = $dir->read()) {
                if (!is_dir($module_directory . $file)) {
                    if (substr($file, strrpos($file, '.')) == $file_extension) {
                        $directory_array[] = [
                            'file'     => $file,
                            'fullPath' => $module_directory . $file
                        ];
                    }
                }
            }
            sort($directory_array);
            $dir->close();
        }

        return $directory_array;
    }
}
