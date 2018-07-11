<?php namespace XoopsModules\Xasset\Validate;

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


/**
 * Class ValidateImageSize
 */
class ValidateImageSize extends Validator
{
    public $file;
    public $maxwidth;
    public $maxheight;

    /**
     * @param $file
     * @param $maxwidth
     * @param $maxheight
     */
    public function __construct($file, $maxwidth, $maxheight)
    {
        $this->file      = $file;
        $this->maxwidth  = $maxwidth;
        $this->maxheight = $maxheight;
        parent::__construct();
    }

    public function validate()
    {
        list($width, $height) = getimagesize($this->file);
        if ($this->maxwidth < $width) {
            $this->setError('Image Width is too large');
        }
        if ($this->maxheight < $height) {
            $this->setError('Image Height is too large');
        }
    }
}
