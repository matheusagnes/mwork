<?php

class MCore
{

    private $projectName;
    private $siteName;
    private static $instance;
    private static $configs;  
    private $frameworkDir;
    //private $mLists;

    public function __construct($new = true)
    {
        if ($new)
        {
            self::$instance = new MCore(false);
            $this->init();            
        }
    }
    
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    }
    
    public function getFrameworkDir()
    {
        return $this->frameworkDir;
    }
    
    public function setFrameworkDir($dir)
    {
        return $this->frameworkDir = $dir;
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
    
    public function getForm($formName, $params = null)
    {
        return new $formName($params);
    }
    
    public function getModel($model)
    {
        if(class_exists($model))
            return new $model();
        else return null;
    }
    
    public function getModelFromTable($table)
    {
        return $this->getModel(glue_first_upper($table, '_'));
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
    
    public function isLoged()
    {
        if($this->getSession('loged'))        
            return true;
        
        return false;
    }

    public function init()
    {
        require_once dirname( __FILE__ ).'/include.php';
//        if(!self::$configs)
//            self::$configs = require_once dirname( __FILE__ ).'/../configs.php';
        require_once dirname( __FILE__ ).'/lib/php/tools.php';
        require_once dirname( __FILE__ ).'/DB.php';
        require_once dirname( __FILE__ ).'/Model.php';
        require_once dirname( __FILE__ ).'/MView.php';
        if (!isset($_SESSION))
        {
                session_start();
        }
    }
    
    public function initConfigs()
    {
        $this->projectName = self::$configs['project_name'];
        $this->siteName = self::$configs['site_name'];
        $this->frameworkDir = self::$configs['framework_dir'];
    }
    
    public function setConfigs($filePath)
    {       
        self::$configs = require_once $filePath;        
        $this->initConfigs();
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

    public function sessionDestroy()
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
