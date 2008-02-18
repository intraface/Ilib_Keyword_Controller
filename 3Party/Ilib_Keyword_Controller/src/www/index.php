<?php
require_once 'config.local.php';

set_include_path(PATH_INCLUDE);

require_once 'k.php';;

class vih_ClassLoader extends k_ClassLoader
{
    static function autoload($classname)
    {
        $filename = str_replace('_', '/', $classname).'.php';
        if (self::SearchIncludePath($filename)) {
            require_once($filename);
        }
    }
}
spl_autoload_register(Array('vih_ClassLoader', 'autoload'));



class Root extends k_Dispatcher
{
    public $debug = TRUE;
    public $map = Array(
        'keyword' => 'Intraface_Keyword_Controller_Index',
    );

    function execute() {
        return $this->forward('keyword');
    }
}


//////////////////////////////////////////////////////////////////////////////
$application = new Root();
$application->dispatch();

