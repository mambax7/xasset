<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

//require_once __DIR__ . '/video/video.php';

/**
 * Class Video
 */
class Video extends Xasset\BaseObject
{
    /**
     * @param $file
     * @param $position
     */
    public function streamVideo($file, $position)
    {
        $hCommon = new Xasset\CommonHandler($GLOBALS['xoopsDB']);
        //
        $bandwidth = $hCommon->getModuleOption('bandwidth');
        //
        $video = new self();
        $video->setFile($file);
        $video->setBitrate($bandwidth * 1024);
        $video->enableThrottle(1 == $hCommon->getModuleOption('Enablebandwidth'));
        $video->streamVideo($position);
    }
}
