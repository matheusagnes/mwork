<?php

class MList extends MGrid
{

    private $MCore;
    private $listId;

    public function __construct($listId)
    {
        parent::__construct();
   
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
        return $this->MCore->getList(str_replace('Control', 'View', $this->listId));
    }    
//    public function __destruct()
//    {
//        //$this->MCore->unsetSession($this->listId);
//        //dbug($_SESSION);echo 'asd';
//    }
   
}

?>
