<?php

class MCombo extends MInput
{
    private static $includes = false;
    private $items; 
    private $click;
    private $selected;


    public function __construct($itens = null)
    {
        parent::__construct();
        if($itens)
            $this->addItens($itens);
    }


    function addItem($index, $label )
    {
        $this->items[$index] = $label;
    }
    
    function addItens($itens)
    {
        foreach ($itens as $key=>$item)
        {            
            $this->addItem($key, $item);            
        }
    }

    function delItem($index)
    {
        unset( $this->items[$index] );
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
            $add='';
            if ($this->properties)
            {
                foreach($this->properties as $name => $value)
                {
                    $add .= " $name='$value'";
                }
            }

	    	if($this->getObligatory())
        	{
            		//$required = "class=\"validate['required']\"";             
        	}          
            
            $htmlCombo = "<select name='{$this->name}'  {$required}' id='{$this->id}'   $add >";
            
            $htmlCombo .= "<option value=\"0\">  Selecione </option>";
            
            if ($this->items)
            {                
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
            return $htmlCombo;                        
    }
}
?>

