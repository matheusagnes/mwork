<?php

class MListView extends MList
{

    private $form;

    public function __construct()
    {
        $listViewName = get_called_class();
        
        parent::__construct($listViewName);
        
        
        $listControlName = str_replace('View', 'Control', $listViewName);
        $formViewName = str_replace('List', 'Form', $formControlName);
        $formControlName = str_replace('View', 'Control', $formViewName);
    }

    public function show()
    {
        if ($this->form)
        {
            $this->form->show();
            parent::setGridId($this->form->getDivTarget());
            parent::showGrid();
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

}

?>
