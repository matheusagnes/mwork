<?php

class MListView extends MList
{

    private $form;
    private $menu;
    private $name;
    
    public function __construct($name = null)
    {
        $this->name = $name;
        parent::__construct(get_called_class());
    }

    public function show()
    {
        if ($this->form)
        {

            echo '<div class="content-list" id = "content-list">';
             echo '<h1> '.$this->name.' </h1>';
            if($this->form)
            {
                echo '<button id="advanced-search-button"> Busca Avançada </button>';
                echo '<script> $("#advanced-search-button").button().click(function() {
                      if($(".advanced-search").css("display") == "none")
                      {
                          $(".advanced-search").slideDown();
                      }
                      else
                      {
                          $(".advanced-search").slideUp();
                      }
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
