<?php

class MCore
{

	private $projectName;
	private static $instance;

    public function __construct($new = false)
    {
		if($new)
		{
			self::$instance = new MCore();
			$this->init();        
		}
    }

	public static function getInstance()
	{
		return self::$instance;
	}

    public function init()
    {
        require_once 'include.php';
        require_once 'configs.php';
        require_once 'lib/php/tools.php';

		$this->projectName = $mgProjectName;
		session_start();
    }

	public function setSession($position, $value)
	{
		$_SESSION[$this->projectName][$position] = $value;		
	}

	public function getSession($position = null)
	{
		if($position)
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


}

?>
