<?php

class MListControl extends MList
{

    private $postFilters;
    private $listView;
    
    public function __construct()
    {
        parent::__construct(get_called_class());
        $this->listView = parent::getListView();
        $this->postFilters = $this->getFiltersFromPost();       
        //dbug($this->listView);
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

    public function edit()
    {
        // passar por parametro para o mformview os values        
    }

    public function delete($id)
    {
        
    }

}

?>
