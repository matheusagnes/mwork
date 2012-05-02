<?php

class MListControl extends MList
{

    private $postFilters;
    private $listView;
    private $table;
    
    public function __construct()
    {   
        parent::__construct(get_called_class());

        $this->listView = parent::getListView();
        $this->postFilters = $this->getFiltersFromPost();       

        
        $this->setTable(glue_upper(str_replace('ListControl','',parent::getListControlName()),'_'));    
    }
    
    
    public function getFiltersFromPost()
    {        
        $objFilter = arrayToObject($_POST);
        $this->listView->setFilter($objFilter);
        return $objFilter;
    }
  
    public function search()
    {        
        $this->listView->showGrid();
    }

    public function edit($id)
    {
        // passar por parametro para o mformview os values
        $objs = DB::getObjects("SELECT * FROM {$this->table} WHERE id = {$id}");
       
        $formView = parent::getFormView();
        $formView->show();                    
    }

    public function delete($id)
    {
        if(DB::delete($id, $this->table))
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

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function show()
    {
        $this->listView->show();
    }

}

?>
