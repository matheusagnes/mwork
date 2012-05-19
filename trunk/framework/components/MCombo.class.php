<?php

class MCombo extends MInput
{

    private static $includes = false;
    private $items;
    private $click;
    private $selected;
    private $multiple;

    public function __construct($itens = null)
    {
        parent::__construct();
        if ($itens)
            $this->addItens($itens);
    }

    function setMultiple()
    {
        $this->multiple = true;
    }

    function addItem($index, $label)
    {
        $this->items[$index] = $label;
    }

    function addItens($itens)
    {
        foreach ($itens as $key => $item)
        {
            $this->addItem($key, $item);
        }
    }

    function delItem($index)
    {
        unset($this->items[$index]);
    }

    function setSelected($selected)
    {
        $this->selected = $selected;
    }

    function getSelected()
    {
        return $this->selected;
    }

    function show()
    {
        parent::show(); //talvez nem precisara moastrar o show..        
        $add = '';
        if ($this->properties)
        {
            foreach ($this->properties as $name => $value)
            {
                $add .= " $name='$value'";
            }
        }

        if ($this->getObligatory())
        {
            //$required = "class=\"validate['required']\"";             
        }

        if (!$this->multiple)
            $htmlCombo = "<select name='{$this->name}'  {$required}' id='{$this->id}'   $add >";
        else
            $htmlCombo = "<select name='{$this->name}[]' multiple='multiple' {$required}' id='{$this->id}'   $add >";

        $htmlCombo .= "<option value=\"0\">  Selecione </option>";

        if ($this->items)
        {
            
            $keysValue = array();
            if (is_array($this->value))
            {
                foreach ($this->value as $k => $v)
                {
                    $keysValue[$k] = $k; 
                }
            }
            foreach ($this->items as $key => $item)
            {
                $text = '';
                
                if ($keysValue)
                {
                    if ($keysValue[$key])
                    {
                        $text = "selected = 'selected' ";
                    }
                }
                else
                {
                    if ($this->selected && $this->selected == $key || $this->value && $this->value == $key)
                    {
                        $text = "selected = 'selected' ";
                    }
                }
                $htmlCombo .= "<option $text value=\"$key\">$item</option>";
            }
        }
        $htmlCombo .= "</select>";
        return $htmlCombo;
    }

}
?>

