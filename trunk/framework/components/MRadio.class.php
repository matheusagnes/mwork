<?php

class MRadio extends MInput
{

    private $labelCheck;
    private $checked;
    private $aChecks;
    private $orientation;

  
    function __construct()
    {
        
    }

    function setOrientationGroup($orientation)
    {
        $this->orientation = $orientation;
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

    function addItem($value, $label, $checked = false,$properties = null)
    {
        $check = new stdClass();
        $check->value = $value;
        $check->label = $label;
        $check->checked = $checked;
        $check->properties = $properties;
        $this->aChecks[] = $check;
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

                if (count($check->properties) > 0)
                {
                    $props = '';
                    foreach ($check->properties as $key => $value)
                    {
                        $props .= ' ' . $key . '=\'' . $value . '\'';
                    }
                }                           
                
                $cont++;
                $htmlCheckBox .= " 
                <div class='container_radio'>
                    <input {$props} class='radio_input' id='{$this->name}_{$cont}' {$check->property} name='{$this->name}' value='{$check->value}' type='radio'  $checked $props > 
                    <label style='width:auto; padding:2px;font-weight: normal; cursor:pointer;' class = 'radio_label' for='{$this->name}_{$cont}'> {$check->label} </label> 
                </div>";
            }
        }
        else
        {
            $htmlCheckBox = "<input id='{$this->name}' name='{$this->name}' value='{$this->value}' type='radio'  $checked $props >";
        }
        //$htmlCheckBox .= "<label for='{$this->name}'> {$this->labelCheck} </label>";
        return $htmlCheckBox;
    }

}

?>
