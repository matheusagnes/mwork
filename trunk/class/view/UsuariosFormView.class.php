<?php

class UsuariosFormView extends MForm
{

    public function __construct($params = null)
    {
        parent::__construct('usuarios', 'Cadastro de Usuários', false);

        if($params)
        {
            
        }
        
        $ref_tipo_usuarios = new MCombo();
        $ref_tipo_usuarios->setMultiple(true);
        $ref_tipo_usuarios->addProperty('style','width:300px; height:300px;');
        
        $objs = DB::getObjects('select * from tipos_usuarios');
        foreach ($objs as $obj)
        {
            $ref_tipo_usuarios->addItem($obj->id, $obj->descricao);
        }
        parent::addProperty('style','width:70%');
        parent::addTab('oiiaa');        
        parent::addField('nome', 'Nome', new MText(), true);

        $aCoisas[1] = 'coisa1';
        $aCoisas[2] = 'coisa2';
        $aCoisas[3] = 'coisa3';
        

        //parent::addField('coisas', 'Coisas', new MCombo($aCoisas), true);

        $multifield = new MMultiField();
        $multifield->addField('senha', 'Senha  ', new MText(), true);
        $multifield->addField('coisas', 'Coisas', new MCombo($aCoisas), true);
                              
        $objField->senha = 'texto';
        $objField->coisas = array('coisa1',1);
        unset($objs);
        $objs[1] = $objField;
        $objField1->senha = 'texto1';
        $objField1->coisas = array('coisa2',2);
        $objs[2] = $objField1;
        $multifield->setValue($objs);
        parent::addField('multiField', 'MultiField', $multifield, true);

        parent::addTab('oii');
        //parent::addField('senha', 'Senha  ', new MText(), true);
        parent::addField('ref_tipo_usuario', 'Tipo Usuário  ', $ref_tipo_usuarios, true);
    }

}

?>
