<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * Class CommonHandler
 */
class CommonHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Common::class;
    public $_dbtable  = '';

    //cons

    /**
     * @param $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        $this->_db = $db;
        //load languages
        //$hLanguage = xoops_getModuleHandler('language','xasset');
        //$hLanguage->loadLanguages('dgcommon');
    }

    ///////////////////////////////////////////////////

    /**
     * @param $db
     *
     * @return CommonHandler
     */
    public function getInstance(\XoopsDatabase $db)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($db);
        }

        return $instance;
    }

    //////////////////////////////////////////////////////////

    /**
     * @param        $option
     * @param string $repmodule
     *
     * @return bool
     */
    public function getModuleOption($option, $repmodule = 'xasset')
    {
        global $xoopsModuleConfig, $xoopsModule;
        static $tbloptions = [];
        if (is_array($tbloptions) && array_key_exists($option, $tbloptions)) {
            return $tbloptions[$option];
        }

        $retval = false;
        if (isset($xoopsModuleConfig)
            && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule
                && $xoopsModule->getVar('isactive'))) {
            if (isset($xoopsModuleConfig[$option])) {
                $retval = $xoopsModuleConfig[$option];
            }
        } else {
            /** @var XoopsModuleHandler $moduleHandler */
            $moduleHandler = xoops_getHandler('module');
            $module        = $moduleHandler->getByDirname($repmodule);
            $configHandler = xoops_getHandler('config');
            if ($module) {
                $moduleConfig = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
                if (isset($moduleConfig[$option])) {
                    $retval = $moduleConfig[$option];
                }
            }
        }
        $tbloptions[$option] = $retval;

        return $retval;
    }

    //////////////////////////////////////////////////////////

    /**
     * @param      $name
     * @param null $date
     *
     * @return string
     */
    public function getDateField($name, $date = null)
    {
        global $xoopsTpl;
        //
        if (!isset($date)) {
            $date = time();
        }
        //
        if ($module_header = $this->getSmartyVar('xoops_module_header')) {
            ob_start();
            require_once XOOPS_ROOT_PATH . '/include/calendarjs.php';
            $module_header = $module_header . ob_get_contents();
            ob_end_clean();
            //assign back
            $xoopsTpl->assign('xoops_module_header', $module_header);
        }

        return "<input type='text' name='$name' id='$name' size='11' maxlength='11' value='" . date('Y-m-d', $date) . "'><input type='reset' value=' ... ' onclick='return showCalendar(\"" . $name . "\");'>";
    }

    //////////////////////////////////////////////////////////

    /**
     * @param      $name
     * @param null $date
     *
     * @return string
     */
    public function getTimeField($name, $date = null)
    {
        require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        //
        if (!isset($date)) {
            $date = time();
        }
        $datetime = getdate($date);
        $div      = 30; //echo  $datetime['hours'] * 3600 + 60 * 30 * ceil($datetime['minutes'] / 30);
        //
        $timearray = [];
        for ($i = 0; $i < 24; ++$i) {
            for ($j = 0; $j < 60; $j = $j + $div) {
                $key             = ($i * 3600) + ($j * 60);
                $timearray[$key] = (0 != $j) ? $i . ':' . $j : $i . ':0' . $j;
            }
        }
        ksort($timearray);
        $timeselect = new \XoopsFormSelect('', $name . '[time]', $datetime['hours'] * 3600 + 60 * $div * ceil($datetime['minutes'] / $div));
        $timeselect->addOptionArray($timearray);

        //
        return $timeselect->render();
    }

    /////////////////////////////////////////

    /**
     * @param     $id
     * @param int $weight
     *
     * @return string
     */
    public function cryptValue($id, $weight = 0)
    {
        $crypt = new Xasset\Crypt();

        //
        return $crypt->cryptValue($id, $weight);
    }

    /////////////////////////////////////////

    /**
     * @param        $id
     * @param        $key
     * @param        $weight
     * @param string $error
     *
     * @return bool
     */
    public function keyMatches($id, $key, $weight, $error = '')
    {
        global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $xasset_module_header;
        //
        $crypt = new Xasset\Crypt();
        //
        if ($crypt->keyMatches($id + $weight, $key)) {
            return true;
        } else {
            //      $GLOBALS['xoopsOption']['template_main'] = 'xasset_error.tpl';
            //      require_once(XOOPS_ROOT_PATH . "/header.php");
            //      $xoopsTpl->assign('xasset_error',$error);
            //      include(XOOPS_ROOT_PATH . "/footer.php");
            return false;
        }
    }

    /////////////////////////////////////////

    /**
     * @return string
     */
    public function insertHeaderCountriesJavaScript()
    {
        $hCount = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
        $script = $hCount->constructSelectJavascript('zone_id', 'country_id');
        //
        $javascript = "<script type='text/javascript'> <!-- \n $script \n //--></script>";

        //return str_replace('</head>',"$javascript</head>",$buffer);
        return $javascript;
    }

    /////////////////////////////////////////

    /**
     * @return string
     */
    public function insertHeaderCountriesJavaScriptNoAllZones()
    {
        $hCount = new Xasset\CountryHandler($GLOBALS['xoopsDB']);
        $script = $hCount->constructSelectJavascript('zone_id', 'country_id', false);
        //
        $javascript = "<script type='text/javascript'> <!-- ' \n $script \n //--></script>";

        //return str_replace('</head>',"$javascript</head>",$buffer);
        return $javascript;
    }

    ///////////////////////////////////////////

    /**
     * @param $email
     *
     * @return bool|mixed
     */
    public function xoopsUserByEmail($email)
    {
        $hUser = xoops_getHandler('user');
        //
        $crit = new \Criteria('email', $email);
        $user = $hUser->getObjects($crit);
        //
        if (count($user) > 0) {
            $user = reset($user);

            return $user;
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////

    /**
     * @param $uname
     *
     * @return bool|mixed
     */
    public function xoopsUserbyUName($uname)
    {
        $hUser = xoops_getHandler('user');
        //
        $crit = new \Criteria('uname', $uname);
        $user = $hUser->getObjects($crit);
        //
        if (count($user) > 0) {
            $user = reset($user);

            return $user;
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////

    /**
     * @param $user
     */
    public function deleteUser($user)
    {
        $usersTable = $this->_db->prefix('users');
        $uid        = $user->uid();
        //
        $sql = "delete from $usersTable where uid = $uid";
        //
        $this->_db->queryF($sql);
    }

    ///////////////////////////////////////////

    /**
     * @param $hObject
     * @param $array
     *
     * @return mixed
     */
    public function &getRowArray($hObject, $array)
    {
        $obj = new $hObject->classname($array);

        return $obj->getArray();
    }

    ///////////////////////////////////////////

    /**
     * @param $email
     * @param $name
     * @param $password
     * @param $level
     *
     * @return bool
     */
    public function &AccountFromEmail($email, $name, &$password, $level)
    {
        $memberHandler = xoops_getHandler('member');

        $unamecount = 10;
        if (0 == strlen($password)) {
            $password = substr(md5(uniqid(mt_rand(), 1)), 0, 6);
        }

        $usernames = $this->GenUserNames($email, $name, $unamecount);
        $newuser   = false;
        $i         = 0;
        while (false === $newuser) {
            $crit  = new \Criteria('uname', $usernames[$i]);
            $count = $memberHandler->getUserCount($crit);
            if (0 == $count) {
                $newuser = true;
            } else {
                //Move to next username
                ++$i;
                if ($i == $unamecount) {
                    //Get next batch of usernames to try, reset counter
                    $usernames = $this->GenUserNames($email->getEmail(), $email->getName(), $unamecount);
                    $i         = 0;
                }
            }
        }

        $xuser = $memberHandler->createUser();
        $xuser->setVar('uname', $usernames[$i]);
        $xuser->setVar('loginname', $usernames[$i]);
        $xuser->setVar('user_avatar', 'blank.gif');
        $xuser->setVar('user_regdate', time());
        $xuser->setVar('timezone_offset', 0);
        $xuser->setVar('actkey', substr(md5(uniqid(mt_rand(), 1)), 0, 8));
        $xuser->setVar('email', $email);
        $xuser->setVar('name', $name);
        $xuser->setVar('pass', md5($password));
        $xuser->setVar('notify_method', 2);
        $xuser->setVar('level', $level);

        if ($memberHandler->insertUser($xuser)) {
            //Add the user to Registered Users group
            $memberHandler->addUserToGroup(XOOPS_GROUP_USERS, $xuser->getVar('uid'));
        } else {
            $res = false;

            return $res;
        }

        return $xuser;
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param     $email
     * @param     $name
     * @param int $count
     *
     * @return array
     */
    public function GenUserNames($email, $name, $count = 20)
    {
        $names  = [];
        $userid = explode('@', $email);
        //if the name has a dot then replace with underscore.
        $userid[0] = str_replace('.', '_', $userid[0]);
        //
        $basename    = '';
        $hasbasename = false;
        $emailname   = $userid[0];

        if (strlen($name) > 0) {
            $name = explode(' ', trim($name));
            if (count($name) > 1) {
                $basename = strtolower(substr($name[0], 0, 1) . $name[count($name) - 1]);
            } else {
                $basename = strtolower($name[0]);
            }
            $basename = xoops_substr($basename, 0, 60, '');
            //Prevent Duplication of Email Username and Name
            if (!in_array($basename, $names)) {
                $names[]     = $basename;
                $hasbasename = true;
            }
        }

        $names[] = $emailname;

        $i          = count($names);
        $onbasename = 1;
        while ($i < $count) {
            $num = $this->GenRandNumber();
            if ($onbasename < 0 && $hasbasename) {
                $names[] = xoops_substr($basename, 0, 58, '') . $num;
            } else {
                $names[] = xoops_substr($emailname, 0, 58, '') . $num;
            }
            $i          = count($names);
            $onbasename = ~$onbasename;
            $num        = '';
        }

        return $names;
    }

    //////////////////////////////////////////////////////////////////////////
    public function InitRand()
    {
        static $randCalled = false;
        if (!$randCalled) {
            mt_srand((double)microtime() * 1000000);
            $randCalled = true;
        }
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param int $digits
     *
     * @return string
     */
    public function GenRandNumber($digits = 2)
    {
        $this->InitRand();
        $tmp = [];

        for ($i = 0; $i < $digits; ++$i) {
            $tmp[$i] = (mt_rand() % 9);
        }

        return implode('', $tmp);
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param $email
     * @param $error
     *
     * @return bool
     */
    public function validEmail($email, &$error)
    {
        $valid = new ValidateEmail($email);
        $error = $valid->getError();

        return $valid->isValid();
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $GLOBALS['xoopsSecurity']->createToken(1200);
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param      $value
     * @param      $field
     * @param bool $required
     * @param      $minval
     * @param      $maxval
     *
     * @return bool
     */
    public function validateInteger($value, $field, $required = true, $minval = -1, $maxval = -1)
    {
        $valid = new ValidateInteger($value, $field, $required, $minval, $maxval);
        if ($valid->isValid()) {
            $res = false;

            return $res;
        } else {
            return $valid->getErrors();
        }
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param      $value
     * @param      $field
     * @param bool $required
     * @param      $minval
     * @param      $maxval
     *
     * @return bool
     */
    public function &validateFloat($value, $field, $required = true, $minval = -1, $maxval = -1)
    {
        $valid = new ValidateFloat($value, $field, $required, $minval, $maxval);
        if ($valid->isValid()) {
            $res = false;

            return $res;
        } else {
            return $valid->getErrors();
        }
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param $module
     */
    public function manageOnline($module)
    {
        global $xoopsUser;
        //
        $hModule = xoops_getHandler('module');
        $hOnline = xoops_getHandler('online');
        //
        $aModule = $hModule->getByDirname($module);
        //
        if (isset($aModule)) {
            if ($xoopsUser) {
                $uid   = $xoopsUser->uid();
                $uname = $xoopsUser->uname();
            } else {
                $uid   = 0;
                $uname = '';
            }
            //
            $hOnline->write($uid, $uname, time(), $aModule->getVar('mid'), getenv('REMOTE_ADDR'));
        }
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param $groupid
     *
     * @return array
     */
    public function &getGroupEmails($groupid)
    {
        $userTable  = $this->_db->prefix('users');
        $groupTable = $this->_db->prefix('groups_users_link');
        //
        $sql = "select distinct email from $userTable u inner join $groupTable g on
              u.uid = g.uid
            where g.groupid = $groupid";
        //
        $aEmails = [];
        if ($res = $this->_db->query($sql)) {
            while (false !== ($row = $this->_db->fetchArray($res))) {
                $aEmails[] = $row;
            }
        } else {
            echo $sql;
        }

        //
        return $aEmails;
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @return array
     */
    public function &getSiteAdminEmails()
    {
        $hConfig = new Xasset\ConfigHandler($GLOBALS['xoopsDB']);

        //
        return $this->getGroupEmails($hConfig->getEmailGroup());
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param $id
     * @param $actkey
     *
     * @return bool
     */
    public function activateUser($id, $actkey)
    {
        $hMember = xoops_getHandler('member');
        //
        $oUser = $hMember->getUser($id);
        //can only activate if the use has not been activated before
        if (0 == $oUser->getVar('level')) {
            //now only activate if the key sent is the same as the key in the tables
            if ($oUser->getVar('actkey') == $actkey) {
                return $hMember->activateUser($oUser);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param      $group_id
     * @param      $user_id
     * @param bool $force
     *
     * @return bool
     */
    public function addUserToGroup($group_id, $user_id, $force = false)
    {
        $memberTable = $this->_db->prefix('groups_users_link');
        //
        $sql = "INSERT INTO $memberTable (linkid, groupid, uid) VALUES (0, $group_id, $user_id)";
        //
        if ($force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }
        //
        if ($result) {
            return true;
        } else {
            echo $sql;

            return false;
        }
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param $name
     *
     * @return bool
     */
    public function getSmartyVar($name)
    {
        global $xoopsTpl;
        //
        if (isset($xoopsTpl->_tpl_vars[$name])) {
            return $xoopsTpl->_tpl_vars[$name];
        } else {
            return false;
        }
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param $table
     *
     * @return bool
     */
    public function tableExists($table)
    {
        $bRetVal = false;
        //Verifies that a MySQL table exists
        //$xoopsDB = \XoopsDatabaseFactory::getDatabaseConnection();
        $realname = $this->_db->prefix($table);
        $sql      = 'SHOW TABLES FROM ' . XOOPS_DB_NAME;
        $ret      = $xoopsDB->queryF($sql);
        while (false !== (list($m_table) = $this->_db->fetchRow($ret))) {
            if ($m_table == $realname) {
                $bRetVal = true;
                break;
            }
        }
        $this->_db->freeRecordSet($ret);

        return $bRetVal;
    }

    //////////////////////////////////////////////////////////////////////////

    /**
     * @param $table
     * @param $field
     *
     * @return bool
     */
    public function fieldExists($table, $field)
    {
        $realname = $this->_db->prefix($table);
        $sql      = "select * from $realname";
        $ret      = false;
        //
        if ($res = $this->_db->query($sql)) {
            $fields = $this->_db->getFieldsNum($res);
            for ($i = 0; $i < $fields; ++$i) {
                if (mysqli_fetch_field_direct($res, $i)->name == $field) {
                    return true;
                }
            }
        }

        return $ret;
    }

    ///////////////////////////////////////////////////////////////////////

    /**
     * @param $content
     */
    public function writeDateLog($content)
    {
        $filename = time();

        if ($handle = fopen($filename, 'a')) {
            fwrite($handle, $content);
            fclose($handle);
        }
    }

    //////////////////////////////////////////////////////////////////////

    /**
     * @return mixed|string
     */
    public function sslXoopsUrl()
    {
        if (false !== strpos(XOOPS_URL, 'https')) {
            return XOOPS_URL;
        } else {
            $url = str_replace('http', 'https', XOOPS_URL);

            return $url;
        }
    }

    ////////////////////////////////////////////////////////////////////

    /**
     * @param $message
     *
     * @return string
     */
    public function pspEncrypt($message)
    {
        $key = $this->getModuleOption('encryptKey');
        //
        $keylength     = strlen($key);
        $messagelength = strlen($message);
        $encstring     = '';
        for ($i = 0; $i <= $messagelength - 1; ++$i) {
            $msgord = ord(substr($message, $i, 1));
            $keyord = ord(substr($key, $i % $keylength, 1));

            if ($msgord + $keyord <= 255) {
                $encstring .= chr($msgord + $keyord);
            }
            if ($msgord + $keyord > 255) {
                $encstring .= chr(($msgord + $keyord) - 256);
            }
        }

        return urlencode(base64_encode($encstring));
    }

    ////////////////////////////////////////////////////////////////////////

    /**
     * @param $message
     *
     * @return string
     */
    public function pspDecrypt($message)
    {
        $message = base64_decode(urldecode($message));
        $key     = $this->getModuleOption('encryptKey');
        //
        $keylength     = strlen($key);
        $messagelength = strlen($message);
        $decstring     = '';
        for ($i = 0; $i <= $messagelength - 1; ++$i) {
            $msgord = ord(substr($message, $i, 1));
            $keyord = ord(substr($key, $i % $keylength, 1));

            if ($msgord - $keyord >= 0) {
                $decstring .= chr($msgord - $keyord);
            }
            if ($msgord + $keyord < 0) {
                $decstring .= chr(($msgord - $keyord) + 256);
            }
        }

        return $decstring;
    }

    //////////////////////////////////////////////////////////////////////

    /**
     * @param $template
     * @param $vars
     *
     * @return bool|mixed|string
     */
    public function fetchTemplate($template, $vars)
    {
        require_once XOOPS_ROOT_PATH . '/class/template.php';
        //
        $tpl = new \XoopsTpl();
        $tpl->assign($vars);

        //
        return $tpl->fetch('db:' . $template . '.tpl');
    }
}
