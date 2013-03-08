<?php

class MCheckBox extends MInput
{

    private $labelCheck;
    private $checked;
    private $aChecks;
    private $max;
    private $orientation;
  
    function __construct()
    {
        
    }

    function setOrientation($orientation)
    {
        $this->orientation = $orientation;
    }

    function setMaxChecked($max)
    {
        $this->max = $max;
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
        $classChecks = '';
        if($this->orientation == 'horizontal')
        {
            $classChecks = "class = 'check_horizontal'";
        }
        else
        {
            $classChecks = "class = 'check_vertical'";
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
                $htmlCheckBox .= "<div {$classChecks} > <input {$props} class='check_input' id='{$this->name}_{$cont}' {$check->property} name='{$this->name}[]' value='{$check->value}' type='checkbox'  $checked $props > <label style='width:auto; padding:2px;font-weight: normal; cursor:pointer;' class = 'check_label' for='{$this->name}_{$cont}'> {$check->label} </label> </div>";
            }
        }
        else
        {
            $htmlCheckBox = "<input id='{$this->name}' name='{$this->name}' value='{$this->value}' type='checkbox'  $checked $props >";
        }

        if($this->max)
        {
            $htmlCheckBox .= "  <script> 
                                    $(document).ready(function()
                                    {
                                        $('[name*=\"{$this->name}\"]').click(function()
                                        {   
                                            var cont_{$this->name} = 0;
                                            var para_{$this->name} = false;
                                            $('[name*=\"{$this->name}\"]').each(function()
                                            {
                                                if($(this).is(':checked'))
                                                {
                                                    cont_{$this->name}++;                        
                                                    if(cont_{$this->name} > {$this->max} && !para_{$this->name})
                                                    {
                                                        $(this).attr('checked', false);
                                                        para_{$this->name} = true;
                                                    }                        
                                                }
                                            });
                                        });
                                    });

                                </script>  ";

        }
        //$htmlCheckBox .= "<label for='{$this->name}'> {$this->labelCheck} </label>";
        return $htmlCheckBox;
    }

}

?>
