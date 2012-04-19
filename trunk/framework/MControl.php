<?php

class MControl
{

	private $sessionFormName;
	private $MCore = null;
	private $aObligatories;
	private $post;
	private $error;

	#FIXME como pegar a view ? de uma forma facil para checar automaticamente os campos
    public function __construct()
    {
		$this->MCore = MCore::getInstance();

		$debug = debug_backtrace();
        $callerClass = get_called_class();//$debug[1]['class'];
        $callerFunction = $debug[1]['function'];

		$this->sessionFormName = str_replace('Control', 'View', $callerClass).'::'.$callerFunction;

		$this->aObligatories = $this->MCore->getSession($this->sessionFormName);	
		$this->post = $this->getPost();
    }

    public function save()
    {
	dbug($debug);	
		if($this->validatePost())
		{
			// Grava no banco
		}
		else
		{
			$this->setError('Preecha todos os campos obrigatórios!');
			return false;
		}

		return true;				
    }
	
	public function getError()
	{
		return $this->error;
	}
	
	public function setError($error)
	{
		$this->error = $error;
	}

	public function validatePost()
	{
        if ($this->aObligatories)
        {
            foreach($this->aObligatories as $key=>$value)
            {
                if(!$this->post->{$key})
                {
                    return false;			
                }
            }
        }
		return true;
	}

	public function getPost()
	{
		return arrayToObject($_POST);
	}

	

}
