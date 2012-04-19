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
		$this->post = $this->getPost();
    }

    public function save()
    {
		
		if($this->validatePost())
		{
			// Grava no banco
		}
		else
		{
			$this->setError('Preecha todos os campos obrigatórios!');
			echo 'Preencha todos os campos obrigatórios!'; 
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
		$debug = debug_backtrace();

        $callerClass = get_called_class() == 'MControl' ?  $debug[2]['class'] : get_called_class();
        $callerFunction = $debug[1]['function'] ? 'save' : $debug[1]['function'];

		$sessionFormName = $callerClass.'::'.$callerFunction;
		$aObligatories = $this->MCore->getSession($sessionFormName);
        if ($aObligatories)
        {
            foreach($aObligatories as $key=>$value)
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
