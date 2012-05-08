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
        $viewName = str_replace('Control', 'View', $controlName);
        $this->setView($viewName);
    }

    public function getFormId()
    {
        return $this->view->getId();
    }

    public function save()
    {        
        if ($this->validatePost())
        {
            if (DB::rec($this->post, $this->getFormId()))
            {
                new Message('Dados gravados com sucesso!');
                return;
            }
            else
            {
                new Message('erro ao inserir os dados', Message::ERROR);
                return;
            }
        }
    }

    public function validatePost()
    {
        $debug = debug_backtrace();
        $callerClass = get_called_class() == 'MControl' ? $debug[2]['class'] : get_called_class();
        $callerFunction = $debug[1]['function'] ? 'save' : $debug[1]['function'];

        $sessionFormName = $callerClass . '::' . $callerFunction;
        $aObligatories = $this->MCore->getSession($sessionFormName);

        $missed_fields = '';
        if ($aObligatories)
        {
            foreach ($aObligatories as $key => $value)
            {
                if (!$this->post->{$key})
                {
                    $missed_fields .= '<br>- ' . $key;
                }
            }
        }

        if ($missed_fields)
        {
            new Message('Preencha todos os campos obrigatóros (javascript, voce devia ter validado isto.):' . $missed_fields, Message::WARNING);
            return false;
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
