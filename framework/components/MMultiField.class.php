<?php


class MMultiField extends MInput
{
    private $fields;
    
    public function __construct($value=null, $name=null, $id=null,$maxlength=null)
    {
        parent::__construct();
        $this->value = $value;
        $this->name = $name;
        $this->id = $id;
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
        
        $this->fields[$name] = $objInput;
    }
    
    public function show()
    {
        parent::show();
        
        if (count($this->properties) > 0)
        {            
            foreach ($this->properties as $key => $value)
            {
                $properties .= " $key='$value' ";
            }
        }
        
        
        $formDialog =
        "
        <div id='dialog-form-{$this->id}' title='Adicionar'>
            <p class='validateTips'>Todos os campos com * são obrigatórios.</p>
            <fieldset id='multiFieldDialogFields-{$this->id}'>
         ";
        
        //allFields = $( [] ).add( name ).add( email ).add( password ),";
        $jsArrayFields = 'var allFields = $( [] )';
        $jsVars = 'var tips = $( ".validateTips" );';
        foreach ($this->fields as $field)
        {
            $jsVars.= "var var_{$field->id} = $( '#{$field->id}' );";
           
            $jsArrayFields .=".add(var_{$field->id})";
            
            $obligatory = null;
            if ($field->getObligatory())
            {
                $obligatory = '<span class="obligatory">*</span>';
            }
            
            $formDialog 
            .="
                <label for='{$field->id}'>{$obligatory} {$field->label}</label>
                ".$field->show()."
            ";
            $tableLabels.= "<td> {$field->label} </td>";    
        }
        $formDialog .= "</fieldset> </div>";
        
        
        $multiFieldScript =
        "
            
        <style>
            body { font-size: 62.5%; }
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            #multiFieldDialogFields-{$this->id} { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#multiField-contain-{$this->id} { width: 350px; margin: 20px 0; }
            div#multiField-contain-{$this->id} table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#multiField-contain-{$this->id} table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>    



            <script>
            $(function() {
                $( '#dialog:ui-dialog' ).dialog( 'destroy' );
	";
        
        
        
        $multiFieldScript .="	
                    
                {$jsVars}
               
                {$jsArrayFields};
                function updateTips( t ) {
                    tips
                    .text( t )
                    .addClass( 'ui-state-highlight' );
                    setTimeout(function() {
                        tips.removeClass( 'ui-state-highlight', 1500 );
                    }, 500 );
                }
                var arrayMultiField_{$this->id} = new Array();
                $( '#dialog-form-{$this->id}' ).dialog({
                    autoOpen: false,
                    height: 300,
                    width: 350,
                    modal: true,
                    buttons: {
                        'Adicionar': function() {
                            //add aqui pra ve se eh requerido os campos
                            if ( 1 ) {
                
                                var tr = $('<tr>');                                
                                $('#multiFieldDialogFields-{$this->id}').find('input,select,textarea').each(function()  
                                {
                                    var td = $('<td>');
                                    td.append($(this).clone().hide());
                                    td.append($(this).val());
                                    tr.append(td);    
                                });  
                
                                $( '#multiFieldTable-{$this->id} tbody' ).append(tr);
                                
                                arrayMultiField_{$this->id}.push($('#multiFieldDialogFields-{$this->id}').find('input,select,textarea').serializeJSON());
                                $('#{$this->id}').val( $.toJSON(arrayMultiField_{$this->id}));
                                
                                
                            }
                        },
                        Cancelar: function() {
                            $( this ).dialog( 'close' );
                        }
                    },
                    close: function() {
                        allFields.val( '' ).removeClass( 'ui-state-error' );
                    }
                });

                $( '#multiFieldAdd-{$this->id}' )
                .button()
                .click(function() {
                    $( '#dialog-form-{$this->id}' ).dialog( 'open' ); return false;
                });
            });
        </script>
        ";        
        
        $multiFieldTable = 
        "<div id='multiField-contain-{$this->id}' class='ui-widget'>
            <div style='text-align:left; width:100%; height:35px'> <br><button style='text-align:left;float:left;' id='multiFieldAdd-{$this->id}'>Adicionar</button> </div>
            <table id='multiFieldTable-{$this->id}' class='ui-widget ui-widget-content'>
                <thead>
                    <tr class='ui-widget-header '>
                        {$tableLabels}
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <input type='text' id='{$this->id}' name='{$this->name}' style='display:none;'/>
        </div>";
            
        return $multiFieldScript.$formDialog.$multiFieldTable;
       
    }



    public function setMaxLength($maxlength)
    {
        $this->maxlength = $maxlength;
    }


    //a - Represents an alpha character (A-Z,a-z)
    //9 - Represents a numeric character (0-9)
    //* - Represents an alphanumeric character (A-Z,a-z,0-9)
    public function setMask($mask)
    {
        $this->mask = $mask;
    }

}

?>
