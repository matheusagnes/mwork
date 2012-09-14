<?php

class MCheckBox extends MInput
{

    private $labelCheck;
    private $checked;
    private $aChecks;

  
    function __construct()
    {
        
    }

    
    function setLabelCheck($label)
    {
        $this->labelCheck = $label;
    }

    function setChecked($checked)
    {
        $this->checked = $checked;
    }
    // array com objChecks contendo value, label, property e checked
    function addChecks($aChecks)
    {
        $this->aChecks = $aChecks;
    }

 
    function show()
    {
        parent::show();

        if (count($this->properties) > 0)
        {
            $props = '';
            foreach ($this->properties as $key => $value)
            {
                $props .= ' ' . $key . '=\'' . $value . '\'';
            }
        }
       
        unset($checked);
        if ($this->checked)
        {
            $checked = " checked = '1' ";
        }
        
        if(!is_array($this->value))
        {         
            $this->value = 1;            
        }

        if($this->aChecks)
        {
            $cont = 0;
            foreach ($this->aChecks as $check) 
            {    
                $checked = '';                       
                if($check->checked || $this->value[$check->value])
                {
                    $checked = " checked = '1' ";
                }                                 
                
                $cont++;
                $htmlCheckBox .= "<div> <input class='check_input' id='{$this->name}_{$cont}' {$check->property} name='{$this->name}[]' value='{$check->value}' type='checkbox'  $checked $props > <label style='width:auto; padding:2px;font-weight: normal;' class = 'check_label' for='{$this->name}_{$cont}'> {$check->label} </label> </div>";
            }
        }
        else
        {
            $htmlCheckBox = "<input id='{$this->name}' name='{$this->name}' value='{$this->value}' type='checkbox'  $checked $props >";
        }
        //$htmlCheckBox .= "<label for='{$this->name}'> {$this->labelCheck} </label>";
        return $htmlCheckBox;
    }

}

?>
