<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;
//require_once __DIR__ . '/video/video.php';

/**
 * Class Video
 */
class Video extends xasset\BaseObject
{
    /**
     * @param $file
     * @param $position
     */
    public function streamVideo($file, $position)
    {
        $hCommon = new xasset\CommonHandler($GLOBALS['xoopsDB']);
        //
        $bandwidth = $hCommon->getModuleOption('bandwidth');
        //
        $video = new Video();
        $video->setFile($file);
        $video->setBitrate($bandwidth * 1024);
        $video->enableThrottle(1 == $hCommon->getModuleOption('Enablebandwidth'));
        $video->streamVideo($position);
    }
}
