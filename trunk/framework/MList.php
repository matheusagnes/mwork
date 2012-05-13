<?php

class MList extends MGrid
{

    private $MCore;
    private $listId;

    public function __construct($listId)
    {
        parent::__construct();
        $this->MCore = MCore::getInstance();
        
        if(strpos($listId, 'Control') === true)
        {
            $listControlName = $listId;
        }
        else
        {
            $listControlName =  str_replace('View', 'Control', $listId);         
        }

        $listViewName = str_replace('Control', 'View', $listControlName);        
        $formViewName = str_replace('List', 'Form', $listViewName);
        $formControlName = str_replace('View', 'Control', $formViewName);
        parent::setListControlName($listControlName);
        parent::setListViewName($listViewName);       
        parent::setFormControlName($formControlName);
        parent::setFormViewName($formViewName);        
        $this->setModel(str_replace('ListControl','',$listControlName));        
        $this->listId = $listId;
        
        
        $this->MCore->setList($this);
    }
    
    public function getListId()
    {
        return $this->listId;
    }
    
    public function getListView()
    {   
        $listView = $this->MCore->getList(str_replace('Control', 'View', $this->listId));
        // para testes, pois ao modificar nao muda pois ja esta na sessao
        //if(!$listView)
        {
            $viewName = str_replace('Control', 'View', $this->listId);
            return new $viewName();        
        }
        return $listView;
    }    

    public function getFormView($params = null)
    {
        return $this->MCore->getForm(parent::getFormViewName(),$params);    
    }
    
    public function setModel($modelName)
    {        
        $this->model = $this->MCore->getModel($modelName);
        parent::setModel($this->model);
    }
}

?>
