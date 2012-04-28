<?php

class MListView extends MGrid
{

    private $form;

    public function __construct()
    {
        $listViewName = get_called_class();
        $listControlName = str_replace('View', 'Control', $listViewName);
        $formViewName = str_replace('List', 'Form', $formControlName);
        $formControlName = str_replace('View', 'Control', $formViewName);
    }

    public function show()
    {
        if ($this->form)
        {
            $this->form->show();
            parent::getGrid($this->form->getDivTarget());
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
