<?php


class MMultiField extends MInput
{
    private $fields;
    private $objects;
    
    public function __construct($value=null, $name=null, $id=null,$maxlength=null)
    {
        parent::__construct();
        $this->value = $value;
        $this->name = $name;
        $this->id = $id;
    }
    
    /** 
    * Set vales to multifield    
    * @param Array
      Usage:
        $objects[table_id] = object->fieldName = 'test'
        $objects[table_id] = object->fieldName = array('test', 10)
    * @return void 
    */ 
    public function setValue($objects)
    {
        
        $this->objects = $objects;
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
        
        if($this->objects)
        {
            $editMutiField = '';
            $cont = 0;
            foreach ($this->objects as $key=>$object)
            {
                $cont++;
                $editMutiField .="<tr>";                
                $editMutiField .= "<td style='display:none;'> <input type='text' disabled='disabled' name='multifield_id' id='multifield_id' value='{$key}' style='display:none'> </td>";
                foreach ($this->fields as $field)
                {
                    $text = null;
                    $value = null;
                    if(!is_array($object->{$field->name}))
                    {
                        $text = $object->{$field->name};
                        $value = $object->{$field->name};                    
                    }
                    else
                    {
                        $text = $object->{$field->name}[0];
                        $value = $object->{$field->name}[1];                    
                    }
                    $text = trim($text);
                    $value = trim($value);
                    $editMutiField .= "<td>";
                    $editMutiField .= "{$text} <input type='text' disabled='disabled' name='multifield_{$field->name}' id='multifield_{$field->id}' value='{$value}' style='display:none'>";
                    $editMutiField .= "</td>";
                }
                $editMutiField .= "<td> <img name = 'edit' class='multiFieldIcon' src='framework/images/edit.png' title='Editar'> <img name = 'delete' class='multiFieldIcon' src='framework/images/delete.png' title='Deletar'> </td>";
                $editMutiField .="</tr>";
            }
        }
        $formDialog .= "</fieldset> </div>";
        
        
        $multiFieldScript =
        "
            
        <style>
            body { font-size: 62.5%; }
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            #multiFieldDialogFields-{$this->id} { padding:10px; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            .multiField-contain { width: 350px; margin: 20px 0; }
            .multiField-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            .multiField-contain table td, .multiField-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .multiFieldIcon {cursor: pointer;border: 0px; padding:0px;}
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>    



            <script>
            function getJsonFromTable_{$this->id}()
            {
                var arrayMultiField_{$this->id} = new Array();
                $( '#multiFieldTable-{$this->id} tbody' ).find('tr').each(function()
                {
                    $(this).find('input,select,textarea').each(function()
                    {
                        $(this).attr('disabled',false);
                    });
                    arrayMultiField_{$this->id}.push($(this).find('input,select,textarea').serializeJSON());
                    $(this).find('input,select,textarea').each(function()
                    {
                        $(this).attr('disabled','true');
                    });
                });                
                $('#{$this->id}').val( $.toJSON(arrayMultiField_{$this->id}).replace(/multifield_/gi,''));
            }
            $(function() {
                $( '#dialog:ui-dialog' ).dialog( 'destroy' );
	";
        
        if($this->objects)
        {
            $scriptJsonObjects = "getJsonFromTable_{$this->id}();";
        }
        
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
                
                $( '#dialog-form-{$this->id}' ).dialog({
                    autoOpen: false,
                    height: 300,
                    width: 350,
                    modal: true,
                    buttons: {                        
                        Cancelar: function() {
                            $( this ).dialog( 'close' );
                        },
                        'Adicionar': function() {
                            //add aqui pra ve se eh requerido os campos
                            if ( 1 ) {
                                var tr = $('<tr>');                                
                                $('#multiFieldDialogFields-{$this->id}').find('input,select,textarea').each(function()  
                                {
                                    var td = $('<td>');
                                    td.append($(this).clone().attr('disabled','disabled').attr('id','multifield_'+$(this).attr('id')).attr('name','multifield_'+$(this).attr('name')).hide());
                                    if($(this).prop('tagName') == 'SELECT')   
                                        td.append($(this).find('option:selected').text());
                                    else
                                        td.append($(this).val());
                                    tr.append(td);    
                                });
                                var td = $('<td>');
                                td.append($('.actionsMultiField{$this->id} img').clone(true));
                                tr.append(td)  
                
                                $( '#multiFieldTable-{$this->id} tbody' ).append(tr);
                                
                                getJsonFromTable_{$this->id}();
                            }
                        },
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

            $('.multiFieldIcon').click(function() 
            {
                if($(this).prop('name') == 'delete')
                {
                    $(this).closest('tr').remove();    
                    getJsonFromTable_{$this->id}();                
                }
                else
                {
                    
                }
                //console.log($(this).prop('name'), );
            });           
        </script>
        ";        
        
        $multiFieldTable = 
        "<div id='multiField-contain-{$this->id}' class='ui-widget multiField-contain'>
            <div style='text-align:left; width:100%; height:35px'> 
                <br>
                <button style='text-align:left;float:left;' id='multiFieldAdd-{$this->id}'>Adicionar</button> 
            </div>
            <table id='multiFieldTable-{$this->id}' class='ui-widget ui-widget-content'>
                <thead>
                    <tr class='ui-widget-header '>
                        {$tableLabels}
                    </tr>
                </thead>
                <tbody>
                        {$editMutiField}
                </tbody>
            </table>
            <div class='actionsMultiField{$this->id}' style='display:none;'>
                <img name = 'edit' class='multiFieldIcon' src='framework/images/edit.png' title='Editar'> <img name = 'delete' class='multiFieldIcon' src='framework/images/delete.png' title='Deletar'>            
            </div> 
            <input type='text' id='{$this->id}' name='{$this->name}' style='display:;'/>
        <script> {$scriptJsonObjects} </script>
        </div>";
            
        return $multiFieldScript.$formDialog.$multiFieldTable;
       
    }
}

?>
