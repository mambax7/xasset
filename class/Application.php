<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * Class Application
 */
class Application extends Xasset\BaseObject
{
    /**
     * @var int
     */
    public $weight;

    //

    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false); // will store Xoops user id
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('platform', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('version', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('datePublished', XOBJ_DTYPE_INT, null, false, time());
        $this->initVar('requiresLicense', XOBJ_DTYPE_INT, null, false, 1);
        $this->initVar('listInEval', XOBJ_DTYPE_INT, null, false, 0);
        $this->initVar('hasSamples', XOBJ_DTYPE_INT, null, false, 0);
        $this->initVar('richDescription', XOBJ_DTYPE_TXTBOX, null, false, 64000);
        $this->initVar('mainMenu', XOBJ_DTYPE_INT, null, false, 0);
        $this->initVar('menuItem', XOBJ_DTYPE_TXTBOX, null, false, 20);
        $this->initVar('productsVisible', XOBJ_DTYPE_INT, 1, false, 0);
        $this->initVar('image', XOBJ_DTYPE_TXTBOX, null, false, 250);
        $this->initVar('product_list_template', XOBJ_DTYPE_TXTBOX, null, false, 64000);
        //
        $this->weight = 15;
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    ///////////////////////////////////////////////

    /**
     * @param string $format
     *
     * @return string
     */
    public function datePublished($format = 'l')
    {
        if ($this->getVar('datePublished') > 0) {
            return formatTimestamp($this->getVar('datePublished'), $format);
        } else {
            return '';
        }
    }

    ///////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->getVar('name');
    }

    ///////////////////////////////////////////////

    /**
     * @return bool
     */
    public function requiresLicense()
    {
        return 1 == $this->getVar('requiresLicense');
    }

    ///////////////////////////////////////////////

    /**
     * @return bool
     */
    public function listInEval()
    {
        return 1 == $this->getVar('listInEval');
    }

    ///////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function poductListTemplate()
    {
        return $this->getVar('product_list_template', 'n');
    }

    ///////////////////////////////////////////////

    /**
     * @return string
     */
    public function poductListPage()
    {
        global $xoopsTpl;
        //
        $template = $this->poductListTemplate();
        //
        $tpl = new \XoopsTpl();
        $tpl->assign($xoopsTpl->get_template_vars());

        //
        return $tpl->xoops_fetchFromData($template);
    }

    ///////////////////////////////////////////////

    /**
     * @param $uid
     *
     * @return array
     */
    public function getLicenses($uid)
    {
        $arr = [];
        //
        $id = (int)$this->getVar('id');
        if (!$id) {
            return $arr;
        }
        //
        if ($this->requiresLicense) {
            $hLicense = new Xasset\LicenseHandler($GLOBALS['xoopsDB']);
            //
            $crit = new \CriteriaCompo();
            $crit->add(new \Criteria('applicationid', $id));
            $crit->add(new \Criteria('uid', $uid));
            $crit->setSort('datePublished');
            //
            $arr = $hLicense->getObjects($crit);
        }

        //
        return $arr;
    }

    ///////////////////////////////////////////////

    /**
     * @return array
     */
    public function getPackageGroups()
    {
        $arr = [];
        //
        $id = (int)$this->getVar('id');
        if (!$id) {
            return $arr;
        }
        //
        $hpackGroups = new Xasset\PackageGroupHandler($GLOBALS['xoopsDB']);
        //
        $crit = new \CriteriaCompo(new \Criteria('applicationid', $id));
        $crit->setSort('datePublished');
        //
        $arr = $hpackGroups->getObjects($crit);

        //
        return $arr;
    }

    /**
     *
     */
    public function getLicenseCount()
    {
    }

    ///////////////////////////////////////////////

    /**
     *
     */
    public function getDownloadCount()
    {
    }

    ///////////////////////////////////////////////

    /**
     * @return string
     */
    public function getKey()
    {
        $crypt = new Xasset\Crypt();

        return $crypt->cryptValue($this->getVar('id'), $this->weight);
    }
}
