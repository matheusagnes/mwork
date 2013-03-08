<?php

class MCombo extends MInput
{

    private static $includes = false;
    private $items;
    private $click;
    private $selected;
    private $multiple;
    private $selecione = true;
    private $search = false;

    public function __construct($itens = null)
    {
        $this->selecione = true;
        parent::__construct();
        if ($itens)
            $this->addItens($itens);
    }

    function setSelecione($selecione)
    {
        $this->selecione = $selecione;
    }

    public function setSearch($search)
    {
        $this->search = $search;
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
        if(!$this->id)
            $this->id = $this->name;
        
        parent::show(); //talvez nem precisara moastrar o show..        
        $add = '';
        if ($this->properties)
        {
            foreach ($this->properties as $name => $value)
            {
                $add .= ''.$name.'="'.$value.'"';
            }
        }

        if ($this->getObligatory())
        {
            $required = "obligatory=\"1\"";             
        }

        if (!$this->multiple)
        {                        
            if(!$add)
                $add = " style='width:90%'";
            $htmlCombo = "<select name='{$this->name}' {$required} id='{$this->id}' $add >";
        }
        else
        {
            $htmlCombo = "
                <script type='text/javascript'>                    
                    $(document).ready(function() { $('#{$this->name}').select2({allowClear: true}); });                    
                </script>";
            
            $htmlCombo .= "<select name='{$this->name}[]'  multiple='multiple' {$required}' id='{$this->id}'   $add >";
        }    
        if(!$this->multiple && $this->selecione)
             $htmlCombo .= "<option value=\"0\">  Selecione </option>";

        if ($this->items)
        {
            
            if (is_array($this->value))
            {                            
                foreach ($this->value as $k => $v)
                {        
                    foreach ($this->items as $key => $item)
                    {                    
                        if($k == $key)
                        {
                            $htmlCombo .= "<option selected = 'selected' $text value=\"$key\">$item</option>";
                            unset($this->items[$key]);
                        }
                    }
                }
            }

            foreach ($this->items as $key => $item)
            {
                $text = '';
                
                
                    if ($this->selected && $this->selected == $key || $this->value && $this->value == $key)
                    {
                        $text = "selected = 'selected' ";
                    }
                
                $htmlCombo .= "<option $text value=\"$key\">$item</option>";
            }
            
        }
        $htmlCombo .= "</select>";
        if (!$this->multiple && $this->search) 
        $htmlCombo .= 
                "
                    <script>
                        $(document).ready(function() { $('select').select2(); });
                    </script>

                ";
        return $htmlCombo;
    }

}
?>

