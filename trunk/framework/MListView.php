<?php

class MListView extends MList
{

    private $form;
    private $menu;
    
    public function __construct()
    {
        parent::__construct(get_called_class());
    }

    public function show()
    {
        if ($this->form)
        {
            if($this->form)
            {
                //echo '<div> Busca Avançada </div>';
                //echo '<div class="advanced-search">';
                $this->form->show();
                //echo '</div>';
            }
            if($this->menu)
                $this->menu->show();

            parent::setGridId($this->form->getDivTarget());
            echo '<div class="list" >';
            parent::showGrid();
            echo '</div>';
        }
    }

    public function setForm($form)
    {
        $this->form = $form;
    }
        
    public function getForm()
    {
        return $this->form;        
    }
    
    public function setMenu($menu)
    {        
        $this->menu = $menu;
    }

}

?>
