<?php

class TiposUsuariosFormView extends MForm
{

    public function __construct()
    {
        parent::__construct('tipos_usuarios', 'Cadastro de Tipos de Usuários', false);

        parent::addField('descricao', 'Descrição', new MText(), true);
    }

}

?>
