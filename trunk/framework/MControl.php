<?php

class MControl
{

    private $sessionFormName;
    private $MCore = null;
    private $aObligatories;
    private $post;
    private $error;
	private $view;

    #FIXME como pegar a view ? de uma forma facil para checar automaticamente os campos

    public function __construct()
    {
        $this->MCore = MCore::getInstance();
        $this->post = $this->getPostObject();
		
		$controlName = get_called_class();
		$viewName = str_replace('Control','View',$controlName);
		$this->setView($viewName);
    }

    public function save()
    {
        if ($this->validatePost())
        {
            #FIXME como a control vai saber para qual tabela deve gravar ??
            // Grava no banco
            echo 'Dados gravados com sucesso!';
            return true;
        }
        else
        {
            //$this->setError('Preecha todos os campos obrigatórios!');
            echo 'Preencha todos os campos obrigatórios!';
            return false;
        }
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
        $callerClass = get_called_class() == 'MControl' ? $debug[2]['class'] : get_called_class();
        $callerFunction = $debug[1]['function'] ? 'save' : $debug[1]['function'];

        $sessionFormName = $callerClass . '::' . $callerFunction;
        $aObligatories = $this->MCore->getSession($sessionFormName);

        if ($aObligatories)
        {
            foreach ($aObligatories as $key => $value)
            {
                if (!$this->post->{$key})
                {
                    return false;
                }
            }
        }
        return true;
    }

    public function getPostObject()
    {
        return arrayToObject($_POST);
    }

    public function getPost()
    {
        return $this->post;
    }

	// Sets the view
	public function setView($view)
	{
		$this->view = new $view();
	}

	// Render the form
	public function show()
	{
		$this->view->show();		
	}

}

?>