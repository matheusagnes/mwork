<?php

class TiposUsuariosListView extends MListView
{

    public function __construct()
    {
        parent::__construct();

        //public function __construct($id, $legend, $is_horizontal = true, $urlTarget = null, $divTarget = '', $controlName = '')   
        $buscaForm = new MForm('tipos_usuarios_busca_form', 'Buscar Tipos Usuários', true, 'TiposUsuariosListControl::search()', 'tipos_usuarios_list_grid');
        
        $buscaForm->addField('tipos_usuarios::id', 'Id', new MText(), true);
        $buscaForm->addField('tipos_usuarios::descricao', 'Descrição', new MText(), true);

        parent::setForm($buscaForm);

        // colunas da grid
        parent::addColumn('tipos_usuarios::id', 'primary', 'Cód.');
        parent::addColumn('tipos_usuarios::descricao', 'varchar', 'Descrição');

    }

}

?>
