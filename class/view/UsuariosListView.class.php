<?php

class UsuariosListView extends MListView
{

    public function __construct()
    {
        parent::__construct();

        //public function __construct($id, $legend, $is_horizontal = true, $urlTarget = null, $divTarget = '', $controlName = '')   
        $buscaForm = new MForm('usuarios_busca_form', 'Buscar Usuários', true, 'UsuariosListControl::search()', 'usuarios_list_grid');
        $buscaForm->addField('usuarios.nome', 'Nome', new MText(), true);
        $buscaForm->addField('usuarios.email', 'E-mail', new MText(), true);
        $buscaForm->addField('usuarios.senha', 'Senha  ', new MText(), true);

        parent::setForm($buscaForm);

        // colunas da grid
        parent::addColumn('usuarios.id', 'primary', 'Cód.');
        parent::addColumn('usuarios.nome', 'varchar', 'Nome');
        parent::addColumn('usuarios.email','varchar', 'Email');

        // acoes da grid
        parent::addAction('view', 'Ver', MGrid::VIEW);
        parent::addAction('edit', 'Editar', MGrid::EDIT);
        parent::addAction('delete', 'Deletar', MGrid::DELETE);

        // 
        parent::setSql('SELECT id,nome,email FROM usuarios');
    }

}

?>
