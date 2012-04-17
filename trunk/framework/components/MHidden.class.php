<?php


class MHidden extends MInput
{
    
    public function __construct($value=null, $name=null, $id=null,$maxlength=null)
    {
        parent::__construct();
        $this->maxlength = $maxlength;
        $this->value = $value;
        $this->name = $name;
        $this->id = $id;
        $this->mask = null;
        
    }



    public function show()
    {
        parent::show();
        
        if (count($this->properties) > 0)
        {
            
            foreach ($this->properties as $key => $value)
            {
//                if (strtolower(trim($key)) == 'style')
//                {
//                    $style = $value;
//                }
//                else
                //{
                    $add .= " $key='$value' ";
                //}
            }
        }

        if ($this->mask)
        {
            //echo '<script type="text/javascript" src="lib/js/mascaras.js"></script>';
            $OnKeyPress .= " onKeyPress=\"var e; if(!window.event){ e = event; }else{e = window.event};  return(formataCampo(this,'{$this->mask}',e))\" ";
        }
        if($this->maxlength)
        {
            $maxlength= "maxlength='{$this->maxlength}'";
        }
        
        if($this->disabled)
        {
            $disabled = "readonly = 'readonly'";
        }        
        
        if($this->getObligatory())
        {
            $required = "class=\"validate['required']\"";            
        }
        return "<input name='{$this->name}' $disabled id = '{$this->id}' $add  size='{$this->size}' value='{$this->value}' {$maxlength} type='hidden' $required  $OnKeyPress />";
       
    }


    public function setMaxLength($maxlength)
    {
        $this->maxlength = $maxlength;
    }


    public function setMask($mask)
    {
        $this->mask = $mask;
    }

}

?>
