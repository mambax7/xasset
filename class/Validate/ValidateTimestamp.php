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
 * Class ValidateTimestamp
 */
class ValidateTimestamp extends Validator
{
    /**
     * Private
     * $timestamp the date/time to validate
     */
    public $timestamp;

    //! A constructor.

    /**
     * Constructs a new ValidateTimestamp object subclass or Validator
     *
     * @param string $timestamp the string to validate
     */
    public function __construct($timestamp)
    {
        $this->timestamp = $timestamp;
        parent::__construct();
    }

    //! A manipulator

    /**
     * Validates a timestamp
     *
     * @return void
     */
    public function validate()
    {
    }
}
