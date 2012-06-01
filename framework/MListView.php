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

            echo '<div class="content-list">';
             echo '<h1> Gerenciamento de Usuários </h1>';
            if($this->form)
            {
                echo '<button id="advanced-search-button"> Busca Avançada </button>';
                echo '<script> $("#advanced-search-button").button().click(function() {
                      $(".advanced-search").show();
                    });; </script>';
                echo '<div class="advanced-search">';
                $this->form->show();
                echo '</div>';
            }
            
            parent::setGridId($this->form->getDivTarget());           
            echo '<div class="list" >';
           
            parent::showGrid();
            echo '</div>';
            echo '</div>';
            
            if($this->menu)
            {  
                echo '<div class = "menu-list">'; 
                $this->menu->show();
                echo '</div>';
            }
            echo '<div class="clear"> </div>';
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
