<?php

class MListControl extends MList
{
    private $postFilters;
    private $listView;    
    private $MCore;
    
    public function __construct()
    {   
        $this->MCore = MCore::getInstance();
        
        if(!$this->MCore->isLoged()) #FIXME trocar para permissao apenas temporario
        {
            new Message('Você precisa estar logado!!', Message::ERROR, Message::DIALOG);
            echo '<script> window.location.href = "index.php" </script>';
            die; #FIXME
        }

        parent::__construct(get_called_class());        
        $this->listView = parent::getListView();
        $this->postFilters = $this->getFiltersFromPost();       
        
        
    }
    
    public function getFiltersFromPost()
    {        
        $objFilter = arrayToObject($_POST);
        $this->listView->setFilter($objFilter);
        return $objFilter;
    }
  
    public function search($fast_search = false)
    {        
        $this->listView->showGrid($fast_search);
    }

    public function edit($id)
    {
        // passar por parametro para o mformview os values
        $obj = $this->model->getObject($id);       
        $formView = parent::getFormView(array($id));
        $formView->setPost($obj);        
        $formView->show();                    
    }

    public function delete($id)
    {
        if($this->model->delete($id))
        {
            new Message('Deletado com Sucesso', Message::SUCCESS, Message::DIALOG);
            return true;
        }
        else
        {
            new Message('Erro', Message::ERROR, Message::DIALOG);
            return true;
        }            
    }

    

    public function show()
    {
        $this->listView->show();
    }

}

?>
