<?php

class MListView extends MList
{

    private $form;

    public function __construct()
    {
        parent::__construct(get_called_class());
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
