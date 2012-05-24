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

        $hora = new MTime();
        $hora->setId('a');        

        $buscaForm = new MForm('usuarios_busca_form', 'Buscar Usuários', true, 'UsuariosListControl::search()', 'usuarios_list_grid');
        $buscaForm->addButton('Buscar');
        $buscaForm->addField('usuarios::nome::like', 'Nome', new MText(), true);
        $buscaForm->addField('horaaa', 'Hora', $hora, true);
        $buscaForm->addField('usuarios::email::like', 'E-mail', new MText(), true);
        $buscaForm->addField('usuarios::senha::like', 'Senha  ', new MText(), true);
        $buscaForm->addField('usuarios::ref_tipo_usuario::=', 'Tipo', $ref_tipo_usuarios, true);

        parent::setForm($buscaForm);
        
        $menu = new MMenu('menu_list');
        $menu->addLink('Cadastrar', '#ajax.php?class=UsuariosFormControl::show()');
        $menu->addLink('Gerenciar', '#ajax.php?class=UsuariosListControl::show()');
        
        parent::setMenu($menu);

        // colunas da grid
        parent::addColumn('usuarios::id', 'Cód',array(5));
        parent::addColumn('usuarios::nome', 'Nome');
        parent::addColumn('usuarios::email', 'Email');
        parent::addColumn('tipos_usuarios::descricao', 'Tipo Usuário', array(30),'tipos_usuarios.id=usuarios.ref_tipo_usuario');
        parent::addColumn('usuarios::valor', 'Valor');
    }

}

?>
