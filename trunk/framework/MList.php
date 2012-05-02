<?php

class MList extends MGrid
{

    private $MCore;
    private $listId;

    public function __construct($listId)
    {
        parent::__construct();

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
   
        $this->listId = $listId;
        
        $this->MCore = MCore::getInstance();
        $this->MCore->setList($this);
    }
    
    public function getListId()
    {
        return $this->listId;
    }
    
    public function getListView()
    {   
        $listView = $this->MCore->getList(str_replace('Control', 'View', $this->listId));
        if(!$listView)
        {
            $viewName = str_replace('Control', 'View', $this->listId);
            return new $viewName();        
        }
        return $listView;
    }    

    public function getFormView()
    {
        return $this->MCore->getForm(parent::getFormViewName());    
    } 
}

?>
