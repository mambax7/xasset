<?php namespace XoopsModules\Xasset;

/**
 * Class BaseObject
 */
class BaseObject extends \XoopsObject
{
    //cons
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    //////////////////////////////////////

    /**
     * @return mixed
     */
    public function ID()
    {
        return $this->getVar('id');
    }

    ///////////////////////////////////////////////////////

    /**
     * initialize variables for the object
     *
     * YOU SHOULD NOT USE THE $enumeration PARAMETER
     *
     * @access   public
     *
     * @param string $key
     * @param int    $data_type set to one of XOBJ_DTYPE_XXX constants (set to XOBJ_DTYPE_OTHER if no data type ckecking nor text sanitizing is required)
     * @param null   $value
     * @param bool   $required  require html form input?
     * @param int    $maxlength for XOBJ_DTYPE_TXTBOX type only
     * @param string $options
     * @param string $pretty
     *
     * @internal param $mixed $
     * @internal param string $option does this data have any select options?
     * @internal param string $enumeration array for XOBJ_DTYPE_ENUM type only
     */
    public function initVar(
        $key,
        $data_type,
        $value = null,
        $required = false,
        $maxlength = null,
        $options = '',
        $pretty = ''
    ) {
        parent::initVar($key, $data_type, $value, $required, $maxlength, $options);
        $this->vars[$key]['pretty'] = $pretty;
    }

    ///////////////////////////////////////////////////////

    /**
     * @return array
     */
    public function &getArray()
    {
        $ary  = [];
        $vars =& $this->getVars();
        foreach ($vars as $key => $value) {
            $ary[$key] = $value['value'];
        }

        return $ary;
    }

    ///////////////////////////////////////////////////////

    /**
     * @param $post
     */
    public function setVarsFromArray($post)
    {
        $vars =& $this->getVars();
        //
        foreach ($post as $key => $value) {
            if (isset($vars[$key])) {
                $this->setVar($key, $value);
            }
        }
    }

    ///////////////////////////////////////////////////////
    /**
     * @param $key
     * @param $value
     */
    //    public function setErrors($key, $value)
    //    {
    //        $this->_errors[$key] = trim($value);
    //    }

    ///////////////////////////////////////////////////////
    /**
     * clean values of all variables of the object for storage.
     * also add slashes whereever needed
     *
     * YOU SHOULD NOT USE ANY OF THE UNICODE TYPES, THEY WILL BE REMOVED
     *
     * @return bool true if successful
     * @access public
     */
    public function cleanVars()
    {
        $ts = \MyTextSanitizer::getInstance();
        foreach ($this->vars as $k => $v) {
            $cleanv = $v['value'];
            if (!$v['changed']) {
            } else {
                $cleanv = is_string($cleanv) ? trim($cleanv) : $cleanv;
                switch ($v['data_type']) {
                    case XOBJ_DTYPE_TXTBOX:
                        if ($v['required'] && '0' != $cleanv && '' == $cleanv) {
                            //                            $this->setErrors($k, "$v[pretty] is required.");
                            $this->setErrors(sprintf("$v[pretty] is required.", $k));
                            continue 2;
                        }
                        if (isset($v['maxlength']) && strlen($cleanv) > (int)$v['maxlength']) {
                            //                            $this->setErrors($k, "$v[pretty] must be shorter than " . (int)$v['maxlength'] . ' characters.');
                            $this->setErrors(sprintf("$v[pretty] must be shorter than " . (int)$v['maxlength'] . ' characters.', $k));
                            continue 2;
                        }
                        if (!$v['not_gpc']) {
                            $cleanv = $ts->stripSlashesGPC($ts->censorString($cleanv));
                        } else {
                            $cleanv = $ts->censorString($cleanv);
                        }
                        break;
                    case XOBJ_DTYPE_TXTAREA:
                        if ($v['required'] && '0' != $cleanv && '' == $cleanv) {
                            //                            $this->setErrors($k, "$v[pretty] is required.");
                            $this->setErrors(sprintf("$v[pretty] is required.", $k));
                            continue 2;
                        }
                        if (!$v['not_gpc']) {
                            $cleanv = $ts->stripSlashesGPC($ts->censorString($cleanv));
                        } else {
                            $cleanv = $ts->censorString($cleanv);
                        }
                        break;
                    case XOBJ_DTYPE_SOURCE:
                        if (!$v['not_gpc']) {
                            $cleanv = $ts->stripSlashesGPC($cleanv);
                        } else {
                            $cleanv = $cleanv;
                        }
                        break;
                    case XOBJ_DTYPE_INT:
                        $cleanv = (int)$cleanv;
                        break;
                    case XOBJ_DTYPE_EMAIL:
                        if ($v['required'] && '' == $cleanv) {
                            // $this->setErrors($k, "$v[pretty] is required.");
                            $this->setErrors(sprintf("$v[pretty] is required.", $k));
                            continue 2;
                        }
                        if ('' != $cleanv
                            && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i", $cleanv)) {
                            //                            $this->setErrors($k, 'Invalid Email');
                            $this->setErrors(sprintf('Invalid Email', $k));
                            continue;
                        }
                        if (!$v['not_gpc']) {
                            $cleanv = $ts->stripSlashesGPC($cleanv);
                        }
                        break;
                    case XOBJ_DTYPE_URL:
                        if ($v['required'] && '' == $cleanv) {
                            // $this->setErrors($k, "$v[pretty] is required.");
                            $this->setErrors(sprintf("$v[pretty] is required.", $k));
                            continue 2;
                        }
                        if ('' != $cleanv && !preg_match("/^http[s]*:\/\//i", $cleanv)) {
                            $cleanv = 'http://' . $cleanv;
                        }
                        if (!$v['not_gpc']) {
                            $cleanv =& $ts->stripSlashesGPC($cleanv);
                        }
                        break;
                    case XOBJ_DTYPE_ARRAY:
                        $cleanv = serialize($cleanv);
                        break;
                    case XOBJ_DTYPE_STIME:
                    case XOBJ_DTYPE_MTIME:
                    case XOBJ_DTYPE_LTIME:
                        $cleanv = !is_string($cleanv) ? (int)$cleanv : strtotime($cleanv);
                        break;
                    default:
                        break;
                }
            }
            $this->cleanVars[$k] =& $cleanv;
            unset($cleanv);
        }
        if (count($this->_errors) > 0) {
            return false;
        }
        $this->unsetDirty();

        return true;
    }
}

/////////////////// global functions /////////////////////////

/**
 * @param $class
 *
 * @return bool
 */
//function &xoopGetModuleHandler($class)
//{
//    return xoops_getModuleHandler($class, 'xasset');
//}
