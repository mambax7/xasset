<?php

require_once __DIR__ . '/xassetBaseObject.php';
require_once __DIR__ . '/video/video.php';
//

/**
 * Class xassetVideo
 */
class XassetVideo extends XassetBaseObject
{
    /**
     * @param $file
     * @param $position
     */
    public function streamVideo($file, $position)
    {
        $hCommon = xoops_getModuleHandler('common', 'xasset');
        //
        $bandwidth = $hCommon->getModuleOption('bandwidth');
        //
        $video = new Video();
        $video->setFile($file);
        $video->setBitrate($bandwidth * 1024);
        $video->enableThrottle($hCommon->getModuleOption('Enablebandwidth') == 1);
        $video->streamVideo($position);
    }
}

/**
 * Class xassetVideoHandler
 */
class XassetVideoHandler extends XassetBaseObjectHandler
{
    //
    public $_db;
    public $classname = 'xassetvideo';

    //

    /**
     * @param $db
     */
    public function __construct(XoopsDatabase $db)
    {
        //
        $this->_db = $db;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $db
     *
     * @return xassetVideoHandler
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
        /** @var \XassetPackageHandler $hPackage */
        $hPackage = xoops_getModuleHandler('package', 'xasset');
        /** @var \XassetUserDetailsHandler $hUserDetail */
        $hUserDetail = xoops_getModuleHandler('userDetails', 'xasset');
        /** @var \XassetCommonHandler $hCommon */
        $hCommon = xoops_getModuleHandler('common', 'xasset');
        //
        $uid      = $hCommon->pspDecrypt($token);
        $oPackage = $hPackage->get($id);
        //
        if ($uid > 0) { //secure the video
            /** @var \XassetUserDetails $oClient */
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
