<?php
class Intraface_Keyword_Controller_Index extends k_Controller
{
    public $map = array('connect' => 'Intraface_Keyword_Controller_Connect',
                        'edit'    => 'Intraface_Keyword_Controller_Edit');

    function GET()
    {
        return get_class($this) . ': intentionally left blank';
    }

    function forward($name)
    {
        if ($name == 'connect') {
            $next = new Intraface_Keyword_Controller_Connect($this, $name);
            return $next->handleRequest();
        } elseif ($name == 'edit') {
            $next = new Intraface_Keyword_Controller_Edit($this, $name);
            return $next->handleRequest();
        }
        parent::forward($name);
    }
}