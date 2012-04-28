<?php

class MForm
{

    private $fields;
    private $id; //Form id will be used in control to rec in DB
    private $cont;
    private $botoes;
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
        $this->botoes = $botoes;
        $this->cont = 0;
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

    /**
     * @method addField
     * Este metodo recebera um objInput
     * O qual contera um tipo de campo
     * Com suas propriedades     
     */
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

        $this->cont++;
        $this->fields["field{$this->cont}"] = $objInput;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getButton()
    {
        return $this->newButton;
    }

    public function addButton($nome = 'Salvar', $type = 'submit', $action = null)
    {
        $this->newButton = " <input class='bt' type='{$type}'  name='{$nome}' value='{$nome}' {$action} /> ";
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

            $htmlForm.= '<fieldset class="tblFooters">' .
                    '<div class="highlight_messages"></div>' .
                    '<input type="submit" value="Salvar">' .
                    '</fieldset>' .
                    '</form>';
        }
        echo $htmlForm;
    }

}

?>
