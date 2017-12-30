<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;


/**
 * Class AjaxHandler
 */
class AjaxHandler extends xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Ajax::class;
    public $_dbtable  = '';

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
     * @return AjaxHandler
     */
    public function getInstance(\XoopsDatabase $db)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($db);
        }

        return $instance;
    }
}
