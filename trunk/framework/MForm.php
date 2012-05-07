<?php

class MForm
{

    private $fields;
    private $id; //Form id will be used in control to rec in DB
    private $buttons;
    private $newButton;
    private $formLegend;
    private $is_horizontal;
    private $urlTarget;
    private $divTarget;
    private $MCore = null;
    private $aObligatories;
    private $sessionFormName;
    private $controlName;

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

    public function addField($name, $label, MInput $objInput, $obligatory = false)
    {
        $objInput->setLabel($label);
        $objInput->setName($name);
        $objInput->setObligatory($obligatory);

        if ($obligatory)
            $this->aObligatories[$name] = $obligatory;

        if (!$objInput->getId())
        {
            $objInput->setId($name);
        }

        $this->fields[$name] = $objInput;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function addButton($nome = 'Salvar', $action = null, $type = 'submit')
    {

        $this->buttons[] = " <input type='{$type}'  name='{$nome}' value='{$nome}' {$action} /> ";
    }

    public function show()
    {
        // create objForm to use in session for validade the form in control
        $this->MCore->setSession($this->sessionFormName, $this->aObligatories);

        #FIXME achar outra maneira para não fazer utilizar o return false no onsubmit;
        $htmlForm = "<form id = '{$this->id}'  onsubmit=\" ajaxSubmit('{$this->urlTarget}','{$this->divTarget}','{$this->id}'); return false;\" class='mform' >";
        $htmlForm.= '<fieldset><legend>' . $this->getFormLegend() . '</legend>';

        $fields = $this->getFields();

        if ($fields)
        {
            foreach ($fields as $field)
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


            if($this->buttons)
            {

                foreach($this->buttons as $button)
                {
                    $buttons .=$button;                
                }        
            }

            if(!$buttons)
                $buttons = '<input type="submit" value="Salvar">';

            $htmlForm.= '<fieldset class="tblFooters">' .
                    '<div class="highlight_messages"></div>' .
                    $buttons .
                    '</fieldset>' .
                    '</form>';
        }
        echo $htmlForm;
    }

}

?>
