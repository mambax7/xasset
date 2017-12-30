<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;

/**
 * Class Zone
 */
class Zone extends \XoopsObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('country_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('code', XOBJ_DTYPE_TXTBOX, null, false, 20);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 30);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getCountry()
    {
        $country = new xasset\CountryHandler($GLOBALS['xoopsDB']);

        return $country->get($this->getVar('countryid'));
    }
}
