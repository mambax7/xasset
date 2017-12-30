<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;

/**
 * class Gateway
 */
class Gateway extends xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('code', XOBJ_DTYPE_TXTBOX, null, false, 20);
        $this->initVar('enabled', XOBJ_DTYPE_INT, 1, false);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getDetails()
    {
        $hgDetail = new xasset\GatewayDetailHandler($GLOBALS['xoopsDB']);

        return $hgDetail->getByIndex($this->getVar('id'));
    }

    ///////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getDetailArray()
    {
        $hgDetail = new xasset\GatewayDetailHandler($GLOBALS['xoopsDB']);

        return $hgDetail->getConfigArrayByIndex($this->getVar('id'));
    }

    ///////////////////////////////////////////////////

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function saveConfigValue($key, $value)
    {
        $hGDetail = new xasset\GatewayDetailHandler($GLOBALS['xoopsDB']);

        return $hGDetail->saveConfigValue($this->getVar('id'), $key, $value);
    }

    ///////////////////////////////////////////////////

    /**
     * @param $values
     */
    public function toggleBinaryValues($values)
    {
        $hGDetail = new xasset\GatewayDetailHandler($GLOBALS['xoopsDB']);
        //
        $aDetail = $hGDetail->getBinaryConfigArrayByIndex($this->getVar('id'));
        //should have an array of binary fields... check if these exist in the post values array
        foreach ($aDetail as $detail) {
            if (isset($values[$detail['gkey']])) {
                $hGDetail->saveConfigValue($this->getVar('id'), $detail['gkey'], true);
            } else {
                $hGDetail->saveConfigValue($this->getVar('id'), $detail['gkey'], false);
            }
        }
    }
}
