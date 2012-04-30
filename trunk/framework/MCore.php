<?php

class MCore
{

    private $projectName;
    private $siteName;
    private static $instance;
    private static $configs;
    //private $mLists;

    public function __construct($new = true)
    {
        if ($new)
        {
            self::$instance = new MCore(false);
            $this->init();
        }
    }
    
    public function setList($list)
    {   
        $this->setSession($list->getListId(), $list);
        //$this->mLists[$list->getListId()] = $list;
    }
    
    public function getList($listId)
    {   
        return $this->getSession($listId);
        //return $this->mLists[$listId];
    }

    public static function getInstance()
    {
        if (!self::$instance)
        {           
           self::$instance = new MCore();
        }
        return self::$instance;
    }
    
    private function getConfigs()
    {
        return self::$configs;
    }

    public function init()
    {
        require_once dirname( __FILE__ ).'/include.php';
        self::$configs = require_once dirname( __FILE__ ).'/configs.php';
        require_once dirname( __FILE__ ).'/lib/php/tools.php';
        require_once dirname( __FILE__ ).'/DB.php';

        $this->projectName = $this->configs['project_name'];
        $this->siteName = $this->configs['site_name'];
        session_start();
    }

    public function getProjectName()
    {
        return $this->projectName;
    }

    public function getSiteName()
    {
        return $this->siteName;
    }

    public function setSession($position, $value)
    {        
        $_SESSION[$this->projectName][$position] = $value;
    }

    public function getSession($position = null)
    {
        if ($position)
        {
            return $_SESSION[$this->projectName][$position];
        }
        else
        {
            return $_SESSION[$this->projectName];
        }
    }

    public function destroySession()
    {
        session_destroy();
    }

    public function unsetSession($position)
    {
        unset($_SESSION[$this->projectName][$position]);
    }
    
    /*
     * Passes on any static calls to this class onto the singleton PDO instance 
     * @param $chrMethod, $arrArguments 
     * @return $mix 
     */

    final public static function __callStatic($chrMethod, $arrArguments)
    {

        $objInstance = self::getInstance();

        return call_user_func_array(array($objInstance, $chrMethod), $arrArguments);
    }

}

?>