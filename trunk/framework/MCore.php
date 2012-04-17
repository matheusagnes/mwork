<?php

class MCore
{
    public function __construct()
    {
        $this->init();
    }

    public static function init()
    {
        require_once 'include.php';
        require_once 'configs.php';
    }


}

?>
