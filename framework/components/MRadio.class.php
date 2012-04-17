<?php

class MRadio extends MInput
{

    private $vertical          = null;
    private $options           = null;
    private $helps             = null;
    private $propertiesOptions = null;


    function setVertical($vertical=true)
    {
        $this->vertical = $vertical;
    }
    
    function show()
    {
        parent::show();
        if (parent::getVisibility())
        {
            if ($this->options)
            {
                if (count($this->properties)>0)
                {
                    foreach($this->properties as $key => $value)
                    {
                        $add .= " $key='$value' ";
                    }
                }
                $id = 0;
                foreach ($this->options as $index => $label)
                {

                    // Prepara as propriedades de cada option
                    $addPropertyOption = '';
                    if (count($this->propertiesOptions[$index])>0)
                    {
                        foreach($this->propertiesOptions[$index] as $key => $value)
                        {
                            $addPropertyOption .= " $key='$value' ";
                        }
                    }

                    $label->addProperty('for',"{$this->name}_$id");
                    $text_label = $label->getValue();
                    // $checked = $this->value ? 'checked' : '';
                    $checked = $this->value == $index ? 'checked' : '';
                    echo "\n<input name='{$this->name}' id='{$this->name}_{$id}' text='{$text_label}' size='{$this->size}' title='{$this->helps[$index]}' alt='{$this->helps[$index]}' value='$index' type='radio' class='loginentry' $add $addPropertyOption $checked>";
                    $label->show();
                    if($this->vertical)
                        echo "<br>\n";
                    $id++;
                }
            }
        }
        else
        {
            $text_label = $this->options[$this->value]->getValue();
            echo "<input type=text size='{$this->size}' name='_n_{$this->name}' value='{$text_label}' readonly='1' class='field_style_disabled' />";
        }
    }

 
    function addItem($index, $label,$help = null, $properties = null)
    {
        if ( !is_object($label) )
        {
            $lblObj = new TLabel( $label );
        }
        elseif ( strtolower( get_class( $label ) ) != 'tlabel' )
        {
            $lblObj = new TLabel('');
        }
        else
        {
            $lblObj = $label;
        }
        $this->options[$index] = $lblObj;
        $this->helps[$index]   = $help;
        $this->propertiesOptions[$index] = $properties;

    }

    function addItems($items)
    {
        foreach( $items as $index => $label )
        {
            $this->addItem( $index, $label );
        }
    }
}
?>
