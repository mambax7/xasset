<?php namespace XoopsModules\Xasset;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Nazar Aziz (www.panthersoftware.com)
 * @author       XOOPS Development Team
 * @package      xAsset
 */

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
