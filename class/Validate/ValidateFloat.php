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
 * @author       XOOPS Development Team
 * @package      xAsset
 */



/**
 * Class ValidateFloat
 */
class ValidateFloat extends Validator
{
    /**
     * Private
     * $text the string to validate
     */
    public $text;

    public $forceentry;

    //! A constructor.

    /**
     * Constructs a new ValidateFloat object subclass or Validator
     * @param      $text
     * @param bool $forceentry
     */
    public function __construct($text, $forceentry = false)
    {
        $this->text       = $text;
        $this->forceentry = $forceentry;
        parent::__construct();
    }

    //! A manipulator

    /**
     * Validates a float number
     *
     * @return void
     */
    public function validate()
    {
        if (!is_float($this->text) && (strlen($this->text) > 0 && !$this->forceentry)) {
            $this->setError(_XHELP_MESSAGE_NOT_FLOAT);
        }
    }
}
