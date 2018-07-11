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
 * Class ValidateMimeType
 */
class ValidateMimeType extends Validator
{
    public $file;
    public $mimetype;
    public $allowed_mimetypes;

    /**
     * @param $file
     * @param $mimetype
     * @param $allowed_mimetypes
     */
    public function __construct($file, $mimetype, $allowed_mimetypes)
    {
        $this->file              = $file;
        $this->mimetype          = $mimetype;
        $this->allowed_mimetypes = $allowed_mimetypes;
        parent::__construct();
    }

    public function validate()
    {
        $allowed_mimetypes = false;
        //Check MimeType
        if (is_array($this->allowed_mimetypes)) {
            foreach ($this->allowed_mimetypes as $mime) {
                if ($mime['type'] == $this->mimetype) {
                    $allowed_mimetypes = $mime['type'];
                    break;
                }
            }
        }

        if (!$allowed_mimetypes) {
            $this->setError('Invalid MimeType');
        }
    }
}
