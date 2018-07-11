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
 *  ValidatorPassword subclass of Validator
 *  Validates a password
 */
class ValidatePassword extends Validator
{
    /**
     * Private
     * $pass the password to validate
     */
    public $pass;

    /**
     * Private
     * $vpass the verification password to validate
     */
    public $vpass;

    //! A constructor.

    /**
     * Constructs a new ValidatePassword object subclass or Validator
     *
     * @param string $pass string to validate
     * @param $vpass
     */
    public function __construct($pass, $vpass)
    {
        $this->pass  = $pass;
        $this->vpass = $vpass;
        parent::__construct();
    }

    //! A manipulator

    /**
     * Validates a password
     *
     * @return void
     */
    public function validate()
    {
        $hConfig         = xoops_getHandler('config');
        $xoopsConfigUser = $hConfig->getConfigsByCat(XOOPS_CONF_USER);

        if (null === $this->pass || '' == $this->pass || null === $this->vpass || '' == $this->vpass) {
            $this->setError(_XHELP_MESSAGE_NOT_SUPPLIED);
            //$stop .= _US_ENTERPWD.'<br>';
        }
        if (null !== $this->pass && ($this->pass != $this->vpass)) {
            $this->setError(_XHELP_MESSAGE_NOT_SAME);
        //$stop .= _US_PASSNOTSAME.'<br>';
        } elseif (('' != $this->pass) && (strlen($this->pass) < $xoopsConfigUser['minpass'])) {
            $this->setError(sprintf(_XHELP_MESSAGE_SHORT, $xoopsConfigUser['minpass']));
            //$stop .= sprintf(_US_PWDTOOSHORT,$xoopsConfigUser['minpass'])."<br>";
        }
    }
}
