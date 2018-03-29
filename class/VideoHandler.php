<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

//require_once __DIR__ . '/video/video.php';


/**
 * Class xassetHandler
 */
class VideoHandler extends Xasset\BaseObjectHandler
{
    //
    public $_db;
    public $classname = Video::class;

    //

    /**
     * @param $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        //
        $this->_db = $db;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $db
     *
     * @return xassetHandler
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
     * @return mixed
     */
    public function &create()
    { //override
        $obj = new $this->classname();

        return $obj;
    }

    ///////////////////////////////////////////////////

    /**
     * @return bool
     */
    public function pluginInstalled()
    {
        if (file_exists('video/video.php')) {
            return true;
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param int    $id
     * @param string $token
     * @param int    $position
     */
    public function getVideo($id, $token, $position = 0)
    {
        /** @var \Xasset\PackageHandler $hPackage */
        $hPackage = new Xasset\PackageHandler($GLOBALS['xoopsDB']);
        /** @var \Xasset\UserDetailsHandler $hUserDetail */
        $hUserDetail = new Xasset\UserDetailsHandler($GLOBALS['xoopsDB']);
        /** @var \CommonHandler $hCommon */
        $hCommon = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
        //
        $uid      = $hCommon->pspDecrypt($token);
        $oPackage = $hPackage->get($id);
        //
        if ($uid > 0) { //secure the video
            /** @var \Xasset\UserDetails $oClient */
            $oClient = $hUserDetail->getUserDetailByID($uid);
            //
            $dummy = '';
            if ($oClient->canDownloadPackage($oPackage->ID(), $dummy) or (!$oPackage->fileProtected())) {
                $file  = $oPackage->filePath();
                $video = $this->create();
                $video->streamVideo($file, $position);
            }
        } else { //requested by anonymous uid... check if video is protected and stream if it is not
            if (!$oPackage->fileProtected()) {
                $file  = $oPackage->filePath();
                $video = $this->create();
                $video->streamVideo($file, $position);
            }
        }
    }

    /////////////////////////////////////////////

    /**
     * @param $id
     */
    public function buildPlayer($id)
    {
        $movie_id = $id;
        $filesize = $this->getVideoSize($id);
    }
}
