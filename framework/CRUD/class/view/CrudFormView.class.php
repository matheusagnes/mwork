<?php

class CrudFormView extends MForm
{

    public function __construct()
    {
        parent::__construct('crud', 'Geração automática de código', true);
        
        $tables = DB::getObjects("show tables");
        
        foreach($tables as $table)
        {
            $key = get_object_vars($table);
            $table->{key($key)};
            
            unset($check);
            $check = new MCheckBox();
            $check->setValue($table->{key($key)});
            $check->setName('tabelas[]');
            parent::addField($table->{key($key)}, $table->{key($key)}, $check);
        }      
    }

}

?>
