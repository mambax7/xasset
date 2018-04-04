<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;

/**
 * class UserDetails
 */
class UserDetails extends Xasset\BaseObject
{
    /**
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('zone_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('country_id', XOBJ_DTYPE_INT, null, true, null, '', 'Country');
        $this->initVar('first_name', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('last_name', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('street_address1', XOBJ_DTYPE_TXTBOX, null, true, 200, '', 'Street Address');
        $this->initVar('street_address2', XOBJ_DTYPE_TXTBOX, null, false, 200);
        $this->initVar('town', XOBJ_DTYPE_TXTBOX, null, true, 30, '', 'Town/City');
        $this->initVar('state', XOBJ_DTYPE_TXTBOX, null, true, 30, '', 'State/County');
        $this->initVar('zip', XOBJ_DTYPE_TXTBOX, null, true, 20, '', 'Post/Zip Code');
        $this->initVar('tel_no', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('fax_no', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('company_name', XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('company_reg', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('vat_no', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('credits', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('client_type', XOBJ_DTYPE_INT, 0, false);
        //
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    //////////////////////////////////////

    /**
     * @return bool|void
     */
    public function &getZone()
    {
        $zone = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);

        return $zone->get($this->getVar('zone_id'));
    }

    //////////////////////////////////////

    /**
     * @return mixed
     */
    public function uid()
    {
        return $this->getVar('uid');
    }

    //////////////////////////////////////

    /**
     * @return XoopsObject
     */
    public function &getUser()
    {
        $hUser = xoops_getHandler('user');

        return $hUser->get($this->uid());
    }

    //////////////////////////////////////

    /**
     * @return mixed
     */
    public function email()
    {
        $oUser =& $this->getUser();

        return $oUser->email();
    }

    //////////////////////////////////////

    /**
     * @return array
     */
    public function &addressArray()
    {
        $address = [];
        if ('' <> $this->getVar('street_address1')) {
            $address[] = $this->getVar('street_address1');
        }
        if ('' <> $this->getVar('street_address2')) {
            $address[] = $this->getVar('street_address2');
        }
        if ('' <> $this->getVar('town')) {
            $address[] = $this->getVar('town');
        }
        if ('' <> $this->getVar('state')) {
            $address[] = $this->getVar('state');
        }
        if ('' <> $this->getVar('zip')) {
            $address[] = $this->getVar('zip');
        }
        if ('' <> $this->getVar('tel_no')) {
            $address[] = $this->getVar('tel_no');
        }
        if ('' <> $this->getVar('fax_no')) {
            $address[] = $this->getVar('fax_no');
        }

        //
        return $address;
    }

    //////////////////////////////////////

    /**
     * @param int $credits
     */
    public function addCredits($credits = 0)
    {
        $handler = new Xasset\UserDetailsHandler($GLOBALS['xoopsDB']);
        //
        $this->setVar('credits', $this->getVar('credits') + $credits);
        $handler->insert($this, true);
    }

    //////////////////////////////////////

    /**
     * @param $groupid
     */
    public function addUserToGroup($groupid)
    {
        $hMember = xoops_getHandler('member');
        //
        $aGroups  = $hMember->getGroupsByUser($this->getVar('uid'));
        $aGroups1 = [];
        //
        foreach ($aGroups as $key => $group) {
            $aGroups1[$group] = 1;
        }
        //
        if (!isset($aGroups[$groupid])) { //echo $groupid .'.'.$this->getVar('uid');
            $hMember->addUserToGroup($groupid, $this->getVar('uid'));
        }
    }

    //////////////////////////////////////

    /**
     * @return mixed
     */
    public function &getUserDownloads()
    {
        $hOrder = new Xasset\OrderHandler($GLOBALS['xoopsDB']);

        //
        return $hOrder->getUserDownloads($this->ID());
    }

    //////////////////////////////////////

    /**
     * @param $pPackageID
     * @param $pError
     *
     * @return bool
     */
    public function canDownloadPackage($pPackageID, &$pError)
    {
        $hPackStats = new Xasset\UserPackageStatsHandler($GLOBALS['xoopsDB']);
        $hThis      = new Xasset\OrderHandler($GLOBALS['xoopsDB']);
        //
        $result    = false;
        $aPackages = $hThis->getUserDownloads($this->ID());
        foreach ($aPackages as $aPackage) {
            if ($aPackage['packageID'] == $pPackageID) {
                if (5 == $aPackage['status']) {
                    $result = true;
                    if ($aPackage['max_days'] > 0) {
                        $firstDowned = $hPackStats->getFirstDownloadDate($pPackageID, $this->getVar('uid'));
                        if (($firstDowned + $aPackage['max_days'] * 60 * 60 * 24) < time()) {
                            $result = true;
                        } else {
                            $pError = 'Download period has expired.';
                            $result = false;
                        }
                    }
                    if ($aPackage['max_access'] > 0) {
                        $downed = $hPackStats->getUserPackageDownloadCount($pPackageID, $this->getVar('uid'));
                        if ($downed < $aPackage['max_access']) {
                            $result = true;
                        } else {
                            $pError = 'Maximum download count exceeded.';
                            $result = false;
                        }
                    }
                }
            }
        }
        //if we get here then client has no access.
        if (!$result) {
            $pError = 'Un-autorised access attempt.';
        }

        //
        return $result;
    }
}
