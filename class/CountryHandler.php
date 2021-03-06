<?php namespace XoopsModules\Xasset;

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

use XoopsModules\Xasset;

/**
 * class CountryHandler
 */
class CountryHandler extends Xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = Country::class;
    public $_dbtable  = 'xasset_country';

    //cons

    /**
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        $this->_db = $db;
    }

    ///////////////////////////////////////////////////

    /**
     * @param \XoopsDatabase $db
     *
     * @return Xasset\CountryHandler
     */
    public function getInstance(\XoopsDatabase $db = null)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($db);
        }

        return $instance;
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function getCountriesArray($criteria = null)
    {
        global $imagearray;
        //
        $objs = $this->getObjects($criteria);
        $ary  = [];
        //
        foreach ($objs as $obj) {
            $actions = '<a href="main.php?op=editCountry&id=' . $obj->getVar('id') . '">' . $imagearray['editimg'] . '</a>' . '<a href="main.php?op=deleteCountry&id=' . $obj->getVar('id') . '">' . $imagearray['deleteimg'] . '</a>';
            //
            $ary[] = [
                'id'      => $obj->getVar('id'),
                'name'    => $obj->getVar('name'),
                'iso2'    => $obj->getVar('iso2'),
                'iso3'    => $obj->getVar('iso3'),
                'actions' => $actions
            ];
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param null $criteria
     *
     * @return array
     */
    public function getCountriesSelect($criteria = null)
    {
        if (null === $criteria) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('name');
        }
        //
        $objs = $this->getObjects($criteria);
        //
        $ar = [];
        //
        foreach ($objs as $obj) {
            $ar[$obj->getVar('id')] = $obj->getVar('name');
        }

        return $ar;
    }

    ///////////////////////////////////////////////////

    /**
     * @param      $zoneField
     * @param      $countryField
     * @param bool $allZones
     *
     * @return bool|string
     */
    public function constructSelectJavascript($zoneField, $countryField, $allZones = true)
    {
        $hZone = new Xasset\ZoneHandler($GLOBALS['xoopsDB']);
        //
        $zones = $hZone->getCountryZones();
        $start = true;
        $first = true;
        //
        $func = "function update_zones(theForm) {
               var NumState = theForm.$zoneField.options.length;
               var SelectedCountry = '';

               while (NumState > 0) {
                 NumState--;
                 theForm.$zoneField.options[NumState] = null;
              }

              SelectedCountry = theForm.$countryField.options[theForm.$countryField.selectedIndex].value;\n";

        foreach ($zones as $country) {
            $countryid = $country['id'];
            //
            if ($start) {
                $func  .= "  if (SelectedCountry == '$countryid') {\n";
                $start = false;
            } else {
                $func .= "} elseif (SelectedCountry == '$countryid') {\n";
            }
            //
            if ($allZones) {
                $func .= "theForm.$zoneField.options[0] = new Option('All Zones', '0');\n";
            }
            //
            if (isset($country['zones'])) {
                $func .= "if (theForm.state != null) {theForm.zone_id.style.display  = 'block';}\n";
                $func .= "if (theForm.state != null) {theForm.state.style.display    = 'none';}\n\n";
                $allZones ? $cnt = 1 : $cnt = 0;
                //
                foreach ($country['zones'] as $zone) {
                    $zoneid = $zone['id'];
                    $zone   = $zone['name'];
                    //
                    $func .= "theForm.$zoneField.options[$cnt] = new Option('$zone', '$zoneid');\n";
                    //
                    ++$cnt;
                }
            } else {
                $func .= "if (theForm.state != null) {theForm.state.style.display   = 'block';}\n";
                $func .= "if (theForm.state != null) {theForm.zone_id.style.display = 'none';}\n";
            }
        }
        if (strlen($func) > 0) {
            $func .= '} }';

            return $func;
        }

        return false;
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|\XoopsObject $obj
     * @param bool               $force
     * @return bool
     */
    public function insert(\XoopsObject $obj, $force = false)
    {
        if (!parent::insert($obj, $force)) {
            return false;
        }
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        // Create query for DB update
        if ($obj->isNew()) {
            // Determine next auto-gen ID for table
            $id  = $this->_db->genId($this->_db->prefix($this->_dbtable) . '_uid_seq');
            $sql = sprintf('INSERT INTO `%s` (id, NAME, iso2, iso3)
                                      VALUES (%u, %s, %s, %s)', $this->_db->prefix($this->_dbtable), $id, $this->_db->quoteString($name), $this->_db->quoteString($iso2), $this->_db->quoteString($iso3));
        } else {
            $sql = sprintf('UPDATE `%s` SET NAME = %s, iso2 = %s, iso3 = %s WHERE id = %u', $this->_db->prefix($this->_dbtable), $this->_db->quoteString($name), $this->_db->quoteString($iso2), $this->_db->quoteString($iso3), $id);
        }
        //echo $sql;
        // Update DB
        if (false !== $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            return false;
        }

        //Make sure auto-gen ID is stored correctly in object
        if (empty($id)) {
            $id = $this->_db->getInsertId();
        }
        $obj->assignVar('id', $id);

        return true;
    }
}
