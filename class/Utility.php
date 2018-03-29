<?php namespace XoopsModules\Xasset;

use Xmf\Request;
use XoopsModules\Xasset;
use XoopsModules\Xasset\Common;

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------
}
