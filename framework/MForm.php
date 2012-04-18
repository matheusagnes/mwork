<?php

class MForm
{
    private $fields;
    private $id;
    private $cont;
    private $onSubmit;
    private $botoes;
    private $newButton;
    private $formLegend;
    private $is_horizontal;
    private $urlTarget;
    private $divTarget;
	private $MCore = null;
	private $aObligatories;
	private $sessionFormName;

    public function __construct($id, $legend, $is_horizontal = true, $urlTarget = null)
    {
		// get mcore instance
		$this->MCore = MCore::getInstance();

        $this->setId($id);
        $this->setFormLegend($legend);
		
		if(!$urlTarget)
		{
			$debug = debug_backtrace();
		    // Get MForm caller class
		    $callerClass = $debug[1]['class'];
			$this->sessionFormName = $callerClass.'::save'; // sempre retirar parentesis
		    $urlTarget = str_replace('View', 'Control', $callerClass) . '::save()';
		}
		
        #FIXME trocar para content
        $this->setSubmit($urlTarget, 'conteudo');
        $this->is_horizontal = $is_horizontal;
        $this->botoes = $botoes;
        $this->cont = 0;
    }


    public function setOnSubmit($onSubmit)
    {
        $this->onSubmit = $onSubmit;
    }

    public function setFormLegend($legend)
    {
        $this->formLegend = $legend;
    }

    public function getFormLegend()
    {
        return $this->formLegend;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSubmit($urlTarget, $divTarget)
    {
        $this->urlTarget = $urlTarget;
        $this->divTarget = $divTarget;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
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
		
		if($obligatory)
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
		$this->MCore->setSession($this->sessionFormName,$this->aObligatories);

        #FIXME achar outra maneira para não fazer utilizar o return false no onsubmit;
        $htmlForm = "<form name = '{$this->name}' id = '{$this->id}'  onsubmit=\" ajaxSubmit('{$this->urlTarget}','{$this->divTarget}','{$this->id}'); return false;\" class='mform' >";
        $htmlForm.= '<fieldset><legend>'.$this->getFormLegend().'</legend>';

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
                $htmlForm .= "<div class='{$classItem}'> ".
                                   "<label for='{$field->getId()}'> $obligatory {$field->getLabel()}: </label>".
                                        $field->show().
                                "</div>";
            }
            $htmlForm.='</fieldset>';

            $htmlForm.= '<fieldset class="tblFooters">'.
                            '<input type="submit" value="Salvar">'.
                        '</fieldset>'.
                    '</form>';
        }
        echo $htmlForm;
    }

}

?>