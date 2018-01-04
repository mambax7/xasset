<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class GatewayLog
 */
class GatewayLog extends Xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('order_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('gateway_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('date', XOBJ_DTYPE_INT, null, false);
        $this->initVar('order_stage', XOBJ_DTYPE_INT, null, false);
        $this->initVar('log_text', XOBJ_DTYPE_TXTBOX, null, false, 50000);

        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getLogDate($format = 'l')
    {
        if ($this->getVar('date') > 0) {
            return formatTimestamp($this->date(''), $format);
        } else {
            return '';
        }
    }
}
