<?php namespace XoopsModules\Xasset;

use XoopsModules\Xasset;
use XoopsModules\Xasset\xajax;

/**
 * Class Ajax
 */
class Ajax extends \XoopsModules\Xasset\xajax\xajax
{
    public function xprojectajax()
    {
        parent::xajax();
    }

    //////////////////////////////////////////////////

    /**
     * @param string $location
     *
     * @return string
     */
    public function getHeaderCode($location = 'class/xajax')
    {
        $cbScript = '<script type="text/javascript">
                  function addComboOption(selectId, txt, val)
                  {
                      var objOption = new Option(txt, val);
                      document.getElementById(selectId).options.add(objOption);
                  }
                  </script>';

        return parent::getJavascript($location) . $cbScript;
    }

    /////////////////////////////////////////////////

    /**
     * Registers a PHP function or method to be callable through xajax in your
     * Javascript. If you want to register a function, pass in the name of that
     * function. If you want to register a static class method, pass in an
     * array like so:
     * <kbd>array("myFunctionName", "myClass", "myMethod")</kbd>
     * For an object instance method, use an object variable for the second
     * array element (and in PHP 4 make sure you put an & before the variable
     * to pass the object by reference). Note: the function name is what you
     * call via Javascript, so it can be anything as long as it doesn't
     * conflict with any other registered function name.
     *
     * <i>Usage:</i> <kbd>$xajax->registerFunction("myFunction");</kbd>
     * or: <kbd>$xajax->registerFunction(array("myFunctionName", &$myObject, "myMethod"));</kbd>
     *
     * @param mixed  contains the function name or an object callback array
     * @param mixed  request type (XAJAX_GET/XAJAX_POST) that should be used
     *               for this function.  Defaults to XAJAX_POST.
     */
    public function registerFunction($function, $url = null)
    {
        if (isset($url)) {
            $this->sRequestURI = $url;
        }
        //
        parent::registerFunction($function, XAJAX_GET);
    }
}
