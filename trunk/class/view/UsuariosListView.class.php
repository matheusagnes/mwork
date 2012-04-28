<?php

class UsuariosListView extends MListView
{

    public function __construct()
    {
        parent::__construct();

        //public function __construct($id, $legend, $is_horizontal = true, $urlTarget = null, $divTarget = '', $controlName = '')   
        $buscaForm = new MForm('usuarios_busca_form', 'Buscar Usuários', true, 'UsuariosListControl::search()', 'usuarios_list_grid');
        $buscaForm->addField('nome', 'Nome', new MText(), true);
        $buscaForm->addField('email', 'E-mail', new MText(), true);
        $buscaForm->addField('senha', 'Senha  ', new MText(), true);

        parent::setForm($buscaForm);

        parent::addColumn('id', 'Cód.');
        parent::addColumn('nome', 'Nome');
        parent::addColumn('email', 'Email');


        parent::addAction('view', 'Ver', MGrid::VIEW);
        parent::addAction('edit', 'Editar', MGrid::EDIT);
        parent::addAction('delete', 'Deletar', MGrid::DELETE);

        parent::setSql('SELECT id,nome,email FROM usuarios');
    }

}

?>
