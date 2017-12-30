<?php namespace Xoopsmodules\xasset;

use Xoopsmodules\xasset;


/**
 * Class ApplicationProductHandler
 */
class ApplicationProductHandler extends xasset\BaseObjectHandler
{
    //vars
    public $_db;
    public $classname = ApplicationProduct::class;
    public $_dbtable  = 'xasset_app_product';

    //cons

    /**
     * @param $db
     * @return ApplicationProductHandler
     */
    public function __construct(\XoopsDatabase $db)
    {
        $this->_db = $db;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $db
     *
     * @return ApplicationProductsHandler
     */
    public function getInstance(\XoopsDatabase $db)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($db);
        }

        return $instance;
    }

    ///////////////////////////////////////////////////

    /**
     * @param      $appid
     * @param null $currid
     * @param bool $force
     *
     * @return array
     */
    public function getAppProductArray($appid, $currid = null, $force = false)
    {
        $crit = new \CriteriaCompo(new \Criteria('application_id', $appid));
        //
        if (!$force) {
            $crit->add(new \Criteria('ap.enabled', 1));
        }
        $crit->setSort('display_order');

        //
        return $this->getProductArray($crit, $currid);
    }

    ///////////////////////////////////////////////////

    /**
     * @param      $criteria
     * @param null $currid
     *
     * @return array
     */
    public function getProductArray($criteria, $currid = null)
    {
        global $imagearray;
        //
        $hApp      = new xasset\ApplicationHandler($GLOBALS['xoopsDB']);
        $hClass    = new xasset\TaxClassHandler($GLOBALS['xoopsDB']);
        $hCurrency = new xasset\CurrencyHandler($GLOBALS['xoopsDB']);
        //
        $thisTable  = $this->_db->prefix($this->_dbtable);
        $classTable = $this->_db->prefix($hClass->_dbtable);
        $appTable   = $this->_db->prefix($hApp->_dbtable);
        $currTable  = $this->_db->prefix($hCurrency->_dbtable);
        //
        if (isset($currid)) {
            $crit = new \Criteria('id', $currid);
            $curs = $hCurrency->getObjects($crit);
        } else {
            $curs = $hCurrency->getObjects();
        }
        //
        $sql = "select ap.*, a.name application_name, c.code tax_code, cu.name currency_name, cu.value
                  from $thisTable ap inner join $appTable a on
                    ap.application_id   = a.id inner join $classTable c on
                    ap.tax_class_id     = c.id inner join $currTable cu on
                    ap.base_currency_id = cu.id";
        $this->postProcessSQL($sql, $criteria);
        //
        $ary = [];
        //
        if ($res = $this->_db->query($sql)) {
            $i        = 0;
            $hPackage = new xasset\PackageHandler($GLOBALS['xoopsDB']);
            //
            $crypt = new xasset\Crypt();
            $obj   = $this->create();
            //
            while ($row = $this->_db->fetcharray($res)) {
                $actions = '<a href="main.php?op=editAppProduct&id=' . $row['id'] . '">' . $imagearray['editimg'] . '</a>' . '<a href="main.php?op=deleteAppProduct&id=' . $row['id'] . '">' . $imagearray['deleteimg'] . '</a>';
                //
                $priceAry = [];
                //
                foreach ($curs as $cur) {
                    $priceAry[] = [
                        'currency_id' => $cur->getVar('id'),
                        'baseUnit'    => $row['unit_price'],
                        'curUnit'     => $cur->getVar('value') * ($row['unit_price'] / $row['value']),
                        'fmtUnit'     => $cur->valueFormat($row['unit_price'] / $row['value'])
                    ];
                }
                //
                $ary[$i]                = $row;
                $ary[$i]['prices']      = $priceAry;
                $ary[$i]['expiresDate'] = formatTimestamp($row['expires'], 's');
                $ary[$i]['key']         = $crypt->cryptValue($row['id'], $obj->weight);
                $ary[$i]['actions']     = $actions;
                $ary[$i]['appSamples']  = $hPackage->getGroupPackagesArray($row['sample_package_group_id']);
                //
                ++$i;
                //
                unset($priceAry);
            }
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $body
     * @param $oApp
     *
     * @return mixed
     */
    public function parseTokens($body, $oApp)
    {
        if (preg_match_all('/{TAG.(.*?)}/', $body, $matches)) {
            //matchs will be of form {TAG.app.BUY(option)
            foreach ($matches[1] as $key => $match) {
                //check for BUY tag
                $replace = $matches[0][$key];
                if (!(false === strpos($match, '.BUY'))) {
                    if (preg_match('/(.*).BUY\[(.*)\]/', $match, $buy)) {
                        //here we have a buy with a pointer to a buy now image BUY[http://image...]
                        $oAppProd =& $this->getProductByCode($buy[1], $oApp->ID());
                        $image    = $buy[2];
                    } elseif (preg_match('/(.*).BUY/', $match, $buy)) {
                        //here were only have app.BUY
                        $oAppProd =& $this->getProductByCode($buy[1], $oApp->ID());
                        $image    = 'assets/images/buyNow.png';
                    }
                    if (is_object($oAppProd)) {
                        //construct button
                        $button = $oAppProd->getBuyNowButton($image);
                        //finally replace
                        $body = str_replace($replace, $button, $body);
                    }
                }
                //matches will be of form {TAG.app.PRICE}
                if (!(false === strpos($match, '.PRICE'))) {
                    if (preg_match('/(.*).PRICE/', $match, $buy)) {
                        $oAppProd =& $this->getProductByCode($buy[1], $oApp->ID());
                        $price    = $oAppProd->getPrice('l');
                        //
                        $body = str_replace($replace, $price, $body);
                    }
                }
                //matches will be of form {TAG.app.DESC}
                if (!(false === strpos($match, '.DESC'))) {
                    if (preg_match('/(.*).DESC/', $match, $buy)) {
                        $oAppProd =& $this->getProductByCode($buy[1], $oApp->ID());
                        $desc     = $oAppProd->getRichDescription();
                        //
                        $body = str_replace($replace, $desc, $body);
                    }
                }

                //matches will be of form {TAG.app.VIDEO}
                if (!(false === strpos($match, '.VIDEO'))) {
                    if (preg_match('/(.*).VIDEO\[(.*)\]/', $match, $buy)) {
                        //here we have a buy with a pointer to a buy now image BUY[http://image...]
                        $oAppProd =& $this->getProductByCode($buy[1], $oApp->ID());
                        $video    = $buy[2];
                    } elseif (preg_match('/(.*).VIDEO/', $match, $buy)) {
                        //here were only have app.BUY
                        $oAppProd =& $this->getProductByCode($buy[1], $oApp->ID());
                        $video    = null;
                    }
                    if (is_object($oAppProd)) {
                        //$hPackage = xoops_getModuleHandler('package','xasset');
                        //
                        $player = $oAppProd->getVideoPlayer($video);
                        $body   = str_replace($replace, $player, $body);
                    }
                }
            }
        }

        return $body;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $pCode
     * @param $pAppID
     *
     * @return bool|mixed
     */
    public function &getProductByCode($pCode, $pAppID)
    {
        $crit = new \CriteriaCompo(new \Criteria('application_id', $pAppID));
        $crit->add(new \Criteria('item_code', $pCode));
        //
        $aObjs = $this->getObjects($crit);
        //
        if (count($aObjs) > 0) {
            $obj = reset($aObjs);

            return $obj;
        } else {
            $obj = false;

            return $obj;
        }
    }

    ///////////////////////////////////////////////////

    /**
     * @param $crit
     *
     * @return array
     */
    public function &getApplicationProductObjectsByOrderDetail($crit)
    {
        //first get prod_ids
        $hOrderDetail = new xasset\OrderDetailHandler($GLOBALS['xoopsDB']);
        $aDetails     = $hOrderDetail->getObjects($crit);
        $crit         = new \CriteriaCompo();
        //
        foreach ($aDetails as $key => $oDetail) {
            $crit->add(new \Criteria('id', $oDetail->getAppProdID()));
        }
        //now get products
        $aProds = $this->getObjects($crit, true);
        //index by orderDetail
        $ary = [];
        foreach ($aDetails as $key => $oDetail) {
            $ary[$oDetail->ID()] = $aProds[$oDetail->getAppProdID()];
        }

        return $ary;
    }

    ///////////////////////////////////////////////////

    /**
     * @param $terms
     * @param $andor
     * @param $limit
     * @param $offset
     * @param $userid
     *
     * @return array
     */
    public function &searchApplicationProduct($terms, $andor, $limit, $offset, $userid)
    {
        $thisTable = $this->tableName();
        $ret       = null;
        //
        $sql  = "select * from $thisTable";
        $crit = new \CriteriaCompo();
        //
        if (isset($userid) && ($userid > 0)) {
            return $ret;
        }

        foreach ($terms as $key => $term) {
            $sub = new \CriteriaCompo();
            $sub->add(new \Criteria('item_description', "%$term%", 'like'));
            $sub->add(new \Criteria('item_rich_description', "%$term%", 'like'), 'or');

            $crit->add($sub, $andor);
        }
        $this->postProcessSQL($sql, $crit);
        $objs =& $this->sqlToArray($sql, true, $limit, $offset);

        //
        return $objs;
    }

    ///////////////////////////////////////////////////

    /**
     * @param object|XoopsObject $obj
     * @param bool               $force
     * @return bool
     */
    public function insert(\XoopsObject $obj, $force = false)
    {
        parent::insert($obj, $force);
        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        // Create query for DB update
        if ($obj->isNew()) {
            // Determine next auto-gen ID for table
            $id  = $this->_db->genId($this->_db->prefix($this->_dbtable) . '_uid_seq');
            $sql = sprintf(
                'INSERT INTO %s (id, application_id, tax_class_id, display_order, base_currency_id, package_group_id,
                                      sample_package_group_id, item_code,
                                      item_description, unit_price, old_unit_price, min_unit_count, max_access, max_days, expires, add_to_group,
                                      add_to_group2, item_rich_description, enabled, group_expire_date, group_expire_date2, extra_instructions)
                                      VALUES (%u, %u, %u, %u, %u, %u, %u, %s, %s, %f, %f, %u, %u, %u, %u, %u, %u, %s, %u, %u, %u, %s)',
                $this->_db->prefix($this->_dbtable),
                $id,
                $application_id,
                $tax_class_id,
                $display_order,
                $base_currency_id,
                $package_group_id,
                $sample_package_group_id,
                           $this->_db->quoteString($item_code),
                $this->_db->quoteString($item_description),
                $unit_price,
                $old_unit_price,
                $min_unit_count,
                $max_access,
                $max_days,
                $expires,
                $add_to_group,
                $add_to_group2,
                $this->_db->quoteString($item_rich_description),
                $enabled,
                $group_expire_date,
                           $group_expire_date2,
                $this->_db->quoteString($extra_instructions)
            );
        } else {
            $sql = sprintf(
                'UPDATE %s SET application_id = %u, tax_class_id = %u, display_order = %u, base_currency_id = %u,
                                        package_group_id = %u, sample_package_group_id = %u, item_code = %s, item_description = %s, unit_price = %f, old_unit_price = %f,
                                        min_unit_count = %u, max_access = %u, max_days = %u, expires = %u, add_to_group = %u, add_to_group2 = %u,
                                        item_rich_description = %s, enabled = %u, group_expire_date = %u, group_expire_date2 = %u, extra_instructions = %s WHERE id = %u',
                $this->_db->prefix($this->_dbtable),
                $application_id,
                $tax_class_id,
                $display_order,
                $base_currency_id,
                $package_group_id,
                           $sample_package_group_id,
                $this->_db->quoteString($item_code),
                $this->_db->quoteString($item_description),
                $unit_price,
                $old_unit_price,
                $min_unit_count,
                $max_access,
                $max_days,
                $expires,
                $add_to_group,
                $add_to_group2,
                $this->_db->quoteString($item_rich_description),
                           $enabled,
                $group_expire_date,
                $group_expire_date2,
                $this->_db->quoteString($extra_instructions),
                $id
            );
        }
        //echo $sql;
        // Update DB
        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            echo $sql;

            return false;
        }
        //Make sure auto-gen ID is stored correctly in object
        if (empty($id)) {
            $id = $this->_db->getInsertId();
        }
        $obj->assignVar('id', $id);

        //
        return true;
    }
}
