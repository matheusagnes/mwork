<?php

class UsuariosListView extends MListView
{

	public function __construct()
	{
     	parent::__construct();		
	
		parent::addColumn('id', 'Cód.');
		parent::addColumn('nome', 'Nome');
		parent::addColumn('email', 'Email');

		parent::addAction('delete','Deletar','icone');
		
		parent::getGrid();
	}

}

?>
