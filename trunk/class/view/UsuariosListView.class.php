<?php

class UsuariosListView extends MListView
{

    public function __construct()
    {
        parent::__construct();

		$ref_tipo_usuarios = new MCombo();
        
        $objs = DB::getObjects('select * from tipos_usuarios');
        foreach ($objs as $obj)
        {
            $ref_tipo_usuarios->addItem($obj->id, $obj->descricao);
        }

        //public function __construct($id, $legend, $is_horizontal = true, $urlTarget = null, $divTarget = '', $controlName = '')   
        $buscaForm = new MForm('usuarios_busca_form', 'Buscar Usuários', true, 'UsuariosListControl::search()', 'usuarios_list_grid');
        $buscaForm->addField('usuarios::nome', 'Nome', new MText(), true);
        $buscaForm->addField('usuarios::email', 'E-mail', new MText(), true);
        $buscaForm->addField('usuarios::senha', 'Senha  ', new MText(), true);
        $buscaForm->addField('usuarios::ref_tipo_usuario', 'Tipo', $ref_tipo_usuarios, true);

        parent::setForm($buscaForm);

        // colunas da grid
        parent::addColumn('usuarios::id', 'primary', 'Cód.');
        parent::addColumn('usuarios::nome', 'varchar', 'Nome');
        parent::addColumn('usuarios::email','varchar', 'Email');
        parent::addColumn('tipos_usuarios::descricao','varchar', 'Email','tipos_usuarios.id=usuarios.ref_tipo_usuario');

        // acoes da grid
        parent::addAction('view', 'Ver', MGrid::VIEW);          // js func     // parameter 
        parent::addAction('edit', 'Editar', MGrid::EDIT, array('showContent'=>'conteudo'));
        parent::addAction('delete', 'Deletar', MGrid::DELETE);

    }

}

?>