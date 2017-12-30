<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;


/**
 * class Package
 */
class Package extends xasset\BaseObject
{
    public $weight;

    //

    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('packagegroupid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('filename', XOBJ_DTYPE_TXTBOX, null, false, 70);
        $this->initVar('filesize', XOBJ_DTYPE_INT, null, false);
        $this->initVar('filetype', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('serverFilePath', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('protected', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('isVideo', XOBJ_DTYPE_INT, 0, false);
        //
        $this->weight = 917;
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    //////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function filePath()
    {
        return $this->getVar('serverFilePath');
    }

    /////////////////////////////////////////////////

    /**
     * @return bool
     */
    public function fileProtected()
    {
        return 1 == $this->getVar('protected');
    }

    /////////////////////////////////////////////////

    /**
     * @param bool $force
     *
     * @return int|mixed
     */
    public function fileSize($force = true)
    {
        if ($force) {
            return filesize($this->filePath());
        } else {
            return $this->getVar('filesize');
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getPackageStats()
    {
        $arr = [];
        //
        $id = (int)$this->getVar('id');
        if (!$id) {
            return $arr;
        }
        //
        $hPackStats = new xasset\UserPackageStatsHandler($GLOBALS['xoopsDB']);
        //
        $crit = new \CriteriaCompo(new \Criteria('packageid', $id));
        $crit->setSort('date');
        //
        $arr = $hPackStats->getObjects($crit);

        //
        return $arr;
    }

    ///////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getTotalDownloads()
    {
        $hPackStats = new xasset\UserPackageStatsHandler($GLOBALS['xoopsDB']);
        $crit       = new \CriteriaCompo(new \Criteria('packageid', $this->ID()));

        //$totalDownloads = $hPackStats->getCount($crit)
        return $hPackStats->getCount($crit);
    }

    ///////////////////////////////////////////////////
    public function secureDownloadFile()
    {
        global $xoopsUser;
        //
        $hClient = new xasset\UserDetailsHandler($GLOBALS['xoopsDB']);
        //
        if ($xoopsUser) {
            if ($oClient = $hClient->getUserDetailByID($xoopsUser->uid())) {
                //this is the user.... check if this user has access to this file
                if ($oClient->canDownloadPackage($this->ID(), $error)) {
                    $this->downloadFile();
                } else {
                    redirect_header('index.php', 5, $error);
                }
            }
        } else {
            redirect_header(XOOPS_URL . '/user.php', 5, 'Not Logged In.');
        }
    }

    ///////////////////////////////////////////////////
    public function incrementDownload()
    {
        $hStats = new xasset\UserPackageStatsHandler($GLOBALS['xoopsDB']);
        $hStats->logPackageDownload($this);
    }

    ///////////////////////////////////////////////////
    public function downloadFile()
    {
        global $HTTP_USER_AGENT, $xoopsUser, $xoopsModule;
        //
        $file_saved   = $this->getVar('serverFilePath');
        $file_display = $this->getVar('filename');
        //
        if ('' <> $this->getVar('filetype')) {
            if (0 == substr_count($file_display, '.')) {
                $file_display = $this->getVar('filename') . '.' . $this->getVar('filetype');
            }
        } elseif ('' <> substr(strrchr($file_display, '.'), 1)) { //file extension in file_display itself
            $this->setVar('filetype', strtolower(substr(strrchr($file_display, '.'), 1)));
        }
        //
        $fileSize = filesize($file_saved);
        //now log the fact that the file has been downloaded
        //    $hStats       = xoops_getModuleHandler('userPackageStats','xasset');
        //now get mime type based on extension
        $mimetype = 'application/x-download';
        @$extensionToMime = include XOOPS_ROOT_PATH . '/class/mimetypes.inc.php';
        if ('' <> $this->getVar('filetype')) {
            if (isset($extensionToMime[$this->getVar('filetype')])) {
                $mimetype = $extensionToMime[$this->getVar('filetype')];
            }
        }
        $this->incrementDownload();
        //    if ($xoopsUser) {
        //      $uid = $xoopsUser->getVar('uid'); }
        //     else {
        //      $uid = 0;
        //     }
        //
        //    $stats  = $hStats->create();
        //    $stats->setVar('packageid',$this->getVar('id'));
        //    $stats->setVar('uid',$uid);
        //    $stats->setVar('ip',getenv("REMOTE_ADDR"));
        //    $stats->setVar('dns',gethostbyaddr(getenv('REMOTE_ADDR'))); ;
        //    $stats->setVar('date',time());
        //    $hStats->insert($stats,true);
        //
        if (!headers_sent($filename, $linenum)) {
            header('Content-Type: ' . $mimetype);
            header('Content-Length: ' . $fileSize);
            header('Expires: 0');
            header('Content-Disposition: attachment; filename="' . $file_display . '"');
            if (preg_match("/MSIE ([0-9]\.[0-9]{1,2})/", $HTTP_USER_AGENT)) {
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
            } else {
                header('Pragma: no-cache');
            }
            readfile($file_saved);
        } else {
            echo "header output started in file: $filename at line number : $linenum. Cannot download file.";
        }
    }

    /////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getPackageGroup()
    {
        $hGrp = new xasset\PackageGroupHandler($GLOBALS['xoopsDB']);

        return $hGrp->get($this->getVar('packagegroupid'));
    }

    ///////////////////////////////////////////////

    /**
     * @return string
     */
    public function getKey()
    {
        $crypt = new xasset\Crypt();

        return $crypt->cryptValue($this->getVar('id'), $this->weight);
    }
}
