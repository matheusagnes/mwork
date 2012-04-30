<?php

class UsuariosFormView extends MForm
{

    public function __construct()
    {
        parent::__construct('usuarios', 'Cadastro de Usuários', false);

        $ref_tipo_usuarios = new MCombo();
        
        $objs = DB::getObjects('select * from tipos_usuarios');
        foreach ($objs as $obj)
        {
            $ref_tipo_usuarios->addItem($obj->id, $obj->descricao);
        }
        
        
        parent::addField('nome', 'Nome', new MText(), true);
        parent::addField('email', 'E-mail', new MText(), true);
        parent::addField('senha', 'Senha  ', new MText(), true);
        parent::addField('ref_tipo_usuario', 'Tipo Usuário  ', $ref_tipo_usuarios, true);
    }

}

?>
