<?php

class MForm
{

    private $fields;
    private $id; //Form id will be used in control to rec in DB
    private $buttons;
    private $formLegend;
    private $is_horizontal;
    private $urlTarget;
    private $divTarget;
    private $MCore = null;
    private $aObligatories;
    private $sessionFormName;
    private $controlName;
    private $tabs;
    private $tab;
    protected $properties;

    #FIXME trocar para content

    public function __construct($id, $legend, $is_horizontal = true, $urlTarget = null, $divTarget = '', $controlName = '')
    {
        
        // get mcore instance
        $this->MCore = MCore::getInstance();
        
        $this->setId($id);
        $this->setFormLegend($legend);
        $this->setControlName($controlName);

        // default value for urlTarget
        if (!$urlTarget)
        {
            if (!$controlName)
            {
                $viewName = get_called_class();
                $controlName = str_replace('View', 'Control', $viewName);
            }
            $this->sessionFormName = $controlName . '::save';
            $urlTarget = $controlName . '::save()';
        }
        else
        {
            // Remove all from (
            $this->sessionFormName = preg_replace('~\(.*~', '', $urlTarget);
        }

        $this->setSubmit($urlTarget, $divTarget);
        $this->is_horizontal = $is_horizontal;
    }
      
    public function setControlName($controlName)
    {
        $this->controlName = $controlName;
    }

    public function setFormLegend($legend)
    {
        $this->formLegend = $legend;
    }

    public function getFormLegend()
    {
        return $this->formLegend;
    }

    public function setSubmit($urlTarget, $divTarget)
    {
        $this->urlTarget = $urlTarget;
        $this->divTarget = $divTarget;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getDivTarget()            
    {
        return $this->divTarget;
    }

    public function setPost($objPost)
    {   
        $primaryKey = DB::getPrimaryKey($this->id);
        foreach (get_object_vars($objPost) as $key => $value)
        {
            if($this->fields[$key])
            {
                $this->fields[$key]->setValue($value);
            }
            else
            {
                if($key == $primaryKey)
                {   
                    $objInput = new MText($value,$key, $key,true);
                    $objInput->setDisabled(true);
                    $objInput->setLabel('Id');
                    $objInput->setObligatory(true);
                    array_unshift($this->fields, $objInput);
                }         
            }
        }                            
    }
    
    public function addTab($tab)
    {
        $this->tab = $tab;
    }

    public function addField($name, $label, MInput $objInput, $obligatory = false)
    {
        $objInput->setLabel($label);
        $objInput->setName($name);
        $objInput->setObligatory($obligatory);

        if ($obligatory)
            $this->aObligatories[$name] = $label;

        if (!$objInput->getId())
        {
            $objInput->setId($name);
        }
        if($this->tab)
            $this->tabs[$this->tab][$name] = $objInput;
        $this->fields[$name] = $objInput;
    }
    
    function addProperty($name,$value)
    {
        $this->properties[$name] = $value;
    }
    
    public function getFields()
    {
        return $this->fields;
    }

    public function addButton($nome = 'Salvar', $js_function = null, $params = null, $type = 'submit')
    {        

        if($js_function) 
        {           
            if($params)
            {
               $params = implode(',' ,$params);       
            }        
        
            $js_function.="($params);";
        }
                
        $this->buttons[] = " <input type='{$type}'  name='{$nome}' value='{$nome}' {$js_function} /> ";
    }

    public function show()
    {
        // create objForm to use in session for validade the form in control
        $this->MCore->setSession($this->sessionFormName, $this->aObligatories);
        
        if($this->properties)
        foreach ($this->properties as $key => $value)
        {
            $properties .= " $key='$value' ";
        }
        
        if($this->buttons)
        {

            foreach($this->buttons as $button)
            {
                $buttons .=$button;                
            }        
        }

        if(!$buttons)
            $buttons = '<input type="submit" value="Salvar">';
        
        #FIXME achar outra maneira para não fazer utilizar o return false no onsubmit;
        $htmlForm = "<form {$properties} id = '{$this->id}'  onsubmit=\" ajaxSubmit('{$this->urlTarget}','{$this->divTarget}','{$this->id}'); return false;\" class='mform' >";

        $inputs = $this->getFields();

        if ($inputs)
        {
            if(count($this->tabs)>1)
            {
                $tabsUl = '<ul>';
                $divTabs.= "
                <script>
                    $(function(){
                        $( '#tabs-{$this->id}' ).tabs();
                    });
                </script> 
                <fieldset>
                    <legend>" . $this->getFormLegend() . "</legend>
                    <div id='tabs-{$this->id}'>";
                $contTabs = 0;
                foreach ($this->tabs as $tab => $fields)
                {
                    $contTabs++;
                    $tabsUl.= "<li> <a href='#tabs-{$this->id}-{$contTabs}'>{$tab}</a> </li>";                                        
                                  
                    $divTabFields .= "<div id='tabs-{$this->id}-{$contTabs}'> <fieldset> ";
                    foreach ($fields as $field)
                    {
                        $obligatory = null;
                        if ($field->getObligatory())
                        {
                            $obligatory = '<span class="obligatory">*</span>';
                        }

                        $classItem = ($this->is_horizontal) ? 'item' : 'item-vertical';
                        $divTabFields .= "
                                <div class='{$classItem}'> " .
                                    "<label for='{$field->getId()}'> $obligatory {$field->getLabel()}: </label>" .
                                        $field->show() .
                                "</div>";
                    }
                    $divTabFields .= '</fieldset> </div>';
                }
                
                $tabsUl .= '</ul>';
                $footer.= '<div style = "text-align: right; padding: 15px; height:auto; display:table; width: 95%;"> 
                                <div class="highlight_messages"> </div> <div style="text-align:right; float:right"> '.$buttons.' </div> </div>';
                $divTabs .= $tabsUl.$divTabFields.$footer.'</div>';
                $htmlForm .= $divTabs . '</fieldset>';
            }
            else
            {
                $htmlForm.= '<fieldset><legend>' . $this->getFormLegend() . '</legend>';                
                foreach ($inputs as $field)
                {
                    $obligatory = null;
                    if ($field->getObligatory())
                    {
                        $obligatory = '<span class="obligatory">*</span>';
                    }

                    $classItem = ($this->is_horizontal) ? 'item' : 'item-vertical';
                    $htmlForm .= "<div class='{$classItem}'> " .
                            "<label for='{$field->getId()}'> $obligatory {$field->getLabel()}: </label>" .
                            $field->show() .
                            "</div>";
                }
                $htmlForm.='</fieldset>';
                $htmlForm.= '<fieldset class="tblFooters">' .
                    '<div class="highlight_messages"></div>' .
                    $buttons .
                    '</fieldset>';
            }
                    $htmlForm.='</form>';
        }
        echo $htmlForm;
    }

}

?>
