<?php

class MControl
{
    private $MCore = null;
    protected $post;
    private $view;
    protected $model;
    private $getView;

    public function __construct($validate=true, $getView=true)
    {
        $this->MCore = MCore::getInstance();
        if($validate)
            if(!$this->MCore->isLoged()) #FIXME trocar para permissao apenas temporario
            {
                new Message('Você precisa estar logado!!', Message::ERROR, Message::DIALOG, 'Atenção');
                echo '<script> window.location.href = "index.php" </script>';
                die; #FIXME
            }        
        $this->post = $this->getPostObject();
        
        $controlName = get_called_class();

        $this->getView = $getView;
        
        if($getView)
        {
            $viewName = str_replace('Control', 'View', $controlName);
            $this->setView($viewName);
        }
        if(!$this->model)
            $this->setModel(str_replace('FormControl','',$controlName));  
    }
    
    public function setModel($model)
    {
        $this->model = $this->MCore->getModel($model);
    }

    public function getFormId()
    {
        return $this->view->getId();
    }

    public function save()
    {        
        if ($this->validatePost())
        {
            if ($this->model->rec($this->post))
            {
                new Message('Dados gravados com sucesso!');
                return;
            }
            else
            {
                new Message('Erro ao inserir os dados', Message::ERROR);
                return;
            }
        }
    }

    public function validatePost($formId = 'save', $alert_type = 'HIGHLIGHT')
    {
        $debug = debug_backtrace();
        $callerClass = get_called_class() == 'MControl' ? $debug[2]['class'] : get_called_class();
        $callerFunction = $debug[1]['function'] ? $formId : $debug[1]['function'];

        $sessionFormName = $callerClass . '::' . $callerFunction;
        $aObligatories = $this->MCore->getSession($sessionFormName);
        
        $missed_fields = '';
        if ($aObligatories)
        {
            foreach ($aObligatories as $key => $value)
            {
                if (!$this->post->{$key})
                {
                    $missed_fields .= '<br>- ' . $value;
                }
            }
        }

        if ($missed_fields)
        {
            new Message('Preencha todos os campos obrigatóros :' . $missed_fields, Message::WARNING, $alert_type,'Atenção');
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
        if($this->getView)
        {            
            if($view);
            $this->view = new $view();
        }
    }

    // Render the form
    public function show()
    {
        $this->view->show();
    }

}

?>
